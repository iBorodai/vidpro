function display_message(text){
		var msg=$('<div class="pop_msg" style="display:none;">'+text+'<a href="#" class="close" onClick="$(this).parent().remove(); return false;">закрыть</a> </div>');
		var tst=$('body').find('.pop_msg');
		if(tst.get().length>0){
		  msg.css('top', tst.eq(tst.get().length-1).position().top+tst.eq(tst.get().length-1).height()*2.8  );
		}
	  $('body').append(msg);
	  msg.css({'display':'block','opacity':0}).animate({opacity:1},200,function(){
	    setTimeout(function(){
	      msg.animate(
					{opacity:0},
					200,
					function(){
					  msg.remove();
					}
				);
			}, 3000);
		});
}

function display_error(text){
		var err=$('<div class="pop_err" style="display:none;">'+text+'<a href="#" class="close" onClick="$(this).parent().remove(); return false;">закрыть</a></div>');
		var tst=$('body').find('.pop_err');
		if(tst.get().length>0){
		  err.css('top', tst.eq(tst.get().length-1).position().top+tst.eq(tst.get().length-1).height()*2.8  );
		}
	  $('body').append(err);
	  err.css({'display':'block','opacity':0}).animate({opacity:1},200,function(){
	    setTimeout(function(){
	      err.animate(
					{opacity:0},
					200,
					function(){
					  err.remove();
					}
				);
			}, 3000);
		});
}

function duration(){
	$('.duration').each(function(){
	  var now=moment()
		var d1=moment($(this).find('.from').text()) ;
		$(this).find('.from').text( moment.duration(now-d1).humanize() );
	});
}

$(document).ready(function(){
	//Проставить все длительности
	moment.lang('ru');
	duration();

	//Форма авторизации, если есть
	if($('#login_block').get().length>0){
	  $('#write_review').click(function(){
	    $('#login_form').toggle();
	    return false;
		});
	}
	
	//Пользовательское меню,если есть
  if($('#user_profile').get().length>0){
	  $('#user_profile').click(function(){
	    $('#user_subnav').toggle();
	    return false;
		});
	}
	
	//Строка поиска
	if( $('#search_form').get().length>0 ){
	  $('#search_reg').append('<option class="other_place" value="other">другое место</option>');
	  $('#search_reg').change(function(){
	    if($(this).val()=='other'  ){
	      $('#search_reg').val('').hide();
				$('#search_reg_other').show().focus();
			}
		});
		if($('#search_reg_other').val()!=''){
	      $('#search_reg').val('').hide();
				$('#search_reg_other').show().focus();
		}
	  $('#search_apply').click(function(){
	    $('#search_form').submit();
	    return false;
		});
	}
});