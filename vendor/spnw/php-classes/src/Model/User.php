<?php

namespace SPNW\Model;
use \SPNW\DB\Sql;
use \SPNW\Model;

class User extends Model{

	const SESSION = "User";

	public static function login($login, $password){

		$sql = new Sql();
		$results = $sql->select("SELECT * FROM tb_users WHERE deslogin = :login", array(
			":login"=>$login
		));

		if(count($results) === 0){
			throw new \Exception("Usuário inexistente ou senha inválida.", 154); # \Exception --> classe Exception global
			
		}

		$firstRecord = $results[0];

		if(password_verify($password, $firstRecord["despassword"]) === true){

			$user = new User();			
			$user->setData($firstRecord);
			$_SESSION[User::SESSION] = $user->getValues();
			return $user;

		}else{
			throw new \Exception("Usuário inexistente ou senha inválida.", 154); # \Exception --> classe Exception global			
		}

	}

	public static function verifyLogin($inAdmin = true){		

		if( !isset($_SESSION[User::SESSION]) #redireciona para login se a sessão não estiver setada, vazia ou se o id não for válido 
			|| !$_SESSION[User::SESSION]
			|| !(int)$_SESSION[User::SESSION]["iduser"] > 0
			|| (bool)$_SESSION[User::SESSION]["inadmin"] !== $inAdmin
		) {		
			
			header("Location: /admin/login");
			exit;
		}
	}

	public static function logout(){
		$_SESSION[User::SESSION] = NULL;
	}
}

?>