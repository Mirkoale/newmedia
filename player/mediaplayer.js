const player = document.querySelector('#audioDisplay')
const progress = document.getElementById('progress')
const playBtn = document.getElementById('playbtn')
const barVolume = document.querySelector('#volume')

const api = './mediaread/mediaencoded.json'
fetch(api)
.then(response=> {

   let data = response.json()
   return data    
               
})            
.then(data=>{   

   //audio

   let audio = data
   
   audio.forEach(function (el) {
      var audioList = document.getElementById('audioList')
      var audioPath = el.dir

      var mediaSelect = document.createElement('button')
      mediaSelect.setAttribute('data-src', audioPath)
      mediaSelect.classList.add('playlist')

      var title = el.name
      mediaSelect.innerText = title

      var src = mediaSelect.getAttribute('data-src')
      
      var setTitle = document.getElementById('musicTitle')      
      
      mediaSelect.addEventListener('click', function (e) {
         e.preventDefault()
         
         
         setTitle.innerText = title         

         if (playBtn.classList.contains('fa-pause')) {
            playBtn.classList.remove('fa-pause')
            playBtn.classList.add('fa-play')
         }

         progress.style.width = 0
         player.src = src
         player.load()
         
      })

      audioList.appendChild(mediaSelect)
      
           
   })
   let mediaSelect = document.querySelectorAll('button')
   return mediaSelect
   
})
.then( mediaSelect=>{
   let mediaArr = Array.from(mediaSelect)   
   let setTitle = document.querySelector('#musicTitle')


   function goPrev() {

      let filter = mediaArr.filter(function (e){
         return e.textContent == setTitle.textContent
      })
            
      let prevTrack = filter[0].previousSibling
      
      if(!prevTrack){
         prevTrack = mediaArr[mediaArr.length - 1]
      }
   
      setTitle.textContent = prevTrack.textContent
      let src3 = prevTrack.getAttribute('data-src')
      
      player.src = src3
      player.load()
      player.play()   

   }



   function goNext() {
      let filter = mediaArr.filter(function (e){
         return e.textContent == setTitle.textContent
      })
            
      let nextTrack = filter[0].nextSibling
      console.log(nextTrack);
      if(!nextTrack){
         nextTrack = mediaArr[0]
      }
   
      setTitle.textContent = nextTrack.textContent
      let src2 = nextTrack.getAttribute('data-src')
      console.log(src2)
      player.src = src2
      player.load()
      player.play()
   }
   
   /*LOOP AFTER END*/
   /*================================*/

   player.addEventListener('ended', () => {  
      goNext()
            
   })

   /*NEXT */
   /*================================*/

   let next = document.querySelector('#next')
   next.addEventListener('click', goNext)

   /*PREVIOUS*/
   /*================================*/

   let previous = document.querySelector('#previous')
   console.log(previous);
   previous.addEventListener('click', goPrev)

   


})


// volume

//mute
var muteUnmute = document.querySelector('#mute')
//console.log(muteUnmute)
muteUnmute.addEventListener('click', function () {
   if (player.muted == false) {
      player.muted = true,
         muteUnmute.classList.remove('fa-volume')
      muteUnmute.classList.add('fa-volume-mute')
   } else {
      player.muted = false,
         muteUnmute.classList.remove('fa-volume-mute')
      muteUnmute.classList.add('fa-volume')

   }
})
//volume

player.volume = barVolume.value / 100
barVolume.addEventListener('change', function () {
   player.volume = barVolume.value / 100

   if (player.volume == 0) {
      muteUnmute.classList.remove('fa-volume')
      muteUnmute.classList.add('fa-volume-mute')

   } else {
      muteUnmute.classList.remove('fa-volume-mute')
      muteUnmute.classList.add('fa-volume')

   }

}) 

/*PLAY PAUSE */
/*================================*/

var playPause = function () {
   if (player.paused) {
      player.play();
   } else {
      player.pause()
   }
}


playBtn.addEventListener('click', playPause)
document.addEventListener('keydown', (e) => {

   if (e.code === "Space") {
      e.preventDefault()
       playPause()
   }
})

player.onplay = function () {
   playBtn.classList.remove('fa-play')
   playBtn.classList.add('fa-pause')
}
player.onpause = function () {
   playBtn.classList.remove('fa-pause')
   playBtn.classList.add('fa-play')
}

/*TIME */
/*================================*/

player.ontimeupdate = function () {
   let ct = player.currentTime;
   tempo.innerHTML = timeFormat(ct)

   let duration = player.duration;
   prog = Math.floor((ct * 100) / duration)
   progress.style.width = prog + '%'
}

function timeFormat(ct) {
   minutes = Math.floor(ct / 60)
   seconds = Math.floor(ct % 60)

   if (seconds < 10) {
      seconds = '0' + seconds
   }
   return minutes + ':' + seconds
}

let update = document.querySelector('.fa-sync-alt')
update.addEventListener('mouseover', spin )

function spin(){
   update.classList.add('fa-spin')
}
update.addEventListener('mouseout', stopSpin )

function stopSpin(){
   update.classList.remove('fa-spin')
}