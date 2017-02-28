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
                      $date = date("d:m:Y ").' as '.date("G:i:s");
                      $dados = array_merge([
                        'user_id' => $user->id,
                        'date' => $date
                      ]);
                      LoginAttempt::redistrarTentativas($dados);
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

  public static function redefinirPass(array $post){

    $callbackObj = new \stdClass();
    $callbackObj->user = null;
    $callbackObj->status = FALSE;
    $callbackObj->code= null;

    $oldpass = $post['oldpass'];
    $newpass = $post['newpass'];
    $checkpass = $post['checkpass'];

    $user = self::find($post['user_id']);

    $password = \HXPHP\System\Tools::hashHX($oldpass, $user->salt);

    if($password['password'] === $user->password){

      if($newpass === $checkpass){
        $up = \HXPHP\System\Tools::hashHX($newpass);
        $callbackObj->user = $user->id;
        $callbackObj->status = true;

        $user->update_attributes(array(
          'password' => $up['password'],
          'salt' => $up['salt']
        ));

      }else{
        $callbackObj->code = 'senha-invalida';
      }

    }else{
      $callbackObj->code = 'senha-incorreta';
    }

    return $callbackObj;

  }

  public static function editarPerfil(array $post){

    $callbackObj = new \stdClass;
    $callbackObj->user = null;
    $callbackObj->status = false;
    $callbackObj->errors = array();

    $user = self::find($post['user_id']);

    $user->update_attributes(array(
      'registration' => $post['registration'],
      'name' => $post['name'],
      'username' => $post['username'],
      'birth' => $post['birth'],
      'sex' => $post['sex'],
      'phone' => $post['phone'],
      'address' => $post['address'],
      'email' => $post['email']
    ));

    if($user->is_valid()){
        $callbackObj->user = $user;
        $callbackObj->status = true;

        return $callbackObj;
    }

    $errors = $user->errors->get_raw_errors();

    foreach ($errors as $fild => $message) {
        array_push($callbackObj->errors, $message[0]);
    }

    return $callbackObj;
  }

  public static function recuperarSenha(array $post){
    $callbackObj = new \stdClass();
    $callbackObj->user = null;
    $callbackObj->status = FALSE;
    $callbackObj->code= null;

    $user = self::find_by_registration($post);

    if(!empty($user)){

    $password = \HXPHP\System\Tools::hashHX($post['registration']);

    $callbackObj->user = $user->id;
    $callbackObj->status = true;

    $user->update_attributes(array(
      'password' => $password['password'],
      'salt' => $password['salt']
    ));
  }else{
    $callbackObj->code = 'matricula-invalida';
  }

    return $callbackObj;

  }
}
