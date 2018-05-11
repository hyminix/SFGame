<?php

class Materiau {

  private $type;
  private $quantite;


  public function __construct($type, $quantite) {
    $this->type = $type;
    $this->quantite = $quantite;
  }

  public function getMateriauType() {
    return $this->type;
  }

  public function getMateriauQuantite() {
    return $this->getQuantite;
  }

}


?>
