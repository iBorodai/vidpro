   var map;

    var map_icon_blue = new google.maps.MarkerImage(
        "http://ustudio.com.ua/img/point_blue.png",
        new google.maps.Size(21,26),
        new google.maps.Point(0,0),
        new google.maps.Point(0,26)
		);

    function map_loader(map_container_id,lat,lng,prm_html) {
        var myOptions = {
            zoom: 16,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            scrollwheel:false
        }

        map = new google.maps.Map(
        	document.getElementById(map_container_id), myOptions
				);

        map.setCenter(new google.maps.LatLng(lat,lng));

        // <![CDATA[
        var point = new google.maps.LatLng(lat,lng);
        marker = map_create_marker(point,prm_html,map_icon_blue);
        // ]]>


        //map.disableDoubleClickZoom = false;
    }


    function map_create_marker(point,html,icon) {
        var marker =    new google.maps.Marker({
            position: point,
            map: map,
            icon: icon
        });

        if(html!="") {
            var infowindow = new google.maps.InfoWindow({
                    content: html
            });
            google.maps.event.addListener(marker, 'click', function() {
                infowindow.open(map,marker);
            });
        }
        return marker;
    }
    var map_set_center = 0;
    function map_load_resize(lat,lng) {
        if(map_set_center==0) {
             map.setCenter(new google.maps.LatLng(lat,lng));
        }
        map_set_center = 1;
    }
    
    
/*
					gMap = new google.maps.Map(document.getElementById('map_container'));
					gMap.setZoom(16);      // This will trigger a zoom_changed on the map

					var t=ll.split(',');
					var lat=t[0],lan=t[1];
					delete t;

					gMap.setCenter(new google.maps.LatLng(lat, lan));
					gMap.setMapTypeId(google.maps.MapTypeId.ROADMAP);

					var info_window = new google.maps.InfoWindow({
	            content: 'loading'
	        });

					var m = new google.maps.Marker({
            map:       gMap,
            animation: google.maps.Animation.DROP,
            title:     obj_title,
            position:  new google.maps.LatLng(lat, lan),
            html:      obj_html
          });

          google.maps.event.addListener(m, 'click', function() {
              info_window.setContent(this.html);
              info_window.open(gMap, this);
          });
*/