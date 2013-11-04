$(document).ready(function(){
	var nm=$('.js_point_name').first().text().toLowerCase();
	var typ=$('.js_point_type').first().text().toLowerCase();
	//Если тип встрачается в названии
	if( nm.indexOf( typ ) >=0 ) $('.js_point_type').hide();
		//Если в названии есть кавычки
		if(
			nm.indexOf( '"' ) >=0 ||
			nm.indexOf( "«" ) >=0
		) $('.js_point_quotes').hide();
		
	$('.stat_info').mouseenter(function(){
	  $('.stat_act',this).css('opacity',0);
	  $(this).addClass('hover');
	  $('.stat_act',this).stop( true, false ).animate({opacity:1},300);
	});
	$('.stat_act').mouseleave(function(){
	  //setTimeout( function(){$('.stat_info').removeClass('hover');}, 300 );
	  $(this).stop( true, false ).animate({opacity:0},200,function(){
	    $('.stat_info').removeClass('hover');
		  $(this).css('opacity',1);
		});
	})
});
