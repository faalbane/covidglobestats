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
    <style>
      @import url('https://cesium.com/downloads/cesiumjs/releases/1.62/Build/Cesium/Widgets/widgets.css');
      html, body {padding: 0; margin: 0;}
      #map {top: 0; right: 0; bottom: 0; left: 0; position: absolute !important;}
		.cesium-infoBox {
			display: none;
		}
    </style>
  </head>
  <body>
    <div id="map"></div>
    <script>
      var viewer = new Cesium.Viewer('map', {
        animation: false,
        baseLayerPicker: false,
        navigationHelpButton: true,
        sceneModePicker: false,
        homeButton: false,
        geocoder: false,
        fullscreenButton: false,
        imageryProvider: new Cesium.UrlTemplateImageryProvider({
          url: 'https://api.maptiler.com/tiles/satellite/{z}/{x}/{y}.jpg?key=2GuOVQtAZMXdkCbgDL9T',
          tileWidth: 512,
          tileHeight: 512,
          credit: new Cesium.Credit('<a href="https://www.maptiler.com/copyright/" target="_blank">© MapTiler</a> <a href="https://www.openstreetmap.org/copyright" target="_blank">© OpenStreetMap contributors</a>', true)
        }),
        timeline: false
      });
      viewer.camera.setView({
        destination: Cesium.Cartesian3.fromDegrees(10, 50, 8000000)
      });
	  
	  
	var l_entity_collection = new Cesium.CustomDataSource("l_entities");
	l_entity_collection.entities.add({
		id : "l_2",
		position : Cesium.Cartesian3.fromDegrees(-101.678, 57.7833),
		point : {
			pixelSize : 10,
			color : Cesium.Color.RED,
			outlineColor : Cesium.Color.WHITE,
			outlineWidth : 3
		}
	});
	l_entity_collection.entities.add({
		id : "l_3",
		position : Cesium.Cartesian3.fromDegrees(-75.166493, 39.9060534),
		point : {
			pixelSize : 10,
			color : Cesium.Color.RED,
			outlineColor : Cesium.Color.WHITE,
			outlineWidth : 3
		}
	});
	viewer.dataSources.add(l_entity_collection);
	
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
	
	var credit = new Cesium.Credit('');
	$('.cesium-viewer-bottom').html('<div style="background-color: black; color: white; padding: 3px">collab between <a href="https://cesium.com/" target="_blank">Cesium<a/>, <a href="https://github.com/CSSEGISandData" target="_blank">CSSEGISandData</a>, and <a href="https://github.com/faalbane" target="_blank">faalbane</a></div>');
	
    viewer.selectedEntityChanged.addEventListener(function(l_entity) {
		console.log(l_entity.id);
	});
	
	var i = 0;

	var handler = new Cesium.ScreenSpaceEventHandler(viewer.canvas);

	handler.setInputAction(function (movement) {
		i++;
		console.log("LEFT_DOWN " + i);
	}, Cesium.ScreenSpaceEventType.LEFT_DOWN);

	handler.setInputAction(function () {
		console.log("LEFT_UP " + i);
	}, Cesium.ScreenSpaceEventType.LEFT_UP);
	
	
	
	</script>
  </body>
</html>
