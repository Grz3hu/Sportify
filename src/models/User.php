<?php

class User{
	private $email;
	private $password;
	private $name;
	private $profile_pic;

	public function __construct(string $email, string $password, string $name, string $profile_pic)
	{
		$this->email = $email;
		$this->password = $password;
		$this->name = $name;
		$this->profile_pic = $profile_pic;
	}


	public function setEmail(string $email)
	{
		$this->email = $email;
	}

	public function setPassword(string $password)
	{
		$this->password = $password;
	}
	
	public function setName(string $name)
	{
		$this->name = $name;
	}

	public function setProfilePic(string $profile_pic)
	{
		$this->profile_pic = $profile_pic;
	}


	public function getEmail()
	{
		return $this->email;
	}

	public function getPassword()
	{
		return $this->password;
	}
	
	public function getName()
	{
		return $this->name;
	}

	public function getProfilePic()
	{
		return $this->profile_pic;
	}
}
