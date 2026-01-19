<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Student Timetable Maker</title>
  <style>
    :root{
      --bg:#0b1020;
      --card:rgba(255,255,255,.06);
      --card2:rgba(255,255,255,.10);
      --text:#eaf0ff;
      --muted:rgba(234,240,255,.75);
      --line:rgba(255,255,255,.10);
      --accent:#7c5cff;
      --accent2:#2dd4bf;
      --radius:18px;
      --shadow: 0 18px 60px rgba(0,0,0,.45);
      --gridbg: rgba(255,255,255,.03);
    }

    *{box-sizing:border-box}
    body{
      margin:0;
      font-family: ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, Arial;
      background:
        radial-gradient(1200px 600px at 20% 10%, rgba(124,92,255,.30), transparent 55%),
        radial-gradient(900px 520px at 85% 20%, rgba(45,212,191,.18), transparent 55%),
        radial-gradient(700px 600px at 60% 90%, rgba(255,160,60,.15), transparent 60%),
        var(--bg);
      color:var(--text);
      min-height:100vh;
    }

    .wrap{
      max-width:1200px;
      margin:24px auto;
      padding:0 16px 40px;
      display:grid;
      grid-template-columns: 360px 1fr;
      gap:16px;
    }

    .panel{
      background: var(--card);
      border:1px solid var(--line);
      border-radius: var(--radius);
      box-shadow: var(--shadow);
      overflow:hidden;
    }

    .panel .head{
      padding:16px 16px 12px;
      border-bottom:1px solid var(--line);
      background: linear-gradient(180deg, rgba(255,255,255,.05), transparent);
    }

    .title{
      display:flex;
      align-items:flex-start;
      justify-content:space-between;
      gap:10px;
    }

    h1{
      font-size:18px;
      margin:0 0 4px 0;
      letter-spacing:.2px;
    }
    .sub{
      font-size:12px;
      color:var(--muted);
      line-height:1.35;
    }

    .badge{
      padding:8px 10px;
      font-size:12px;
      border-radius:999px;
      border:1px solid var(--line);
      background:rgba(255,255,255,.06);
      color:var(--muted);
      white-space:nowrap;
    }

    .body{
      padding:14px 16px 16px;
    }

    .row{
      display:grid;
      gap:10px;
      margin-bottom:10px;
    }
    label{
      font-size:12px;
      color:var(--muted);
      margin-bottom:6px;
      display:block;
    }
    input, select, textarea{
      width:100%;
      border-radius:14px;
      border:1px solid var(--line);
      background: rgba(0,0,0,.25);
      color:var(--text);
      padding:10px 12px;
      outline:none;
      transition: .18s;
    }
    textarea{min-height:70px; resize:vertical}
    input:focus, select:focus, textarea:focus{
      border-color: rgba(124,92,255,.55);
      box-shadow: 0 0 0 4px rgba(124,92,255,.18);
    }

    .two{
      grid-template-columns: 1fr 1fr;
    }
    .three{
      grid-template-columns: 1fr 1fr 1fr;
    }

    .btns{
      display:flex;
      gap:10px;
      flex-wrap:wrap;
      margin-top:8px;
    }
    .btn{
      border:1px solid var(--line);
      background: rgba(255,255,255,.08);
      color:var(--text);
      padding:10px 12px;
      border-radius:14px;
      cursor:pointer;
      font-weight:600;
      transition:.18s;
      display:inline-flex;
      align-items:center;
      gap:8px;
    }
    .btn:hover{ transform: translateY(-1px); background: rgba(255,255,255,.12); }
    .btn.primary{
      border-color: rgba(124,92,255,.55);
      background: linear-gradient(180deg, rgba(124,92,255,.32), rgba(124,92,255,.12));
    }
    .btn.danger{
      border-color: rgba(255,90,90,.45);
      background: rgba(255,90,90,.12);
    }
    .btn.ghost{
      background: transparent;
    }

    .hint{
      margin-top:12px;
      font-size:12px;
      color:var(--muted);
      line-height:1.5;
      border-top:1px dashed var(--line);
      padding-top:12px;
    }

    /* Timetable */
    .board{
      background:
        radial-gradient(900px 380px at 35% 10%, rgba(124,92,255,.18), transparent 60%),
        radial-gradient(700px 320px at 80% 20%, rgba(45,212,191,.12), transparent 60%),
        var(--card);
      border:1px solid var(--line);
      border-radius: var(--radius);
      box-shadow: var(--shadow);
      overflow:hidden;
      position:relative;
    }

    .boardHead{
      display:flex;
      align-items:center;
      justify-content:space-between;
      gap:12px;
      padding:14px 16px;
      border-bottom:1px solid var(--line);
      background: linear-gradient(180deg, rgba(255,255,255,.05), transparent);
    }
    .boardHead h2{
      margin:0;
      font-size:16px;
      letter-spacing:.2px;
    }
    .boardActions{
      display:flex;
      gap:10px;
      flex-wrap:wrap;
      justify-content:flex-end;
    }

    .gridWrap{
      padding:12px;
      overflow:auto;
    }

    .grid{
      display:grid;
      grid-template-columns: 90px repeat(5, 1fr);
      min-width: 900px;
      border:1px solid var(--line);
      border-radius:16px;
      overflow:hidden;
      background: rgba(0,0,0,.20);
    }

    .cell, .timeCell, .dayHead{
      border-right:1px solid var(--line);
      border-bottom:1px solid var(--line);
      padding:10px;
      position:relative;
    }
    .dayHead{
      background: rgba(255,255,255,.06);
      font-weight:700;
      font-size:12px;
      text-align:center;
      letter-spacing:.3px;
    }
    .timeCell{
      background: rgba(255,255,255,.04);
      font-size:12px;
      color:var(--muted);
      text-align:right;
      padding-right:12px;
      font-variant-numeric: tabular-nums;
    }
    .cell{
      background: var(--gridbg);
      height:64px; /* per slot */
    }
    .cell:hover{
      outline:2px solid rgba(124,92,255,.25);
      outline-offset:-2px;
    }

    .block{
      position:absolute;
      inset:6px 6px 6px 6px;
      border-radius:14px;
      padding:10px 10px 9px;
      display:flex;
      flex-direction:column;
      gap:6px;
      border:1px solid rgba(255,255,255,.15);
      box-shadow: 0 12px 24px rgba(0,0,0,.25);
      cursor:grab;
      user-select:none;
      overflow:hidden;
    }
    .block:active{ cursor:grabbing; }
    .bTop{
      display:flex; align-items:flex-start; justify-content:space-between; gap:10px;
    }
    .bTitle{
      font-weight:900;
      font-size:13px;
      line-height:1.1;
      letter-spacing:.2px;
    }
    .bMeta{
      font-size:11px;
      opacity:.9;
      line-height:1.2;
    }
    .bTiny{
      font-size:11px;
      color: rgba(255,255,255,.92);
      opacity:.95;
      display:flex;
      gap:8px;
      flex-wrap:wrap;
    }
    .pill{
      display:inline-flex;
      padding:4px 8px;
      border-radius:999px;
      background: rgba(255,255,255,.16);
      border:1px solid rgba(255,255,255,.14);
      font-weight:700;
    }

    /* Modal */
    .modal{
      position:fixed;
      inset:0;
      background: rgba(0,0,0,.60);
      display:none;
      align-items:center;
      justify-content:center;
      padding:18px;
      z-index:50;
    }
    .modal.show{ display:flex; }
    .modalCard{
      width:min(560px, 100%);
      background: rgba(20,24,40,.92);
      border:1px solid rgba(255,255,255,.12);
      border-radius: 18px;
      box-shadow: 0 22px 80px rgba(0,0,0,.55);
      overflow:hidden;
      backdrop-filter: blur(10px);
    }
    .modalHead{
      padding:14px 16px;
      border-bottom:1px solid rgba(255,255,255,.10);
      display:flex;
      align-items:center;
      justify-content:space-between;
      gap:10px;
    }
    .modalHead h3{ margin:0; font-size:14px; }
    .x{
      border:1px solid rgba(255,255,255,.14);
      background: rgba(255,255,255,.08);
      color:var(--text);
      border-radius:12px;
      cursor:pointer;
      padding:8px 10px;
      font-weight:900;
    }
    .modalBody{ padding:14px 16px 16px; }

    /* Themes */
    .themeRow{ display:flex; gap:10px; flex-wrap:wrap; }
    .themeChip{
      padding:10px 12px;
      border-radius:999px;
      border:1px solid var(--line);
      background: rgba(255,255,255,.06);
      cursor:pointer;
      font-weight:800;
      font-size:12px;
      color: var(--muted);
    }
    .themeChip.active{
      color: var(--text);
      border-color: rgba(124,92,255,.55);
      background: rgba(124,92,255,.18);
    }

    /* Print */
    @media print{
      body{ background:white !important; color:black !important; }
      .wrap{ grid-template-columns: 1fr; max-width: 100%; margin:0; padding:0; }
      .panel{ display:none !important; }
      .board{ box-shadow:none !important; border:none !important; }
      .boardHead .boardActions{ display:none !important; }
      .boardHead{ border:none !important; }
      .gridWrap{ padding:0 !important; }
      .grid{ min-width: 0 !important; border:1px solid #ddd !important; background:white !important; }
      .dayHead, .timeCell{ background:#f3f3f3 !important; color:#222 !important; }
      .cell{ background:white !important; }
      .block{
        box-shadow:none !important;
        border:1px solid #999 !important;
        color:#111 !important;
      }
      .pill{ background:#eee !important; border:1px solid #ddd !important; color:#111 !important; }
    }

    @media (max-width: 980px){
      .wrap{ grid-template-columns: 1fr; }
    }
  </style>
</head>
<body>
  <div class="wrap">
    <!-- Left Controls -->
    <section class="panel">
      <div class="head">
        <div class="title">
          <div>
            <h1>Timetable Scheduler Maker</h1>
            <div class="sub">Add classes dynamically, make it cantik, then print. Auto-saves on this browser.</div>
          </div>
          <div class="badge" id="countBadge">0 classes</div>
        </div>
      </div>

      <div class="body">
        <div class="row">
          <label>Subject / Activity</label>
          <input id="title" placeholder="e.g. KP35203 Network Programming"/>
        </div>

        <div class="row two">
          <div>
            <label>Day</label>
            <select id="day">
              <option value="Mon">Monday</option>
              <option value="Tue">Tuesday</option>
              <option value="Wed">Wednesday</option>
              <option value="Thu">Thursday</option>
              <option value="Fri">Friday</option>
            </select>
          </div>
          <div>
            <label>Start Time</label>
            <select id="start"></select>
          </div>
        </div>

        <div class="row three">
          <div>
            <label>Duration</label>
            <select id="dur">
              <option value="1">1 slot (1 hour)</option>
              <option value="2">2 slots (2 hours)</option>
              <option value="3">3 slots (3 hours)</option>
              <option value="4">4 slots (4 hours)</option>
            </select>
          </div>
          <div>
            <label>Location</label>
            <input id="loc" placeholder="e.g. Lab BK3"/>
          </div>
          <div>
            <label>Lecturer</label>
            <input id="lec" placeholder="e.g. Dr. ____"/>
          </div>
        </div>

        <div class="row">
          <label>Notes (optional)</label>
          <textarea id="notes" placeholder="e.g. Bring laptop, quiz week 5"></textarea>
        </div>

        <div class="row two">
          <div>
            <label>Color</label>
            <input id="color" type="color" value="#7c5cff" />
          </div>
          <div>
            <label>Style</label>
            <select id="style">
              <option value="glass">Glass</option>
              <option value="solid">Solid</option>
              <option value="gradient">Gradient</option>
            </select>
          </div>
        </div>

        <div class="btns">
          <button class="btn primary" id="addBtn">➕ Add to Timetable</button>
          <button class="btn ghost" id="clearBtn">🧹 Clear All</button>
          <button class="btn" id="exportBtn">⬇️ Export JSON</button>
          <label class="btn" for="importFile" style="cursor:pointer;">⬆️ Import JSON</label>
          <input id="importFile" type="file" accept="application/json" hidden />
        </div>

        <div class="hint">
          <b>Tips:</b><br/>
          • Click a class block to edit/delete.<br/>
          • Drag a block to move it to another time/day.<br/>
          • Print = clean version for submission.
        </div>

        <div style="margin-top:12px">
          <label>Theme</label>
          <div class="themeRow" id="themes">
            <div class="themeChip active" data-theme="purple">Purple Night</div>
            <div class="themeChip" data-theme="mint">Mint Clean</div>
            <div class="themeChip" data-theme="sunset">Sunset</div>
          </div>
        </div>
      </div>
    </section>

    <!-- Timetable -->
    <section class="board">
      <div class="boardHead">
        <h2>Your Weekly Timetable</h2>
        <div class="boardActions">
          <button class="btn" id="printBtn">🖨️ Print</button>
          <button class="btn" id="resetLayoutBtn">↺ Reset Layout</button>
        </div>
      </div>

      <div class="gridWrap">
        <div class="grid" id="grid"></div>
      </div>
    </section>
  </div>

  <!-- Modal for editing -->
  <div class="modal" id="modal">
    <div class="modalCard">
      <div class="modalHead">
        <h3>Edit Class</h3>
        <button class="x" id="closeModal">✕</button>
      </div>
      <div class="modalBody">
        <div class="row">
          <label>Subject / Activity</label>
          <input id="m_title"/>
        </div>

        <div class="row two">
          <div>
            <label>Day</label>
            <select id="m_day">
              <option value="Mon">Monday</option>
              <option value="Tue">Tuesday</option>
              <option value="Wed">Wednesday</option>
              <option value="Thu">Thursday</option>
              <option value="Fri">Friday</option>
            </select>
          </div>
          <div>
            <label>Start Time</label>
            <select id="m_start"></select>
          </div>
        </div>

        <div class="row three">
          <div>
            <label>Duration</label>
            <select id="m_dur">
              <option value="1">1 hour</option>
              <option value="2">2 hours</option>
              <option value="3">3 hours</option>
              <option value="4">4 hours</option>
            </select>
          </div>
          <div>
            <label>Location</label>
            <input id="m_loc"/>
          </div>
          <div>
            <label>Lecturer</label>
            <input id="m_lec"/>
          </div>
        </div>

        <div class="row">
          <label>Notes</label>
          <textarea id="m_notes"></textarea>
        </div>

        <div class="row two">
          <div>
            <label>Color</label>
            <input id="m_color" type="color"/>
          </div>
          <div>
            <label>Style</label>
            <select id="m_style">
              <option value="glass">Glass</option>
              <option value="solid">Solid</option>
              <option value="gradient">Gradient</option>
            </select>
          </div>
        </div>

        <div class="btns">
          <button class="btn primary" id="saveEdit">💾 Save</button>
          <button class="btn danger" id="deleteItem">🗑️ Delete</button>
        </div>
      </div>
    </div>
  </div>

<script>
/* ----------------- Config ----------------- */
const DAYS = ["Mon","Tue","Wed","Thu","Fri"];
const DAY_LABEL = {Mon:"MON", Tue:"TUE", Wed:"WED", Thu:"THU", Fri:"FRI"};

// time slots: 8am - 6pm (10 slots)
const START_HOUR = 8;
const END_HOUR = 18; // exclusive
const SLOTS = [];
for(let h=START_HOUR; h<END_HOUR; h++){
  SLOTS.push(`${String(h).padStart(2,"0")}:00`);
}

const STORAGE_KEY = "student_timetable_v1";

/* ----------------- State ----------------- */
let items = []; // {id,title,day,startIndex,dur,loc,lec,notes,color,style}
let editingId = null;

/* ----------------- Helpers ----------------- */
const $ = (q)=>document.querySelector(q);
const uid = ()=> Math.random().toString(16).slice(2) + Date.now().toString(16);

function timeLabel(idx){
  const h = START_HOUR + idx;
  const hh = String(h).padStart(2,"0");
  return `${hh}:00`;
}
function clamp(n,min,max){ return Math.max(min, Math.min(max,n)); }

function styleBackground(color, style){
  if(style === "solid") return `linear-gradient(180deg, ${color}, ${color})`;
  if(style === "gradient") return `linear-gradient(135deg, ${color}, rgba(255,255,255,.12))`;
  // glass
  return `linear-gradient(135deg, ${hexToRgba(color,.35)}, rgba(255,255,255,.08))`;
}
function hexToRgba(hex, a){
  const h = hex.replace("#","");
  const r = parseInt(h.substring(0,2), 16);
  const g = parseInt(h.substring(2,4), 16);
  const b = parseInt(h.substring(4,6), 16);
  return `rgba(${r},${g},${b},${a})`;
}

function save(){
  localStorage.setItem(STORAGE_KEY, JSON.stringify(items));
  updateCount();
}
function load(){
  try{
    const raw = localStorage.getItem(STORAGE_KEY);
    if(!raw) return;
    const data = JSON.parse(raw);
    if(Array.isArray(data)) items = data;
  }catch(e){}
  updateCount();
}
function updateCount(){
  const n = items.length;
  $("#countBadge").textContent = `${n} class${n===1?"":"es"}`;
}

/* ----------------- Build Select Options ----------------- */
function fillTimeSelect(sel){
  sel.innerHTML = "";
  SLOTS.forEach((t, i)=>{
    const opt = document.createElement("option");
    opt.value = String(i);
    opt.textContent = t;
    sel.appendChild(opt);
  });
}

fillTimeSelect($("#start"));
fillTimeSelect($("#m_start"));

/* ----------------- Build Grid ----------------- */
function buildGrid(){
  const grid = $("#grid");
  grid.innerHTML = "";

  // Row 0 headers
  // top-left empty cell
  const topLeft = document.createElement("div");
  topLeft.className = "dayHead";
  topLeft.textContent = "TIME";
  grid.appendChild(topLeft);

  DAYS.forEach(d=>{
    const h = document.createElement("div");
    h.className = "dayHead";
    h.textContent = DAY_LABEL[d];
    grid.appendChild(h);
  });

  // Slot rows
  for(let r=0; r<SLOTS.length; r++){
    const timeCell = document.createElement("div");
    timeCell.className = "timeCell";
    timeCell.textContent = SLOTS[r];
    grid.appendChild(timeCell);

    for(let c=0; c<DAYS.length; c++){
      const cell = document.createElement("div");
      cell.className = "cell";
      cell.dataset.day = DAYS[c];
      cell.dataset.startIndex = String(r);
      cell.addEventListener("dblclick", ()=>{
        // quick add: fill day + start and focus title
        $("#day").value = DAYS[c];
        $("#start").value = String(r);
        $("#title").focus();
      });
      grid.appendChild(cell);
    }
  }
}

buildGrid();

/* ----------------- Render Items ----------------- */
function clearBlocks(){
  document.querySelectorAll(".block").forEach(b=>b.remove());
}

function render(){
  clearBlocks();

  for(const it of items){
    const cell = findCell(it.day, it.startIndex);
    if(!cell) continue;

    const block = document.createElement("div");
    block.className = "block";
    block.dataset.id = it.id;

    block.style.background = styleBackground(it.color, it.style);
    block.style.borderColor = hexToRgba(it.color, .55);
    block.style.backdropFilter = "blur(10px)";
    block.style.height = `calc(${it.dur} * 64px - 12px)`; // slot height minus inset
    block.style.top = "6px";
    block.style.left = "6px";
    block.style.right = "6px";

    block.innerHTML = `
      <div class="bTop">
        <div>
          <div class="bTitle">${escapeHtml(it.title || "Untitled")}</div>
          <div class="bMeta">${SLOTS[it.startIndex]} • ${it.dur}h</div>
        </div>
        <div class="pill">${it.day}</div>
      </div>
      <div class="bTiny">
        ${it.loc ? `<span class="pill">📍 ${escapeHtml(it.loc)}</span>` : ""}
        ${it.lec ? `<span class="pill">👤 ${escapeHtml(it.lec)}</span>` : ""}
      </div>
    `;

    // click to edit
    block.addEventListener("click", (e)=>{
      e.stopPropagation();
      openEdit(it.id);
    });

    // drag to move
    enableDrag(block);

    cell.appendChild(block);
  }

  save();
}

function escapeHtml(str){
  return String(str).replace(/[&<>"']/g, (m)=>({
    "&":"&amp;","<":"&lt;",">":"&gt;",'"':"&quot;","'":"&#039;"
  }[m]));
}

function findCell(day, startIndex){
  return document.querySelector(`.cell[data-day="${day}"][data-start-index="${startIndex}"]`);
}

/* ----------------- Add Item ----------------- */
$("#addBtn").addEventListener("click", ()=>{
  const title = $("#title").value.trim();
  const day = $("#day").value;
  const startIndex = parseInt($("#start").value, 10);
  const dur = parseInt($("#dur").value, 10);
  const loc = $("#loc").value.trim();
  const lec = $("#lec").value.trim();
  const notes = $("#notes").value.trim();
  const color = $("#color").value;
  const style = $("#style").value;

  if(!title){
    $("#title").focus();
    alert("Please enter Subject / Activity.");
    return;
  }

  // prevent overflow
  const safeStart = clamp(startIndex, 0, SLOTS.length-1);
  const safeDur = clamp(dur, 1, SLOTS.length - safeStart);

  const item = {
    id: uid(),
    title, day,
    startIndex: safeStart,
    dur: safeDur,
    loc, lec, notes,
    color, style
  };

  items.push(item);
  render();

  // reset small fields but keep theme color
  $("#title").value = "";
  $("#loc").value = "";
  $("#lec").value = "";
  $("#notes").value = "";
});

/* ----------------- Clear ----------------- */
$("#clearBtn").addEventListener("click", ()=>{
  if(!confirm("Clear all classes?")) return;
  items = [];
  render();
});

/* ----------------- Print ----------------- */
$("#printBtn").addEventListener("click", ()=>window.print());

/* ----------------- Reset Layout ----------------- */
$("#resetLayoutBtn").addEventListener("click", ()=>{
  // just rerender (useful if something overlaps)
  render();
});

/* ----------------- Modal Edit ----------------- */
const modal = $("#modal");

function openEdit(id){
  const it = items.find(x=>x.id===id);
  if(!it) return;
  editingId = id;

  $("#m_title").value = it.title || "";
  $("#m_day").value = it.day;
  $("#m_start").value = String(it.startIndex);
  $("#m_dur").value = String(it.dur);
  $("#m_loc").value = it.loc || "";
  $("#m_lec").value = it.lec || "";
  $("#m_notes").value = it.notes || "";
  $("#m_color").value = it.color || "#7c5cff";
  $("#m_style").value = it.style || "glass";

  modal.classList.add("show");
}

function closeEdit(){
  modal.classList.remove("show");
  editingId = null;
}

$("#closeModal").addEventListener("click", closeEdit);
modal.addEventListener("click", (e)=>{ if(e.target === modal) closeEdit(); });
document.addEventListener("keydown", (e)=>{ if(e.key === "Escape") closeEdit(); });

$("#saveEdit").addEventListener("click", ()=>{
  const it = items.find(x=>x.id===editingId);
  if(!it) return;

  it.title = $("#m_title").value.trim() || "Untitled";
  it.day = $("#m_day").value;
  it.startIndex = clamp(parseInt($("#m_start").value,10), 0, SLOTS.length-1);
  it.dur = clamp(parseInt($("#m_dur").value,10), 1, SLOTS.length - it.startIndex);
  it.loc = $("#m_loc").value.trim();
  it.lec = $("#m_lec").value.trim();
  it.notes = $("#m_notes").value.trim();
  it.color = $("#m_color").value;
  it.style = $("#m_style").value;

  closeEdit();
  render();
});

$("#deleteItem").addEventListener("click", ()=>{
  if(!editingId) return;
  if(!confirm("Delete this class?")) return;
  items = items.filter(x=>x.id !== editingId);
  closeEdit();
  render();
});

/* ----------------- Drag and Drop ----------------- */
function enableDrag(block){
  let dragging = false;
  let startX=0, startY=0;

  block.addEventListener("mousedown", (e)=>{
    // ignore if right click
    if(e.button !== 0) return;
    dragging = true;
    startX = e.clientX;
    startY = e.clientY;
    block.style.opacity = "0.92";
  });

  window.addEventListener("mousemove", (e)=>{
    if(!dragging) return;
    // small "ghost" effect
    const dx = e.clientX - startX;
    const dy = e.clientY - startY;
    block.style.transform = `translate(${dx}px, ${dy}px) scale(1.01)`;
  });

  window.addEventListener("mouseup", (e)=>{
    if(!dragging) return;
    dragging = false;
    block.style.opacity = "";
    block.style.transform = "";

    // figure out which cell under cursor
    const el = document.elementFromPoint(e.clientX, e.clientY);
    const cell = el?.closest?.(".cell");
    if(!cell) return;

    const id = block.dataset.id;
    const it = items.find(x=>x.id===id);
    if(!it) return;

    it.day = cell.dataset.day;
    it.startIndex = parseInt(cell.dataset.startIndex,10);
    it.dur = clamp(it.dur, 1, SLOTS.length - it.startIndex);
    render();
  });
}

/* ----------------- Theme Switch ----------------- */
const themeEl = $("#themes");
themeEl.addEventListener("click", (e)=>{
  const chip = e.target.closest(".themeChip");
  if(!chip) return;

  document.querySelectorAll(".themeChip").forEach(c=>c.classList.remove("active"));
  chip.classList.add("active");

  const t = chip.dataset.theme;
  if(t==="purple"){
    setRoot({
      "--bg":"#0b1020",
      "--accent":"#7c5cff",
      "--accent2":"#2dd4bf",
      "--gridbg":"rgba(255,255,255,.03)"
    });
  }
  if(t==="mint"){
    setRoot({
      "--bg":"#071318",
      "--accent":"#22c55e",
      "--accent2":"#38bdf8",
      "--gridbg":"rgba(255,255,255,.035)"
    });
  }
  if(t==="sunset"){
    setRoot({
      "--bg":"#120a12",
      "--accent":"#ff6a3d",
      "--accent2":"#fbbf24",
      "--gridbg":"rgba(255,255,255,.032)"
    });
  }
});

function setRoot(vars){
  for(const k in vars){
    document.documentElement.style.setProperty(k, vars[k]);
  }
}

/* ----------------- Export/Import JSON ----------------- */
$("#exportBtn").addEventListener("click", ()=>{
  const blob = new Blob([JSON.stringify(items, null, 2)], {type:"application/json"});
  const url = URL.createObjectURL(blob);
  const a = document.createElement("a");
  a.href = url;
  a.download = "timetable.json";
  document.body.appendChild(a);
  a.click();
  a.remove();
  URL.revokeObjectURL(url);
});

$("#importFile").addEventListener("change", async (e)=>{
  const file = e.target.files?.[0];
  if(!file) return;
  try{
    const text = await file.text();
    const data = JSON.parse(text);
    if(!Array.isArray(data)) throw new Error("Invalid format");
    // basic sanitize
    items = data.map(x=>({
      id: x.id || uid(),
      title: String(x.title || "Untitled"),
      day: DAYS.includes(x.day) ? x.day : "Mon",
      startIndex: clamp(parseInt(x.startIndex ?? 0,10)||0, 0, SLOTS.length-1),
      dur: clamp(parseInt(x.dur ?? 1,10)||1, 1, SLOTS.length),
      loc: String(x.loc || ""),
      lec: String(x.lec || ""),
      notes: String(x.notes || ""),
      color: String(x.color || "#7c5cff"),
      style: ["glass","solid","gradient"].includes(x.style) ? x.style : "glass"
    }));
    render();
    alert("Imported successfully!");
  }catch(err){
    alert("Failed to import JSON.");
  }finally{
    e.target.value = "";
  }
});

/* ----------------- Init ----------------- */
load();
render();
</script>
</body>
</html>
