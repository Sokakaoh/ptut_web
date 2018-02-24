"use strict";
$(document).ready(function () {

    $('.imageViewer').on('click',function (e) {
        e.preventDefault();
        if (e.which !== 1 && e.which !== 3) return
        var index = null;
        var items = [];
        var that = $(this);
        $.each($('.imageViewer:not(.thumb)'), function (key, value) {
            var data = $(this).data();
            if (data.index == true && that.data('href') == data.href) {
                index = key;
            }
            var size = data.size.split('x');
            items.push({
                src: data.href,
                w: size[0],
                h: size[1],
            });
        });

        if (index === null) {
            if (e.which == 1 ){
                index = 0;
            } else {
                index = items.length -1;
            }
        }

        var pswpElement = document.querySelectorAll('.pswp')[0];

        // define options (if needed)
        var options = {
            // optionName: 'option value'
            // for example:
            index: index, // start at first slide
            bgOpacity: 1,
        };

        // Initializes and opens PhotoSwipe
        var gallery = new PhotoSwipe(pswpElement, PhotoSwipeUI_Default, items, options);
        gallery.init();

        gallery.listen('imageLoadComplete', function() {
            $('.pswp__img').on('contextmenu', function (e) {
                e.preventDefault();
            });
        });

    });

})