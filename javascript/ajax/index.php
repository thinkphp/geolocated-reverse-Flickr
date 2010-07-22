<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
   <title>Geolocated Photos Flickr</title>
   <link rel="stylesheet" href="http://yui.yahooapis.com/2.7.0/build/reset-fonts-grids/reset-fonts-grids.css" type="text/css">
   <link rel="stylesheet" href="http://yui.yahooapis.com/2.7.0/build/base/base.css" type="text/css">
   <link rel="stylesheet" href="getPhotosFromFlickr.css" type="text/css">
</head>
<body>
<div id="doc" class="yui-t7">
   <div id="hd" role="banner"><h1>Geolocated Photos Flickr</h1></div>
   <div id="bd" role="main">
      <form action="#" id="f" method="get" name="f">
         <div>
         <label for="latitude">latitude</label>
         <input type="text" name="latitude" id="latitude" value="37.416115"/>
         </div>
         <div>
         <label for="longitude">longitude</label>
         <input type="text" name="longitude" id="longitude" value="-122.02456"/>
         </div>
         <div>
         <input type="submit" value="get Photos" id="grab"/>
         </div>
      </form>
	<div class="yui-g">
             <div id="photos"></div>
        </div>
	</div>
   <div id="ft" role="contentinfo"><p>Written by Adrian Statescu using YUI, YQL and Flickr</p></div>
</div>
<script type="text/javascript" src="ajax.js"></script>
<script type="text/javascript">

(function(){

  var f = document.getElementById('f');

  var container = document.getElementById('photos');

  var s = document.getElementById('grab');

  f.onsubmit = function(){

        s.setAttribute('value','loading...');

        var lat = document.f.latitude.value;

        var lon = document.f.longitude.value;
 
        var url = 'getPhotos.php?lat='+lat+'&lon='+lon;

        asyncRequest.REQUEST('GET',url,handleResponse);    

        function handleResponse(o) {

           container.innerHTML = o;  

           s.setAttribute('value','get Photos');
        }

     return false;
  }

})();
</script>
</body>
</html>
