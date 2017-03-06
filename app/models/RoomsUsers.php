<?php

class RoomsUsers extends \HXPHP\System\Model{

  static $validates_presence_of = array(
       array(
             'room_id',
             'message' => 'O campo <b>Turma</b> é um campo obrigatório!'
       )
  );

  public static function registrarRoomUsers(array $registro){

    $callbackObj = new \stdClass;
    $callbackObj->user = null;
    $callbackObj->status = false;
    $callbackObj->errors = array();


    $user_id = User::find_by_registration($registro['registration'])->id;

    $post = [
      'room_id' => (int)$registro['room_id'],
      'user_id' => $user_id
    ];

    $cadastrar =  self::create($post);

    if($cadastrar->is_valid()){
        $callbackObj->user = $cadastrar;
        $callbackObj->status = true;

        return $callbackObj;

    }

    $errors = $cadastrar->errors->get_raw_errors();

    foreach ($errors as $fild => $message) {
        array_push($callbackObj->errors, $message[0]);
    }

    return $callbackObj;
  }
}
