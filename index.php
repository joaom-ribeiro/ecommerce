<?php
session_start();
require_once "vendor/autoload.php";

use SPNW\Page;
use SPNW\PageAdmin;
use SPWN\Model\User;

$app = new Slim\Slim();

$app->config('debug', true);

$app->get('/', function(){	
	$page = new Page();
	$page->setTpl("index");	
});

$app->get('/admin/', function(){	
	\SPNW\Model\User::verifyLogin();	#verifica se o usuario esta logado, gera uma exception caso ocorra algum problema	
	$page = new PageAdmin();
	$page->setTpl("index");
});

$app->get('/admin/login/', function(){	
	$page = new PageAdmin([
		"header"=>false,	#desabilitando header e footer
		"footer"=>false 	
	]);
	$page->setTpl("login");
});

$app->get('/admin/logout', function(){
	\SPNW\Model\User::logout();
	header("Location: /admin/login");
	exit;
});

$app->post('/admin/login/', function(){	
	\SPNW\Model\User::login($_POST["login"], $_POST["password"]);
	header("Location: /admin/");
	exit;
});

$app->run();

?>
