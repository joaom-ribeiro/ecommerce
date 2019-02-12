<?php

namespace SPNW;
use Rain\Tpl;

class Page {

	private $tpl;
	private $pageVars = [];	#variáveis da página
	private $defaults = [	#argumentos padrão
		"header"=>true,
		"footer"=>true,
		"data"=>[]
	];

	public function __construct($opts = array(), $tpl_dir = "/views/"){	#padrão eh /views/

		$this->pageVars = array_merge($this->defaults, $opts);	#se $opts for definido, sobreescreve o default
																#se nada for passado como parametros, assume header e footer como true
																#caso contrario, header e footer assume o comportamento passado por parametros		

		$config = array(
			# $_SERVER['DOCUMENT_ROOT'] = C:/wamp64/www/ecommerce
			"tpl_dir"=>		$_SERVER['DOCUMENT_ROOT'] . $tpl_dir,
			"cache_dir"=>	$_SERVER['DOCUMENT_ROOT'] . "/views-cache/",
			"debug"		=> true
		);


		Tpl::configure($config);

		$this->tpl = new Tpl;

		$this->setPageVars($this->pageVars["data"]);		

		if($this->pageVars["header"] === true){			
			$this->tpl->draw("header");
		}
		
	}

	private function setPageVars($data = array()){
		foreach ($this->pageVars["data"] as $key => $value) {	#percorre o array de variáveis da página, ex: $key = titulo e $value = "Página Principal"
			$this->tpl->assign($key, $value);			
		}
	}

	public function setTpl($name, $data = array(), $returnHtml = false){ # $name = nome do template, ex: index, $data = variáveis da página, 
																		 # $returnHtml = controla o retorno do método draw, útil para usar em PHPMailer
		$this->setPageVars($data);		
		return $this->tpl->draw($name, $returnHtml); 
	}

	public function __destruct(){
		if($this->pageVars["footer"] === true){
			$this->tpl->draw("footer");
		}
				
	}
}

?>