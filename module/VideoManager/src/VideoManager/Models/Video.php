<?php
namespace VideoManager\Models;

class Video
{
    public $videoId;
    public $directorId;
    public $title;
    public $duration;
    public $synopsis;
    public $genre;
    public $website;
    public $releaseDate;

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function exchangeArray($data)
    {
        $this->videoId = (isset($data['videoId'])) ? $data['videoId'] : null;
        $this->title = (isset($data['title'])) ? $data['title'] : null;
        $this->directorId = (isset($data['directorId'])) ? $data['directorId'] : null;
        $this->duration = (isset($data['duration'])) ? $data['duration'] : null;
        $this->synopsis = (isset($data['synopsis'])) ? $data['synopsis'] : null;
        $this->genre = (isset($data['genre'])) ? $data['genre'] : null;
        $this->website = (isset($data['website'])) ? $data['website'] : null;
        $this->releaseDate = (isset($data['releaseDate'])) ? $data['releaseDate'] : null;
    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
}
