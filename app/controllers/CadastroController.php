<?php

class CadastroController extends \HXPHP\System\Controller{

  public function __construct($configs){
    parent::__construct($configs);

    $this->load('Services\Auth',
        $configs->auth->after_login,
        $configs->auth->after_logout,
        true
    );

    $this->auth->redirectCheck(true);
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
  }

  public function atividadeAction(){
    $this->view->setFile('atividade');
  }

  public function questaoAction(){
    $this->view->setFile('questao');
  }


}
