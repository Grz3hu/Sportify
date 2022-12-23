<?php

class User{
	private $email;
	private $password;
	private $name;
    private $phone_number;
	private $profile_pic;

	public function __construct(string $email, string $password, string $name, string $phone_number,string $profile_pic)
	{
		$this->email = $email;
		$this->password = $password;
		$this->name = $name;
        $this->phone_number = $phone_number;
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

    public function setPhoneNumber(string $phone_number): void
    {
        $this->phone_number = $phone_number;
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

    public function getPhoneNumber(): string
    {
        return $this->phone_number;
    }
}
