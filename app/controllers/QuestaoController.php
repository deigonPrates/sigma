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
      'activity' => Activity::all(),
      'question' => Question::All()
    ]);
    $post = $this->request->post();

    if(!empty($post)){
      $this->view->setFile('avaliacao');
    }

  }


}
