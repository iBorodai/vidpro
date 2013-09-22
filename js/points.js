var ilist=[],itimer=false;

$(document).ready(function(){
		var req = new JsHttpRequest("utf-8");
		req.onreadystatechange = function(){
			if (req.readyState == 4){
			  console.log(req);
				if(req.responseJS){
				  if( req.responseJS.error ){
				    display_error(req.responseJS.error);
					}else{
					  $('#point_container').html( req.responseJS.content );
					  
						var $container = $('.point_list');
						$container.masonry({
						  itemSelector: '.item',
						});
						
						$container.masonry('bindResize', function() {
						  console.log('resize');
						} );
						
						ilist=$('.point_list .item').get();
						
						for(var j, x, i = ilist.length; i; j = Math.floor(Math.random() * i), x = ilist[--i], ilist[i] = ilist[j], ilist[j] = x);
						
						itimer=setInterval(function(){
						  $(ilist[0]).animate({opacity:1},300);
						  ilist.shift();
						  if( ilist.length<1 ) clearInterval(itimer);
						},100);
					}
				}
				if(req.responseText!='') alert(req.responseText);
			}
		}
		
  	req.open(null,'/ajax', true);
		req.send({'mode':'points_comm_last',fields:['block']});
});