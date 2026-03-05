const menus = ['list', 'search', 'faves', 'account']

function menu(id) {
	for (const item of menus) {document.getElementById(item).style.display = 'none'}
	document.getElementById(id).style.display = 'block'
}

const nowplaying = document.getElementById('now-playing').querySelectorAll('div')
const artist = document.getElementsByClassName('artist')[0]
const player = new Player()
const timeline = document.getElementById('timeline')
let listening = undefined

function playsong(name, artistname, file, cover, songid) {
	nowplaying[0].style.backgroundImage = `url('${cover}')`
	nowplaying[1].innerText = name
	artist.innerText = artistname
	player.load(file)
	player.play()
	timeline.value = 0
	listening = songid

	if (localStorage.getItem(`faves_${songid}`)) {heart.style.filter = 'brightness(1)'}
	else {heart.style.filter = 'brightness(100)'}
}

setInterval(() => {
	const state = player.state()
	if (state.isPlaying) {
		timeline.max = Math.floor(state.duration)
		timeline.value = state.time
	}
}, 1000)

const searchmenu = document.getElementById('searchmenu')
async function search(data){
	if (data == '') {
		searchmenu.style.display = 'none'
		return
	}

	const stream = await fetch(`./search.php?info=${data}`)

	searchmenu.innerHTML = ''
	for (const song of await stream.json()) {
		searchmenu.innerHTML += `
		<div class="faves-song" onclick="playsong('${song.Song_name}', '${song.Username}', '${song.Audio_file}', '${song.Cover}', '${song.Song_ID}')">
        	<div class="icon" style="background-image: url('${song.Cover}')"></div>
	        <div class="text-wrap">
    	        <div class="songtitle">
        	        ${song.Song_name}
	            </div>
    	        <div class="artist">
        	        ${song.Username}
	            </div>
    	    </div>
    	</div>
	`
	}
	searchmenu.style.display = 'block'
}

const favemenu = document.getElementById('skibidifaves')
const heart = document.getElementById('favefavefave')
async function fetchfaves() {
	favemenu.innerHTML = ''
	for (const songfave of Object.keys(localStorage)) {
		if (!songfave.includes('faves_')) {continue}

		const stream = await fetch(`./fave.php?id=${songfave.split('_')[1]}`)
		const song = await stream.json()

		if (!song.Song_name) {continue}

		favemenu.innerHTML += `
		<div class="faves-song" onclick="playsong('${song.Song_name}', '${song.Username}', '${song.Audio_file}', '${song.Cover}', '${song.Song_ID}')">
        	<div class="icon" style="background-image: url('${song.Cover}')"></div>
	        <div class="text-wrap">
    	        <div class="songtitle">
        	        ${song.Song_name}
	            </div>
    	        <div class="artist">
        	        ${song.Username}
	            </div>
    	    </div>
    	</div>
	`
	}
}; fetchfaves()

function fave() {
	const ls = localStorage.getItem(`faves_${listening}`)

	if (ls) {
		localStorage.removeItem(`faves_${listening}`)
		heart.style.filter = 'brightness(999)'
	} else {
		localStorage.setItem(`faves_${listening}`, 'ik klap mijn papa')
		heart.style.filter = 'brightness(1)'
	}
	fetchfaves()
}