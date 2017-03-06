<?php

class Answers extends \HXPHP\System\Model{

  static $validates_presence_of = array(
       array(
             'alternative',
             'message' => 'Escolha um das alternativas!'
       )
   );

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
