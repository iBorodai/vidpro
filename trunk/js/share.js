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

function dialog_show( callback ){
	if( $('#dialog_block').is(':visible') ){
	  dialog_hide();
	  return false;
	}
	$('#dialog_block .content').css({'opacity':0, });
	$('#dialog_block').css({'height':0,'display':'block'}).animate({height:600+'px'},200,function(){
	  var t=new callback;
	  $('#dialog_block .content').animate({'opacity':1},200);
	});
}
function dialog_hide(){
  $('#dialog_block .content').animate({'opacity':0, },200,function(){
    $('#dialog_block').animate({height:0},200,function(){
      $(this).hide();
		});
	});
}

function review_dialog(){
  dialog_show( function(){
	    if($('#point').get().length>0){
		    $('#dialog_block .content').html($('#review_form_tpl').html());
		    //Определяю какой шаблон подставить
		    if($('#point').data('weight')>0){
		      var tpl=$('#recommend_plus_tpl').html();  //recommend_plus_tpl
				}else if($('#point').data('weight')<0){
				  var tpl=$('#recommend_minus_tpl').html();	//recommend_minus_tpl
				}else {
				  var tpl=$('#recommend_def_tpl').html();	//recommend_def_tpl
				}
				tpl=tpl.replace(/onclick/g,'data-onClick');
				
		    $('#dialog_block .content .recomend_block').html(tpl);
		    $('#dialog_block .content .recomend_block a').unbind('click').click(function(){
		    	var r=(($(this).data('onclick')+'').indexOf('(1)') <0 )?-1:1;
		      $(this).parents('.review_form').find('.recomend_fld').val(  r  );
		      return false;
				});
		    
			}else{
			  $('#dialog_block .content').css('padding-left',$('#search_form').position().left+'px' ).html($('#review_search_tpl').html());
			}
	});
}

function send_review(form){
	var req = new JsHttpRequest("utf-8");
	req.onreadystatechange = function(){
		if (req.readyState == 4){
			if(req.responseJS){
			  if( req.responseJS.error ){
			    display_error(req.responseJS.error);
				}else{
				  $('#dialog_block .content').html( req.responseJS.content );
				  var t=$('<div>'+$('#point_comm .comment').first().html()+'</div>');
				  t.find('.recommend,.duration,.fs_label').remove();
				  
				  t.find('.bullet img').attr('src', $('#user_profile img').attr('src')  );
				  t.find('.user .name').html( $('#user_subnav .title').html()  );
				  t.find('.date').html( moment().format('L') );
				  t.find('.text').html( $(form).find('textarea').val() );
				  
				  $('#point_comm .label').after('<div class="comment">'+t.html()+'</div>');
				  dialog_hide();
				}
			}
			if(req.responseText!='') alert(req.responseText);
		}
	}

	req.open(null,'/ajax', true);
	req.send({'mode':'send_review',fields:['block'],text:$(form).find('textarea').val(), point:$('#point').attr('rel'), recomend:$(form).find('.recomend_fld').val() });
}

function send_recommend(){
	alert('send_recommend');
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
	}else{
	//Отображение диалога комментария
	  $('#write_review').click(function(){
	    review_dialog();
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

  	//LIVESAEARCH
		liveSearch.init($('#search_query')[0],{
			attr_set:'placeholder,name,id',
			mode:'search_points',
			query:{
				'query':$('#search_query').val(),
				'reg':$('#search_reg').val()
			},
			search_url:'/ajax/',
			callback:function( respJS,e ){
				$('#search_form .resDiv a').click(function(){
				  if( $('#dialog_block').is(':visible') ){
						$('#dialog_block .content').html('<span id="point" rel="'+$(this).parents('li').attr('id')+'"></span>' + $('#review_form_tpl').html());
					  return false;
					}
				});
			}
		});
		
	}
});