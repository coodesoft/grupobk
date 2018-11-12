<?php

$user = wp_get_current_user();
if ( in_array( 'RRHH', (array) $user->roles ) ) {
  //get_template_part( 'rrhh' );
// echo '<a href="localhost\globalsax\wp-content\themes\Avada\rrhh.php" id="addContent" class= >RRHH</a>';
//menu no cantes las horas
}


$data = array();
global $wpdb;
$cfdb         = apply_filters( 'cfdb7_database', $wpdb );
$table_name  = $cfdb->prefix . ('db7_forms');

$form_post_id = '4842';
if (empty($_POST['edad'])){
	$edad_inic = 0;
	$edad_fin = 9999;
} else {
	$edad_inic = get_edad($_POST['edad'], 'inic');
	$edad_fin = get_edad($_POST['edad'], 'fin');
}
$filtros = array(
	"puesto" => $_POST['puesto'],
"edad_inic" => $edad_inic,
"edad_fin" => $edad_fin,
"genero" => $_POST['genero'],
"provincia" => $_POST['provincia_rrhh'],
"localidad" => $_POST['localidad']
);

$primer_filtro = get_not_empty($filtros);
$primer_filtro .= get_query($filtros);

if (!empty($primer_filtro)){
$result_form = $cfdb->get_results("SELECT * FROM $table_name WHERE form_value LIKE ".$primer_filtro ."
AND form_post_id = '$form_post_id' ");
} else {
  $result_form = $cfdb->get_results("SELECT * FROM $table_name WHERE form_post_id = '$form_post_id' ");
}

echo '<div id="body">';
echo '<section class="section">';
  echo '<div class="interior">';
  echo '<div class="titular"><h2>RRHH</h2></div>';
  if (isset($_POST['busqueda'])){
      echo "<div class='boton_unico'><a class='boton_gris' style='margin-top:20px;' href='". esc_url(get_permalink()) ."'>Nueva Busqueda</a></div>";
  if(sizeof($result_form) === 0){
      echo "<div class='mensajes'><div style='background-color:#5BC965;' class='mensaje_interno'><p>No hay resultados para su consulta.</p><script type='text/javascript'>$(document).ready(function() { setTimeout(function() { $('.mensaje_interno').fadeOut(1500); },6000); }); </script></div></div>"; mysqli_close($conexion);
  } else {
      
      echo "<div class='rrhh_personas'>";
      foreach ( $result_form as $result ) {
				  $form_value =  unserialize($result->form_value);
					/*$link  = "<b><a href=admin.php?page=cfdb7-list.php&fid=%s&ufid=%s>%s</a></b>";
					if(isset($form_value['cfdb7_status']) && ( $form_value['cfdb7_status'] === 'read' ) )
							$link  = "<a href=admin.php?page=cfdb7-list.php&fid=%s&ufid=%s>%s</a>";
          $fid   = $result->form_post_id;
					$form_values['form_id'] = $result->form_id;*/

				foreach ($form_value as $k => $value) {
						$ktmp = $k;
						$can_foreach = is_array($value) || is_object($value);
						if ( $can_foreach ) {
								foreach ($value as $k_val => $val):
										$form_values[$ktmp] = ( strlen($val) > 150 ) ? substr($val, 0, 150).'...': $val;
										$form_values[$ktmp] = sprintf($link, $fid, $result->form_id, $form_values[$ktmp]);
								endforeach;
						}else{
								 $form_values[$ktmp] = ( strlen($value) > 150 ) ? substr($value, 0, 150).'...': $value;
								 $form_values[$ktmp] = sprintf($form_values[$ktmp]);
								 }
						}
						$data[] = $form_values;
						//if (0 < strpos(strtolower ($form_values['menu-genero']), 'masculino')) {$genero = 'masculino';} else {$genero ='femenino';}
						$genero = strtolower ($form_values['menu-genero']);
						$CV = /* get_string (*/$form_values['file-archivocfdb7_file'];
						$puesto = /* get_string */$form_values['your-puesto'];
						$nombre = /* get_string */$form_values['your-name'];
						$apellido = /* get_string */$form_values['your-lastname'];
						$email = /* get_string (*/$form_values['your-email'];
						$puesto = /* get_string (*/$form_values['your-puesto'];
						$telefono = /* get_string (*/$form_values['your-fijo'];
						$prov = /* get_string (*/$form_values ['your-provincia'];
						$loc = /* get_string */$form_values ['your-localidad'];
						$fecha = /* get_string */$form_values ['fecha-nacimiento'];
						if ((busca_edad($fecha) < $filtros['edad_fin']) && (busca_edad($fecha) > $filtros['edad_inic']) ){
          echo "<div class='rrhh_personas_div'><img class='anim' src='/demo/img/ico_".$genero.".svg'/>";
          echo "<h3>".$puesto."</h3>";
          echo "<h4><a target='_blank' title='Descargar CV' href='../cfdb7_uploads/" . $CV . "'><img src='/demo/img/ico_descarga.svg'/></a></h4>";
          echo "<div class='datos_rrhh'><p><span>Nombre: </span>".$nombre."</p>";
          echo "<p><span>Apellido: </span>".$apellido."</p>";
          echo "<p><span>Mail: </span>".$email."</p>";
          echo "<p><span>Tel: </span>".$telefono."</p>";
          echo "<p><span>Provincia: </span>".$prov."</p>";
          echo "<p><span>Localidad: </span>".$loc."</p>";
          echo "<p><span>Nac: </span>".$fecha."</p>";
          echo "<p><span>Edad: </span>".busca_edad($fecha)." años</p>";
          echo "</div></div>";
        }} echo "</div>";
      }
  } else { ?>
  <form class="formtrescol" name="rrhhpersonas" action="" method="post" enctype="multipart/form-data">
  <div class="trescol">
      <div>
          <label for="puesto"><p>Puesto</p></label>
          <select id="Puesto" name="puesto">
              <option value="">Todos</option>
              <option value="Chofer Repartidor">Chofer Repartidor</option>
              <option value="Encimador Textil">Encimador Textil</option>
              <option value="Cortador a Maquina">Cortador a máquina</option>
              <option value="Oficial de Costura">Oficial de Costura</option>
              <option value="Empleado de Produccion">Empleado de Producción</option>
              <option value="Oficial de Embolse">Oficial de Embolse</option>
              <option value="Empleado Administrativo y/o de Facturacion">Empleado Administrativo y/o de Facturación</option>
              <option value="Vendedora">Vendedora</option>
              <option value="Disenadora de Indumentaria">Diseñadora de Indumentaria</option>
              <option value="Modelista">Modelista</option>
              <option value="Otros">Otros</option>
          </select>
      </div>
      <div class="">
          <label for="edad"><p>Edad<span> (00-00)</span></p></label>
          <input type="text" name="edad" id="edad" size="30"/>
      </div>
        <div>
          <label for="genero"><p>Género</p></label>
          <select id="genero" name="genero">
              <option value="">Ambos</option>
              <option value="Masculino">Masculino</option>
              <option value="Femenino">Femenino</option>
          </select>
      </div>
  </div>
  <div class="trescol">
      <div>
          <?php/*
          require("../conexion.php");
          $res_prov = mysqli_query($conexion, "select * from provincias");
          mysqli_close($conexion);*/
          ?>
          <label for="provincia_rrhh"><p>Provincia</p></label>
          <select type="text" name="provincia_rrhh" id="provincia_rrhh">
                            <option value="" selected>Todas</option>
							<option value="Buenos Aires" >Buenos Aires</option>
							<option value="Catamarca" >Catamarca</option>
							<option value="Chaco" >Chaco</option>
							<option value="Chubut" >Chubut</option>
							<option value="Cordoba" >Cordoba</option>
							<option value="Corrientes" >Corrientes</option>
							<option value="Entre Rios" >Entre Rios</option>
							<option value="Formosa" >Formosa</option>
							<option value="Jujuy" >Jujuy</option>
							<option value="La Pampa" >La Pampa</option>
							<option value="La Rioja" >La Rioja</option>
							<option value="Mendoza" >Mendoza</option>
							<option value="Misiones" >Misiones</option>
							<option value="Neuquen" >Neuquen</option>
							<option value="San Juan" >San Juan</option>
							<option value="San Luis" >San Luis</option>
							<option value="Santa Cruz" >Santa Cruz</option>
							<option value="Santa Fe" >Santa Fe</option>
							<option value="Santiago del Estero" >Santiago del Estero</option>
							<option value="Tierra del Fuego" >Tierra del Fuego</option>
							<option value="Tucuman" >Tucuman</option>
          </select>
      </div>
      <div id="localidad_rrhh">
          <label for="localidad"><p>Localidad</p></label>
		  <input type="text" name="localidad" id="localidad" size="30"/>
      </div>
      <div></div>
  </div>
      <div class="botontrescol">
          <button class="boton_envia" type="submit" input="submit" name="busqueda" value="Buscar"><p>Buscar</p></button>
          <button class="boton_borra" type="reset" value="Borrar"><img src="/demo/img/basura.svg"/></button>
      </div>
  </form>
<?php } ?>
  </div>
</section>
</div>
