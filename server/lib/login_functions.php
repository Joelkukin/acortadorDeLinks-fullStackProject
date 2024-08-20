<?php
// login Functions
function check_user_loged(){
  if(session_id() !== null){
    return true;
  }else{
    header(401);
    echo json_encode([
      'status' => false,
      'error' => 'debe iniciar sesion para acceder a esta seccion'
    ]);
    return false;
  }
}

function close_user_session(){
  if(session_id()){
    session_destroy();
  }
  echo json_encode([
    "status" => true,
    "message" => 'user session closed',
  ]);
  return true;
}

?>