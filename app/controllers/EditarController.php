<?php

class EditarController extends \HXPHP\System\Controller{

  public function __construct($configs){
      parent::__construct($configs);

      $this->load('Services\Auth',
          $configs->auth->after_login,
          $configs->auth->after_logout,
          true
      );

      $this->auth->redirectCheck(false);
  }
  public function perfilAction(){
    $this->view->setFile('perfil');
  }

  public function senhaAction(){
    $this->view->setFile('senha');
  }

}
