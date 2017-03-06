<?php

class QuestaoController extends \HXPHP\System\Controller{

  public function __construct($configs){
    parent::__construct($configs);

    $this->load('Services\Auth',
        $configs->auth->after_login,
        $configs->auth->after_logout,
        true
    );

    $this->view->setTitle('SIGMA - Questões');
    $this->auth->redirectCheck(false);


        $role_id = User::find($this->auth->getUserId());

          if(!empty($role_id->role_id)){
            if($role_id->role_id != 3){
              $this->view->setHeader('header_admin');
            }else{
              $this->view->setHeader('header_aluno');
            }
        }
  }


  public function indexAction(){
      $this->view->setFile('index');
  }

  public function atividadeAction(){
    $this->view->setFile('index');
    $this->view->setVars([
      'activity' => Activity::all()
    ]);
  }

  public function validacaoAction(){
    $post = $this->request->post();
    if(!empty($post)){
      $this->view->setVars([
        'activity' => $post,
        'question' => Question::All()
      ]);
      $this->view->setFile('avaliacao');
    }else{
      $this->load('Helpers\Alert', array(
          'danger',
          'Nenhuma avaliação definida. Por favor tente novamente!<br>
          <h6>Clique em fazer atividade no menu ao lado e defina uma avaliação....</h6>'
      ));
    }
  }
  public function gravarespostaAvaliacaoAction(){
    $post = $this->request->post();

    $teste = User::teste();


      /*
    $this->view->setFile('avaliacao');
    var_dump($question_id);
    if(!empty($post) && (!is_null($question_id))){
      $post = array_merge($post,[
        'user_id' => $this->auth->getUserId(),
        'question_id' => $question_id
      ]);

      var_dump($post);
      # $respostaAvaliacao = Answers::salvarResposta($post);

      if($respostaAvaliacao->status === false){
        $this->load('Helpers\Alert', array(
          'danger',
          'Por favor, corrija os erros encontrados!',
          $respostaAvaliacao->errors
        ));
      }
    }*/
  }

  public function visualizarAtividadeAction($activity_id = null){
    $this->view->setFile('listarAtividades');
    $this->view->setVars([
      'activity' => Activity::all()
    ]);
  }


}
