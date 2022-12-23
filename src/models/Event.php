<?php

class Event
{
	private $category;
	private $date;
	private $location;
	private $image;

	public function __construct($category, $date, $location, $image)
	{
		$this->category=$category;
		$this->date=$date;
		$this->location=$location;
		$this->image=$image;
	}

	public function setCategory(string $category)
	{
		$this->category = $category;
	}

	public function setDate(string $date)
	{
		$this->date = $date;
	}

	public function setLocation(string $location)
	{
		$this->location = $location;
	}

	public function setImage(string $image)
	{
		$this->image = $image;
	}


	public function getCategory(): string
	{
		return $this->category;
	}

	public function getDate(): string
	{
		return $this->date;
	}

	public function getLocation(): string
	{
		return $this->location;
	}

	public function getImage(): string
	{
		return $this->image;
	}
}
