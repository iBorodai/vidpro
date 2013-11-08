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
	  if($(this).hasClass('done'))return;
	  var now=moment()
		var d1=moment($(this).find('.from').text()) ;
		$(this).find('.from').text( moment.duration(now-d1).humanize() );
		$(this).addClass('done');
	});
}

function dialog_show( callback ){
	if( $('#dialog_block').is(':visible') ){
	  var t=new callback;
	  return true;
	  //dialog_hide(); return false;
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

function profile_dialog(){
  dialog_show( function(){
    var t=$('#profile_form_tpl').html();
    t=t.replace(/jsremove_/g,'');
		$('#dialog_block .content').html( t );
		
		var t=false;
		t=$('.uinf_name').text(); 	if(t) $('.pro_name').html( t );
		t=$('.uinf_geo').text(); 		if(t) $('.pro_geo').html( t );
		
		t=$('.uinf_name').text(); 	if(t) $('.usr_name input').val( t );
		t=$('.uinf_sname').text();	if(t) $('.usr_sname input').val( t );
		t=$('.uinf_bdate').text();	if(t) $('.usr_bdate input').val( t );
		t=$('.uinf_img').text();		if(t) $('.pro_avatar img').attr('src', t );
		
		t=$('.uinf_gender').text();
		if(t) $('#gender_'+t.substr(0,1)  ).attr('checked','checked');
			
		return;
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
				  setTimeout( function(){dialog_hide();}, 1000 );
				}
			}
			if(req.responseText!='') alert(req.responseText);
		}
	}

	req.open(null,'/ajax', true);
	req.send({'mode':'send_review',fields:['block'],text:$(form).find('textarea').val(), point:$('#point').attr('rel'), recomend:$(form).find('.recomend_fld').val() });
}

function send_vote(point, vote, marker){
	var req = new JsHttpRequest("utf-8");
	var elm=marker;
	elm.html('loading');
	
	req.onreadystatechange = function(){
		if (req.readyState == 4){
			if(req.responseJS){
			  if( req.responseJS.error ){
			    display_error(req.responseJS.error);
				}else{
				  elm.html( req.responseJS.content );
				}
			}
			if(req.responseText!='') alert(req.responseText);
		}
	}

	req.open(null,'/ajax', true);
	req.send({ 'mode':'send_vote', fields:['block'], recomend:vote, 'point':point });
}

function send_profile(form){
	var req = new JsHttpRequest("utf-8");
	req.onreadystatechange = function(){
		if (req.readyState == 4){
			if(req.responseJS){
			  if( req.responseJS.error ){
			    display_error(req.responseJS.error);
				}else{
				  $('#dialog_block .content').html( req.responseJS.content );
				  setTimeout( function(){dialog_hide();}, 1000 );
				}
			}
			if(req.responseText!='') console.log(req.responseText);//alert(req.responseText);
		}
	}

	req.open(null,'/ajax', true);
	req.send({'mode':'store_profile',fields:['block'],form_profile:form});
}

//n, form1, form2, form5
//"письмо", "письма", "писем"
// nObj=id|false;
function pluralForm( nObj,nRes,f1,f24,f59,f0 ) {
	var obj=false, val=false;
	if(!nObj && typeof(nRes)=='number' ){
	  val=parseInt(nRes);
	}else{
		obj=$('#'+nObj);
		val=parseInt(obj.html());
	}
	if( val==0 && f0){
		if(obj){
			obj.hide(); obj.html(f0); return true;
		}else return f0;
	}

	var res=f1;
	var n = Math.abs(val) % 100;
	var n1 = Math.floor(n / 10)*10;	// десятки
	n=(n-n1);                  			// в «N» остаются еденицы

	if( n1>=10 && n1<20 ) res=f59; else
  if( n==1 ) res=f1; else
	if( n>1&&n<5 ) res=f24; else
	res=f59;

	if(obj){
	  var tst=document.getElementById(nRes);
	  if(tst!=undefined) tst.innerHTML=res;
	}else{
	  return res;
	}
}

function populars(){
	$('.pop_form').each(function(){
	  if( $(this).hasClass('done') ) return;
	  //pluralForm( nObj,nRes,f1,f24,f59,f0 )
	  var int_val=parseInt($('.pop_num',this).text());
	  $('.pop_res',this).each(function(){
	    var forms=$(this).attr('rel').split(',');
	    $(this).html( pluralForm( false,int_val,forms[0],forms[1],forms[2],forms[3] ) );
		});
	  $(this).addClass('done');
	});
}

function toggle_pop(jq_selector, shower ){
	$('.pop').not(jq_selector).hide();
	if(typeof(shower)=='undefined')	$(jq_selector).toggle();
	else{
		shower();
	}
}

$(document).ready(function(){
	//Проставить все длительности
	moment.lang('ru');
	duration();
  populars();

	//Форма авторизации, если есть
	if($('#login_block').get().length>0){
	  $('#write_review').click(function(){
	    toggle_pop('#login_form');
	    return false;
		});
	}else{
		//Нажатие на комментировать
	  $('#write_review').click(function(){
	    toggle_pop('#dialog_block',review_dialog);
	    return false;
		});
		//Нажатие на мой профиль
	  $('#my_profile').click(function(){
	    toggle_pop('#dialog_block',profile_dialog);
	    return false;
		});
	}
	
	
	
	//Пользовательское меню,если есть
  if($('#user_profile').get().length>0){
	  $('#user_profile').click(function(){
	     //$('#user_subnav').toggle();
      //$('.pop').hide();
	    toggle_pop('#user_subnav');
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
			make_query:function(){
			  return {
					'query':$('#search_query').val(),
					'reg':$('#search_reg').val(),
					'reg_new':$('#search_reg_other').val()
				}
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
	
	$('.fb').fancybox();
	//Если есть ошибка авторизации - открыть диалог
	if( $('#login_block .err_err').get().length>0 ){
	  toggle_pop('#login_form');
	}
});