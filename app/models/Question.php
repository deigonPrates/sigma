<?php
class Question extends \HXPHP\System\Model{

  static $validates_presence_of = array(
       array(
             'query',
             'message' => 'O campo <b>Pergunta</b> é um campo obrigatório!'
       ),
       array(
           'alternative_a',
           'message' => 'O campo <b>A</b> é um campo obrigatório!'
       ),
       array(
           'alternative_b',
           'message' => 'O campo <b>C</b> é um campo obrigatório!'
       ),
       array(
           'alternative_c',
           'message' => 'O campo <b>C</b> é um campo obrigatório!'
       ),
       array(
           'alternative_d',
           'message' => 'O campo <b>D</b> é um campo obrigatório!'
       ),
       array(
           'alternative_e',
           'message' => 'O campo <b>E</b> é um campo obrigatório!'
       ),
       array(
           'answer',
           'message' => 'O campo <b>Resposta</b> é um campo obrigatório!'
       )
  );

  public static function cadastrarQuestao(array $post){
    $callbackObj = new \stdClass;
    $callbackObj->user = null;
    $callbackObj->status = false;
    $callbackObj->errors = array();

    $cadastrarQuestao = self::create($post);

    if($cadastrarQuestao->is_valid()){
        $callbackObj->user = $cadastrarQuestao;
        $callbackObj->status = true;

        return $callbackObj;

    }

    $errors = $cadastrarQuestao->errors->get_raw_errors();
    foreach ($errors as $fild => $message) {
        array_push($callbackObj->errors, $message[0]);
    }

    return $callbackObj;
  }

}
