<?php

class QuestaoController extends \HXPHP\System\Controller{

  public function __construct($configs){
    parent::__construct($configs);

    $this->load('Storage\Session');
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

  public function definirAtividadeAction(){
    $this->view->setFile('index');
    $this->view->setVars([
      'activity' => Activity::all()
    ]);
  }

  public function responderAvaliacaoAction($contador = null){

    $this->view->setFile('avaliacao');

    if(is_null($contador)){
        $contador= 1;
    }

    $post = $this->request->post();

    if(!empty($post)){
      $this->session->set('activity_id', $post['activity_id']);
      $this->view->setVars([
        'activity' => $post,
        'question' => Question::All(),
        'contador' => $contador
      ]);

    }else{
      $this->load('Helpers\Alert', array(
          'danger',
          'Nenhuma avaliação definida. Por favor tente novamente!<br>
          <h6>Clique em fazer atividade no menu ao lado e defina uma avaliação....</h6>'
      ));
    }
  }
  public function gravaRespostaAvaliacaoAction($contador = null){
    $this->view->setFile('avaliacao');

    $post= $this->request->post();

    $activity = [
      'activity_id' => $this->session->get('activity_id')
    ];

    if(is_null($contador)){
        $contador= 1;
    }else{
      $contador++;
    }

    if(!empty($post)){
      $this->view->setVars([
        'activity' => $activity,
        'question' => Question::All(),
        'contador' => $contador
      ]);

      $alternativa = substr($post['alternative'], 0 , 1);
      $questao_id = substr($post['alternative'],  2);

      $post = [
        'user_id' => $this->auth->getUserId(),
        'question_id' => $questao_id,
        'alternative' => $alternativa
      ];

        $gravacao = Answers::salvarResposta($post);

        if($gravacao->status === false){
          $this->view->setFile('avaliacao');
          $this->load('Helpers\Alert', array(
            'danger',
            'Por favor, corrija os erros encontrados para efetuar o cadastro!',
            $gravacao->errors
          ));
        }
        $this->view->setFile('avaliacao');
    }

  }

  public function visualizarAtividadeAction(){
      $this->view->setFile('listarAtividades');
      $this->view->setVars([
        'activity' => Activity::all()
      ]);

  }
  public function visualizarHistoricoAction(){

    $post = $this->request->post();
    $this->view->setFile('historico');

    $this->view->setVars([
      'tipo' => $post
    ]);
    $activity = Activity::all();
    $question = Question::all();
    $answers = Answers::all();

    $question_id= array();
    $activity_id= array();
    $answers_id= array();
    $question_answer= array();

    foreach ($activity as $key) {
       $activity_id[] = $key->id;
    }
    $cont =  count($activity_id);

    for($i =0 ; $i< $cont; $i++){
      foreach ($question as $key) {
        if($key->activity_id === $activity_id[$i] ){
          $question_answer[$key->id] = $key->answer;
        }
      }
    }

    var_dump($activity_id);
    var_dump($question_answer);
    var_dump($answers);
  }

  public function destruirSessionAction(){
    $this->session->clear('activity_id');

    $this->view->setPath('home');
    $this->view->setFile('index');
  }


}
