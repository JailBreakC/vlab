// Generated by CoffeeScript 1.7.1
(function() {
  $(function() {
    $('.thumbnail').hover((function() {
      return $(this).find('.caption').addClass('show');
    }), function() {
      return $(this).find('.caption').removeClass('show');
    });
    $('.to-top').click(function() {
      return $(window).scrollTop(0);
    });
    return 
    $('#myTab a').click(function (e) {
      e.preventDefault()
      $(this).tab('show')
    })
    ;
  });

}).call(this);

//# sourceMappingURL=main.map
