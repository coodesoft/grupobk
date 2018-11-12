<?php

require_once(__DIR__ . '/../db/Clients.php');


add_action( 'wp_ajax_cu_add_client', 'cu_add_client' );
function cu_add_client(){

  $params = array();
  parse_str($_POST['data'], $params);

  $clientName = $params['Cliente'];
  $clientName = strtolower($clientName);

  $stored = Clients::getByName($clientName);

  if ($stored){
    $msg = 'El cliente ya existe mostri';
    echo json_encode(['msg' => $msg, 'type' => 'cu-error']);
    wp_die();
  }

  $result = Clients::add($clientName);

  if ($result){
    $stored = Clients::getAll();

    $html = "";
    foreach ($stored as $key => $value) {
      $html .= '<tr>';
      $html .= '<td>' . $value['nombre_cliente'] . '</td>';
      $html .= '<td>  <div class="edit-client"></div><div class="remove-client"></div></td>';
      $html .= '</tr>';
    }
    echo json_encode(['msg' => 'Se añadió correctamente el cliente',
                      'response' => $html,
                      'type' => 'cu-success'
                    ]);
    wp_die();
  }
}

add_action( 'wp_ajax_cu_edit_client', 'cu_edit_client' );
function cu_edit_client(){
  $params = array();
  parse_str($_POST['data'], $params);

  $clientEdit = $params['ClientEdit'];
  $clientName = strtolower($clientEdit['name']);
  $clientId = $clientEdit['id'];

  $result = Clients::update($clientId, $clientName);

  if ($retuls !== false){
    echo json_encode(['msg' => 'Se actualizó correctamente el cliente',
                      'response' => $clientName,
                      'type' => 'cu-success']);
  } else{
    echo json_encode(['msg' => 'Se produjo un error al actualizar el cliente',
                      'response' => $clientName,
                      'type' => 'cu-error']);
  }
  wp_die();
}


add_action( 'wp_ajax_cu_delete_client', 'cu_delete_client' );
function cu_delete_client(){

  $params = array();
  parse_str($_POST['data'], $params);

  $toRemove = $params['ClientRemove'];
  $result = Clients::delete($toRemove);

  if ($result){
    echo json_encode(['msg' => 'Se eliminó correctamente el cliente',
                      'type' => 'cu-success']);
  } else{
    echo json_encode(['msg' => 'Se produjo un error al eliminar el cliente',
                      'type' => 'cu-error']);
  }
  wp_die();
}

add_action( 'wp_ajax_cu_get_sucursales', 'cu_get_sucursales' );
function cu_get_sucursales(){
  $params = array();
  parse_str($_POST['user'], $params);
  $cliente_id = $params['Sucursal']['cliente_actual'];
  $sucursales = Clients::getSucursalesByClient($cliente_id);
  if (!empty($sucursales)){
    $html = "";
    foreach ($sucursales as $key => $value)
      $html .= '<li>' . $value['direccion_publica'] . '</li>';

    echo $html;
  }else
    echo 'No hay sucursales cargadas';

  wp_die();
}


add_action( 'wp_ajax_cu_add_sucursal', 'cu_add_sucursal' );
function cu_add_sucursal(){
  $params = array();
  parse_str($_POST['data'], $params);
  $sucursal = $params['Sucursal']['location'];
  $cliente_id = $params['Sucursal']['cliente_actual'];
  $provincia = $params['Sucursal']['provincia'];
  $ciudad = $params['Sucursal']['ciudad'];

  $result = Clients::addSucursal($cliente_id, $sucursal, $provincia, $ciudad);

  if ($result){
    $sucursales = Clients::getSucursalesByClient($cliente_id);
    if (!empty($sucursales)){
      $html = "";
      foreach ($sucursales as $key => $value)
        $html .= '<li>' . $value['direccion_publica'] . '</li>';
    }
    echo json_encode(['msg' => 'Se añadió correctamente el cliente',
                      'response' => $html,
                      'type' => 'cu-success'
                    ]);
  } else{
    $msg = 'Se produjo un error al agregar la sucursal. Consulte con soporte';
    echo json_encode(['msg' => $msg, 'type' => 'cu-error']);
  }

  wp_die();
}

