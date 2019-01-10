<?php

class News
{
  private $url;
  private $date;
  private $title;
  private $website;
  private $description;
  private $image;

  public function getUrl() {
    return $this->url;
  }

  public function getDate() {
    return $this->date;
  }

  public function getTitle() {
    return $this->title;
  }

  public function getWebsite() {
    return $this->website;
  }

  public function getDescription() {
    return $this->description;
  }

  public function getImage() {
    return $this->image;
  }

  public function setUrl(string $url) {
    $this->url = $url;
  }
  public function setDate(string $date) {
    $this->date = $date;
  }
  public function setTitle(string $title) {
    $this->title = $title;
  }
  public function setWebsite(string $website) {
    $this->website = $website;
  }
  public function setDescription(string $description) {
    $this->description = $description;
  }
  public function setImage($image) {
    $this->image = $image;
  }
}
