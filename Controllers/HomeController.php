<?php

Class HomeController extends Controller{
	private $data = array();

	public function __construct(){
		if(construct_login()){
			$this->data["userInfo"] = construct_login();
		}
	}

	public function index(){
		
		$this->data["JS"] = customJS("echarts.min");
		$this->data["JS"] .= customJS("home_vendas_equipamentos");
		$this->data["JS"] .= customJS("home_adesao_sistemas");
		$this->data["JS"] .= customJS("home_adesao_qnt");
		$this->data["JS"] .= customJS("home_recorrencia");


		$this->loadTemplate("salesman", "Salesman/index", $this->data);
	}
}