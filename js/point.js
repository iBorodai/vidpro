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
	block_weight.removeClass('w0').removeClass('w1').removeClass('w-1').addClass( (p_weight<0)?'w-1':'w1' );
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
	init_admin();
});

function FS_onLoadSaveToWidget(){
	alert('show');
	$('.fourSq-modal iframe').css('display','block');
}


function comm_rel_block(obj){
	var prt=$(obj).parents('.foot');
	if( prt.find('.relator').get().length<1 ){
	  prt.append('<div class="relator"></div>');
	}
	return $('.relator',prt);
}

function comm_ans(obj){
  var rel=comm_rel_block(obj);
  $('.relator').html('');
	rel.html( $('#ans_tpl').html() );
	$('.parent_fld',rel).val( $(obj).parents('.comment').attr('rel') );
  return false;
}
function send_answer(form){
  var comObj=$(form).parents('.comment');
	var req = new JsHttpRequest("utf-8");
	req.onreadystatechange = function(){
		if (req.readyState == 4){
			if(req.responseJS){
			  if( req.responseJS.error ){
			    display_error(req.responseJS.error);
				}else{
				  var mode_edit=$('.relator').find('.com_id_fld').val();
				  
				  $('.relator').html('');
				  if(mode_edit){
				    $('.comment[rel="'+mode_edit+'"]').replaceWith( req.responseJS.content );
					}else{
						var ansObj=comObj.find('.answers');

					  if( ansObj.get().length<1 ){
							comObj.append('<div class="answers">'+req.responseJS.content+'</div>');
					  }else{
					    ansObj.append( req.responseJS.content );
						}
					}
				}
			}
			if(req.responseText!='') console.log(req.responseText);
		}
	}

	req.open(null,'/ajax', true);
	req.send({
		'mode':'send_review',
		fields:['block'],
		text:$(form).find('textarea').val(),
		point:$('#point').attr('rel'),
		parent:$(form).find('.parent_fld').val(),
		com_id:$(form).find('.com_id_fld').val()
	});
}

function comm_edit(obj){
  var rel=comm_rel_block(obj);
  $('.relator').html('');
	rel.html( $('#ans_tpl').html() );
	var prt=$(obj).parents('.comment').first();
	$('.com_id_fld',rel).val( prt.attr('rel') );
	$('.reveiw',rel).val( $.trim(prt.find('.text').text()) );
  return false;
}

function comm_alarm(obj){
  var prt=$(obj).parents('.comment').first();
	var id=prt.attr('rel');
	
	var req = new JsHttpRequest("utf-8");
	req.onreadystatechange = function(){
		if (req.readyState == 4){
			if(req.responseJS){
			  if( req.responseJS.error ){
			    display_error(req.responseJS.error);
				}else{
				  display_message( 'Ваша жалоба отправлена модератору.<br>Спасибо за участие в проекте.' );
				}
			}
			if(req.responseText!='') console.log(req.responseText);
		}
	}

	req.open(null,'/ajax', true);
	req.send({
		'mode':'com_alarm',
		fields:['block'],
		com_id:id
	});
	return false;
}

function comm_del(obj){
  var prt=$(obj).parents('.comment').first();
	var id=prt.attr('rel');

	var req = new JsHttpRequest("utf-8");
	req.onreadystatechange = function(){
		if (req.readyState == 4){
			if(req.responseJS){
			  if( req.responseJS.error ){
			    display_error(req.responseJS.error);
				}else{
				  $('#com_'+id).remove();
				  display_message( 'Коментарий удален' );
				}
			}
			if(req.responseText!='') console.log(req.responseText);
		}
	}

	req.open(null,'/ajax', true);
	req.send({
		'mode':'com_del',
		fields:['block'],
		com_id:id
	});
	return false;
}

function init_admin(){
	if( $.trim($('#user_inf .uinf_grp').text()) !='adm') return;
	$('#point_main').addClass('editMode');
	$('#point_main').append('<form id="uploadCover" style="display:none;" method="post" enctype="multipart/form-data" onsubmit="return false"><input type="file" name="newCover" id="newCover_fld" onChange="doCoverUpload(this);"></form>');
	//Подставить ссылки управления
	var fgi=$('#point_gallery a:first');
	if(fgi.get().length<1){
	  $('#point_gallery').append('<a href="#"><img src="/img/profile_def.jpg"></a>');
	  var fgi=$('#point_gallery a:first');
	}
	fgi.prepend('<span><i></i></span>');
	fgi.addClass('admin').removeClass('fb').unbind('click').attr('title','Изменить обложку').click(function(){
	  $('#newCover_fld').click();
	  return false;
	});
	
	$('#point_main').append('<a href="#" class="admin_edit" onclick="gotoEdit(); return false;">Редактировать данные</a>')
}

