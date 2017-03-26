<?php

class CadastroController extends \HXPHP\System\Controller{

  public function __construct($configs){
    parent::__construct($configs);

    $this->load('Services\Auth',
        $configs->auth->after_login,
        $configs->auth->after_logout,
        true
    );

   $this->load('Storage\Session');

    $this->view->setTitle('SIGMA - Cadastro');
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
    $this->view->setFile('usuario');
  }
  public function cadastrarAction(){

      $this->view->setFile('usuario');

      $this->request->setCustomFilters(array(
        'email' => FILTER_VALIDATE_EMAIL
      ));

      $cadastrarUsuario = User::cadastrar($this->request->post());

      if($cadastrarUsuario->status === false){
        $this->load('Helpers\Alert', array(
          'danger',
          'Por favor, corrija os erros encontrados para efetuar o cadastro!',
          $cadastrarUsuario->errors
        ));
      }else{
        $this->load('Helpers\Alert', array(
            'success',
            'Cadastro efetuado com sucesso!',
            $cadastrarUsuario->errors
        ));
      }

  }
  public function turmaAction(){

    $this->view->setFile('turma');

    $post = $this->request->post();

    $this->view->setVars([
      'users' => User::all()
    ]);


    if(!empty($post)){

    $post = array_merge($post,[
      'status'=> 1
    ]);
    $cadastroTurma = Room::cadastrarTurma($post);

    if($cadastroTurma->status === false){
      $this->load('Helpers\Alert', array(
        'danger',
        'Por favor, corrija os erros encontrados para efetuar o cadastro!',
        $cadastroTurma->errors
      ));
    }else{
      $this->load('Helpers\Alert', array(
          'success',
          'Cadastro efetuado com sucesso!',
          $cadastroTurma->errors
      ));
    }
  }

  }

  public function atividadeAction(){
    $this->view->setFile('atividade');

    $post = $this->request->post();

    $this->view->setVars([
        'room' => Room::all()
    ]);
    $this->view->setVars([
      'activity' => Activity::all(),
      'contador' => 1
    ]);
    if(!empty($post)){
      $cadastroAtividade = Activity::cadastrarAtividade($post);

      if($cadastroAtividade->status === false){
        $this->load('Helpers\Alert', array(
          'danger',
          'Por favor, corrija os erros encontrados para efetuar o cadastro!',
          $cadastroAtividade->errors
        ));
      }else{
        $activity_id = Activity::last();
        $activity_id = $activity_id->id;
        $this->session->set('activity_id', $activity_id);
        $this->view->setFile('questao');
      }
    }
  }

  public function questaoAction(){

    $this->view->setFile('questao');

    $contador = (!empty($this->request->post('number'))) ? $this->request->post('number') : 0;

    $contador += 1;

    $this->view->setVars([
      'activity' => Activity::All(),
      'contador' => $contador
    ]);

    $post = $this->request->post();

    if(!empty($post)){

      $post = array_merge($post, array(
          'activity_id' => $this->session->get('activity_id')
      ));

      $cadastrarQuestao = Question::cadastrarQuestao($post);

      if($cadastrarQuestao->status === false){
        $this->load('Helpers\Alert', array(
          'danger',
          'Por favor, corrija os erros encontrados para efetuar o cadastro!',
          $cadastrarQuestao->errors
        ));
      }else{
        $this->load('Helpers\Alert', array(
            'success',
            'Questão cadastrada com sucesso. Após cadastrar <strong>TODAS</strong> as questões desejadas clique em <strong>finalizar</strong>. '
        ));;
      }
    }
  }
  public function AlunoTurmaAction(){
    $this->view->setFile('alunoTurma');
    $this->view->setVars([
      'room' => Room::all()
    ]);


    $post = $this->request->post();

    if(!empty($post)){
      $cadastrar = RoomsUsers::registrarRoomUsers($post);

        if($cadastrar->status === false){
          $this->load('Helpers\Alert', array(
            'danger',
            'Por favor, corrija os erros encontrados para efetuar o registro!',
            $cadastrar->errors
          ));
        }else{
          $this->load('Helpers\Alert', array(
              'success',
              'Aluno matriculado na turma com sucesso!'
          ));;
        }
    }
  }


}
