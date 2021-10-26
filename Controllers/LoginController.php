<?php 

class LoginController extends Controller{
	private $data = array();

	public function index(){
		$user = new Users();

		if($user->isLogged() == true){
			header("Location: ".CONF_BASE_URL."Home");
		}else{
			$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);
			if($post){
				$this->data['email'] = $post['email'];
				if(!is_email($post['email'])){
					$this->data["alert"] = message()->warning("Email Inválido, por favor tente novamente.");
				}else{
					if(!$user->verifyEmail($post['email'])){						
						$this->data["alert"] = message()->warning("Email inexistente na nossa base de dados");
					}else{
						if($user->doLogin($post['email'], $post['pass'])){
							header("Location: ".CONF_BASE_URL."Home");
							exit;
						}else{
							$this->data["email"] = $post["email"];
							$this->data["alert"] = message()->warning("Senha inválida!");
						}
					}
				}

			}
		}

		//trocar dps
		$this->loadView("Bootstrap/Login/index", $this->data);
	}

	public function logout(){
		$user = new Users();
		$user->logout();
		header("Location: ".CONF_BASE_URL."Login");exit;
	}
}