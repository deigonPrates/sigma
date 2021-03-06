<?php
	//Constantes
	$configs = new HXPHP\System\Configs\Config;

	$configs->env->add('development');

  $configs->env->development->baseURI= '/sigma/';

  $configs->env->development->database->setConnectionData([
    'host' => 'localhost',
    'user' => 'root',
    'password' => '',
    'dbname' => 'emcac'
  ]);

	$configs->env->development->auth->setURLs('/sigma/home/', '/sigma/login/');


	$configs->env->add('production');

  $configs->env->production->baseURI= '/';

  $configs->env->production->database->setConnectionData([
    'host' => 'mysql.hostinger.com.br',
    'user' => 'u678426544_root',
    'password' => '$|O@1g#BR/m&9hy&Z&',
    'dbname' => 'u678426544_sigma'
  ]);

	$configs->env->production->auth->setURLs('/home/', '/login/');

	/*
		//Globais
		$configs->title = 'Titulo customizado';

		//Configurações de Ambiente - Desenvolvimento
		$configs->env->add('development');

		$configs->env->development->baseURI = '/hxphp/';

		$configs->env->development->database->setConnectionData([
			'driver' => 'mysql',
			'host' => 'localhost',
			'user' => 'root',
			'password' => '',
			'dbname' => 'hxphp',
			'charset' => 'utf8'
		]);

		$configs->env->development->mail->setFrom([
			'from' => 'Remetente',
			'from_mail' => 'email@remetente.com.br'
		]);

		$configs->env->development->menu->setConfigs([
			'container' => 'nav',
			'container_class' => 'navbar navbar-default',
			'menu_class' => 'nav navbar-nav'
		]);

		$configs->env->development->menu->setMenus([
			'Home/home' => '%siteURL%',
			'Subpasta/folder-open' => [
				'Home/home' => '%baseURI%/admin/have-fun/',
				'Teste/home' => '%baseURI%/admin/index/',
			]
		]);

		$configs->env->development->auth->setURLs('/hxphp/home/', '/hxphp/login/');
		$configs->env->development->auth->setURLs('/hxphp/admin/home/', '/hxphp/admin/login/', 'admin');

		//Configurações de Ambiente - Produção
		$configs->env->add('production');

		$configs->env->production->baseURI = '/';

		$configs->env->production->database->setConnectionData([
			'driver' => 'mysql',
			'host' => 'localhost',
			'user' => 'usuariodobanco',
			'password' => 'senhadobanco',
			'dbname' => 'hxphp',
			'charset' => 'utf8'
		]);

		$configs->env->production->mail->setFrom([
			'from' => 'Remetente',
			'from_mail' => 'email@remetente.com.br'
		]);
	*/


	return $configs;
