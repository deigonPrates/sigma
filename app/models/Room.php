<?php

class Room extends \HXPHP\System\Model
{
  static $validates_presence_of = array(
    array(
          'name',
          'message' => 'O campo <b>Nome</b> é um campo obrigatório!'
    ),array(
          'year',
          'message' => 'O campo <b>Ano</b> é um campo obrigatório!'
    ),array(
          'teacher',
          'message' => 'O campo <b>Professor</b> é um campo obrigatório!'
    )
  );

  public static function cadastrarTurma(array $post){
    $callbackObj = new \stdClass;
    $callbackObj->user = null;
    $callbackObj->status = false;
    $callbackObj->errors = array();
    $cadastrarTurma = self::create($post);

    if($cadastrarTurma->is_valid()){
        $callbackObj->user = $cadastrarTurma;
        $callbackObj->status = true;

        return $callbackObj;

    }

    $errors = $cadastrarTurma->errors->get_raw_errors();

    foreach ($errors as $fild => $message) {
        array_push($callbackObj->errors, $message[0]);
    }

    return $callbackObj;

  }

}
