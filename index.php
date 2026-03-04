<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Undangan Pernikahan - Keraton</title>

    <style>
        :root {
            --text: #fff6e5;
            --muted: rgba(255, 246, 229, .78);
            --gold: #d2aa57;
            --gold2: #f3d89c;
            --card: rgba(24, 9, 12, .78);
            --border: rgba(243, 216, 156, .18);
            --radius: 30px;

            /* padding global */
            --pad: 18px;
        }

        /* reset */
        * {
            box-sizing: border-box
        }

        html,
        body {
            height: 100%
        }

        body {
            margin: 0;
            font-family: "Georgia", serif;
            color: var(--text);
            background: #0b0707;

            /* jangan hidden, biar mobile gak aneh */
            overflow: hidden;
        }

        /* ===== BACKGROUND IMAGE ===== */
        .bg {
            position: fixed;
            inset: 0;
            z-index: -5;

            background-image: url("bg.jpg");
            background-repeat: no-repeat;
            background-position: center;
            background-size: 100% 100%;
            /* INI KUNCINYA */
        }


        .bg {
            background-attachment: scroll;
        }


        /* ===== COVER ===== */
        .cover {
            position: fixed;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: var(--pad);
            z-index: 999;
            transition: .55s cubic-bezier(.2, .9, .2, 1);
            background:
                radial-gradient(circle at 50% 20%, rgba(210, 170, 87, .22), transparent 60%),
                linear-gradient(180deg, rgba(12, 6, 7, .98), rgba(7, 4, 5, .98));
            backdrop-filter: blur(8px);
        }

        .cover.hidden {
            opacity: 0;
            transform: translateY(16px);
            pointer-events: none;
        }

        .cover-inner {
            width: 100%;
            max-width: 480px;
            text-align: center;
            background: linear-gradient(180deg, rgba(59, 16, 22, .75), rgba(24, 9, 12, .82));
            border: 1px solid rgba(243, 216, 156, .22);
            border-radius: 34px;
            padding: 22px;
            box-shadow: 0 22px 60px rgba(0, 0, 0, .55);
            overflow: hidden;
        }

        .ornament-line {
            height: 12px;
            border-radius: 999px;
            margin: 10px auto;
            width: 72%;
            background: linear-gradient(90deg, transparent, rgba(243, 216, 156, .9), transparent);
            opacity: .9;
        }

        .cover-title {
            margin: 0;
            font-size: 13px;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: var(--gold2);
            opacity: .95;
        }

        .cover-names {
            margin-top: 10px;
            font-size: 30px;
            font-weight: 700;
        }

        .cover-sub {
            margin-top: 10px;
            font-size: 14px;
            color: var(--muted);
            line-height: 1.7;
        }

        .guest-badge {
            margin-top: 14px;
            display: inline-block;
            padding: 10px 14px;
            border-radius: 18px;
            background: rgba(255, 255, 255, .06);
            border: 1px solid rgba(243, 216, 156, .20);
            color: var(--muted);
            font-size: 13px;
        }

        .guest-badge b {
            color: var(--gold2)
        }

        .open-btn {
            margin-top: 16px;
            border: none;
            width: 100%;
            cursor: pointer;
            background: linear-gradient(135deg, var(--gold), var(--gold2));
            color: #1a140b;
            padding: 12px 18px;
            border-radius: 18px;
            font-weight: 700;
            font-size: 14px;
            box-shadow: 0 14px 22px rgba(210, 170, 87, .18);
        }

        /* ===== SCROLL SNAP CONTAINER ===== */
        /* penting: tinggi stabil pakai dvh + fallback var(--vh) */
        .snap {
            height: 100dvh;
            height: calc(var(--vh, 1vh) * 100);
            overflow-y: auto;

            /* padding pakai variable */
            padding: var(--pad);

            scroll-snap-type: y mandatory;
            scroll-behavior: smooth;
            position: relative;
            z-index: 1;

            /* biar scroll halus di iOS */
            -webkit-overflow-scrolling: touch;
        }

        /* page: jangan dihitung aneh-aneh, cukup 100% viewport minus padding */
        .page {
            min-height: calc(100dvh - (var(--pad) * 2));
            min-height: calc((var(--vh, 1vh) * 100) - (var(--pad) * 2));

            scroll-snap-align: start;

            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* ===== CARD ===== */
        .card {
            width: 100%;
            max-width: 760px;
            background: var(--card);
            border-radius: var(--radius);
            border: 1px solid var(--border);
            box-shadow: 0 22px 70px rgba(0, 0, 0, .55);
            overflow: hidden;
            backdrop-filter: blur(10px);

            opacity: 0;
            transform: translateX(0) scale(0.985);
            transition: opacity .45s ease, transform .55s cubic-bezier(.2, .9, .2, 1);
            will-change: transform, opacity;
        }

        .from-left {
            transform: translateX(-95px);
        }

        .from-right {
            transform: translateX(95px);
        }

        .card.show {
            opacity: 1;
            transform: translateX(0) scale(1);
            filter: blur(0);
        }

        /* ===== STAGGER TEXT ===== */
        .stagger>* {
            opacity: 0;
            transform: translateY(14px);
            transition: opacity .5s ease, transform .6s cubic-bezier(.2, .9, .2, 1);
            will-change: transform, opacity;
        }

        .card.from-left .stagger>* {
            transform: translateX(-16px) translateY(18px);
        }

        .card.from-right .stagger>* {
            transform: translateX(16px) translateY(18px);
        }

        .card.show .stagger>* {
            opacity: 1;
            transform: translateY(0);
        }

        .stagger>*:nth-child(1) {
            transition-delay: .15s
        }

        .stagger>*:nth-child(2) {
            transition-delay: .38s
        }

        .stagger>*:nth-child(3) {
            transition-delay: .62s
        }

        .stagger>*:nth-child(4) {
            transition-delay: .86s
        }

        .stagger>*:nth-child(5) {
            transition-delay: 1.10s
        }

        /* ===== HERO ===== */
        .hero {
            padding: 34px 22px;
            text-align: center;
            background:
                radial-gradient(circle at 50% 0%, rgba(210, 170, 87, .20), transparent 60%),
                linear-gradient(180deg, rgba(255, 255, 255, .06), transparent);
            position: relative;
        }

        .gunungan-img {
            width: 90px;
            height: auto;
            margin: 0 auto 14px;
            display: block;
            opacity: .95;
            filter: drop-shadow(0 18px 25px rgba(0, 0, 0, .55));
        }

        h1,
        h2 {
            margin: 0 0 10px;
            line-height: 1.25;
            color: var(--gold2);
        }

        h1 {
            font-size: 26px;
            letter-spacing: 1px;
        }

        h2 {
            font-size: 20px;
        }

        .names {
            margin-top: 14px;
            font-size: 30px;
            font-weight: 700;
        }

        .muted {
            color: var(--muted);
            font-size: 14px;
            line-height: 1.75;
        }

        .inner {
            padding: 24px 22px;
        }

        .box {
            margin-top: 12px;
            background: rgba(255, 255, 255, .05);
            border: 1px solid rgba(243, 216, 156, .16);
            padding: 14px;
            border-radius: 22px;
            line-height: 1.8;
            font-size: 14px;
            color: var(--muted);
        }

        .item {
            background: rgba(255, 255, 255, .04);
            border: 1px solid rgba(243, 216, 156, .14);
            padding: 12px 14px;
            border-radius: 22px;
            margin-top: 10px;
            font-size: 14px;
            line-height: 1.65;
            color: var(--muted);
        }

        .label {
            font-weight: 700;
            color: var(--gold2);
            margin-bottom: 4px;
        }

        .btn {
            display: inline-block;
            margin-top: 12px;
            text-decoration: none;
            background: linear-gradient(135deg, var(--gold), var(--gold2));
            color: #1a140b;
            padding: 10px 14px;
            border-radius: 16px;
            font-weight: 700;
            font-size: 14px;
            border: none;
            cursor: pointer;
            box-shadow: 0 14px 22px rgba(210, 170, 87, .18);
        }

        .countdown-wrap {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 14px;
            flex-wrap: wrap;
        }

        .count-item {
            min-width: 72px;
            padding: 10px 12px;
            border-radius: 18px;
            background: rgba(255, 255, 255, .05);
            border: 1px solid rgba(243, 216, 156, .16);
        }

        .count-num {
            font-size: 18px;
            font-weight: 700;
            color: var(--gold2);
        }

        .count-lbl {
            margin-top: 3px;
            font-size: 12px;
            color: var(--muted);
        }

        .btn-wa {
            margin-top: 14px;
            width: 100%;
            max-width: 360px;
        }

        /* ===== GALLERY FIX MOBILE ===== */

        /* ===== GALLERY FINAL ===== */
        .gallery {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            /* desktop 2 kolom */
            gap: 12px;
            margin-top: 14px;
        }

        .gallery img {
            width: 100%;
            aspect-ratio: 3 / 4;
            object-fit: contain;
            object-position: center;

            background: transparent;
            border-radius: 35px;
            /* ini bikin lebih smooth */
            border: 1px solid rgba(243, 216, 156, .14);
            padding: 6px;
        }

        .gallery img:hover {
            transform: scale(1.03);
        }

        /* MOBILE */
        @media (max-width:560px) {
            .gallery {
                grid-template-columns: repeat(2, 1fr);
                /* tetap 2 kolom di HP */
                gap: 10px;
            }

            .gallery img {
                aspect-ratio: 3 / 4;
            }
        }

        footer {
            text-align: center;
            padding: 18px 22px 26px;
            font-size: 12px;
            color: var(--muted);
        }

        .divider {
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(243, 216, 156, .55), transparent);
            margin: 14px 0 0;
            opacity: .9;
        }

        /* ===== COMPACT WISH LIST ===== */
        #wishList {
            display: grid;
            gap: 8px;
            max-height: 220px;
            overflow-y: auto;
            padding-right: 6px;
            -webkit-overflow-scrolling: touch;
        }

        .wish-item {
            padding: 10px 12px;
            border-radius: 16px;
            border: 1px solid rgba(243, 216, 156, .14);
            background: rgba(255, 255, 255, .04);
        }

        .wish-head {
            display: flex;
            justify-content: space-between;
            gap: 10px;
            align-items: baseline;
        }

        .wish-name {
            color: var(--gold2);
            font-weight: 700;
            font-size: 13px;
        }

        .wish-time {
            font-size: 11px;
            color: rgba(255, 246, 229, .55);
            white-space: nowrap;
        }

        .wish-msg {
            margin-top: 5px;
            color: var(--muted);
            line-height: 1.45;
            font-size: 13px;
        }

        /* ===== MOBILE ===== */
        @media (max-width:560px) {
            :root {
                --pad: 12px;
            }

            .cover-inner {
                padding: 18px;
                border-radius: 26px;
            }

            .cover-names {
                font-size: 24px;
            }

            .card {
                backdrop-filter: none;
            }

            .cover {
                backdrop-filter: none;
            }

            h1 {
                font-size: 22px;
            }

            h2 {
                font-size: 18px;
            }

            .names {
                font-size: 24px;
            }

            .hero {
                padding: 24px 16px;
            }

            .inner {
                padding: 18px 16px;
            }

            .btn {
                width: 100%;
                text-align: center;
            }

            .count-item {
                min-width: 68px;
                padding: 8px 10px;
                border-radius: 16px;
            }

            .count-num {
                font-size: 16px;
            }



            .gallery img {
                height: 240px;
            }

            #wishList {
                max-height: 190px;
            }

            .wish-item {
                padding: 9px 10px;
            }

            .wish-msg {
                font-size: 12.5px;
            }

            .snap {
                scroll-snap-type: none;
            }

            .page {
                scroll-snap-align: none;
            }
        }

        /* =========================
   ORNAMEN POJOK CARD (w2.png)
========================= */
        .card {
            position: relative;
            /* wajib */
            overflow: hidden;
            /* biar ornamen gak keluar card */
        }

        /* kiri atas */
        .card::before {
            content: "";
            position: absolute;
            top: -22px;
            left: -22px;
            width: 120px;
            height: 120px;
            background: url("bingkai.png") center/contain no-repeat;
            opacity: .55;
            pointer-events: none;
            z-index: 0;
            filter: drop-shadow(0 14px 22px rgba(0, 0, 0, .55));
        }

        /* kanan bawah (mirror biar simetris) */
        .card::after {
            content: "";
            position: absolute;
            bottom: -22px;
            right: -22px;
            width: 120px;
            height: 120px;
            background: url("bingkai.png") center/contain no-repeat;
            opacity: .55;
            pointer-events: none;
            z-index: 0;
            transform: scaleX(-1) scaleY(-1);
            filter: drop-shadow(0 14px 22px rgba(0, 0, 0, .55));
        }

        /* semua isi card harus di atas ornamen */
        .card>* {
            position: relative;
            z-index: 1;
        }

        /* =========================
   DOOR OPEN ANIMATION
========================= */
        /* =========================
   DOOR PNG (kiri.png & kanan.png)
========================= */
        /* =========================
   DOOR PUSH OPEN (3D ROTATE)
========================= */
        .cover {
            position: fixed;
            inset: 0;
            perspective: 1200px;
            /* bikin efek 3D */
            transform-style: preserve-3d;
        }

        /* panel pintu */
        .door {
            position: absolute;
            top: 0;
            width: 50%;
            height: 100%;
            z-index: 998;

            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;

            transform-style: preserve-3d;
            backface-visibility: hidden;

            transition: transform 1.7s cubic-bezier(.2, .9, .15, 1);
        }

        /* pintu kiri (engsel di kiri) */
        .door.left {
            left: 0;
            background-image: url("kiri.png");
            transform-origin: left center;
            /* titik engsel */
            transform: rotateY(0deg);
        }

        /* pintu kanan (engsel di kanan) */
        .door.right {
            right: 0;
            background-image: url("kanan.png");
            transform-origin: right center;
            /* titik engsel */
            transform: rotateY(0deg);
        }

        /* garis emas di tengah pintu */
        .door.left::after,
        .door.right::after {
            content: "";
            position: absolute;
            top: 0;
            bottom: 0;
            width: 2px;
            background: linear-gradient(180deg, transparent, rgba(243, 216, 156, .75), transparent);
            opacity: .85;
        }

        .door.left::after {
            right: -1px;
        }

        .door.right::after {
            left: -1px;
        }

        /* OPEN: pintu kebuka kaya didorong */
        .cover.open .door.left {
            transform: rotateY(-85deg);
        }

        .cover.open .door.right {
            transform: rotateY(85deg);
        }

        /* cover-inner ikut fade pelan */
        .cover.open .cover-inner {
            opacity: 0;
            transform: scale(.98);
            transition: opacity .7s ease, transform .7s ease;
        }

        .cover-inner {
            position: relative;
            z-index: 999;
        }

        /* =========================
   MUSIC TOGGLE BUTTON
========================= */
        .music-btn {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 2000;

            width: 48px;
            height: 48px;
            border-radius: 50%;
            border: 1px solid rgba(243, 216, 156, .35);

            background: rgba(24, 9, 12, .85);
            color: var(--gold2);
            font-size: 18px;
            cursor: pointer;

            backdrop-filter: blur(6px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, .4);

            transition: all .3s ease;
        }

        .music-btn:hover {
            transform: scale(1.08);
        }



        /* =========================
   PROFILE PREMIUM STYLE
========================= */

        .profile-wrap {
            display: flex;
            flex-direction: column;
            gap: 26px;
            margin-top: 22px;
        }

        /* Card tiap profile */
        /* =========================
   PROFILE PREMIUM STYLE
========================= */

        /* =========================
   PROFILE PREMIUM STYLE
========================= */

        .profile-wrap {
            display: flex;
            flex-direction: column;
            gap: 36px;
            margin-top: 28px;
        }

        /* PROFILE CARD */
        .profile {
            display: flex;
            align-items: center;
            justify-content: space-between;
            /* kiri kanan */
            gap: 30px;

            padding: 26px;
            border-radius: 30px;
            border: 1px solid rgba(243, 216, 156, .18);
            background: rgba(255, 255, 255, .04);

            opacity: 0;
            transform: translateY(50px);
            transition: opacity 1s ease, transform 1.2s cubic-bezier(.2, .9, .2, 1);
        }

        .profile.show-profile {
            opacity: 1;
            transform: translateY(0);
        }

        /* FOTO BULAT + GLOW */
        .profile img {
            width: 200px;
            height: 200px;
            object-fit: cover;

            border-radius: 50%;
            border: 3px solid var(--gold2);
            padding: 6px;

            background: rgba(0, 0, 0, .3);

            box-shadow:
                0 0 0 2px rgba(243, 216, 156, .15),
                0 0 22px rgba(243, 216, 156, .35),
                0 12px 35px rgba(0, 0, 0, .6);

            transition: transform .6s ease, box-shadow .6s ease;
        }

        /* HOVER EFFECT */
        .profile:hover img {
            transform: scale(1.07);
            box-shadow:
                0 0 0 3px rgba(243, 216, 156, .25),
                0 0 32px rgba(243, 216, 156, .55),
                0 16px 40px rgba(0, 0, 0, .7);
        }

        /* TEXT */
        .profile-info {
            flex: 1;
            text-align: center;
            font-size: 15px;
            color: var(--muted);
            line-height: 1.9;
        }

        /* ORNAMENT DIVIDER */
        .ornament-divider {
            height: 1px;
            width: 65%;
            margin: 0 auto;
            background: linear-gradient(90deg,
                    transparent,
                    rgba(243, 216, 156, .9),
                    transparent);
            position: relative;
        }

        .ornament-divider::before {
            content: "✦";
            position: absolute;
            top: -11px;
            left: 50%;
            transform: translateX(-50%);
            color: var(--gold2);
            font-size: 18px;
        }

        /* =========================
   MOBILE
========================= */

        @media (max-width:560px) {

            .profile {
                flex-direction: column;
                text-align: center;
                padding: 22px;
            }

            .profile img {
                width: 150px;
                height: 150px;
            }

            .profile-info {
                text-align: center;
                font-size: 14px;
            }

        }

        /* ===== MAP ===== */

        .map-wrap {
            margin-top: 14px;
            border-radius: 20px;
            overflow: hidden;
            border: 1px solid rgba(243, 216, 156, .15);
        }

        .map-wrap iframe {
            width: 100%;
            height: 220px;
            border: none;
        }

        /* ===== QR ===== */

        .qr-wrap {
            margin-top: 16px;
            text-align: center;
        }

        .qr-wrap img {
            width: 140px;
            border-radius: 12px;
            padding: 6px;
            background: rgba(255, 255, 255, .05);
        }
    </style>
