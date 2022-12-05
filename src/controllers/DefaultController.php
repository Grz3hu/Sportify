<?php

require_once 'AppController.php';

class DefaultController extends AppController {
	
	public function index() {
		//TODO display login.html
		$this->render('login');
	}

	public function events() {
		//TODO display search_events.html
		$this->render('search_event');
	}

	public function my_events() {
		//TODO display search_events.html
		$this->render('my_events');
	}
}
