//nav 切换 by kenshin
$(function(){
	$('#nav li').hover(function(){
		$(this).children('a').children('span').css('visibility', 'visible').css({top : '-14px', '_top' : '-30px'}, 'fast');
	}, function(e){
		e.stopPropagation();
		$(this).children('a').children('span').stop().css({'top' : 0, 'visibility' : 'hidden'});
	});
});








