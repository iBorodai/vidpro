var ilist=[],itimer=false;
$(document).ready(function(){
		//Жду секунду, чтобы посмотрели на заставку и загружаю данные
		setTimeout(function(){
		  load_page();
		},1000);

		$(window).scroll(function(){
		  if( ($(document).height()-$(window).scrollTop()-$(window).height())<100 ) load_more();
		});

		$('#nav_cats_lnk').click(function(){
		  $('#nav_cats_block').toggle();
		  return false;
		});
});

var show_list=[];
var loading_more=false;
function load_page(page_num,callback){
    loading_page=true;
		var req = new JsHttpRequest("utf-8");
		req.onreadystatechange = function(){
			if (req.readyState == 4){
			  console.log(req);
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
							//$('#point_container').append( $(req.responseJS.content).find('.point_list').html() );
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
						  var ilist=t.find('.item').get();
						  
						  for ( var i = 0; i < ilist.length; i++ ) {
						    $container.append( ilist[i] );
						    show_list.push(ilist[i]);
						  }
              //$container.masonry( 'appended', ilist );
              $container.masonry( 'addItems', ilist);
              $container.masonry( 'layout' );
              $(window).resize();
						}
						
						duration();
						
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
				if( $(document).height()-$(window).height() <100 ) load_more();
			}
		}
		
		//Объект-парамерты запроса
		if(typeof(page_num)=='undefined') page_num=1;
		var params_obj={'mode':'points_comm_last',fields:['block'],page:page_num};
		
		//GET параметры страницы
		var t=(document.location.search+'').substr(1).split('&');
		for(var i=0; i<t.length; i++){
		  var tt=t[i].split('=');
		  if( typeof(tt[1])=='undefined' ) continue;
		  params_obj[tt[0]]=tt[1];
		}
		console.log(params_obj);
		//$('#point_container');
  	req.open(null,'/ajax', true);
		req.send( params_obj );
}

var loaded_count=0;
function load_more(){
	if(loading_page) return;
	var page_cur=parseInt($('.point_pages').last().find('.current').html());
	var page_count=parseInt($('.point_pages').last().find('.on_page').html());
	var page_ttl=parseInt($('.point_pages').last().find('.total').html());
	loaded_count+=page_cur*page_count;
	if( loaded_count<page_ttl){
	  console.log( page_cur*page_count+'<'+page_ttl );
	  $('#point_container').append( $('#js_tpl_points .loading_tpl').html() );
	  load_page(page_cur+1 ,function(req){
	    $('#point_container').find('.loading').remove();
		});
	}
}