<?php

Class Controller{
	public function loadView($viewName, $viewData = array()){
		extract($viewData);
		require "Views/{$viewName}.php";
	}

	public function loadTemplate($actor, $viewName, $viewData = array()){
		require "Views/Templates/{$actor}.php";
	}

	public function loadViewInTemplate($viewName, $viewData = array()){
		extract($viewData);
		require "Views/{$viewName}.php";
	}
}