<?php

class Event
{
	private $category;
	private $date;
	private $location;
	private $picture;
    private $likes;

	public function __construct($category, $date, $location, $picture, $likes=0)
	{
		$this->category=$category;
		$this->date=$date;
		$this->location=$location;
		$this->picture=$picture;
        $this->likes=$likes;
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

	public function setPicture(string $picture)
	{
		$this->picture = $picture;
	}

    public function setLikes(int $likes)
    {
        $this->likes = $likes;
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

	public function getPicture(): string
	{
		return $this->picture;
	}

    public function getLikes(): int
    {
        return $this->likes;
    }
}
