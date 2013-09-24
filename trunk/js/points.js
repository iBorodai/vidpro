var ilist=[],itimer=false;
$(document).ready(function(){
		load_page();
		
		$(window).scroll(function(){
		  if( ($(document).height()-$(window).scrollTop()-$(window).height())<100 ) load_more();
		  //console.log( $(document).height()+' '+$(window).height()+' '+$(window).scrollTop() );
		});
});

function load_page(page_num,callback){
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
					  
					  $('#point_container').append( req.responseJS.content );
						var $container = $('.point_list');
						
						if(!adding){
							$container.masonry({
							  itemSelector: '.item',
							});
							var ilist=$('.point_list .item').get();
						}else{
						  var ilist=$('#point_container .item').not('.displayed').get();
						  console.log(ilist);
              $container.masonry( 'appended', ilist );
						}
						
						duration();
						for(var j, x, i = ilist.length; i; j = Math.floor(Math.random() * i), x = ilist[--i], ilist[i] = ilist[j], ilist[j] = x);

						itimer=setInterval(function(){
						  $(ilist[0]).animate({opacity:1},300,function(){
						    $(this).addClass('displayed');
							});
						  ilist.shift();
						  if( ilist.length<1 ) clearInterval(itimer);
						},100);
					}
				}
				//if(req.responseText!='') alert(req.responseText);
			}
		}

		$('#point_container');
		if(typeof(page_num)=='undefined') page_num=1;
  	req.open(null,'/ajax', true);
		req.send({'mode':'points_comm_last',fields:['block'],page:page_num});
}

var loading_more=false;
function load_more(){
	if(loading_more) return;
	loading_more=true;
	var page_cur=parseInt($('.point_pages').last().find('.current').html());
	var page_count=parseInt($('.point_pages').last().find('.on_page').html());
	var page_ttl=parseInt($('.point_pages').last().find('.total').html());
	if(page_cur*page_count<page_ttl){
	  $('#point_container').append( $('#js_tpl_points .loading_tpl').html() );
	  load_page(page_cur+1 ,function(req){
	    $('#point_container').find('.list_title').last().remove();
	    $('#point_container').find('.loading').remove();
		});
	}
}