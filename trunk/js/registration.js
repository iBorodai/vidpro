$(document).ready(function(){
  if( $('#cats').get().length>0 ){
    $('#cats a').click(function(){return false;});
    $('#cats a').each(function(){
      if( $(this).position().top>$(window).height()*.5 ) $(this).addClass('bottom');
		});

    $('#cats a').mouseenter(function(){
      $(this).append('<div class="bubble">'+$(this).attr('title')+'</div>');
		});
    $('#cats a').mouseleave(function(){
      $('.bubble',this).remove();
		});
	}
});
