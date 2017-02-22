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
  public function indexAction(){
    $this->view->setFile('perfil');
  }
  public function perfilAction(){
    $this->view->setFile('perfil');
  }

  public function senhaAction(){
        //validação da senha antiga
        $matricula = $this->request->post('registration');
        $senha_nova = $this->request->post('new_pass');
        $update = User::updatePassword($senha_nova, $matricua);
  }

}
