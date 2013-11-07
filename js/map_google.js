   var map;

    var map_icon_green = new google.maps.MarkerImage(
        "http://mysite.com/green_pointer.png",
        new google.maps.Size(12,20),
        new google.maps.Point(0,0));

    var map_icon_blue = new google.maps.MarkerImage(
        "http://mysite.com/blue_pointer.png",
        new google.maps.Size(12,20),
        new google.maps.Point(0,0));

    var map_icon_yellow = new google.maps.MarkerImage(
        "http://mysite.com/yellow_pointer.png",
        new google.maps.Size(12,20),
        new google.maps.Point(0,0));

    var map_icon_red = new google.maps.MarkerImage(
        "http://mysite.com/red_pointer.png",
        new google.maps.Size(12,20),
        new google.maps.Point(0,0));

    var map_icon_shadow = new google.maps.MarkerImage(
        "http://mysite.com/shadow.png",
        new google.maps.Size(28,20),
        new google.maps.Point(-6,0));

    var map_crosshair = new google.maps.MarkerImage(
        "http://mysite.com/cross-hair.gif",
        new google.maps.Size(17,17),
        new google.maps.Point(0,0));


    function map_loader() {
        var myOptions = {
            zoom: 5,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            scrollwheel:false
        }

        map = new google.maps.Map(
                document.getElementById('map_container'), myOptions);

        map.setCenter(new google.maps.LatLng(53.0,-1.0));

        // <![CDATA[
        var point = new google.maps.LatLng(53.0,-4.0755);
        marker = map_create_marker(point,"some html which is OK",map_icon_red);
        // ]]>

        // <![CDATA[
        var point = new google.maps.LatLng(-24.0,25.0);
        marker = map_create_marker(point,"some html which is OK",map_icon_red);
        // ]]>

        // <![CDATA[
        var point = new google.maps.LatLng(54.0,-2.0);
        marker = map_create_marker(point,"some html which is OK",map_icon_red);
        // ]]>

        map.disableDoubleClickZoom = false;
    }


    function map_create_marker(point,html,icon) {
        var marker =    new google.maps.Marker({
            position: point,
            map: map,
            icon: icon,
            shadow: map_icon_shadow
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
    function map_load_resize() {
        if(map_set_center==0) {
             map.setCenter(new google.maps.LatLng(53.0,-1.0));
        }
        map_set_center = 1;
    }