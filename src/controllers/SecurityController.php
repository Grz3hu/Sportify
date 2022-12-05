<?php

require_once 'AppController.php';
require_once __DIR__.'/../models/User.php';

class SecurityController extends AppController
{
	public function login()
	{
		$user = new User('dd@o2.pl','admin','John','Snow');

		if(!$this->isPost()){ 
			return $this->render('login');
		}

		$email = $_POST["email"];
		$password = $_POST["password"];

		if ($user->getEmail() !== $email) {
			return $this->render('login', ['messages' => ['User with this email doesnt exist']]);
		}

		if ($user->getPassword() !== $password) {
			return $this->render('login', ['messages' => ['Wrong password']]);
		}

		/* return $this->render('my_events'); */

		$url = "http://$_SERVER[HTTP_HOST]";
		header("Location: {$url}/my_events");
	}
}