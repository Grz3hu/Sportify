<?php

require_once 'AppController.php';

class DefaultController extends AppController {
	
	public function login() {
		//TODO display login.html
		$this->render('login');
	}

	public function register() {
		//TODO display login.html
		$this->render('register');
	}

	public function events() {
		//TODO display search_events.html
		$this->render('search_event');
	}

	public function my_events() {
		//TODO display search_events.html
		$this->render('my_events');
	}

	public function add_event() {
		//TODO display search_events.html
		$this->render('add_event');
	}
}
