<?php

class LoginAttempt extends \HXPHP\System\Model
{
    public static function redistrarTentativas($user_id){
          self::create(array(
              'user_id' => $user_id
          ));
    }
    public static function limparTentativas($user_id){
          self::delete_all(array(
            'conditions' => array(
              'user_id = ?',
              $user_id
            )
          ));
    }
    public static function totalTentativas($user_id){
          return count(self::find_all_by_user_id($user_id));
    }
    public static function tentativasRestantes($user_id){
          return intval(10-self::totalTentativas($user_id));
    }
    public static function checarTetnativas($user_id){
          return self::totalTentativas($user_id) < 10 ? TRUE : false;
    }
}
