document.getElementById("callclick").addEventListener('click', function() {
    var cid = uuid();

    var time = new Date(Date.now());
    var nonce = Math.floor((time.getTime() / 1000)).toString();
    var ajaxurl = 'https://www.google-analytics.com/collect?v=1&tid=UA-55186923-1&cid=' + cid + '&t=event&ec=click&ea=phonenumber&z=' + nonce;
    var value = jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
    }, true);
});

