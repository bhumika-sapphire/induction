/* Countdown shown in #countdown; tracks elapsed seconds in #tss and submits formId when time runs out */
function final_test(minutes, formId) {
    var total = Math.round(minutes * 60);
    var started = Date.now();
    var box = document.getElementById('countdown');
    var tss = document.getElementById('tss');

    if (window._testTimer) {
        clearInterval(window._testTimer);
    }

    function pad(n) { return (n < 10 ? '0' : '') + n; }

    function tick() {
        var elapsed = Math.floor((Date.now() - started) / 1000);
        var left = Math.max(total - elapsed, 0);
        if (tss) {
            tss.value = elapsed;
        }
        if (box) {
            box.innerHTML = '<i class="fa fa-clock-o"></i> Time left: ' +
                pad(Math.floor(left / 3600)) + ':' + pad(Math.floor(left % 3600 / 60)) + ':' + pad(left % 60);
            box.className = left < 300 ? 'countdown warning' : 'countdown';
        }
        if (left <= 0) {
            clearInterval(window._testTimer);
            var form = formId && document.getElementById(formId);
            if (form) {
                form.submit();
            }
        }
    }

    tick();
    window._testTimer = setInterval(tick, 1000);
}

$(function () {
    $('.nav-toggle').on('click', function () {
        $('.site-nav').toggleClass('open');
    });

    /* Popups: <a class="fancybox" href="#id"> shows the hidden element with that id */
    var $overlay = $('#popupOverlay');
    var $placeholder = null;
    var $shown = null;

    function closePopup() {
        if ($shown) {
            $shown.hide();
            $placeholder.replaceWith($shown);
            $shown = null;
            $placeholder = null;
        }
        $overlay.removeClass('open');
        $('body').removeClass('popup-open');
        $overlay.find('video, audio').each(function () { this.pause(); });
    }

    $(document).on('click', 'a.fancybox', function (e) {
        var href = $(this).attr('href') || '';
        if (href.charAt(0) !== '#') {
            return;
        }
        var el = document.getElementById(href.substring(1));
        if (!el) {
            return;
        }
        e.preventDefault();
        closePopup();
        $shown = $(el);
        $placeholder = $('<span hidden></span>');
        $shown.before($placeholder);
        $overlay.find('.popup-content').empty().append($shown.show());
        $overlay.addClass('open');
        $('body').addClass('popup-open');
    });

    $overlay.on('click', function (e) {
        if (e.target === this) {
            closePopup();
        }
    });
    $overlay.find('.popup-close').on('click', closePopup);
    $(document).on('keydown', function (e) {
        if (e.key === 'Escape') {
            closePopup();
        }
    });

    /* Chapter lessons accordion */
    $('.syllabus-view').each(function () {
        if (!$(this).hasClass('first')) {
            $(this).find('.point-list').hide();
            $(this).find('.main-point').removeClass('active');
        }
    });
    $('.syllabus-view .main-point').on('click', function () {
        $(this).toggleClass('active').next('.point-list').slideToggle(200);
    });

    /* Highlight the chosen answer */
    $(document).on('change', '.label_radio input[type=radio]', function () {
        var name = $(this).attr('name');
        $('input[name="' + name + '"]').closest('.label_radio').removeClass('checked');
        $(this).closest('.label_radio').addClass('checked');
    });

    /* Tests declare their duration with data-minutes */
    $('form[data-minutes]').each(function () {
        final_test(parseFloat($(this).data('minutes')), this.id);
    });
});
