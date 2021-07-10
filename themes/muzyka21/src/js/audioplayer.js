$ = jQuery;
$(document).ready(function () {
  const audio = document.querySelector(".audioplayer audio");
  var state = audio.muted;
  
  const volumeSlider = document.querySelector(".audioplayer_volume input");
  const muteIcon = document.getElementById("mute-icon");

  var player = new Splide(".audioplayer_inner", {
    type: "loop",
    width: "100%",
    gap: "15px",
    lazyLoad: "sequential",
    autoWidth: true,
    autoplay: false,
    arrows: false, //'slider',
    pagination: false,
    interval: 1800,
    pauseOnHover: true,
    trimSpace: "move",
    focus: "center",
  }).mount();

  $(document).on('click','.openstream',function(e){
    e.preventDefault();
    $('.audioplayer').css('display','flex');
  });
  $(document).on('click','.closestream',function(e){
    e.preventDefault();
    $('.audioplayer').css('display','none');
  });

  $(document).on('click','.audioplayer_list_el_play',function(){
    var current = this.parentNode;
    audio.setAttribute("src", current.getAttribute("data-src"));
    muteIcon.classList.remove("muted");
    audio.muted = false;
    try {
      audio.play();
      } catch(e) {
        
      }
  });
  try {
  audio.play();
  } catch(e) {

  }
  volumeSlider.addEventListener("input", (e) => {
    const value = e.target.value;
    audio.volume = value / 100;
    if (value > 0) {
      muteIcon.classList.remove("muted");
      state = false;
    } else {
      muteIcon.classList.add("muted");
      state = true;
    }
    try {
      audio.play();
      } catch(e) {
        
      }
  });

  muteIcon.addEventListener("click", () => {
    if (state === false) {
      audio.muted = true;
      state = true;
      muteIcon.classList.add("muted");
    } else {
      audio.muted = false;
      state = false;
      muteIcon.classList.remove("muted");
      if (volumeSlider.value == 0) {
        volumeSlider.value = 50;
        audio.volume = 50 / 100;
      }
    }
    try {
      audio.play();
      } catch(e) {
        
      }
  });
});
