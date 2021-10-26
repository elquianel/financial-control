<?php 

class Users extends Model{  

	protected $fail;
	private $userInfo;	

	/* ============== USERS ============== */

	public function bootstrap($first_name, $last_name, $email, $id_group, $id = null){
		$this->first_name = $first_name;
		$this->last_name = $last_name;
		$this->email = $email;
		$this->id_group = $id_group;
		$this->id = $id;
	}

	public function save(){
		if(is_null($this->id)){
			try{
				$sql = $this->db->prepare("INSERT INTO users (id_father, first_name, last_name, email, id_group) VALUES (1, :first_name, :last_name, :email, :id_group)");
				$sql->bindValue(":first_name", $this->first_name);
				$sql->bindValue(":last_name", $this->last_name);
				$sql->bindValue(":email", $this->email);
				$sql->bindValue(":id_group", $this->id_group);
				if($sql->execute()){
					$this->id = $this->db->lastInsertId();
					return true;
				}else{
					return false;
				}
			}catch(PDOException $exception){
				$this->fail = $exception->getMessage();
				return false;
			}
		}else{
			try{
				$sql = $this->db->prepare("UPDATE users SET first_name = :first_name, last_name = :last_name, email = :email, id_group = :id_group WHERE id_user = :id");
				$sql->bindValue(":first_name", $this->first_name);
				$sql->bindValue(":last_name", $this->last_name);
				$sql->bindValue(":email", $this->email);
				$sql->bindValue(":id_group", $this->id_group);
				$sql->bindValue(":id", $this->id);
				$sql->execute();
				if($sql->execute() === false){				
					$this->fail = $sql->errorInfo();
					return false;
				}else{
					return true;
				}

			}catch(PDOException $exception){
				$this->fail = $exception->getMessage();
				return false;
			}
		}
	}

	public function getFail(){
		return $this->fail;
	}

	public function getId(){
		return $this->userInfo->id_user;
	}

	public function getName(){
		return $this->userInfo->first_name;
	}

	public function getLastName(){
		return $this->userInfo->last_name;
	}

	public function getEmail(){
		return $this->userInfo->email;
	}

	public function getInfo(){
		return $this;
	}

	public function getCurrentGroup($id_user){
		$current_group = 0;

		$sql = $this->db->prepare("SELECT id_group FROM users WHERE id_user = :id_user");
		$sql->bindValue(":id_user", $id_user);
		$sql->execute();

		if($sql->rowCount() > 0){
			$current_group = $sql->fetch(PDO::FETCH_OBJ);
			$current_group = $current_group->id_group;
		}

		return $current_group;
	}

	public function getUsers(){
		$result = array();

		$sql = $this->db->prepare("SELECT * FROM users");
		$sql->execute();

		if($sql->rowCount() > 0){
			$result = $sql->fetchAll(PDO::FETCH_OBJ);
		}

		return $result;
	}

	public function getUserById($id_user){
		$result = array();

		$sql = $this->db->prepare("SELECT * FROM users WHERE id_user = :id_user");
		$sql->bindValue(":id_user", $id_user);
		$sql->execute();

		if($sql->rowCount() > 0){
			$result = $sql->fetch(PDO::FETCH_OBJ);
		}

		return $result;
	}

	public function getGroupsByIdUser($id_user){
		$result = array();

		$sql = $this->db->prepare("SELECT groups.id_group, groups.name FROM users INNER JOIN groups ON users.id_group = groups.id_group WHERE users.id_user = :id_user");
		$sql->bindValue(":id_user", $id_user);
		$sql->execute();

		if($sql->rowCount() > 0){
			$result = $sql->fetchAll(PDO::FETCH_OBJ);
		}
		return $result;
	}

	public function getUsersWithoutComissionsRules(){
		$result = array();

		$sql = $this->db->prepare("SELECT id_user, first_name, last_name FROM users WHERE NOT EXISTS (SELECT id_user FROM comissions_rules WHERE users.id_user = comissions_rules.id_user);");
		$sql->execute();

		if($sql->rowCount() > 0){
			$result = $sql->fetchAll(PDO::FETCH_OBJ);
		}

		return $result;
	}

	/* ============== USER AUTHENTICATION ============== */	
	public function isLogged(){
		if(isset($_SESSION[CONF_SESSION_NAME]) && !empty($_SESSION[CONF_SESSION_NAME])){
			return true;
		}else{
			return false;
		}
	}

	public function setLoggedUser(){
		if(isset($_SESSION[CONF_SESSION_NAME]) && !empty($_SESSION[CONF_SESSION_NAME])){
			$id_user = $_SESSION[CONF_SESSION_NAME];

			$sql = $this->db->prepare("SELECT * FROM users WHERE id_user = :id_user");
			$sql->bindValue(":id_user", $id_user);
			$sql->execute();

			if($sql->rowCount() > 0){
				$this->userInfo = $sql->fetch(PDO::FETCH_OBJ);
				// echo "<pre>";
				// var_dump($this->userInfo);exit;
			}
		}
	}

	public function doLogin($email, $password){
		$sql = $this->db->prepare("SELECT id_user, password FROM users WHERE email = :email");
		$sql->bindValue(":email", $email);
		$sql->execute();

		if($sql->rowCount() > 0){
			$row = $sql->fetch(PDO::FETCH_OBJ);

			if(password_verify($password, $row->password)){
				$_SESSION[CONF_SESSION_NAME] = $row->id_user;
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}

	public function logout(){
		unset($_SESSION[CONF_SESSION_NAME]);
	}

	/* ============== USERS VERIFICATIONS  ============== */

	public function verifyEmail($email){
		$sql = $this->db->prepare("SELECT id_user FROM users WHERE email = :email");
		$sql->bindValue(":email", $email);
		$sql->execute();

		if($sql->rowCount() > 0){
			return true;
		} else {
			return false;
		}
	}

	public function verifyId($id_user){
		$sql = $this->db->prepare("SELECT first_name FROM users WHERE id_user = :id_user");
		$sql->bindValue(":id_user", $id_user);
		$sql->execute();

		if($sql->rowCount() > 0){
			return true;
		}else{
			return false;  
		}
	}

	public function getAccountants($group_name){
		$result = array();

		$sql = $this->db->prepare("SELECT users.first_name, users.id_user FROM users INNER JOIN groups ON users.id_group = groups.id_group WHERE groups.name = :group_name");
		$sql->bindValue(":group_name", $group_name);
		$sql->execute();

		if($sql->rowCount() > 0){
			$result = $sql->fetchAll(PDO::FETCH_OBJ);
		}

		return $result;
	}
}