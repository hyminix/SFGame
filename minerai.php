<?php

class Minerai {

  private $type;
  private $quantite;


  public function __construct($type, $quantite) {
    $this->type = $type;
    $this->quantite = $quantite;
  }

  public function getMineraiType() {
    return $this->type;
  }

  public function getMineraiQuantite() {
    return $this->quantite;
  }

}


?>
