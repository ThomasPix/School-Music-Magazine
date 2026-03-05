// this code could be rewritten so it is better readable
const faves = document.getElementById("faves");
const handle = faves.querySelector(".resize-handle");
const btn = document.getElementById("shrink");

const songList = document.querySelector(".list-songs-container");

let isResizing = false;
let lastWidth = 300; 

function syncSongList(width) {
  songList.style.marginLeft = width + "px";
}

syncSongList(lastWidth);

handle.addEventListener("mousedown", () => {
  if (faves.classList.contains("shrunk")) return;
  isResizing = true;
  document.body.style.cursor = "ew-resize";
});

document.addEventListener("mousemove", (e) => {
  if (!isResizing) return;

  const newWidth = e.clientX - faves.getBoundingClientRect().left;
  const clampedWidth = Math.max(250, Math.min(600, newWidth));

  faves.style.width = clampedWidth + "px";
  syncSongList(clampedWidth);

  lastWidth = clampedWidth;
});

document.addEventListener("mouseup", () => {
  isResizing = false;
  document.body.style.cursor = "default";
});

btn.addEventListener("click", () => {
  const isShrunk = faves.classList.toggle("shrunk");

  if (isShrunk) {
    lastWidth = faves.getBoundingClientRect().width;
    faves.style.width = "50px";
    syncSongList(50);
  } else {
    faves.style.width = lastWidth + "px";
    syncSongList(lastWidth);
  }
});
