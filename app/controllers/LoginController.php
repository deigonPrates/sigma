<?php

class LoginController extends \HXPHP\System\Controller{

  public function __construct($configs){
    parent::__construct($configs);

    $this->load('Services\Auth',
      $configs->auth->after_login,
      $configs->auth->after_logout,
      true
    );

    $this->view->setTitle('SIGMA - login');
  }

  public function indexAction(){
      $this->auth->redirectCheck(true);
  }

  public function logarAction(){

    $this->auth->redirectCheck(true);
    $this->view->setFile('index');

    $post = $this->request->post();

    if(!empty($post)){
        $login = User::login($post);
        if($login->status === TRUE){
            $this->auth->login($login->user->id, $login->user->username);
        }else{
            $this->load('Modules\Messages', 'auth');
            $this->messages->setBlock('alerts');
            $errors = $this->messages->getByCode($login->code, array(
              'message' => $login->tentativas_restantes
            ));

            $this->load('Helpers\Alert', $errors);
        }
    }

  }

  public function sairAction(){
      return  $this->auth->logout();
  }

}
