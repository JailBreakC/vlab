$ ->
    
    $('.thumbnail').hover (->
        $(this).find('.caption').addClass('show');
    ),->
        $(this).find('.caption').removeClass('show');
    $('.to-top').click ->
        $(window).scrollTop(0);
    `
    $('#myTab a').click(function (e) {
      e.preventDefault()
      $(this).tab('show')
    })
    `