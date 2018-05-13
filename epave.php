<?php

class Epave {

  private $typeEpave;
  private $nomEpave;
  private $volumeEpave;
  private $volMateriaux;
  private $volMateriauxAlien;
  private $listeMAteriaux =array();

  const NOM_EPAVE = ["Débris de structure","Station abandonnée","Epave de vaisseau terrien","Epave de vaisseau extra-terrestre"];
  const QTE_MATERIAU_EPAVE_MIN = [1,2000,500,500];
  const QTE_MATERIAU_EPAVE_MAX = [1000,10000,5000,2000];
  const QTE_MATERIAU_ALIEN_EPAVE_MIN = [0,0,0,500];
  const QTE_MATERIAU_ALIEN_EPAVE_MAX = [0,0,0,2000];

  const MATERIAU_NOM = ["Acier","Aluminium","Titane","Cuivre","Plomb","Argent","Or","Uranium","Bolognium","Carbonium"];
  const MATERIAU_ORI = [0,0,0,0,0,0,0,0,1,1];
  const MATERIAU_TAUX = [700,700,500,500,300,80,5,1,850,150];
  const MATERIAU_MODU = [100,100,30,20,10,1,1,1,100,1];

  public function __construct($type) {
    $this->typeEpave = $type;
    $this->nomEpave = self::NOM_EPAVE[$type];
    $nb = count (self::MATERIAU_NOM);
    $this->volMateriaux=rand(self::QTE_MATERIAU_EPAVE_MIN[$type],self::QTE_MATERIAU_EPAVE_MAX[$type]);
		$this->volMateriauxAlien=rand(self::QTE_MATERIAU_ALIEN_EPAVE_MIN[$type],self::QTE_MATERIAU_ALIEN_EPAVE_MAX[$type]);
    $this->listeMAteriaux = $this->calculMatEpave($this->volMateriaux*1000,$this->volMateriauxAlien*1000); // *1000 pour passer en kg
    $i=0;
    foreach($this->listeMAteriaux as $arrayQuantiteMateriau) {
      new Materiau($i, $arrayQuantiteMateriau);
      $i++;
    }
  }

  private function calculMatEpave($mat,$matalien) {
    $liste_mat=array();
    $nb_mat=count(self::NOM_EPAVE);
    for ($z=1;$z<=$nb_mat;$z++) {
      array_push($liste_mat,0);
    }
    $i=0;
    While ($mat>0) {
      if (self::MATERIAU_ORI[$i]==0) { // test si materiau humain
        $t=rand(1,1000);
        If ($t<=self::MATERIAU_TAUX[$i]) {
          $mat-=self::MATERIAU_MODU[$i];
          $liste_mat[$i]+=self::MATERIAU_MODU[$i];
        }
      }
      $i++;
      if ($i==$nb_mat) {
        $i=0;
      }
    }
    $i=0;
    While ($matalien>0) {
      if (self::MATERIAU_ORI[$i]==1) { // test si materiau alien
        $t=rand(1,1000);
        If ($t<=self::MATERIAU_TAUX[$i]) {
          $matalien -= self::MATERIAU_MODU[$i];
          $liste_mat[$i] += self::MATERIAU_MODU[$i];
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
