<?php

class IndexController extends \HXPHP\System\Controller
{
    public function __construct($configs){
        parent::__construct($configs);

        $this->load('Services\Auth',
            $configs->auth->after_login,
            $configs->auth->after_logout,
            true
        );

        $this->auth->redirectCheck(true);

        $this->view->setPath('login');
        $this->view->setFile('index');

        $this->view->setTitle('SIGMA - login');
    }

}
