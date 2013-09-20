$(document).ready(function(){
  //Для всех радиокнопок-иконок - выставление класса "актив" при выборе
	function set_act_radio(){
		$('.radio_block.active,.check_block.active').removeClass('active');
		$('.radio_block input:checked').each(function(){
		  $(this).parents('.radio_block').addClass('active');
		});
		$('.check_block input:checked').each(function(){
		  $(this).parents('.check_block').addClass('active');
		});
	}
	$('.radio_block input,.check_block input').click(function(){
	  set_act_radio();
	});
});
