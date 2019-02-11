<?php
require_once "vendor/autoload.php";

$app = new Slim\Slim();

$app->config('debug', true);

$app->get('/', function(){
	$sql = new SPNW\DB\Sql();	#lembrar de alterar o namespace no arquivo Sql.php
	$results = $sql->select("SELECT * FROM tb_users");
	echo json_encode($results);
});

$app->run();

?>
