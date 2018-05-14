<?php
include_once ("constantes_carte.php");

class Epave {

  private $typeEpave;
  private $nomEpave;
  private $volumeEpave;
  private $volMateriaux;
  private $volMateriauxAlien;
  private $listeMAteriaux =array();

  //const NOM_EPAVE = ["Débris de structure","Station abandonnée","Epave de vaisseau","Epave extra-terrestre"];
  // const QTE_MATERIAU_EPAVE_MIN = [1,2000,500,500];
  // const QTE_MATERIAU_EPAVE_MAX = [1000,10000,5000,2000];
  // const QTE_MATERIAU_ALIEN_EPAVE_MIN = [0,0,0,500];
  // const QTE_MATERIAU_ALIEN_EPAVE_MAX = [0,0,0,2000];

  //const NOM_MATERIAU = ["Acier","Aluminium","Titane","Cuivre","Plomb","Argent","Or","Uranium","Bolognium","Carbonium"];
  //const MATERIAU_ORI = [0,0,0,0,0,0,0,0,1,1];
  // const TAUX_MATERIAU_EPAVE = [700,700,500,500,300,80,5,1,850,150];
  // const MODULE_MATERIAU_EPAVE = [100,100,30,20,10,1,1,1,100,1];

  public function __construct($type) {
    $this->typeEpave = $type;
    $this->nomEpave = NOM_EPAVE[$type];
    $nb = count (NOM_MATERIAU);
    $this->volMateriaux=rand(QTE_MATERIAU_EPAVE_MIN[$type],QTE_MATERIAU_EPAVE_MAX[$type]);
		$this->volMateriauxAlien=rand(QTE_MATERIAU_ALIEN_EPAVE_MIN[$type],QTE_MATERIAU_ALIEN_EPAVE_MAX[$type]);
    $this->listeMAteriaux = $this->calculMatEpave($this->volMateriaux*1000,$this->volMateriauxAlien*1000); // *1000 pour passer en kg
    $i=0;
    foreach($this->listeMAteriaux as $arrayQuantiteMateriau) {
      new Materiau($i, $arrayQuantiteMateriau);
      $i++;
    }
  }

  private function calculMatEpave($mat,$matalien) {
    $liste_mat=array();
    $nb_mat=count(NOM_EPAVE);
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
