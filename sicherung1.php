<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Restaurant Finden</title>
<script src="js/jQuery.js"></script>
<link rel="stylesheet" href="css/styles.css">
</head>
<body>
	<h1>Restaurant finden</h1>
	<div class="box" id="restaurants"></div>
	<div class="box" id="map"></div>
	<script>
		
		
		<!-- initMap(lat1, lng1) - Initialisiert die Map mit einem Marker und zentriert die Karte, Parameter (Längengrad, Breitengrad)   -->
		
		function initMap(lat1, lng1) {
      
		var myLatlng = {lat : parseFloat(lat1), lng : parseFloat(lng1)};
		
        var vmap = new google.maps.Map(document.getElementById('map'), {
          zoom: 18,
          center: myLatlng
        });
        var marker = new google.maps.Marker({
          position: myLatlng,
          map: vmap,
          title: 'Click to zoom'
        });

        vmap.addListener('center_changed', function() {
          // 3 seconds after the center of the map has changed, pan back to the
          // marker.
          window.setTimeout(function() {
            vmap.panTo(marker.getPosition());
          }, 3000);
        });

        marker.addListener('click', function() {
          vmap.setZoom(15); //heraus zoomen (faktor 3)
          vmap.setCenter(marker.getPosition());
        });
      }
	  
	  <!-- Hauptprogramm: eine Restaurantliste aus einer json-Datei einlesen und daraus eine Restaurantliste erzeugen  -->
	  
	  var lat;
	  var lng;
	  
		
		$.getJSON("js/restaurants.json", function(json) {

            var div = document.createElement('div');
			document.getElementById('restaurants').appendChild(div);
			
			$.each(json, function( index, value ) {

                var img = document.createElement("img");
                img.setAttribute("src", value.logo);
				var ul = document.createElement('ul');
				var li = document.createElement('li');
                var a = document.createElement('a');
                var div2 = document.createElement('div');
                div.appendChild(div2);

			  <!-- Div wird ein onclick-Ereignis zugewiesen -->	
                div2.onclick = function(){
                    initMap(value.location.lat,value.location.long);
                };


                div2.appendChild(img);
                div2.append(ul);
				ul.appendChild(li);
				li.innerHTML += value.name;
				ul.appendChild(li);
				li.innerHTML += value.description;

			});
		});	  
		  
	 </script>
	 <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC8DTDDaFQ6qHBShuB7BmB2f-ycmUTQ3r4&callback=initMap" async defer></script>
</body>
</html>