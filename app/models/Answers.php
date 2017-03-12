<?php

class Answers extends \HXPHP\System\Model{

  static $validates_presence_of = array(
       array(
             'alternative',
             'message' => 'Escolha um das alternativas!'
       )
   );
   static $validates_uniqueness_of = array(
     array(
        array('question_id', 'user_id'),
        'message' => 'Já existe uma resposta salva em nossa base de dados para essa pergunta!'
   ));
  public static function salvarResposta(array $post){
      $callbackObj = new \stdClass;
      $callbackObj->user = null;
      $callbackObj->status = false;
      $callbackObj->errors = array();

      $salvar = self::create($post);

      if($salvar->is_valid()){
          $callbackObj->user = $salvar;
          $callbackObj->status = true;

          return $callbackObj;

      }

      $errors = $salvar->errors->get_raw_errors();

      foreach ($errors as $fild => $message) {
          array_push($callbackObj->errors, $message[0]);
      }

      return $callbackObj;

  }


}