function doCoverUpload(file_fld){
	var req = new JsHttpRequest("utf-8");
	req.onreadystatechange = function(){
		if (req.readyState == 4){
			if(req.responseJS){
			  if( req.responseJS.error ){
			    display_error(req.responseJS.error);
				}else{
				  $('#point_gallery a.admin span i').css('background',bgtmp);
				  
					$('#point_gallery .admin img').attr('src', req.responseJS.content+'?rnd='+Math.random() );
				  display_message( 'Обложка изменена' );
				}
			}
			if(req.responseText!='') console.log(req.responseText);
		}
	}
	
	var bgtmp=$('#point_gallery a.admin span i').css('background');
	$('#point_gallery a.admin span i').css('background','url(/img/loading.gif) center center no-repeat');
	var id=$('#point').attr('rel');
	req.open(null,'/ajax', true);
	req.send({
		'mode':'admin_cover',
		fields:['block'],
		p_id:id,
		cover:file_fld
	});
}

function subscribe_abs(obj){
  subscribe('point', $('#point').attr('rel') );
}
function unsubscribe_abs(obj){
  unsubscribe('point', $('#point').attr('rel') );
}
function subscribe(type_var, id_var ){
	var req = new JsHttpRequest("utf-8");
	req.onreadystatechange = function(){
		if (req.readyState == 4){
			if(req.responseJS){
			  if( req.responseJS.error ){
			    display_error(req.responseJS.error);
				}else{
				  switch(type_var){
				    case 'point':
				      $('#subscribe').replaceWith(req.responseJS.content);
				      break;
				    case 'user':
				      $('.u_'+id_var).replaceWith(req.responseJS.content);
				      break;
					}
					
				  display_message( 'Подписка оформлена' );
				}
			}
			if(req.responseText!='') console.log(req.responseText);
		}
	}

	req.open(null,'/ajax', true);
	req.send({
		'mode':'subscribe',
		fields:['block'],
		type:type_var,
		obj:id_var
	});
}
function unsubscribe(type_var, id_var ){
	var req = new JsHttpRequest("utf-8");
	req.onreadystatechange = function(){
		if (req.readyState == 4){
			if(req.responseJS){
			  if( req.responseJS.error ){
			    display_error(req.responseJS.error);
				}else{
				  switch(type_var){
				    case 'point':
				      $('#unsubscribe').replaceWith(req.responseJS.content);
				      break;
				    case 'user':
				      $('.u_'+id_var).replaceWith(req.responseJS.content);
				      break;
					}
				  display_message( 'Подписка отменена' );
				}
			}
			if(req.responseText!='') console.log(req.responseText);
		}
	}

	req.open(null,'/ajax', true);
	req.send({
		'mode':'unsubscribe',
		fields:['block'],
		type:type_var,
		obj:id_var
	});
}

function gotoEdit(){
	var url=$('#prm_point_url').text();
	url='/point/'+url+'/edit';
	//alert(url);
	//document.location=url; return false;
		$.fancybox({
			'padding'		: 0,
			'autoScale'		: false,
			'transitionIn'	: 'none',
			'transitionOut'	: 'none',
			'width'		: 800,
			'height'		: 600,
			'href'			: url,
			'type'			: 'iframe',
		});
}

function like_com(domObj){
	var id=$(domObj).parents('.comment').attr('rel');
	var req = new JsHttpRequest("utf-8");
	
	req.onreadystatechange = function(){
		if (req.readyState == 4){
			if(req.responseJS){
			  if( req.responseJS.error ){
			    display_error(req.responseJS.error);
				}else{
				  display_message( 'Ваш лайк учтен, спасибо за участие в проекте.' );
				  if( $(domObj).hasClass('likes_0') ){
				    $(domObj).removeClass('likes_0').addClass('likes_1');
				    $('span',domObj).html('1');
					}else{
					  var res=parseInt($('span',domObj).html())+1;
					  $('span',domObj).html( res );
					}
				}
			}
			if(req.responseText!='') console.log(req.responseText);
		}
	}

	req.open(null,'/ajax', true);
	req.send({
		'mode':'like_com',
		fields:['block'],
		obj:id
	});
}