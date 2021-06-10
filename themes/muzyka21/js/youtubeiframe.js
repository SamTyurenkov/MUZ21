function showyoutubevideo() {
    document.getElementById('video_container').style.opacity = 1;
    document.getElementById('video_container').style.zIndex = 99999;
    if (document.querySelector('.youtube-script') == undefined);
    var tag = document.createElement('script');
    tag.classList.add('youtube-script');
    tag.src = "https://www.youtube.com/iframe_api";
    var firstScriptTag = document.getElementsByTagName('script')[0];
    firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
}

function hideyoutubevideo() {
    document.getElementById('video_container').style.opacity = 0;
    document.getElementById('video_container').style.zIndex = -99999;
}


function onYouTubeIframeAPIReady() {
    var player;
    var framer = document.getElementById("youtubevideo");
    var fwidth = document.getElementById("youtubevideo").clientWidth;
    var fheight = (fwidth / 16 * 9) + 'px';
    framer.parentElement.style.height = fheight;
    framer.style.height = fheight;
    player = new YT.Player('youtubevideo', {
        videoId: localize.id,
        playerVars: {
            enablejsapi: 1,
            autoplay: 1,
            controls: 1,
            width: fwidth,
            height: fheight,
            showinfo: 1,
            modestbranding: 1,
            loop: 1,
            fs: 1,
            cc_load_policy: 0,
            iv_load_policy: 3,
            autohide: 0,
            origin: 'https://asp.sale',
            playsinline: 1,
            rel: 0
        },
        events: {
            onReady: function(e) {
                e.target.mute();
                e.target.playVideo();
            },
            onStateChange: function(e) {
                // e.target.playVideo();
            }
        }
    });
}