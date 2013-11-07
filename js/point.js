var p_weight=false;
var p_votes=false;
var p_plus_cnt=false;
var p_you=false;
var p_pct=false;


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
	
	p_weight=parseInt($('#prm_point_weight').text());
	p_votes=parseInt($('#prm_point_votes').text());
	p_plus_cnt=parseInt($('#prm_point_plus_cnt').text());
	p_you=parseInt( $('#prm_point_you').text() );

	if( p_weight==0 && p_votes>0 ) p_weight=1;
	//Проценты
  p_pct=Math.ceil(p_plus_cnt*100/ p_votes);
  //Минусовой процент
	if( p_weight<0 ) p_pct=100-p_pct;
	var block_weight=$('.stat_block .weight');
	block_weight.html(p_pct+'%');
	block_weight.removeClass('w0').removeClass('w1').removeClass('w-1').addClass('w'+p_weight);
	//if(block_weight.hasClass('w0')) {block_weight.removeClass('w0').addClass('w1');}
	
	//Требуется авторизация
  if($('#login_block').get().length>0){
    $('.stat_act').html('');
	}
	
		//Посещало участников
	  if( p_votes==0 ){
	    $('#place_visited').html('Место еще не посещали участники Vidguk.pro<br>Станьте первым, кто поделился своим мнением!');
	    block_weight.hide();
		}else{
			if(p_votes==1){
			  $('#place_visited').html('Место посетил один участник Vidguk.pro');
			  if(p_weight>0)	$('#ptext_many').html('он его рекомендует');
			  else 						$('#ptext_many').html('он его не рекомендует');
			}else{
        $('#ptext_many').html('Большинство');
        if( p_you/Math.abs(p_you)== p_weight/Math.abs(p_weight)) $('#ptext_you').html(', в том чсле и вы ');
        if(p_weight>0)$('#ptext_recomend').html('его рекомендуют');
        else $('#ptext_recomend').html('его не рекомендуют');
			}
		}

	
	
	
	
	$('.stat_act .plus,.stat_act .minus').click(function(){
	  if( $(this).hasClass('plus') ) var vote=1;
	  else var vote=-1;
	  
	  send_vote( $('#point').attr('rel') , vote,  $('.stat_info') );
	  return false;
	});
	
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
	});
});
