function mycarousel_initCallback(carousel)
{
    carousel.buttonNext.bind('click', function() {
        carousel.startAuto(0);
    });

    carousel.buttonPrev.bind('click', function() {
        carousel.startAuto(0);
    });

    // Pause autoscrolling if the user moves with the cursor over the clip.
    carousel.clip.hover(function() {
        carousel.stopAuto();
    }, function() {
        carousel.startAuto();
    });
};

jQuery(document).ready(function() {
    jQuery('.slider').jcarousel({
        auto: 10,
        wrap: 'last',
        visible: 5,
        scroll: 3,
        animation: 800,
        easing: 'swing',          
        initCallback: mycarousel_initCallback
    });
});