<?php

    define( 'SHORTINIT', true );
    require_once( $_SERVER['DOCUMENT_ROOT'] . '/demo/wp-load.php' );
  
  $file_id = $_POST['file_id'];
  $user_id = $_POST['user_id'];
  global $wpdb;
  $history_table_name = $wpdb->prefix . 'cu_history';

  $timestamp = getdate();
  $datetimeFormat = 'Y-m-d H:i:s';

  $date = new \DateTime('now');
  // If you must have use time zones
  // $date = new \DateTime('now', new \DateTimeZone('Europe/Helsinki'));
  $date->setTimestamp($timestamp);
  $date_now = $date->format($datetimeFormat);
  $consulta = ("INSERT INTO $history_table_name (file_id, user_id, date) VALUES( '$file_id', '$user_id', '$date_now' )");
  //echo $consulta;
  $resultado = $wpdb->query($consulta);

 ?>

