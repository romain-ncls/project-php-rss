<?php
  class Flux
  {
      public function __construct(String $name, String $url)
      {
          $this->name = $name;
          $this->url = $url;
      }
      
      public function getName()
      {
          return $this->name;
      }
      
      public function getUrl()
      {
          return $this->url;
      }
  }
