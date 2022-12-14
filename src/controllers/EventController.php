<?php

require_once 'AppController.php';
require_once __DIR__.'/../models/Event.php';

class EventController extends AppController
{
	const MAX_FILE_SIZE = 1024*1024;
	const SUPPORTED_TYPES = ['image/png','image/jpeg'];
	const UPLOAD_DIRECTORY = '/../public/uploads/';

	private $messages = [];

	public function add_event()
	{
		if($this->isPost() && is_uploaded_file($_FILES['event_photo']['tmp_name']) && $this->validate_file($_FILES['event_photo']))
		{
			move_uploaded_file(
				$_FILES['event_photo']['tmp_name'],
				dirname(__DIR__).self::UPLOAD_DIRECTORY.$_FILES['event_photo']['name']
			);

			$event = new Event($_POST['category'],$_POST['date'],$_POST['location'],$_POST['event_photo']);


			$this->messages[] = 'Event added';
			return $this->render('my_events', ['messages'=> $this->messages]);
		}

		$this->render('add_event', ['messages'=> $this->messages]);
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
