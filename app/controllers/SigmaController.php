<?php

class SigmaController extends \HXPHP\System\Controller{

  public function __construct($configs){
    parent::__construct($configs);

    $this->load('Services\Auth',
        $configs->auth->after_login,
        $configs->auth->after_logout,
        true
    );
    $this->view->setTitle('SIGMA - Gerenciamento');
    $this->auth->redirectCheck(false);
    $this->view->setFile('listar');


    $check = $this->checkNivel($this->auth->getUserId());

    if($check === true){
      $this->view->setHeader('header_admin');
    }else{
      $this->view->setHeader('header_aluno');
    }


  }
  /*
  * function para verificar o nivel de acesso do usuario
  * caso seja admim  return true caso não return false
  */
  public function checkNivel($user_id){
    $role_id = User::find($this->auth->getUserId());

      if(!empty($role_id->role_id)){
        if($role_id->role_id != 3){
            return true;
        }else{
            return false;
        }
      }

  }
  public function listarAtividadeAction($user_id = null){

    $check = $this->checkNivel($this->auth->getUserId());

    if($check === true){
      $this->view->setTitle('SIGMA - Atividades');
      $this->view->setFile('listarAtividades');
      $this->view->setVars([
          'activity' => Activity::all()
      ]);
    }

  }
  public function listarUsuariosAction($user_id = null){
    $check = $this->checkNivel($this->auth->getUserId());

    if($check === true){
      $this->view->setTitle('SIGMA - Usuários');
      $this->view->setFile('listar');
      $this->view->setVars([
          'users' => User::all()
      ]);
    }
  }
  public function bloquearAction($user_id = null){
    $check = $this->checkNivel($this->auth->getUserId());

    if($check === true){
  		if (is_numeric($user_id)) {
  			$user = User::find_by_id($user_id);
  			if (!is_null($user)) {
  				$user->status = 0;
  				$user->save(false);
  				$this->view->setVar('users', User::all());
  			}
  		}
    }
	}
	public function desbloquearAction($user_id = null){
    $check = $this->checkNivel($this->auth->getUserId());

    if($check === true){
      if (is_numeric($user_id)) {
  			$user = User::find_by_id($user_id);
  			if (!is_null($user)) {
  				$user->status = 1;
  				$user->save(false);
  				$this->view->setVar('users', User::all());
  			}
  		}
    }
	}
  public function bloquearAtividadeAction($activity_id = null){
    $check = $this->checkNivel($this->auth->getUserId());

    if($check === true){
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
	}
	public function desbloquearAtividadeAction($activity_id = null){
    $check = $this->checkNivel($this->auth->getUserId());

    if($check === true){
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
	}
	public function excluirAction($user_id = null){
    $check = $this->checkNivel($this->auth->getUserId());

    if($check === true){
      if (is_numeric($user_id)) {
  			$user = User::find_by_id($user_id);
  			if (!is_null($user)) {
  				$user->delete();
  				$this->view->setVar('users', User::all());
  			}
  		}
    }
  }

  public function RDAtividadeAction(){
    $check = $this->checkNivel($this->auth->getUserId());

    if($check === true){
      $this->view->setFile('RDAtividade');

      $this->view->setVars([
          'activity' => Activity::all()
      ]);
    }
  }

  public function visualizarAtividade($user_id = null){
    echo 'cu';
  }

  public function RDAlunoAction(){
    $check = $this->checkNivel($this->auth->getUserId());

    if($check === true){
      $this->view->setFile('RDAluno');

      $this->view->setVars([
          'users' => User::all()
      ]);
    }
  }
  public function visualizarAluno($user_id = null){
    echo 'cu';
  }
  public function listarTurmaAction(){
    $this->view->setVars([
      'room' => Room::all()
    ]);
    $this->view->setFile('listarTurma');

  }

  public function bloquearTurmaAction($room_id = null){
    $check = $this->checkNivel($this->auth->getUserId());

    if($check === true){
      if (is_numeric($room_id)) {
        $room = Room::find_by_id($room_id);
        if (!is_null($room)) {
          $room->status = 0;
          $room->save(false);
          $this->view->setVar('room', Room::all());
          $this->view->setFile('listarTurma');
        }
      }
    }
  }
  public function desbloquearTurmaAction($room_id = null){
    $check = $this->checkNivel($this->auth->getUserId());

    if($check === true){
      if (is_numeric($room_id)) {
        $room = Room::find_by_id($room_id);
        if (!is_null($room)) {
          $room->status = 1;
          $room->save(false);
          $this->view->setVar('room', Room::all());
          $this->view->setFile('listarTurma');
        }
      }
    }
  }
  public function visualizarRDAtividadeAction($activity_id = null){
    $post = $this->request->post();
    $this->view->setHeader('header_sigma');
    $this->view->setFile('visualizarRDAtividade');

    $this->view->setVars([
      'tipo' => $post
    ]);
    
  }

}
