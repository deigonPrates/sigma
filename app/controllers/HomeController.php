<?php

class HomeController extends \HXPHP\System\Controller{

  public function __construct($configs){
    parent::__construct($configs);

    $this->load('Services\Auth',
        $configs->auth->after_login,
        $configs->auth->after_logout,
        true
    );

    $this->auth->redirectCheck(false);

    $role_id = User::find_by_role_id($this->auth->getUserId())->role_id;

    if(!empty($role_id)){
      if($role_id != 3){
        $this->view->setHeader('header_admin');
      }else{
        $this->view->setHeader('header_aluno');
      }
    }
  }
}
