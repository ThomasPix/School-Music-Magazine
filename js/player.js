class Player {
	constructor() {this.audio = new Audio()}

	state() {
		return {
			duration: this.audio.duration,
			time: this.audio.currentTime,
			volume: this.audio.volume,
			isPlaying: (this.audio.paused ? false : true)
		}
	}

	load(link) {
		this.audio.src = link
		this.audio.load()
		this.audio.currentTime = 0
	}

	play() {this.audio.play()}
	pause() {this.audio.pause()}
	toggleplay() {
		if (this.audio.paused) {this.play()}
		else {this.pause()}
	}
	stop() {
		this.audio.pause()
		this.audio.currentTime = 0
	}
	
	volume(percent) {this.audio.volume = (percent / 100)}
	settime(seconds) {this.audio.currentTime = seconds}
}