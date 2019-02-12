<?php

namespace SPNW;

class Model{

	private $values = [];

	public function __call($name, $args){

		$method = substr($name, 0, 3);		#3 primeiras letras da chamada, pode ser get ou set
		$fieldName = substr($name, 3, strlen($name));	# nome do campo a ser settado ou gettado		
		
		switch ($method) {
			case "get":
					return $this->values[$fieldName];
				break;

			case "set":
					$this->values[$fieldName] = $args[0];
				break;
			
			default:
				
				break;
		}
		
	}

	public function setData($data = array()){	# este método gera automaticamente todos os setters
												# e getters de acordo com o nome da coluna no banco

		foreach ($data as $key => $value) {	# 
			$this->{"set".$key}($value);	# {"set" . nome da coluna do banco de dados }(valor da coluna do banco de dados)}
											# {} permite criar o nome do método dinamicamente de acordo com o parametro $key
											# assistir https://www.udemy.com/curso-php-7-online/learn/v4/t/lecture/6809908?start=1463 em caso de dúvidas
		}

		/*
		foreach ($data as $key => $value) {
			$this->{"get".$key}($value);
		}*/
	}

	public function getValues(){
		
		return $this->values;	#tomar cuidado pra não chamar $this->values() pq nao vai dar erro mas nao vai funcionar XD;
	}

}

?>