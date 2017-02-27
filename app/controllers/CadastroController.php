<?php

class CadastroController extends \HXPHP\System\Controller{

  public function __construct($configs){
    parent::__construct($configs);

    $this->load('Services\Auth',
        $configs->auth->after_login,
        $configs->auth->after_logout,
        true
    );

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
    if(!empty($post)){
      $cadastroAtividade = Activity::cadastrarAtividade($post);

      if($cadastroAtividade->status === false){
        $this->load('Helpers\Alert', array(
          'danger',
          'Por favor, corrija os erros encontrados para efetuar o cadastro!',
          $cadastroAtividade->errors
        ));
      }else{
        $this->load('Helpers\Alert', array(
            'success',
            'Atividade cadastrada com sucesso. <a href="questao" class="btn btn-danger">Clique aqui</a> para adicionar as questões da atividade'
        ));;
      }
    }
  }

  public function questaoAction(){
    $this->view->setFile('questao');

    $this->view->setVars([
      'activity' => Activity::All()
    ]);

    $post = $this->request->post();

    if(!empty($post)){
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
            'Atividade cadastrada com sucesso.'
        ));;
      }
    }
  }


}
