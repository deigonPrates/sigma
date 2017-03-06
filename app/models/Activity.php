<?php


class Activity extends \HXPHP\System\Model{

  static $has_one = array(
       array('room')
  );


  static $validates_presence_of = array(
       array(
             'subject',
             'message' => 'O campo <b>Assunto</b> é um campo obrigatório!'
       ),
       array(
           'value',
           'message' => 'O campo <b>Valor</b> é um campo obrigatório!'
       ),
       array(
           'date',
           'message' => 'O campo <b>Data</b> é um campo obrigatório!'
       ),
       array(
           'room_id',
           'message' => 'O campo <b>Turma</b> é um campo obrigatório!'
       )
  );


  public static function cadastrarAtividade(array $post){
    $callbackObj = new \stdClass;
    $callbackObj->user = null;
    $callbackObj->status = false;
    $callbackObj->errors = array();

    $cadastrarAtividade = self::create($post);

    if($cadastrarAtividade->is_valid()){
        $callbackObj->user = $cadastrarAtividade;
        $callbackObj->status = true;

        return $callbackObj;

    }

    $errors = $cadastrarAtividade->errors->get_raw_errors();

    foreach ($errors as $fild => $message) {
        array_push($callbackObj->errors, $message[0]);
    }

    return $callbackObj;
  }
}
