var debugeo=true;
//var getgeotimer=1000;
//var location_timeout=false;
var uip=false;
$(document).ready(function(){
	//есть IP?
  if( $('#user-ip').get().length>0 ) uip=$('#user-ip').text();
  
  //—мотрю может уже прописана геолокаци€ - ничего не делать
  if(uip.substring(0, 7) =='session' ){
    var t=uip.substring(7).split(',');
    if(debugeo) console.log('geo in session:'+t);
    $('input.geolocation_lat').val(t[0]);
	  $('input.geolocation_lng').val(t[1]);
    return true;
	}
	
	//«апускаю запрос к freeipapi определени€ геолокации по IP
	get_by_ip();
	//location_timeout = setTimeout("get_by_ip()", getgeotimer);
  
	if (navigator.geolocation) {
	    if(debugeo) console.log('geo navigator request');
	    navigator.geolocation.getCurrentPosition(function(position) {
	        //clearTimeout(location_timeout);

	        var lat = position.coords.latitude;
	        var lng = position.coords.longitude;
	        
	        //display_message(lat+" "+lng);
	        if(debugeo) console.log('geo navigator location:'+lat+' '+lng);
	        //Ѕезусловно выстав€лю
	        $('input.geolocation_lat').val(lat);
	        $('input.geolocation_lng').val(lng);
	    }, function(error) {
					if(error.PERMISSION_DENIED){
			      if(debugeo) console.log('geo navigator error:'.error);
			    }
	        //clearTimeout(location_timeout);
	        geolocFail('отменено пользователем');
	    },{
	        maximumAge:Infinity,
	        timeout:Infinity,
	        enableHighAccuracy:false
	    });
	} /*else {
			if(uip){
				//freegeoip.net
				get_by_ip();
			} else
	    	geolocFail();
	}*/
});
	function geolocFail(msg){
    if(debugeo) console.log('geo fail:'.msg);
	  if(typeof(msg)=='undefined') var msg='';
	    //alert("не удалось определеить ваше местоположение "+msg);
	     display_error("не удалось определеить ваше местоположение: "+msg);
	     //$('#user_place').show();
	}

//freegeoip.net
function get_by_ip(){
	if(!uip)
	  if( $('#user-ip').get().length>0 )
			uip=$('#user-ip').text();
		else{
		  //geolocFail('Ќе определено местоположение');
		  if(debugeo) console.log('geo freegeoip.net request fail - no IP');
			return false;
		}
		
		var req = new JsHttpRequest("windows-1251");
		req.onreadystatechange = function(){
			if (req.readyState == 4){
				if(req.responseJS){
				  if( req.responseJS.error ){
				    //geolocFail( req.responseJS.error );
					}else{
						var lat = req.responseJS.latitude;
						var lng = req.responseJS.longitude;
						if(lat==0 && lng==0){
						  geolocFail( 'получены не корректные координаты' );
						}else{
							//display_message(lat+" "+lng);
							//¬ыставл€ю если еще не выставлено
							if( $('input.geolocation_lat').val()=='' ){
							  if(debugeo) console.log('geo freegeoip.net response:'+lat+' '+lng);
								$('input.geolocation_lat').val(lat);
				      	$('input.geolocation_lng').val(lng);
				      }else
				        if(debugeo) console.log('geo freegeoip.net geolocation alredy set!');
				    }
					}
				}else{
				  geolocFail();
				}
				if(req.responseText!='') alert(req.responseText);
			}
		}
		if(debugeo) console.log('geo freegeoip.net request IP:'+uip);
		
  	req.open(null,'/lib/geoip.php', true);
		req.send({'uip':uip});
}