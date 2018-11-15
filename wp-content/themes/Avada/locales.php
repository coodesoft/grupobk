<?php

require_once(__DIR__ . '/../../plugins/custom-upload/db/Clients.php');

global $imgBasePath;
?>
<div id="body" class="locales-section">
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
        <option value="Tucuman">Tucuman</option>
    </select>
    <div class="filters">
      <div class="filters-title">Filtrar por Categorías</div>
      <ul>
        <li><a class="item_list bk-pointer"><img class="locales_img" data-toggle="tooltip" data-placement="top" title="Venta Mayorista" data-categoria="venta_mayorista" src="<?php echo $imgBasePath.'locales_venta_mayorista.svg'?>"></a></li>
        <li><a class="item_list bk-pointer"><img class="locales_img" data-toggle="tooltip" data-placement="top" title="Venta Minorista" data-categoria="venta_minorista" src="<?php echo $imgBasePath.'locales_venta_minorista.svg'?>"></a></li>
        <li><a class="item_list bk-pointer"><img class="locales_img" data-toggle="tooltip" data-placement="top" title="Venta Online" data-categoria="venta_online" src="<?php echo $imgBasePath.'locales_venta_online.svg'?>"></a></li>
        <li><a class="item_list bk-pointer"><img class="locales_img" data-toggle="tooltip" data-placement="top" title="Revendedor" data-categoria="revendedoras" src="<?php echo $imgBasePath.'locales_revendedoras.svg'?>"></a></li>
      </ul>
    </div>
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
