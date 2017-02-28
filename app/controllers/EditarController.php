<?php

class EditarController extends \HXPHP\System\Controller{

  public function __construct($configs){
      parent::__construct($configs);

      $this->load('Services\Auth',
          $configs->auth->after_login,
          $configs->auth->after_logout,
          true
      );
      $this->view->setTitle('SIGMA - Editar');
      
      $this->auth->redirectCheck(false);
      $this->view->setVars([
          'users' => User::all($this->auth->getUserId())
      ]);



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
    $this->view->setFile('perfil');
  }
  public function senhaAction(){
    $this->view->setFile('senha');

    $post =$this->request->post();

    $array = array(
       'user_id' => $this->auth->getUserId()
     );

    if(!empty($post =$this->request->post())){

      $post = array_merge($post, $array);
      $upSenha = User::redefinirPass($post);

      if($upSenha->status === false){
        $this->load('Modules\Messages', 'auth');
        $this->messages->setBlock('alerts');
        $errors = $this->messages->getByCode($upSenha->code);

        $this->load('Helpers\Alert', $errors);
      }else{
        $this->load('Helpers\Alert', array(
            'success',
            'Atualização realizada com sucesso!<br><h6>Por favor, saia do SIGMA e entre novamente, para que as atualizações entrem em vigor.</h6>'
        ));
      }
    }

  }

  public function perfilAction(){

      $this->view->setFile('perfil');

      $this->request->setCustomFilters(array(
        'email' => FILTER_VALIDATE_EMAIL
      ));
      $post = $this->request->post();

      $array = array(
         'user_id' => $this->auth->getUserId()
       );

          if(!empty($post) && !empty($post['sex'])){
              $post = array_merge($post, $array);
              $editarPerfil = User::editarPerfil($post);

             if($editarPerfil->status === false){
                $this->load('Helpers\Alert', array(
                  'danger',
                  'Por favor, corrija os erros encontrados para efetuar a atualização!',
                  $editarPerfil->errors
                ));
              }else{
                $this->load('Helpers\Alert', array(
                    'success',
                    'Atualização realizada com sucesso!<br><h6>Por favor, saia do SIGMA e entre novamente, para que as atualizações entrem em vigor.</h6>',
                    $editarPerfil->errors
                ));
              }
          }

    }
}
