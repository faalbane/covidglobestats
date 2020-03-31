<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="initial-scale=1,maximum-scale=1,user-scalable=no" />
    <script src="https://cesium.com/downloads/cesiumjs/releases/1.62/Build/Cesium/Cesium.js"></script>
	<script src="https://api.mapbox.com/mapbox-gl-js/v1.9.0/mapbox-gl.js"></script>
	<script
	  src="https://code.jquery.com/jquery-3.4.1.js"
	  integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
	  crossorigin="anonymous"></script>
	<link href="https://api.mapbox.com/mapbox-gl-js/v1.9.0/mapbox-gl.css" rel="stylesheet" />
	 <!-- LBOOT -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
    <style>
      @import url('https://cesium.com/downloads/cesiumjs/releases/1.62/Build/Cesium/Widgets/widgets.css');
      html, body {padding: 0; margin: 0;}
      #map {top: 0; right: 0; bottom: 0; left: 0; position: absolute !important;}
	  button.cesium-infoBox-camera{
		  display: none;
	  }
    </style>
  </head>
  <body>
    <div id="map"></div>
    <script>

	//l_init viewer
      var viewer = new Cesium.Viewer('map', {
        animation: false,
        baseLayerPicker: false,
        navigationHelpButton: true,
        sceneModePicker: false,
        homeButton: false,
        geocoder: false,
        fullscreenButton: false,
        imageryProvider: new Cesium.UrlTemplateImageryProvider({
          url: 'https://api.maptiler.com/maps/hybrid/{z}/{x}/{y}@2x.jpg?key=2GuOVQtAZMXdkCbgDL9T',
          tileWidth: 512,
          tileHeight: 512,
          credit: new Cesium.Credit('<a href="https://www.maptiler.com/copyright/" target="_blank">© MapTiler</a> <a href="https://www.openstreetmap.org/copyright" target="_blank">© OpenStreetMap contributors</a>', true)
        }),
        timeline: false
      });
      viewer.camera.setView({
        destination: Cesium.Cartesian3.fromDegrees(10, 50, 8000000)
      });
	  
	//l_ajax
	var l_grow = 'l_grow'; //l_tradition
	$.ajax({
		url: "php/l_fetch_covid_data.php",
		type: "POST",
		dataType: 'json',
		cache: false,
		success: function (data) {

			//l_go
			console.log(data);
			if(data[0][0].l_status == "l_go!"){
				
				//l_mm
				/* l_godata:
				l_uid
				l_country_region
				l_last_update
				l_lat
				l_lon
				l_confirmed
				l_deaths
				l_recover
				l_active
				l_combo_key
				*/
				//l_entity collection
				var l_entity_collection = new Cesium.CustomDataSource("l_entities");
				$.each(data[1], function (k, v) {
					
					if(v.l_active == 0){
						v.l_active = v.l_confirmed - v.l_deaths - v.l_recover;
					}
					if(v.l_active < 0){
						v.l_active = '-';
					}
					l_descrip_key = "Confirmed Cases: " + v.l_confirmed + "<br>Deaths: " + v.l_deaths + "<br>Recovered: " + v.l_recover + "<br>Active Cases: " + v.l_active + "<br>Last Updated: " + v.l_last_update;
					if(v.l_confirmed == 0 && v.l_deaths == 0 && v.l_recover == 0 && v.l_active == 0){
					
						//l_think
						/*
						l_entity_collection.entities.add({
							id : v.l_uid,
							name : v.l_combo_key,
							position : Cesium.Cartesian3.fromDegrees(v.l_lon, v.l_lat),
							point : {
								pixelSize : 10,
								color : Cesium.Color.BLUE,
								outlineColor : Cesium.Color.WHITE,
								outlineWidth : 3
							},
							description : l_descrip_key
						});
						*/
						
					}else{
						
						l_entity_collection.entities.add({
							id : v.l_uid,
							name : v.l_combo_key,
							position : Cesium.Cartesian3.fromDegrees(v.l_lon, v.l_lat),
							point : {
								pixelSize : 10,
								color : Cesium.Color.RED,
								outlineColor : Cesium.Color.WHITE,
								outlineWidth : 3
							},
							description : l_descrip_key
						});
						
					}
					
				});
				viewer.dataSources.add(l_entity_collection);
			}
			if(data[0][0].l_status == "l_oops!"){
				alert("oops! please contact faalbane@gmail.com asap!")
			}

		},
		error: function (XMLHttpRequest, textStatus, errorThrown) {
			alert("Oops! error");
		}
	}) 

	//l_label collection
	/*
	let l_label_collection = new Cesium.LabelCollection();
	l_label_collection.add({
	  position: Cesium.Cartesian3.fromDegrees(-101.678, 57.7833),
	  text: 'Canada',
	  translucencyByDistance : new Cesium.NearFarScalar(0.2e7, 1.0, 0.3e7, 0.0)
	});
	l_label_collection.add({
	  position : Cesium.Cartesian3.fromDegrees(-75.1641667, 39.9522222),
	  text: 'Philadelphia',
	  translucencyByDistance : new Cesium.NearFarScalar(0.2e7, 1.0, 0.3e7, 0.0)
	});
	viewer.scene.primitives.add(l_label_collection);
	*/
	
	var credit = new Cesium.Credit('');
	$('.cesium-viewer-bottom').html('<div style="background-color: black; color: white; padding: 3px">sources: <br>data: <a href="https://github.com/CSSEGISandData" target="_blank">CSSEGISandData</a> <br> SDK: <a href="https://cesium.com/" target="_blank">Cesium<a/> <br> web engineer: <a href="https://github.com/faalbane" target="_blank">faalbane</a></div>');
	//$('.cesium-viewer-toolbar').prepend('<button>lahh</button>');
	
	
	</script>
  </body>
</html>
