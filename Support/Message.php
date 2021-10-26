<?php
class Message {
	private $text;
	private $type;

	public function __toString(){
		return $this->render();
	}

	public function getText(){
		return $this->text;
	}

	public function getType(){
		return $this->type;
	}

	public function info($message){
		$this->type = CONF_MESSAGE_INFO;
		$this->text = $this->filter($message);
		return $this;
	}

	public function success($message){
		$this->type = CONF_MESSAGE_SUCCESS;
		$this->text = $this->filter($message);
		return $this;
	}

	public function warning($message){
		$this->type = CONF_MESSAGE_WARNING;
		$this->text = $this->filter($message);
		return $this;
	}

	public function error($message){
		$this->type = CONF_MESSAGE_ERROR;
		$this->text = $this->filter($message);
		return $this;
	}

	public function render(){
		return "<div class='".CONF_MESSAGE_CLASS." {$this->getType()} alert-dismissible fade show' role='alert'><i class='fas fa-info-circle'></i> {$this->getText()}<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
	}

	public function json(){
		return json_encode(["error" => $this->getText()]);

	}

	public function flash(){
		(new Session())->set("flash", $this);
	}

	private function filter($message){
		return filter_var($message, FILTER_SANITIZE_SPECIAL_CHARS);
	}
}