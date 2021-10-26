<?php 

Class NotFoundController extends Controller{

	public function index(){
		$this->loadView('Bootstrap/404', array());
	}
}