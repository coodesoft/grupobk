<?php

require_once(__DIR__ . '/../../plugins/custom-upload/db/Clients.php');

global $wpdb;
/* ?>

<script>
function initMap() {
var map = new google.maps.Map(document.getElementById('map'), {
  center: new google.maps.LatLng(-33.863276, 151.207977),
  zoom: 12
});
var infoWindow = new google.maps.InfoWindow;


  downloadUrl('https://storage.googleapis.com/mapsdevsite/json/mapmarkers2.xml', function(data) {
    var xml = data.responseXML;
    var markers = xml.documentElement.getElementsByTagName('marker');
    Array.prototype.forEach.call(markers, function(markerElem) {
      var id = markerElem.getAttribute('id');
      var name = markerElem.getAttribute('name');
      var address = markerElem.getAttribute('address');
      var type = markerElem.getAttribute('type');
      var point = new google.maps.LatLng(
          parseFloat(markerElem.getAttribute('lat')),
          parseFloat(markerElem.getAttribute('lng')));

      var infowincontent = document.createElement('div');
      var strong = document.createElement('strong');
      strong.textContent = name
      infowincontent.appendChild(strong);
      infowincontent.appendChild(document.createElement('br'));

      var text = document.createElement('text');
      text.textContent = address
      infowincontent.appendChild(text);
      var icon = customLabel[type] || {};
      var marker = new google.maps.Marker({
        map: map,
        position: point,
        label: icon.label
      });
      marker.addListener('click', function() {
        infoWindow.setContent(infowincontent);
        infoWindow.open(map, marker);
      });
    });
  });
}



function downloadUrl(url, callback) {
var request = window.ActiveXObject ?
    new ActiveXObject('Microsoft.XMLHTTP') :
    new XMLHttpRequest;

request.onreadystatechange = function() {
  if (request.readyState == 4) {
    request.onreadystatechange = doNothing;
    callback(request, request.status);
  }
};

request.open('GET', url, true);
request.send(null);
}

function doNothing() {}

</script>
<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD-cK8Eml2T7tgYd0JjWQnXH7hJHzupqe8&callback=initMap"></script>
<?php */
/*$user = wp_get_current_user();

$locales_db = apply_filters('locales_db', $wpdb);
$table_name = $locales_db->prefix .*/

$clientes = Clients::getAll();
$sucursales = Clients::getSucursales();



/*foreach ($sucursales as $key => $value) {
    $address = $value['direccion_publica'] . ", " . $value['ciudad'] . ", " . $value['provincia'];
}

$address   = urlencode($address);

$url       = "https://maps.google.com/maps/api/geocode/json?sensor=false&address={$address}";
$resp_json = file_get_contents($url);
$resp      = json_decode($resp_json, true);

    if ($resp['status'] == 'OK') {
        // get the important data
        $lati  = $resp['results'][0]['geometry']['location']['lat'];
        $longi = $resp['results'][0]['geometry']['location']['lng'];
        /*echo $lati;
        echo $longi;*/


 //$sucursales = Clients::getSucursalesByClient($id);
 /*<ul>
   <?php foreach ($clientes as $key => $value) { ?>
     <li><?php echo $value['nombre_cliente']?></li>
   <?php } ?>
 </ul>*/
?>
<div id="body">
 <section class="section">
   <div class="interior">
   <div class="titular"><h2>Locales</h2></div>

  <div class="info_list provincia" id="provincia" >
      <select name="menu-prov"  class="selector" aria-required="true" aria-invalid="false">
        <option value="">---</option>
        <option value="Buenos Aires">Buenos Aires</option>
        <option value="Buenos Aires-GBA">Buenos Aires-GBA</option>
        <option value="Capital Federal">Capital Federal</option>
        <option value="Catamarca">Catamarca</option>
        <option value="Chaco">Chaco</option>
        <option value="Chubut">Chubut</option>
        <option value="Cordoba">Cordoba</option>
        <option value="Corrientes">Corrientes</option>
        <option value="Entre Rios">Entre Rios</option>
        <option value="Formosa">Formosa</option>
        <option value="Jujuy">Jujuy</option>
        <option value="La Pampa">La Pampa</option>
        <option value="La Rioja">La Rioja</option>
        <option value="Mendoza">Mendoza</option>
        <option value="Misiones">Misiones</option>
        <option value="Neuquen">Neuquen</option>
        <option value="Rio Negro">Rio Negro</option>
        <option value="Salta">Salta</option>
        <option value="San Juan">San Juan</option>
        <option value="San Luis">San Luis</option>
        <option value="Santa Cruz">Santa Cruz</option>
        <option value="Santa Fé">Santa Fé</option>
        <option value="Santiago del Estero">Santiago del Estero</option>
        <option value="Tierra del Fuego">Tierra del Fuego</option>
        <option value="Tucuman">Tucuman</option></select>

     <ul>
      <li><a class="item_list"><img class="locales_img" data-cat="venta_mayorista" src="/demo/img/locales_venta_mayorista.svg"></a></li>
      <li><a class="item_list"><img class="locales_img" data-cat="venta_minorista" src="/demo/img/locales_venta_minorista.svg"></a></li>
      <li><a class="item_list"><img class="locales_img" data-cat="venta_online" src="/demo/img/locales_venta_online.svg"></a></li>
      <li><a class="item_list"><img class="locales_img" data-cat="revendedoras" src="/demo/img/locales_revendedoras.svg"></a></li>
    </ul>
   </div>

 <div class="other_section">
   <div id="mapas" class="mapas"> </div>

   <div class="fusion-separator fusion-full-width-sep sep-single sep-solid separator">
   </div>

    <div class="provincia" id=sucursales>
    </div>
  </div>
</div>
 </section>
 </div>
