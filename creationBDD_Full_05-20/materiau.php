<?php

class Materiau {
  private $sql;
  private $materiauId;
  private $type;
  private $quantite;

  public function __construct($type, $quantite, $sourceId) {
    $this->sql = database::getInstance();
    $this->type = $type;
    $this->quantite = $quantite;
    if ($quantite>0) { // enregistre en bdd les materiaux dont la quantité est >0
      $this->materiauId = $this->sql->ajoutMateriauEpave ($type, $quantite, $sourceId);
    }
  }

  public function getMateriauType() {
    return $this->type;
  }

  public function getMateriauQuantite() {
    return $this->getQuantite;
  }
}


?>
