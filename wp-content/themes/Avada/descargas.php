<?php

$user = wp_get_current_user();
//if ( in_array( 'Cliente', (array) $user->roles ) ) {
  //get_template_part( 'rrhh' );
// echo '<a href="localhost\globalsax\wp-content\themes\Avada\rrhh.php" id="addContent" class= >RRHH</a>';
//menu no cantes las horas
$script =   "<script type='text/javascript' src='https://code.jquery.com/jquery-1.11.3.min.js'></script>";

global $wpdb;

$user_id = $user->ID;
$cudb         = apply_filters( 'cu_database', $wpdb );
$access_table_name  = $cudb->prefix . ('cu_access');
$files_table_name  = $cudb->prefix . ('cu_files');
$history_table_name = $cudb->prefix . ('cu_history');
?>
<script type="text/javascript" >
function insertar_con_js ( varfile_id, varuser_id ) {
// ----- INICIO Convertimos las variables de javascript en variables de PHP
jQuery(function (){
// Definimos las variables de javascrpt
var file_id = varfile_id;
var user_id = varuser_id;
// Ejecutamos AJAX
jQuery("#cont").load( "/demo/wp-content/themes/Avada/procesar_file_id.php" , {file_id, user_id});
});
// ----- FIN Convertimos las variables de javascript en variables de PHP
}
</script>
<?php

$tipos = array(
  '0' => 'JPG',
  '1' => '1X1',
  '2' => 'PDF',
  '3' => 'L. Precios',
  '4' => 'N. Pedidos',
  '5' => 'Video');

$files_type = array(
  '0' => 'JPG',
  '1' => '1X1',
  '2' => 'pdf',
  '3' => 'precios',
  '4' => 'pedidos',
  '5' => 'video');

      $consulta = ("SELECT file_dir, $files_table_name.file_id, $files_table_name.file_type  FROM $files_table_name RIGHT JOIN $access_table_name
              ON $access_table_name.user_id = $user_id
              AND $files_table_name.file_id = $access_table_name.file_id
              ORDER BY $files_table_name.file_type");

$resultado = $wpdb->get_results($consulta, OBJECT);

$files_array = array();
$productos = array();
foreach($resultado as $index => $row){
  if (!(is_null($row->file_dir))){
    $lastSlash = strrpos($row->file_dir, '/');
    $lastfolderpos = strpos($row->file_dir, '/files/');
    $uptolastslash = $lastSlash - $lastfolderpos;
    $lastfolder = substr($row->file_dir, $lastfolderpos+1, $uptolastslash);
    $filename = substr($row->file_dir, $lastSlash+1);
    $file_dir = home_url('/wp-content/plugins/custom-upload/' . $lastfolder );
    $posproducto = strpos($lastfolder, '/') + 1;
    $producto = substr($lastfolder, $posproducto);
    $producto = substr($producto, 0 , -1);
    
    if($row->file_type < 3) {
      $src = home_url('/wp-content/uploads/2018/04/'. $producto .'_pdf_2017.svg');
    } else {
      $src = home_url('/wp-content/uploads/2018/04/'. $producto .'_'. $files_type[$row->file_type] .'.svg');
    }
    $link ="<span class='fusion-imageframe imageframe-none imageframe-1 hover-type-none icon folder'><a class='fusion-no-lightbox'target='_blank' aria-label='' rel='noopener noreferrer' href='".$file_dir . $filename ."'><img src= $src width='' height='' alt='' class='img-responsive wp-image-11977 cont' onclick='insertar_con_js($row->file_id, $user_id);' ></a></span>";
    $insert = array("producto" => $producto, "link" => $link, "tipo" => $row->file_type);
    

   array_push($files_array, $insert);
   array_push($productos, $producto);
  }
}

$colores = array( 'belen' => '#7c5c81',
                  'sigry' => '#a6a299',
                  'lara_teens' =>'#c70a6e',
                  'bakhou' => '#285b8a');

$reemprod = array( 'belen' => 'Belen Intima',
                  'sigry' => 'Sigry',
                  'lara_teens' =>'Lara Teens',
                  'bakhou' => 'Bakhou');


$cargados = array();

  for ($i=0; $i <= sizeof($productos); $i++) {
  if (!(in_array($productos[$i], $cargados))){

  echo '<h2 style="text-align:left;padding-left:15px;padding-top:10px;" data-fontsize="18" data-lineheight="27"><strong><span style="color: '.$colores[$productos[$i]].'">'. $reemprod[$productos[$i]] . '</span></strong></h2>';
  echo "<div class='fusion-column-content-centered'><div class='fusion-column-content'>";
  $actual = $productos[$i];
    for ($j=0; $j <= sizeof($files_array); $j++) {
      if ($files_array[$j-1]["producto"] == $actual) {
        echo "<div class='fusion-layout-column fusion_builder_column fusion_builder_column_1_6  fusion-one-sixth 1_6' style = 'margin-top:0px;margin-bottom:20px;width:16%;width:calc(16.66% - ( ( 4% + 4% + 4% + 4% + 4% ) * 0.1666 ) );margin-right: 3%;'>";
        echo "<div class='fusion-column-wrapper' style='background-position:left top;background-repeat:no-repeat;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;'>";
        echo "<div class='fusion-column-content-centered'><div class='fusion-column-content'>";
        echo $files_array[$j-1]["link"];
        echo '<p style="text-align: left; padding-left: 25%;">';
        echo $tipos[$files_array[$j-1]["tipo"]];
        echo '</p>';
        echo "</div></div></div></div>";
            }
    }
    echo "</div></div>";
    array_push($cargados, $productos[$i]);
    }
  }
    echo "<div style='display:none;' id='cont'></div>";
    
?>