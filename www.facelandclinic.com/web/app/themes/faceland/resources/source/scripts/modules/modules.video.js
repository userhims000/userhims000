/*------------------------------------------------------------------------*/
/*  Rodesk video module
/*------------------------------------------------------------------------*/

window.rodeskVideo = (() => {
    let settings;

    const defaults = {
        videoWrapper: '.js-video-wrapper',
        videoPlay: '.js-video-play',
        autoplay: true
    };

    /**
     * Setup the module
     *
     */
    const _videoType = event => {
        const $target = $(event.target);
        const videoId = $target.attr('data-id');
        const videoType = $target.attr('data-type');
        const $videoWrapper = $target.closest(settings.videoWrapper);
        const videoHeight = Math.ceil($videoWrapper.outerHeight());
        const videoWidth = Math.ceil($videoWrapper.outerWidth());
        const autoplayVimeo = settings.autoplay ? '?autoplay=1&muted=1' : '';
        const autoplayYoutube =
            settings.autoplay && rodeskBreakpoints.isBreakpoint('large') ? '?autoplay=1&mute=1' : '';

        if (videoType === 'vimeo') {
            $.ajax({
                url: `https://vimeo.com/api/v2/video/${videoId}.json`,
                dataType: 'jsonp',
                type: 'GET',
                success: () => {
                    $videoWrapper.html(
                        `<iframe src="https://player.vimeo.com/video/${videoId}${autoplayVimeo}" width="${videoWidth}" height="${videoHeight}" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>`
                    );

                    fitvids($videoWrapper);
                }
            });
        } else if (videoType === 'youtube') {
            $.ajax({
                url: `https://www.googleapis.com/youtube/v3/videos?part=id,snippet&id=${videoId}${autoplayYoutube}&key=AIzaSyAXBfQgG0HgqLQmJW97m0ru9AOUXaM5O0I'`,
                dataType: 'jsonp',
                type: 'GET',
                success: () => {
                    $videoWrapper.html(
                        `<iframe src="https://www.youtube.com/embed/${videoId}${autoplayYoutube}" width="${videoWidth}" height="${videoHeight}" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>`
                    );

                    fitvids($videoWrapper);
                }
            });
        }
        return false;
    };

    /**
     * Bind reveal events
     * Close the cookie bar on click of the close button
     *
     */
    const _bindEvents = () => {
        $(settings.videoPlay).on('click', _videoType);
    };

    /**
     * Init module
     */
    const _init = options => {
        // Setup settings.
        options = options || {};
        settings = $.extend({}, defaults, options);

        _bindEvents();
    };

    // Return public functions
    return {
        init: _init // Init this function
    };
})(); // Fully reference jQuery after this point.
