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

    private $bcrypt_options = ['cost' => 11];
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

        if (!password_verify($password, $user->getPassword())) {
			return $this->render('login', ['messages' => ['Wrong password']]);
		}

        session_start();
        $_SESSION['logged_in_user_email'] = $email;
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

            $userRepository = new UserRepository();
            if($userRepository->getUserByEmail($email))
            {
                $this->messages[] = 'User with this email already exists';
                return $this->render('register', ['messages'=> $this->messages]);
            }

            if(!preg_match('/^[0-9]{11}+$/', $phone_number)){
                $this->messages[] = 'Incorrect phone number';
                return $this->render('register', ['messages'=> $this->messages]);
            }

			if($password!==$password2){
				$this->messages[] = 'Passwords do not match';
				return $this->render('register', ['messages'=> $this->messages]);
			}

            $hashed_password = password_hash($password, PASSWORD_BCRYPT, $this->bcrypt_options);
            $userRepository->addUser(new User($email,$hashed_password,$name,$phone_number,$profile_pic));

			$this->messages[] = 'User added';
			return $this->render('login', ['messages'=> $this->messages]);
		}
		$this->render('register', ['messages'=> $this->messages]);
	}

    public function logout()
    {
        session_start();
        unset($_SESSION);
        session_destroy();

        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: {$url}/login");
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

    public function admin()
    {
        session_start();
        if(!isset($_SESSION['logged_in_user_email'])) {
            $this->messages[] = 'Please log in to see this page';
            return $this->render('login', ['messages'=> $this->messages]);
        }

        $userRepository = new UserRepository();
        session_start();
        $email = $_SESSION['logged_in_user_email'];
        if (!$userRepository->isUserAdmin($email)) {
            $this->messages[] = 'You are not allowed to view this page';
            return $this->render('login', ['messages' => $this->messages]);
        }

        $users = $userRepository->getAllUsers();
        return $this->render('admin', ['users' => $users]);
    }
}
