<?php
include_once ("constantes_carte.php");

class Epave {
  private $sql;
  private $epaveId;
  private $typeEpave;
  private $masseEpave;
  private $listeMAteriaux =array();

  public function __construct($posX, $posY, $type, $nom) {
    $this->sql = database::getInstance();
    $this->typeEpave = $type;
    $nb = count (NOM_MATERIAU);
    $volMateriaux=rand(QTE_MATERIAU_EPAVE_MIN[$type],QTE_MATERIAU_EPAVE_MAX[$type]);
		$volMateriauxAlien=rand(QTE_MATERIAU_ALIEN_EPAVE_MIN[$type],QTE_MATERIAU_ALIEN_EPAVE_MAX[$type]);
    $this->listeMAteriaux = $this->calculMatEpave($volMateriaux*1000, $volMateriauxAlien*1000); // *1000 pour passer en kg
    $this->masseEpave = array_sum ($this->listeMAteriaux);
    $i=0;
    $secteurId = $this->sql->getSecteurId ($posX, $posY);
    $this->epaveId = $this->sql->ajoutEpave ($secteurId, $type, $this->masseEpave, $nom);

    foreach($this->listeMAteriaux as $arrayQuantiteMateriau) {
      new Materiau($i, $arrayQuantiteMateriau, $this->epaveId);
      $i++;
    }
  }

  private function calculMatEpave($mat, $matalien) {
    $liste_mat=array();
    $nb_mat=count(NOM_MATERIAU);
    for ($z=1;$z<=$nb_mat;$z++) {
      array_push($liste_mat,0);
    }
    $i=0;
    While ($mat>0) {
      if (ORIGINE_MATERIAU[$i]==0) { // test si materiau humain
        $t=rand(1,1000);
        If ($t<=TAUX_MATERIAU_EPAVE[$i]) {
          $mat-=MODULE_MATERIAU_EPAVE[$i];
          $liste_mat[$i]+=MODULE_MATERIAU_EPAVE[$i];
        }
      }
      $i++;
      if ($i==$nb_mat) {
        $i=0;
      }
    }
    $i=0;
    While ($matalien>0) {
      if (ORIGINE_MATERIAU[$i]==1) { // test si materiau alien
        $t=rand(1,1000);
        If ($t<=TAUX_MATERIAU_EPAVE[$i]) {
          $matalien -= MODULE_MATERIAU_EPAVE[$i];
          $liste_mat[$i] += MODULE_MATERIAU_EPAVE[$i];
        }
      }
      $i++;
      if ($i==$nb_mat) {
        $i=0;
      }
    }
    return $liste_mat; // renvoi une liste contenant la quantité de tous les materiaux
  }


  public function getEpaveType() {
    return $this->typeEpave;
  }
  public function getEpaveNom() {
    return $this->nomEpave;
  }
  public function getEpaveVolume() {
    return $this->volumeEpave;
  }

}

?>
