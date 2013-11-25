$.fn.maskable = function (opts) {
  var options = $.extend({
    maskSrc: 'images/mask.png'
  }, opts);

  $(this).each(function () {
    var $img = $(this);
    $img.css('background', 'url(' + $img.attr('src') + ') center center no-repeat').attr('src', options.maskSrc);
  });
}
