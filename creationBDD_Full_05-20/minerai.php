<?php

class Minerai {
  private $sql;
  private $mineraiId;
  private $type;
  private $quantite;

  public function __construct($type, $quantite, $sourceId, $origine) {
    $this->sql = database::getInstance();
    $this->type = $type;
    $this->quantite = $quantite;
    if ($quantite>0) { // enregistre en bdd les minerais dont la quantité est >0
      if ($origine==1) {
        $this->mineraiId = $this->sql->ajoutMineraiPlanete ($type, $quantite, $sourceId);
      } else {
        $this->mineraiId = $this->sql->ajoutMineraiAsteroide ($type, $quantite, $sourceId);
      }
    }
  }

  public function getMineraiType() {
    return $this->type;
  }

  public function getMineraiQuantite() {
    return $this->quantite;
  }
}


?>
