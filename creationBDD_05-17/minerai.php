<?php

class Minerai {
  private $mineraiId;
  private $type;
  private $quantite;

  public function __construct($type, $quantite, $asteroideId) {
    $this->type = $type;
    $this->quantite = $quantite;
    $this->mineraiId = ajoutMineraiAsteroideBdd ($type, $quantite, $asteroideId);
  }

  public function getMineraiType() {
    return $this->type;
  }

  public function getMineraiQuantite() {
    return $this->quantite;
  }

}


?>