</head>

<body>

    <!-- BACKGROUND -->
    <div class="bg"></div>
    <button id="musicToggle" class="music-btn" onclick="toggleMusic()">
        🔊
    </button>
    <audio id="bgm" preload="auto" loop>
        <source src="lagu.mp3" type="audio/mpeg">
    </audio>
    <!-- COVER -->
    <div class="cover" id="cover">
        <div class="door left"></div>
        <div class="door right"></div>

        <div class="cover-inner">
            <div class="ornament-line"></div>
            <p class="cover-title">UNDANGAN PERNIKAHAN</p>
            <div class="cover-names">Muhammad Hendro, S.T & Nadya Maharani, S.Pd</div>

            <div class="cover-sub">
                Sabtu, 04 April 2026<br>
                Mohon Doa Restu & Kehadirannya
            </div>

            <div class="guest-badge">
                Kepada Yth: <b id="guestName">Tamu Undangan</b>
            </div>

            <button class="open-btn" onclick="openInvitation()">Buka Undangan</button>
            <div class="ornament-line"></div>
        </div>
    </div>

    <!-- CONTENT -->
    <div class="snap" id="snap">

        <!-- PAGE 1 -->
        <section class="page">
            <div class="card from-left" data-animate="page">
                <div class="hero stagger">
                    <img src="tengah.png" class="gunungan-img" alt="Gunungan">

                    <h1>The Wedding Of</h1>
                    <div class="names">Muhammad Hendro, S.T & Nadya Maharani, S.Pd</div>
                    <div class="countdown-wrap">
                        <div class="count-item">
                            <div class="count-num" id="cdDays">00</div>
                            <div class="count-lbl">Hari</div>
                        </div>
                        <div class="count-item">
                            <div class="count-num" id="cdHours">00</div>
                            <div class="count-lbl">Jam</div>
                        </div>
                        <div class="count-item">
                            <div class="count-num" id="cdMinutes">00</div>
                            <div class="count-lbl">Menit</div>
                        </div>
                        <div class="count-item">
                            <div class="count-num" id="cdSeconds">00</div>
                            <div class="count-lbl">Detik</div>
                        </div>
                    </div>

                    <button class="btn btn-wa" onclick="shareWA()">
                        Share Undangan via WhatsApp
                    </button>

                    <p class="muted" style="margin-top:10px;">
                        “Rahajeng rawuh, mugi pinaringan berkah”<br>
                        Scroll ke bawah untuk melihat detail acara
                    </p>

                    <div class="box" style="text-align:center;">
                        Kepada Yth: <b id="guestName2" style="color:var(--gold2);">Tamu Undangan</b>
                    </div>

                    <div class="divider"></div>
                </div>

                <footer class="stagger">
                    <div style="letter-spacing:2px; color:rgba(243,216,156,0.85)">↓</div>
                </footer>
            </div>
        </section>

        <!-- PAGE 2 -->
        <section class="page">
            <div class="card from-right" data-animate="page">
                <div class="inner stagger">
                    <h2>Salam</h2>

                    <div class="box">
                        Assalamu’alaikum Warahmatullahi Wabarakatuh<br><br>
                        Dengan memohon rahmat dan ridho Allah SWT, kami bermaksud
                        mengundang Bapak/Ibu/Saudara/i untuk menghadiri acara
                        pernikahan kami.
                    </div>

                    <div class="box" style="margin-top:14px; text-align:center;">
                        <em>
                            “Dan di antara tanda-tanda (kebesaran)-Nya ialah Dia menciptakan
                            pasangan-pasangan untukmu dari jenismu sendiri, agar kamu
                            cenderung dan merasa tenteram kepadanya, dan Dia menjadikan
                            di antaramu rasa kasih dan sayang.”
                        </em>
                        <br><br>
                        <strong>QS. Ar-Rum: 21</strong>
                    </div>

                    <div class="profile-wrap">

                        <!-- Mempelai Pria -->
                        <div class="profile">
                            <img src="foto/1.jpg" alt="Muhammad Hendro">

                            <div class="profile-info">
                                <div class="label">Muhammad Hendro, S.T</div>
                                Putra dari<br>
                                Almarhum Bapak Djoko Sarono<br>
                                & Ibu Suharti
                            </div>
                        </div>

                        <div class="ornament-divider"></div>

                        <!-- Mempelai Wanita -->
                        <div class="profile">
                            <div class="profile-info">
                                <div class="label">Nadya Maharani, S.Pd</div>
                                Putri dari<br>
                                Almarhum Bapak Suyatno<br>
                                & Ibu Hesti Setyawati
                            </div>

                            <img src="foto/6.jpg" alt="Nadya Maharani">
                        </div>

                    </div>

                </div>
            </div>
        </section>

        <!-- PAGE 3 -->
        <section class="page">
            <div class="card from-left" data-animate="page">
                <div class="inner stagger">
                    <h2>Rangkaian Acara</h2>

                    <p class="muted" style="text-align:center;">
                        Dengan memohon rahmat dan ridho Allah SWT, kami bermaksud
                        menyelenggarakan rangkaian acara pernikahan sebagai berikut:
                    </p>

                    <div class="item">
                        <div class="label">Akad Nikah</div>
                        Sabtu, 4 April 2026<br>
                        Pukul 07.00 WIB
                    </div>

                    <div class="item">
                        <div class="label">Resepsi</div>
                        Sabtu, 4 April 2026<br>
                        Pukul 11.00 – 16.00 WIB
                    </div>

                    <div class="box" style="text-align:center;">
                        <em>
                            “Mugi dados pasangan sakinah, mawaddah, warahmah.”
                        </em>
                    </div>
                </div>
            </div>
        </section>

        <!-- PAGE 4 -->
        <section class="page">
            <div class="card from-right" data-animate="page">
                <div class="inner stagger">
                    <h2>Lokasi</h2>

                    <div class="item">
                        <div class="label">Tempat</div>
                        Perumahan Papan Mas
                    </div>

                    <div class="item">
                        <div class="label">Alamat</div>
                        Blok G 3 No. 3 RT.007 RW.003<br>
                        Desa Setia Mekar, Tambun Selatan<br>
                        Kabupaten Bekasi
                    </div>

                    <!-- MAP -->
                    <div class="map-wrap">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m17!1m12!1m3!1d3966.0841799967493!2d107.04861110000002!3d-6.252638899999999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m2!1m1!2zNsKwMTUnMDkuNSJTIDEwN8KwMDInNTUuMCJF!5e0!3m2!1sen!2sid!4v1772598484522!5m2!1sen!2sid"
                            loading="lazy"
                            allowfullscreen
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>

                    <!-- QR CODE -->
                    <div class="qr-wrap">
                        <img src="qra.jpg" alt="QR Lokasi">
                        <div class="muted">Scan QR untuk membuka lokasi</div>
                    </div>

                    <a class="btn" target="_blank"
                        href="https://maps.app.goo.gl/x2EVri9M4z4qHvpk8">
                        Buka di Google Maps
                    </a>

                </div>
            </div>
        </section>

        <!-- PAGE 5 -->
        <section class="page">
            <div class="card from-left" data-animate="page">
                <div class="inner stagger">
                    <h2>Galeri</h2>
                    <p class="muted">Momen terbaik kami 💛</p>

                    <div class="gallery">
                        <img src="foto/1.jpg" loading="lazy" alt="Foto 1">
                        <img src="foto/2.jpg" loading="lazy" alt="Foto 2">
                        <img src="foto/3.jpg" loading="lazy" alt="Foto 3">
                        <img src="foto/4.jpg" loading="lazy" alt="Foto 4">
                        <img src="foto/5.jpg" loading="lazy" alt="Foto 5">
                        <img src="foto/6.jpg" loading="lazy" alt="Foto 6">
                    </div>

                    <div class="box" style="text-align:center;">
                        Maturnuwun 🙏<br>
                        Terima kasih atas doa dan kehadirannya
                    </div>
                </div>
            </div>
        </section>

        <!-- PAGE 6 -->
        <section class="page">
            <div class="card from-right" data-animate="page">
                <div class="inner stagger">
                    <h2>Ucapan & Doa</h2>
                    <p class="muted">Silakan kirim doa terbaik untuk kami 🙏</p>

                    <div class="box">
                        <form id="wishForm">
                            <div style="display:grid; gap:10px;">
                                <input id="wishName" type="text" placeholder="Nama" required
                                    style="padding:12px 14px; border-radius:16px; border:1px solid rgba(243,216,156,0.18); background:rgba(255,255,255,0.04); color:var(--text); outline:none;">

                                <textarea id="wishMsg" rows="4" placeholder="Tulis ucapan & doa..." required
                                    style="padding:12px 14px; border-radius:16px; border:1px solid rgba(243,216,156,0.18); background:rgba(255,255,255,0.04); color:var(--text); outline:none; resize:none;"></textarea>

                                <button type="submit" class="btn" style="width:100%;">
                                    Kirim Ucapan
                                </button>

                                <div id="wishStatus" class="muted" style="text-align:center;"></div>
                            </div>
                        </form>
                    </div>

                    <div class="box" style="margin-top:12px;">
                        <div style="font-weight:bold; color:var(--gold2); margin-bottom:8px;">
                            Ucapan Terbaru
                        </div>
                        <div id="wishList"></div>
                    </div>
                </div>
            </div>
        </section>



    </div>

    <script>
        function openInvitation() {
            const cover = document.getElementById("cover");

            // ✅ PLAY MUSIC setelah klik
            const bgm = document.getElementById("bgm");
            if (bgm) {
                bgm.volume = 0.75; // atur volume
                bgm.play().catch((err) => {
                    console.log("Autoplay diblokir:", err);
                });
            }

            cover.classList.add("open");

            // tunggu pintu selesai muter
            setTimeout(() => {
                cover.classList.add("hidden");

                setTimeout(() => {
                    document.getElementById("snap").scrollTo({
                        top: 0,
                        behavior: "smooth"
                    });
                }, 200);

            }, 1700);
        }


        // Cinematic page show/hide
        const cards = document.querySelectorAll('[data-animate="page"]');
        const obs = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add("show");
                    obs.unobserve(entry.target); // ✅ stop observe biar ringan
                }
            });
        }, {
            threshold: 0.25
        });

        cards.forEach(el => obs.observe(el));

        // Nama tamu dari query (?to=Nadia)
        function getGuest() {
            const params = new URLSearchParams(window.location.search);
            return params.get("to") || "Tamu Undangan";
        }
        const guest = getGuest();
        document.getElementById("guestName").textContent = guest;
        document.getElementById("guestName2").textContent = guest;

        // =========================
        // COUNTDOWN
        // =========================
        // UBAH TANGGAL NIKAH DI SINI (WIB)
        const weddingDate = new Date("2026-04-04T11:00:00+07:00");


        function pad(n) {
            return String(n).padStart(2, '0');
        }

        function updateCountdown() {
            const now = new Date();
            let diff = weddingDate - now;

            if (diff <= 0) {
                document.getElementById("cdDays").textContent = "00";
                document.getElementById("cdHours").textContent = "00";
                document.getElementById("cdMinutes").textContent = "00";
                document.getElementById("cdSeconds").textContent = "00";
                return;
            }

            const totalSeconds = Math.floor(diff / 1000);
            const days = Math.floor(totalSeconds / (3600 * 24));
            const hours = Math.floor((totalSeconds % (3600 * 24)) / 3600);
            const minutes = Math.floor((totalSeconds % 3600) / 60);
            const seconds = totalSeconds % 60;

            document.getElementById("cdDays").textContent = pad(days);
            document.getElementById("cdHours").textContent = pad(hours);
            document.getElementById("cdMinutes").textContent = pad(minutes);
            document.getElementById("cdSeconds").textContent = pad(seconds);
        }

        setInterval(updateCountdown, 1000);
        updateCountdown();


        // =========================
        // SHARE WA
        // =========================
        function shareWA() {
            const guestName = getGuest();
            const url = window.location.href;

            const text = `Assalamu’alaikum 🙏

Dengan hormat, kami mengundang *${guestName}* untuk hadir di acara pernikahan kami.

✨ Undangan Digital:
${url}

Terima kasih 🤍`;

            const waUrl = `https://wa.me/?text=${encodeURIComponent(text)}`;
            window.open(waUrl, "_blank");
        }


        /***********************
         * CONFIG
         ***********************/
        const GOOGLE_SCRIPT_URL = "https://script.google.com/macros/s/AKfycbwTM6a6yTIBlQlcroWpG4sI10oXOvqPXBzaprk_gsmAC4I7JCGaF_E8vYTqZc2b2-I/exec";

        const LIMIT = 5;

        let nextOffset = 0;
        let hasMore = true;
        let isLoading = false;

        /***********************
         * API
         ***********************/
        async function sendWish(nama, ucapan) {
            const res = await fetch(GOOGLE_SCRIPT_URL, {
                method: "POST",
                headers: {
                    "Content-Type": "text/plain;charset=utf-8"
                },
                body: JSON.stringify({
                    nama,
                    ucapan
                })
            });

            const raw = await res.text();
            try {
                return JSON.parse(raw);
            } catch (e) {
                console.log("POST bukan JSON:", raw);
                return {
                    success: false,
                    error: "POST response bukan JSON"
                };
            }
        }

        async function fetchWishes(offset = 0, limit = LIMIT) {
            const url = `${GOOGLE_SCRIPT_URL}?mode=get&offset=${offset}&limit=${limit}&ts=${Date.now()}`;
            const res = await fetch(url);
            const raw = await res.text();

            let json = {};
            try {
                json = JSON.parse(raw);
            } catch (e) {
                console.log("GET bukan JSON:", raw);
                return {
                    success: false,
                    error: "GET response bukan JSON"
                };
            }
            return json;
        }

        /***********************
         * UI HELPERS
         ***********************/
        function escapeHtml(str) {
            return String(str)
                .replaceAll("&", "&amp;")
                .replaceAll("<", "&lt;")
                .replaceAll(">", "&gt;")
                .replaceAll('"', "&quot;")
                .replaceAll("'", "&#039;");
        }

        function formatWIB(isoString) {
            try {
                const d = new Date(isoString);
                return new Intl.DateTimeFormat("id-ID", {
                    timeZone: "Asia/Jakarta",
                    day: "2-digit",
                    month: "short",
                    year: "numeric",
                    hour: "2-digit",
                    minute: "2-digit"
                }).format(d) + " WIB";
            } catch (e) {
                return "";
            }
        }

        function renderWishItem(name, msg, timestamp) {
            const el = document.createElement("div");
            el.className = "wish-item";

            el.innerHTML = `
    <div class="wish-head">
      <div class="wish-name">${escapeHtml(name)}</div>
      <div class="wish-time">${escapeHtml(formatWIB(timestamp))}</div>
    </div>
    <div class="wish-msg">${escapeHtml(msg)}</div>
  `;
            return el;
        }

        /***********************
         * LOAD PAGINATION (NO BUTTON)
         ***********************/
        async function resetWishes() {
            nextOffset = 0;
            hasMore = true;

            const wishList = document.getElementById("wishList");
            if (!wishList) return;

            wishList.innerHTML = `<div class="muted">Loading ucapan...</div>`;
            await loadMoreWishes(true);
        }

        async function loadMoreWishes(isReset = false) {
            if (isLoading) return;
            if (!hasMore && !isReset) return;

            const wishList = document.getElementById("wishList");
            if (!wishList) return;

            isLoading = true;

            try {
                const result = await fetchWishes(nextOffset, LIMIT);

                if (!result.success) {
                    if (isReset) wishList.innerHTML = `<div class="muted">Gagal load: ${result.error || "unknown"}</div>`;
                    return;
                }

                const data = result.data || [];

                if (isReset) wishList.innerHTML = "";

                if (data.length === 0 && isReset) {
                    wishList.innerHTML = `<div class="muted">Belum ada ucapan.</div>`;
                } else {
                    data.forEach(item => {
                        wishList.appendChild(renderWishItem(item.nama, item.ucapan, item.timestamp));
                    });
                }

                nextOffset = result.nextOffset ?? (nextOffset + data.length);
                hasMore = !!result.hasMore;

                // ✅ kasih penanda halus kalau sudah mentok
                if (!hasMore && !isReset) {
                    const end = document.createElement("div");
                    end.className = "muted";
                    end.style.textAlign = "center";
                    end.style.fontSize = "12px";
                    end.style.opacity = "0.7";
                    end.style.marginTop = "6px";
                    end.textContent = "— selesai —";
                    wishList.appendChild(end);
                }

            } catch (err) {
                console.log("loadMoreWishes error:", err);
                if (isReset) wishList.innerHTML = `<div class="muted">Gagal load (koneksi error)</div>`;
            } finally {
                isLoading = false;
            }
        }

        /***********************
         * AUTO LOAD WHEN SCROLL BOTTOM (INFINITE SCROLL)
         ***********************/
        function attachWishScrollPagination() {
            const wishList = document.getElementById("wishList");
            if (!wishList) return;

            wishList.addEventListener("scroll", () => {
                const nearBottom = wishList.scrollTop + wishList.clientHeight >= wishList.scrollHeight - 30;
                if (nearBottom) {
                    loadMoreWishes(false);
                }
            });
        }

        /***********************
         * INIT
         ***********************/
        document.addEventListener("DOMContentLoaded", () => {
            resetWishes();
            attachWishScrollPagination();

            const wishForm = document.getElementById("wishForm");
            const wishStatus = document.getElementById("wishStatus");

            if (!wishForm) return;

            wishForm.addEventListener("submit", async (e) => {
                e.preventDefault();

                const name = document.getElementById("wishName").value.trim();
                const msg = document.getElementById("wishMsg").value.trim();
                if (!name || !msg) return;

                wishStatus.textContent = "Mengirim ucapan...";
                wishStatus.style.color = "var(--muted)";

                try {
                    const result = await sendWish(name, msg);

                    if (result.success) {
                        wishStatus.textContent = "✅ Ucapan terkirim. Terima kasih!";
                        wishStatus.style.color = "var(--gold2)";
                        wishForm.reset();

                        // refresh dari awal biar ucapan baru muncul paling atas
                        setTimeout(() => resetWishes(), 350);
                    } else {
                        wishStatus.textContent = "❌ Gagal mengirim. " + (result.error || "Coba lagi.");
                        wishStatus.style.color = "#ffb3b3";
                    }
                } catch (err) {
                    wishStatus.textContent = "❌ Error koneksi. Coba lagi.";
                    wishStatus.style.color = "#ffb3b3";
                }
            });
        });

        function toggleMusic() {
            const bgm = document.getElementById("bgm");
            const btn = document.getElementById("musicToggle");

            if (!bgm) return;

            if (bgm.paused) {
                bgm.play();
                btn.textContent = "🔊";
            } else {
                bgm.pause();
                btn.textContent = "🔇";
            }
        }

        // Animate profile on scroll
        const profiles = document.querySelectorAll('.profile');

        const profileObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('show-profile');
                }
            });
        }, {
            threshold: 0.3
        });

        profiles.forEach(el => profileObserver.observe(el));
    </script>


    <script>
        function setVH() {
            document.documentElement.style.setProperty('--vh', `${window.innerHeight * 0.01}px`);
        }
        window.addEventListener('resize', setVH);
        setVH();
    </script>

</body>

</html>