<?php

class HomeController extends \HXPHP\System\Controller{

  public function __construct($configs){
    parent::__construct($configs);

    $this->load('Services\Auth',
        $configs->auth->after_login,
        $configs->auth->after_logout,
        true
    );

    $this->view->setTitle('SIGMA - Inicio');
    $this->auth->redirectCheck(false);

    $role_id = User::find($this->auth->getUserId());
    $this->view->setVars([
      'user' => User::find($this->auth->getUserId())
    ]);

      if(!empty($role_id->role_id)){
        if($role_id->role_id != 3){
          $this->view->setHeader('header_admin');
        }else{
          $this->view->setHeader('header_aluno');
        }
    }
  }
}
