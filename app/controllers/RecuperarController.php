<?php

class RecuperarController extends \HXPHP\System\Controller{


   public function __construct($configs){
     parent::__construct($configs);

     $this->load('Services\Auth',
      $configs->auth->after_login,
      $configs->auth->after_logout,
      true
      );


          $role_id = User::find($this->auth->getUserId());

            if(!empty($role_id->role_id)){
              if($role_id->role_id != 3){
                $this->view->setHeader('header_admin');
              }else{
                $this->view->setHeader('header_aluno');
              }
          }
   }
}
