const snapWrap = document.getElementById("snapWrap");

/* =========================
   INCLUDE HTML (LAZY LOAD)
========================= */
async function loadInto(el) {
  // sudah diload? skip
  if (el.dataset.loaded === "1") return;

  const file = el.getAttribute("data-include");
  const res = await fetch(file);
  if (!res.ok) throw new Error("not found: " + file);

  el.innerHTML = await res.text();
  el.dataset.loaded = "1";
}

// load cover dulu saja
async function loadCoverOnly() {
  const cover = document.getElementById("pageCover");
  await loadInto(cover);
}

/* =========================
   CURTAIN OPEN INVITATION
========================= */
window.openInvitation = async function () {
  const curtain = document.getElementById("curtain");
  const cover = document.getElementById("pageCover");

  // 1) cover fade out
  cover.classList.add("fade-out");

  // 2) tampilkan tirai
  curtain.classList.remove("hidden");

  // tunggu sedikit biar cover fade kerasa
  await new Promise(r => setTimeout(r, 420));

  // 3) mulai animasi buka tirai
  curtain.classList.add("open");

  // 4) munculkan halaman lain (tapi BELUM load semua)
  document.querySelectorAll(".snap-page.hidden").forEach(el => {
    el.classList.remove("hidden");
  });

  // 5) load halaman pertama setelah cover biar ga blank pas scroll
  const pages = document.querySelectorAll(".snap-page[data-include]");
  const firstAfterCover = pages[1];
  if (firstAfterCover) await loadInto(firstAfterCover);

  // 6) scroll ke halaman kedua
  snapWrap.scrollTo({ top: window.innerHeight, behavior: "smooth" });

  // 7) aktifkan lazy-load + animasi halaman aktif
  initLazyLoadPages();
  initActivePageObserver();

  // 8) hilangkan tirai setelah animasi selesai
  setTimeout(() => {
    curtain.classList.add("hidden");
    curtain.classList.remove("open");
  }, 900);
};

/* =========================
   LAZY LOAD PAGES ON VIEW
========================= */
function initLazyLoadPages() {
  const pages = document.querySelectorAll(".snap-page[data-include]");

  const obs = new IntersectionObserver(async (entries) => {
    for (const entry of entries) {
      if (entry.isIntersecting) {
        await loadInto(entry.target);

        // init RSVP jika form sudah ada
        if (entry.target.querySelector("#formRsvp")) {
          initRSVP();
        }
      }
    }
  }, {
    root: snapWrap,
    threshold: 0.35
  });

  pages.forEach(p => obs.observe(p));
}

/* =========================
   ACTIVE PAGE ANIMATION
========================= */
function initActivePageObserver() {
  const pages = document.querySelectorAll(".snap-page");

  const obs = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        pages.forEach(p => p.classList.remove("is-active"));
        entry.target.classList.add("is-active");
      }
    });
  }, {
    root: snapWrap,
    threshold: 0.6
  });

  pages.forEach(p => obs.observe(p));
}

/* =========================
   RSVP LOCAL STORAGE
========================= */
function initRSVP() {
  const form = document.getElementById("formRsvp");
  const wrap = document.getElementById("listUcapan");
  if (!form || !wrap) return;

  function loadUcapan() {
    return JSON.parse(localStorage.getItem("ucapan") || "[]");
  }
  function saveUcapan(data) {
    localStorage.setItem("ucapan", JSON.stringify(data));
  }
  function escapeHtml(str) {
    return str.replace(/[&<>"']/g, (m) => ({
      '&': '&amp;', '<': '&lt;', '>': '&gt;',
      '"': '&quot;', "'": '&#039;'
    })[m]);
  }

  function render() {
    const data = loadUcapan();
    wrap.innerHTML = "";

    if (data.length === 0) {
      wrap.innerHTML = `<p style="color:rgba(255,246,229,.6)">Belum ada ucapan 😄</p>`;
      return;
    }

    data.slice(0, 30).forEach(x => {
      const div = document.createElement("div");
      div.className = "event-box";
      div.innerHTML = `
        <div class="label">${escapeHtml(x.nama)} • <span style="color:var(--text)">${escapeHtml(x.hadir)}</span></div>
        <div class="desc">${escapeHtml(x.pesan)}</div>
        <div style="margin-top:8px;color:rgba(255,246,229,.45);font-size:12px">${escapeHtml(x.time)}</div>
      `;
      wrap.appendChild(div);
    });
  }

  // biar tidak double binding
  form.onsubmit = (e) => {
    e.preventDefault();

    const nama = document.getElementById("nama").value.trim();
    const hadir = document.getElementById("hadir").value;
    const pesan = document.getElementById("pesan").value.trim();
    if (!nama || !hadir || !pesan) return;

    const data = loadUcapan();
    data.unshift({
      nama, hadir, pesan,
      time: new Date().toLocaleString("id-ID")
    });

    saveUcapan(data);
    form.reset();
    render();
  };

  render();
}

/* =========================
   GOOGLE CALENDAR
========================= */
window.addToCalendar = function () {
  const title = encodeURIComponent("Pernikahan Hendro & Nadya");
  const details = encodeURIComponent("Undangan Pernikahan Tema Kraton Jawa");
  const location = encodeURIComponent("Pendopo Keraton, Kota Anda");

  // 07.00 WIB = 00.00 UTC
  const start = "20260404T000000Z";
  const end = "20260404T030000Z";

  const url = `https://calendar.google.com/calendar/render?action=TEMPLATE&text=${title}&details=${details}&location=${location}&dates=${start}/${end}`;
  window.open(url, "_blank");
};

/* =========================
   FIRST LOAD (COVER ONLY)
========================= */
loadCoverOnly();
