<?php
require_once "../lib/db_config";
require_once "../lib/phpqrcode/qrlib.php";

function create_qr_link($url){
  $codesDir = "../assets/codes/";   
  $codeFile = date('d-m-Y-h-i-s').'.png';
  QRcode::png($url, $codesDir.$codeFile, 'L',32,12);
  echo '<img class="img-thumbnail" src="'.$codesDir.$codeFile.'" />';
}

?>