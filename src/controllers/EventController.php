<?php

require_once 'AppController.php';
require_once __DIR__.'/../models/Event.php';
require_once __DIR__.'/../repositories/EventRepository.php';

class EventController extends AppController
{
	const MAX_FILE_SIZE = 1024*1024;
	const SUPPORTED_TYPES = ['image/png','image/jpeg'];
	const UPLOAD_DIRECTORY = '/../public/uploads/';
	private $messages = [];
    private $eventRepository;

    public function add_event()
	{
        session_start();
        if(!isset($_SESSION['logged_in_user_email'])) {
            $this->messages[] = 'Please log in to see this page';
            return $this->render('login', ['messages'=> $this->messages]);
        }
		if($this->isPost() && is_uploaded_file($_FILES['event_photo']['tmp_name']) && $this->validate_file($_FILES['event_photo']))
		{
			move_uploaded_file(
				$_FILES['event_photo']['tmp_name'],
				dirname(__DIR__).self::UPLOAD_DIRECTORY.$_FILES['event_photo']['name']
			);

            $date=new DateTime($_POST['date']);
            if($date < new DateTime()) {
                $this->messages[] = 'Date has to be future';
                return $this->render('add_event', ['messages' => $this->messages]);
            }

            $eventRepository= new EventRepository();
            $userRepository = new UserRepository();
            $event = new Event($_POST['category'],$_POST['date'],$_POST['location'],$_FILES['event_photo']['name']);
            $user = $userRepository->getUserByEmail($_SESSION['logged_in_user_email']);

            $eventRepository->addEvent($user, $event);

			$this->messages[] = 'Event added';

            $user_id = $userRepository->getUserIdByEmail($_SESSION['logged_in_user_email']);
            $events = $eventRepository->getUserEvents($user_id);
            return $this->render('my_events', ['messages' => $this->messages, 'events' => $events]);
		}

        $this->render('add_event', ['messages'=> $this->messages]);
	}

    public function events() {
        session_start();
        if(!isset($_SESSION['logged_in_user_email'])) {
            $this->messages[] = 'Please log in to see this page';
            return $this->render('login', ['messages'=> $this->messages]);
        }
        $userRepository = new UserRepository();
        $user_id = $userRepository->getUserIdByEmail($_SESSION['logged_in_user_email']);
        $eventRepository = new EventRepository();
        $events = $eventRepository->getEvents($user_id);
        $this->render('search_event', ['events' => $events]);
    }

    public function search() {
        session_start();
        if(!isset($_SESSION['logged_in_user_email'])) {
            $this->messages[] = 'Please log in to see this page';
            return $this->render('login', ['messages'=> $this->messages]);
        }
        $eventRepository = new EventRepository();
        $userRepository = new UserRepository();
        $user_id = $userRepository->getUserIdByEmail($_SESSION['logged_in_user_email']);

        $contentType = isset($_SERVER['CONTENT_TYPE']) ? trim($_SERVER["CONTENT_TYPE"]) : '';

        if($contentType === 'application/json') {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);

            header('Content-type: application/json');
            http_response_code(200);

            echo json_encode($eventRepository->getEventByTitle($user_id, $decoded['search']));
        }
    }

    public function my_events() {
        session_start();
        if(!isset($_SESSION['logged_in_user_email'])) {
            $this->messages[] = 'Please log in to see this page';
            return $this->render('login', ['messages'=> $this->messages]);
        }
        $userRepository = new UserRepository();
        $eventRepository = new EventRepository();

        $user_id = $userRepository->getUserIdByEmail($_SESSION['logged_in_user_email']);
        $events = $eventRepository->getUserEvents($user_id);
        $this->render('my_events', ['events' => $events]);
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
