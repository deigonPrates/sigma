<?php

class User  extends \HXPHP\System\Model{

     static $validates_presence_of = array(
          array(
                'role_id',
                'message' => 'O campo <b>Usuário</b> é um campo obrigatório!'
          ),
          array(
              'registration',
              'message' => 'O campo <b>Matricula</b> é um campo obrigatório!'
          ),
          array(
              'name',
              'message' => 'O campo <b>Nome</b> é um campo obrigatório!'
          ),
          array(
              'username',
              'message' => 'O campo <b>Username</b> é um campo obrigatório!'
          ),
          array(
              'birth',
              'message' => 'O campo <b>Nascimento</b> é um campo obrigatório!'
          ),
          array(
              'sex',
              'message' => 'O campo <b>Sexo</b> é um campo obrigatório!'
          ),
          array(
              'address',
              'message' => 'O campo <b>Endereço</b> é um campo obrigatório!'
          ),
          array(
              'password',
              'message' => 'A <b>Senha</b> é um campo obrigatório!'
          )
     );
     static $validates_uniqueness_of = array(
       array(
          array('email'),
          'message' => 'Já existe um usuário cadastrado com esse email!'
     ),
     array(
        array('registration'),
        'message' => 'Já existe um usuário cadastrado com essa Matricula!'
      )
   );
  public static function cadastrar(array $post){

      $callbackObj = new \stdClass;
      $callbackObj->user = null;
      $callbackObj->status = false;
      $callbackObj->errors = array();

      $password = \HXPHP\System\Tools::hashHX($post['registration']);

      $post = array_merge($post, $password, array(
        'status' => 1
      ));

      $cadastrar = self::create($post);

      if($cadastrar->is_valid()){
          $callbackObj->user = $cadastrar;
          $callbackObj->status = true;

          return $callbackObj;
      }

      $errors = $cadastrar->errors->get_raw_errors();

      foreach ($errors as $fild => $message) {
          array_push($callbackObj->errors, $message[0]);
      }

      return $callbackObj;
  }

  /**
   * @name $Atualiza a senha
   * @param type $id utilizado para identificar qual a senha a ser atualizada
   *
   */

  public static function login(array $post){

    $callbackObj = new \stdClass();
    $callbackObj->user = null;
    $callbackObj->status = FALSE;
    $callbackObj->code= null;
    $callbackObj->tentativas_restantes= null;


     $user = self::find_by_registration($post['registration']);

     if(!is_null($user)){
        if($user->status === 1){
                $password = \HXPHP\System\Tools::hashHX($post['password'], $user->salt);
                if(LoginAttempt::checarTetnativas($user->id)){
                    if($password['password'] === $user->password){
                        $callbackObj->user = $user;
                        $callbackObj->status = true;
                        LoginAttempt::limparTentativas($user->id);
                    }else{
                      if(LoginAttempt::tentativasRestantes($user->id) <= 5){
                        $callbackObj->code = 'tentativas-esgotando';
                        $callbackObj->tentativas_restantes = LoginAttempt::tentativasRestantes($user->id);
                      }else{
                        $callbackObj->code = 'dados-incorretos';
                      }
                      LoginAttempt::redistrarTentativas($user->id);
                    }
                }else{
                    $callbackObj->code = 'usuario-bloqueado';
                    $user->status = 0;
                    $user->save(false);
                }
          }else{
              $callbackObj->code = 'usuario-bloqueado';
          }
      }else{
          $callbackObj->code = 'usuario-inexistente';
      }
      return $callbackObj;
  }

}
