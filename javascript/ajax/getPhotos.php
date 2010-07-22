<?php

if(isset($_GET['lat']) && isset($_GET['lon']) && $_GET['lat'] != '' && $_GET['lon'] != '') {

   $lat = $_GET['lat'];

   $lon = $_GET['lon'];

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


   echo$out;

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