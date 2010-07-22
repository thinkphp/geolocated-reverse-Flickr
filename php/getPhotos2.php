<?php

if(isset($_GET['latitude']) && isset($_GET['longitude']) && $_GET['latitude'] != '' && $_GET['longitude'] != '') {

   $lat = $_GET['latitude'];

   $lon = $_GET['longitude'];

} else {

   $lat = '37.416115';

   $lon = '-122.02456';
}

        $url = "http://query.yahooapis.com/v1/public/yql?q=select%20*%20from%20flickr.photos.search%20where%20woe_id%20in%20(%20select%20place.woeid%20from%20flickr.places%20where%20lat%3D'".$lat."'%20and%20lon%3D'".$lon."')&format=json";

        $output = get($url);

        $results = json_decode($output);

        $photos = $results->query->results->photo;

        $all = count($photos);

        $out = '<ul>';   

             foreach($photos as $p) {

                     $src = 'http://farm'.$p->farm . '.static.flickr.com/'.$p->server.'/'.$p->id.'_'.$p->secret.'_m.jpg';

                     $out .= '<li><a href="http://www.flickr.com/photos/'.$p->owner.'/'.$p->id.'" title="'.$p->title.'"><img src="'.$src.'" alt="'.$p->title.'"></a></li>';
             }       

        $out .= '</ul>';


  /* get brute content of url */
  function get($url) {

          $ch = curl_init();

          curl_setopt($ch,CURLOPT_URL,$url);

          curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);

          curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,2);

          $data = curl_exec($ch);
 
          curl_close($ch);  

          if(empty($data)) {

            return 'Error retrieve data, please try again.';

          } else {return $data;}   

   }//endfunction get
?>

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
      <form action="<?php echo$_SERVER['PHP_SELF'];?>" id="f" method="get" name="f">
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
             <div id="photos"><?php echo$out;?></div>
        </div>
	</div>
   <div id="ft" role="contentinfo"><p>Written by Adrian Statescu using YUI, YQL and Flickr</p></div>
</div>
</body>
</html>
