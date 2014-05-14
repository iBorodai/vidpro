var ilist=[],itimer=false;
$(document).ready(function(){
		//Жду секунду, чтобы посмотрели на заставку и загружаю данные
		setTimeout(function(){
		  load_page();
		},10);

		$(window).scroll(function(){ check_load_more(); });

		$('#nav_cats_lnk').click(function(){
		  toggle_pop('#nav_cats_block');
		  return false;
		});
		
		var t=$('#line_nav_html').html();
		$('#line_nav_html').html('');
		
		$('#point_container').before( t );
		
		$('.nav_elm').removeClass('active');
		
		$('.'+window['active_nav_point']).addClass('active');
});

function check_load_more(){
  if( ($(document).height()-$(window).scrollTop()-$(window).height())<100 ) load_more();
}

var show_list=[];
var loading_more=false;

function load_page(page_num,callback){
    loading_page=true;
		var req = new JsHttpRequest("utf-8");
		req.onreadystatechange = function(){
			if (req.readyState == 4){
console.log('answer:',req);
				if(req.responseJS){
				  if( req.responseJS.error ){
				    display_error(req.responseJS.error);
					}else{
					  if(typeof(callback)!='undefined') new callback(req);
					  
					  if($('#point_container .item').get().length>0)
							var adding=true;
						else{
						  $('#point_container .loading_start').remove();
							var adding=false;
						}
					  
						if(!adding){
							$('#point_container').html( req.responseJS.content );
							var $container = $('.point_list');
							$container.masonry({
							  itemSelector: '.item',
							});
							var ilist=$('.point_list .item').get();
							show_list=ilist;
						}else{
						  var $container = $('.point_list');
						  
							var t=$(req.responseJS.content);
							$('.point_pages').html( t.find('.point_pages').html() );
						  //var ilist=t.find('.item').get();
						  var ilist=[];
						  var tlist=t.find('.item').get();
						  var j=0;
						  for ( var i = 0; i < tlist.length; i++ ) {
						    if( $('#'+$(tlist[i]).attr('id')).get().length>0 ){
//console.log('skip ',$(tlist[i]).attr('id'));
									continue;
								}
								//console.log($(ilist[i]).attr('id'));
								ilist[j]=tlist[i]
						    $container.append( ilist[j] );
						    show_list.push( ilist[j] );
						    j++;
						  }
//console.log('ilist', ilist);
              $container.masonry( 'addItems', ilist);
              $container.masonry( 'layout' );
              $(window).resize();
						}
						
						duration();
						init_votes();
						
						for(var j, x, i = show_list.length; i; j = Math.floor(Math.random() * i), x = show_list[--i], show_list[i] = show_list[j], show_list[j] = x);

						if(itimer) clearInterval(itimer);
						itimer=setInterval(function(){
						  $(show_list[0]).animate({opacity:1},200,function(){
						    $(this).addClass('displayed');
							});
						  show_list.shift();
						  if( show_list.length<1 ) clearInterval(itimer);
						},50);

					}
				}
				loading_page=false;
				//if( $(document).height()-$(window).height() <100 ) load_more();
				check_load_more();
			}
		}
		
		//Объект-парамерты запроса
		if(typeof(page_num)=='undefined') page_num=1;
		
		var get_mode='points_comm_last';
		
		switch(window['active_nav_point']){
		  case 'users': get_mode='points_user_subscribed'; break;
		  case 'points': get_mode='points_subscribed'; break;
		}
		var params_obj={'mode':get_mode,fields:['block'],page:page_num};
		
		//GET параметры страницы
		var t=(document.location.search+'').substr(1).split('&');
		for(var i=0; i<t.length; i++){
		  var tt=t[i].split('=');
		  if( typeof(tt[1])=='undefined' ) continue;
		  params_obj[tt[0]]=tt[1];
		}
		//$('#point_container');
console.log('request:',params_obj);
  	req.open(null,'/ajax', true);
		req.send( params_obj );
}

var loaded_count=0;
function load_more(){
	if(loading_page) return;
	var page_cur=parseInt($('.point_pages').last().find('.current').html());
	var page_count=parseInt($('.point_pages').last().find('.on_page').html());
	var page_ttl=parseInt($('.point_pages').last().find('.total').html());
	if( loaded_count<page_ttl){
	  //console.log( page_cur*page_count+'<'+page_ttl );
	  $('#point_container').append( $('#js_tpl_points .loading_tpl').html() );
	  load_page(page_cur+1, function(req){
			page_count=parseInt($('.point_pages').last().find('.on_page').html());
	    loaded_count+=page_count;
	    $('#point_container').find('.loading').remove();
		});
	}else{
	  //console.log( 'stoped at '+page_cur+' loaded:'+loaded_count );
	}
}

function init_votes(){
  $('.recommend .plus,.recommend .minus').unbind('click').click(function(){
	  if( $(this).hasClass('plus') ) var vote=1;
	  else var vote=-1;

	  send_vote( $(this).parents('.item').attr('rel') , vote,  $(this).parent(), function(req,elm){
	    $(elm).parents('.vote').html( req.responseJS.content );
		});
	  return false;
	});
}