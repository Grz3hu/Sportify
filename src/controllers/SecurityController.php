<?php

require_once 'AppController.php';
require_once __DIR__.'/../models/User.php';
require_once __DIR__.'/../repositories/UserRepository.php';

class SecurityController extends AppController
{
	const MAX_FILE_SIZE = 1024*1024;
	const SUPPORTED_TYPES = ['image/png','image/jpeg'];
	const UPLOAD_DIRECTORY = '/../public/uploads/';

	private $messages = [];

	public function login()
	{
		$userRepository = new UserRepository();

		if(!$this->isPost()){
			return $this->render('login');
		}

		$email = $_POST["email"];
		$password = $_POST["password"];
		$user = $userRepository->getUserByEmail($email);

		if (!$user) {
			return $this->render('login', ['messages' => ['User with this email doesnt exist']]);
		}

		if ($user->getPassword() !== $password) {
			return $this->render('login', ['messages' => ['Wrong password']]);
		}

		/* return $this->render('my_events'); */

		$url = "http://$_SERVER[HTTP_HOST]";
		header("Location: {$url}/my_events");
	}

	public function register()
	{
        if($this->isPost() && is_uploaded_file($_FILES['profile_pic']['tmp_name']) && $this->validate_file($_FILES['profile_pic']))
		{
			move_uploaded_file(
				$_FILES['profile_pic']['tmp_name'],
				dirname(__DIR__).self::UPLOAD_DIRECTORY.$_FILES['profile_pic']['name']
			);

			$email = $_POST["email"];
            $name = $_POST["name"];
			$phone_number = $_POST["phone_number"];
			$password = $_POST["password"];
			$password2 = $_POST["password2"];
			$profile_pic = $_FILES['profile_pic']['name'];

			if($password!==$password2){
				$this->messages[] = 'Passwords do not match';
				return $this->render('register', ['messages'=> $this->messages]);
			}

            $userRepository = new UserRepository();
            $userRepository->addUser(new User($email,$password,$name,$phone_number,$profile_pic));

			$this->messages[] = 'User added';
			return $this->render('login', ['messages'=> $this->messages]);
		}
		$this->render('register', ['messages'=> $this->messages]);
	}

	private function validate_file(array $file): bool
	{
		if($file['size'] > self::MAX_FILE_SIZE) 
		{
			$this->messages[] = 'File is too large';
			return false;
		}

		if(!isset($file['type']) && !in_array($file['type'],self::SUPPORTED_TYPES))
		{
			$this->messages[] = 'Not supported file type';
			return false;
		}

		return true;
	}
}
