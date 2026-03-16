const App = (()=>{

/* =============================
CONFIG
============================= */

const CONFIG = {
weddingDate : new Date("2026-04-04T11:00:00+07:00"),
wishAPI : "https://script.google.com/macros/s/AKfycbwTM6a6yTIBlQlcroWpG4sI10oXOvqPXBzaprk_gsmAC4I7JCGaF_E8vYTqZc2b2-I/exec",
limit : 5
};

let nextOffset = 0;
let hasMore = true;
let loading = false;

/* =============================
UTIL
============================= */

const util = {

pad(n){
return String(n).padStart(2,"0");
},

guest(){
const p = new URLSearchParams(location.search);
return p.get("to") || "Tamu Undangan";
},

escape(str){
return String(str)
.replaceAll("&","&")
.replaceAll("<","<")
.replaceAll(">",">");
},

formatWIB(iso){

try{

const d = new Date(iso);

return new Intl.DateTimeFormat("id-ID",{
timeZone:"Asia/Jakarta",
day:"2-digit",
month:"short",
year:"numeric",
hour:"2-digit",
minute:"2-digit",
}).format(d)+" WIB";

}catch(e){return ""}

}

};

/* =============================
OPEN INVITATION
============================= */

function openInvitation(){

const cover = document.getElementById("cover");

const bgm = document.getElementById("bgm");

if(bgm){
bgm.volume = .75;
bgm.play().catch(()=>{});
}

const door = document.getElementById("doorSound");

if(door){
door.currentTime=0;
door.play().catch(()=>{});
}

particles();

cover.classList.add("open");

setTimeout(()=>{

cover.classList.add("hidden");

document.getElementById("snap").scrollTo({
top:0,
behavior:"smooth"
});

},1700);

}

/* =============================
COUNTDOWN
============================= */

function countdown(){

function update(){

let diff = CONFIG.weddingDate - new Date();

if(diff<=0) diff=0;

const s = Math.floor(diff/1000);

const d = Math.floor(s/86400);
const h = Math.floor((s%86400)/3600);
const m = Math.floor((s%3600)/60);
const sec = s%60;

document.getElementById("cdDays").textContent=util.pad(d);
document.getElementById("cdHours").textContent=util.pad(h);
document.getElementById("cdMinutes").textContent=util.pad(m);
document.getElementById("cdSeconds").textContent=util.pad(sec);

}

update();

setInterval(update,1000);

}

/* =============================
SHARE WA
============================= */

function shareWA(){

const guest = util.guest();
const url = location.href;

const text = `Assalamu’alaikum 🙏

Dengan hormat kami mengundang *${guest}*

✨ Undangan Digital
${url}

Terima kasih`;

window.open(
`https://wa.me/?text=${encodeURIComponent(text)}`,
"_blank"
);

}

/* =============================
MUSIC
============================= */

function toggleMusic(){

const bgm = document.getElementById("bgm");
const btn = document.getElementById("musicToggle");

if(!bgm) return;

if(bgm.paused){

bgm.play();
btn.textContent="🔊";

}else{

bgm.pause();
btn.textContent="🔇";

}

}

/* =============================
PAGE ANIMATION
============================= */

function pageAnimation(){

const cards = document.querySelectorAll('[data-animate="page"]');

const obs = new IntersectionObserver(entries=>{

entries.forEach(e=>{

if(e.isIntersecting){

e.target.classList.add("show");
obs.unobserve(e.target);

}

});

},{threshold:.25});

cards.forEach(el=>obs.observe(el));

}

/* =============================
PROFILE ANIMATION
============================= */

function profileAnimation(){

const profiles = document.querySelectorAll(".profile");

const obs = new IntersectionObserver(entries=>{

entries.forEach(e=>{
if(e.isIntersecting){
e.target.classList.add("show-profile");
}
});

},{threshold:.3});

profiles.forEach(el=>obs.observe(el));

}

/* =============================
VH FIX
============================= */

function fixVH(){

function setVH(){

document.documentElement.style.setProperty(
"--vh",
`${window.innerHeight*.01}px`
);

}

setVH();

window.addEventListener("resize",setVH);

}

/* =============================
PARTICLE
============================= */

function particles(){

const container = document.getElementById("goldDust");

if(!container) return;

for(let i=0;i<120;i++){

const p = document.createElement("div");

p.className="gold-particle";

p.style.left = Math.random()*100+"%";
p.style.bottom="10%";
p.style.animationDelay=(Math.random()*1.5)+"s";

const spread = (Math.random()*400-200);

p.style.transform=`translateX(${spread}px)`;

const size = 4+Math.random()*6;

p.style.width=size+"px";
p.style.height=size+"px";

container.appendChild(p);

setTimeout(()=>p.remove(),3500);

}

}

/* =============================
WISHES SYSTEM
============================= */

async function sendWish(nama,ucapan){

const res = await fetch(CONFIG.wishAPI,{
method:"POST",
headers:{
"Content-Type":"text/plain;charset=utf-8"
},
body:JSON.stringify({nama,ucapan})
});

return JSON.parse(await res.text());

}

async function fetchWish(offset=0){

const url =
`${CONFIG.wishAPI}?mode=get&offset=${offset}&limit=${CONFIG.limit}&ts=${Date.now()}`;

const res = await fetch(url);

return JSON.parse(await res.text());

}

function renderWish(name,msg,time){

const el = document.createElement("div");

el.className="wish-item";

el.innerHTML = `

<div class="wish-head">
<div class="wish-name">${util.escape(name)}</div>
<div class="wish-time">${util.formatWIB(time)}</div>
</div>
<div class="wish-msg">${util.escape(msg)}</div>
`;

return el;

}

async function loadWish(reset=false){

if(loading) return;

loading=true;

const list = document.getElementById("wishList");

if(reset){
list.innerHTML=`<div class="muted">Loading...</div>`;
nextOffset=0;
hasMore=true;
}

const res = await fetchWish(nextOffset);

if(reset) list.innerHTML="";

(res.data||[]).forEach(item=>{

list.appendChild(
renderWish(item.nama,item.ucapan,item.timestamp)
);

});

nextOffset = res.nextOffset ?? nextOffset;
hasMore = !!res.hasMore;

loading=false;

}

function wishSystem(){

const form = document.getElementById("wishForm");

if(!form) return;

loadWish(true);

form.addEventListener("submit",async e=>{

e.preventDefault();

const name = document.getElementById("wishName").value.trim();
const msg = document.getElementById("wishMsg").value.trim();

if(!name||!msg) return;

await sendWish(name,msg);

form.reset();

setTimeout(()=>loadWish(true),300);

});

}

/* =============================
INIT
============================= */

function init(){

const guest = util.guest();

const g1 = document.getElementById("guestName");
const g2 = document.getElementById("guestName2");

if(g1) g1.textContent=guest;
if(g2) g2.textContent=guest;

countdown();
pageAnimation();
profileAnimation();
fixVH();
wishSystem();

}

/* =============================
EXPORT
============================= */

return{
init,
openInvitation,
shareWA,
toggleMusic
};

})();

document.addEventListener("DOMContentLoaded",App.init);


function copyRek(id){
  const text = document.getElementById(id).innerText;
  navigator.clipboard.writeText(text);
  alert("Nomor rekening berhasil disalin");
}

function copyText(btn){
  const text = btn.parentElement.querySelector(".gift-address").innerText;
  navigator.clipboard.writeText(text);
  alert("Alamat berhasil disalin");
}
