<?php

class SigmaController extends \HXPHP\System\Controller{

  public function __construct($configs){
    parent::__construct($configs);

    $this->load('Services\Auth',
        $configs->auth->after_login,
        $configs->auth->after_logout,
        true
    );

    $this->auth->redirectCheck(false);
      $this->view->setFile('listar');

  }
  public function listarAction($user_id = null){
    $this->view->setFile('listar');
    $this->view->setVars([
        'users' => User::all()
    ]);
  }
  public function bloquearAction($user_id = null){
		if (is_numeric($user_id)) {
			$user = User::find_by_id($user_id);
			if (!is_null($user)) {
				$user->status = 0;
				$user->save(false);
				$this->view->setVar('users', User::all());
			}
		}
	}
	public function desbloquearAction($user_id = null){
		if (is_numeric($user_id)) {
			$user = User::find_by_id($user_id);
			if (!is_null($user)) {
				$user->status = 1;
				$user->save(false);
				$this->view->setVar('users', User::all());
			}
		}
	}
	public function excluirAction($user_id = null){
		if (is_numeric($user_id)) {
			$user = User::find_by_id($user_id);
			if (!is_null($user)) {
				$user->delete();
				$this->view->setVar('users', User::all());
			}
		}

  }

}
