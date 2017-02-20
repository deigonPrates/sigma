<?php

header("HTTP/1.0 404 Not Found");

class Error404Controller extends \HXPHP\System\Controller
{
	public function __construct($configs){
			parent::__construct($configs);

			$this->load('Services\Auth',
					$configs->auth->after_login,
					$configs->auth->after_logout,
					true
			);

			$this->auth->redirectCheck(true);
	}

	public function indexAction()
	{
		$this->view->setAssets('css', $this->configs->baseURI . 'public/css/error.css');
	}
}