add_action('wp_ajax_load_prov', 'load_prov');
add_action('wp_ajax_nopriv_load_prov', 'load_prov');
function load_prov(){
  parse_str ($_POST['user'], $values);
  $sucursales = Clients::getSucursalesByProvincia($values['menu-prov']);
  $ciudadescargadas = array();
  foreach ($sucursales as $k => $v) {
     if (($v['provincia'] == $values['menu-prov'])){
     if (!(in_array($v['id'], $ciudadescargadas))){ ?>
      <div class="container-prov">
      <div class="ciudad"> <?php echo $v['ciudad'] ?>   </div>
      <div id="hidden-info" class="sucursal">
        <div class="nombre_cliente" data-address="<?php echo $v['direccion_publica'].",".$v['ciudad'].",".$v['provincia'].",Argentina" ?>">
           <span><?php echo $v['nombre_cliente'] ?></span></div>
        <div class="direccion_publica"> <?php echo $v['direccion_publica'] ?> </div>
        <div class="info">
          <ul>
          <?php if (($v['sitio_web'])== true) { ?>
            <li><img class="items" src="/demo/img/locales_sitio_web.svg" href="#"></li>
          <?php } ?>

          <?php if (($v['venta_mayorista'])== true) { ?>
            <li><img class="items" src="/demo/img/locales_venta_mayorista.svg"></li>
          <?php } ?>

          <?php if (($v['venta_minorista'])== true) {  ?>
            <li><img class="items" src="/demo/img/locales_venta_minorista.svg"></li>
          <?php } ?>

          <?php if (($v['venta_online'])== true) { ?>
            <li><img class="items" src="/demo/img/locales_venta_online.svg"></li>
          <?php } ?>

          <?php if (($v['revendedoras'])== true) { ?>
            <li><img class="items" src="/demo/img/locales_revendedoras.svg"></li>
          <?php } ?>
        </ul>
        </div>
      </div>
    </div>
        <?php array_push($ciudadescargadas, $v['id']);

      }
      }
    }

  wp_die();
}

add_action('wp_ajax_cat_filter', 'cat_filter');
add_action('wp_ajax_nopriv_cat_filter', 'cat_filter');
function cat_filter(){
  $category = $_POST['cat']['cat'];
  $sucursales = Clients::getSucursalesByCategory($category);
  $ciudadescargadas = array();
  foreach ($sucursales as $k => $v) {
     if (!(in_array($v['id'], $ciudadescargadas))){ ?>
      <div class="container-prov">
      <div class="ciudad"> <?php echo $v['ciudad'] ?>   </div>
      <div id="hidden-info" class="sucursal">
        <div class="nombre_cliente" data-address="<?php echo $v['direccion_publica'].",".$v['ciudad'].",".$v['provincia'].",Argentina" ?>"> <span><?php echo $v['nombre_cliente'] ?></span></div>
        <div class="direccion_publica"> <?php echo $v['direccion_publica'] ?> </div>
        <div class="info">
          <ul>
          <?php if (($v['sitio_web'])== true) { ?>
            <li><img class="items" src="/demo/img/locales_sitio_web.svg" href="#"></li>
          <?php } ?>

          <?php if (($v['venta_mayorista'])== true) { ?>
            <li><img class="items" src="/demo/img/locales_venta_mayorista.svg"></li>
          <?php } ?>

          <?php if (($v['venta_minorista'])== true) {  ?>
            <li><img class="items" src="/demo/img/locales_venta_minorista.svg"></li>
          <?php } ?>

          <?php if (($v['venta_online'])== true) { ?>
            <li><img class="items" src="/demo/img/locales_venta_online.svg"></li>
          <?php } ?>

          <?php if (($v['revendedoras'])== true) { ?>
            <li><img class="items" src="/demo/img/locales_revendedoras.svg"></li>
          <?php } ?>
        </ul>
        </div>
      </div>
    </div>
        <?php array_push($ciudadescargadas, $v['id']);

      }
    }
  wp_die();
}


add_action( 'wp_ajax_cu_edit_features', 'cu_edit_features' );
function cu_edit_features(){
  parse_str($_POST['data'], $params);
  $clientes = $params['Cliente'];
  $result = [];
  $results = [];
  foreach ($clientes as $cliente_id => $sucursales) {
    foreach ($sucursales as $sucursal_id => $features) {
      $fields = [];
      $fields['visibilidad'] = 0;
      $fields['venta_mayorista'] = 0;
      $fields['venta_minorista'] = 0;
      $fields['venta_online'] = 0;
      $fields['revendedoras'] = 0;
      foreach ($features as $key => $value) {
        if ($key == 'direccion_publica')
          $fields[$key] = $value;
        else
          $fields[$key] = 1;
      }
      $result = Clients::updateSucursalFeature($fields, $cliente_id, $sucursal_id);
      $results[] = [$cliente_id, $sucursal_id, $result];
    }
  }
  $msg = "";
  $return = [];

  foreach ($results as $key => $result) {
    if ($result === false)
      $msg .= 'Se produjo un error en el cliente con id: '. $result[0] ."y sucursal con id: ". $sucursal_id. '<br>';
  }

  if (strlen($msg) == 0){
    $msg = 'Se actualizaron las características exitosamente';
    $return['type'] = 'cu-success';
  } else
    $return['type'] = 'cu-error';

  $return['response'] = '<p>'. $msg .'</p>';
  echo json_encode($return);
  wp_die();
}
