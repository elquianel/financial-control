<?php
// URL
function url($path){
	return CONF_BASE_URL .($path[0] == "/" ? mb_substr($path, 1) : $path);
}

// MESSAGE
function message(){
	return new Message();
}

// VALIDATE
function is_email($email){
	return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function is_cnpj($cnpj){

	//verificando se o tamanho do cnpj é diferente de 14
	if (strlen($cnpj) != 14) 
		return false;

	//verificando se são todos os numeros repetidos -> (ex: 0000000000)
	if (preg_match('/(\d)\1{13}/', $cnpj))
		return false;	

	//aqui ele vai fazer a conta que verifica se é um cnpj válido mesmo (serve pra cpf tbm)

	//validando primeiro dígito verificador
	for ($i = 0, $j = 5, $sum = 0; $i < 12; $i++)
	{
		$sum += $cnpj[$i] * $j;
		$j = ($j == 2) ? 9 : $j - 1;
	}

	$rest = $sum % 11;

	if ($cnpj[12] != ($rest < 2 ? 0 : 11 - $rest))
		return false;

	//validando segundo dígito verificador
	for ($i = 0, $j = 6, $sum = 0; $i < 13; $i++)
	{
		$sum += $cnpj[$i] * $j;
		$j = ($j == 2) ? 9 : $j - 1;
	}

	$rest = $sum % 11;

	return $cnpj[13] == ($rest < 2 ? 0 : 11 - $rest);
}

// DATES
function br_date($date){
	if(isset($date) && !empty($date)){
		return date("d/m/Y H:i:s", strtotime($date));
	}else{
		return "Data não informada";
	}
}

function br_date_only($date){
	if(isset($date) && !empty($date)){
		return date("d/m/Y", strtotime($date));
	}else{
		return "Data não informada";
	}
}

// CUSTOM CSS AND JS
function customCSS($file_name, $vendor = false){
	if(!$vendor){
		return "<link rel='stylesheet' href='".CONF_BASE_URL."Assets/css/".$file_name.".css'>"; 
	}else{
		return "<link rel='stylesheet' href='".CONF_BASE_URL."Assets/vendor/".$file_name.".css'>"; 
	}
}

function customJS($file_name, $vendor = false){
	if(!$vendor){
		return "<script type='text/javascript' src='".CONF_BASE_URL."Assets/js/".$file_name.".js'></script>";
	}else{
		return "<script type='text/javascript' src='".CONF_BASE_URL."Assets/vendor/".$file_name.".js'></script>";
	}
}

// LOGIN
function construct_login(){
	$user = new Users();

	if($user->isLogged() == false) {
		header("Location: ".CONF_BASE_URL."Login");
		exit;
	}else{
		$user->setLoggedUser();
		return $user->getInfo();
	}
}

//CURRENT GROUP - VERIFY PERMISSIONS
function currentGroup(){
	$user = new Users();
	$user->setLoggedUser();

	$currentGroup = $user->getCurrentGroup($user->getId());
	return $currentGroup;
}

//GROUPS 
function getGroupsByUser(){
	$user = new Users();
	$user->setLoggedUser();

	$groups = $user->getGroupsByIdUser($user->getId());
	return $groups;
}

// ARRAY
function in_array_r($search, $array, $column){
	foreach($array as $struct){
		if($search == $struct->{$column}){return true;}
	}
	return false;
}

// PERMISSION
function has_permission($param_name, $id_group){ // ainda preciso melhorar por causa dos user_groups que ainda não estamos tratando corretamente
	// capturamos o id do params pelo nome
	$params = new Parameters();
	$groups = new Groups();

	$id_param = $params->getIdByName($param_name);

	if($id_param != false){
		// capturamos os params do grupo
		$group_params = $groups->getParamsByIdGroup($id_group);
		// verifico se ele está dentro do grupo
		if(!in_array_r($id_param, $group_params, "id_param")){			
			header("Location: ".CONF_BASE_URL."Home");
			exit;
		}
	}else{		
		header("Location: ".CONF_BASE_URL."Home");
		exit;
	}	
}

// BRAZILIAN REAL TO NUMBER ONLY
function number_to_bd($value){

	$value = str_replace("R$ ", "", $value);
	$value = str_replace(".", "", $value);
	$value = str_replace(",", ".", $value);

	return $value;
}

function number_to_real($value){
	$value = str_replace(".", ",", $value);
	$value = "R$ ".$value;
	return $value;
}

