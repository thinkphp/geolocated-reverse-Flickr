var getPhotosFromFlickr = function(){

    var config = {

        output: 'photos' 
    }; 

    var c;
  
    function init(lat,lon,obj) {

         c = obj;
 
         document.getElementById(config.output).innerHTML = 'Loading...';

         var yql = 'select * from flickr.places where lat="'+ lat + '" and lon="' + lon + '"';

         callJSONService(yql,'seed'); 
    }

    function seed(o) {

         if(typeof o.query.results.places.place != 'undefined') {

                   var yql = 'select * from flickr.photos.search(20) where woe_id = "' + o.query.results.places.place.woeid + '"';

                   callJSONService(yql,'showPhotos');                

                   document.getElementById(config.output).innerHTML = '<h2>Photos in '+o.query.results.places.place.name+'</h2>';
         }

    }


    function showPhotos(o) {

         var old = document.getElementById('jsonsource');

         if(old) {old.parentNode.removeChild(old);} 

         var container = document.getElementById(config.output);

         var results = o.query.results.photo,all = results.length;

         var out = '<ul>';   

             for(var i=0;i<all;i++) {

                     var current = results[i];

                     var src = 'http://farm'+current.farm + '.static.flickr.com/'+current.server+'/'+current.id+'_'+current.secret+'_m.jpg';

                     out += '<li><a href="http://www.flickr.com/photos/'+current.owner+'/'+current.id+'" title="'+current.title+'"><img src="'+src+'" alt="'+current.title+'"></li>';  
             }       

             out += '</ul>';

             container.innerHTML += out;

             c.callback();
    } 

    function callJSONService(yql,callback) {

         var old = document.getElementById('jsonsource');

         if(old) {old.parentNode.removeChild(old);} 

         var call = 'getPhotosFromFlickr.'+callback;

         var endpoint = 'http://query.yahooapis.com/v1/public/yql?q=';

         var url = endpoint + encodeURIComponent(yql) + '&format=json&callback='+call;

         //create a script node and add it to the document
         var script = document.createElement('script') 

         script.setAttribute('src',url);

         script.setAttribute('id','jsonsource');

         document.getElementsByTagName('head')[0].appendChild(script);
    }

    return {grab: init,seed: seed,showPhotos: showPhotos,config: config};
}();
