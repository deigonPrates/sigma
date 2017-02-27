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


        $role_id = User::find($this->auth->getUserId());

          if(!empty($role_id->role_id)){
            if($role_id->role_id != 3){
              $this->view->setHeader('header_admin');
            }else{
              $this->view->setHeader('header_aluno');
            }
        }

  }
  public function listarAtividadeAction($user_id = null){
    $this->view->setFile('listarAtividades');
    $this->view->setVars([
        'activity' => Activity::all()
    ]);
  }
  public function listarUsuariosAction($user_id = null){
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
  public function bloquearAtividadeAction($activity_id = null){
		if (is_numeric($activity_id)) {
			$activity = Activity::find_by_id($activity_id);
			if (!is_null($activity)) {
				$activity->status = 0;
				$activity->save(false);
				$this->view->setVar('activity', Activity::all());
        $this->view->setFile('listarAtividades');
			}
		}
	}
	public function desbloquearAtividadeAction($activity_id = null){
		if (is_numeric($activity_id)) {
			$activity = Activity::find_by_id($activity_id);
			if (!is_null($activity)) {
				$activity->status = 1;
				$activity->save(false);
				$this->view->setVar('activity', Activity::all());
          $this->view->setFile('listarAtividades');
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
