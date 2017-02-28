<?php

class RecuperarController extends \HXPHP\System\Controller{


   public function __construct($configs){
     parent::__construct($configs);

     $this->load('Services\Auth',
      $configs->auth->after_login,
      $configs->auth->after_logout,
      true
      );

      $this->view->setTitle('SIGMA - Recuperar');
          $role_id = User::find($this->auth->getUserId());

            if(!empty($role_id->role_id)){
              if($role_id->role_id != 3){
                $this->view->setHeader('header_admin');
              }else{
                $this->view->setHeader('header_aluno');
              }
          }
   }


   public function senhaAction(){

     $this->view->setFile('index');
     $post = $this->request->post();
     if(!empty($post)){
       $redefinir = User::recuperarSenha($post);

       if($redefinir->status === false){
         $this->load('Modules\Messages', 'auth');
         $this->messages->setBlock('alerts');
         $errors = $this->messages->getByCode($redefinir->code);

         $this->load('Helpers\Alert', $errors);
       }else{
         $this->load('Helpers\Alert', array(
             'success',
             'Redefinição realizada com sucesso!'
         ));
       }
     }
   }
}
