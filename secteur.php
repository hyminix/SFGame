<?php
include_once ("constantes_carte.php");

class Secteur {

  private $secteurType;
  private $secteurVolume;
  private $secteurOrdre;
  private $posX;
  private $posY;
  private $asteroids;
  private $planete;
  private $epave;

  // constantes secteurs
  //const TAUX_ASTEROIDE = 220;
  //const TAUX_PLANETE = 30;
  //const TAUX_EPAVE = 15;
  //const TAUX_TROU_NOIR = 3;
  //const VOLUME_SECTEUR_MIN = 20;
  //const VOLUME_SECTEUR_MAX = 40;

  // Constantes asteroides
  //const ASTEROIDE_TAUX = [2,7,12,30,40,50];
  //const ASTEROIDE_VOLUME = [20,12,8,5,2,1];
  //const MINERAI_VOLUME_MIN = [10000,3000,1000,300,100,50];
  //const MINERAI_VOLUME_MAX = [50000,10000,3000,1000,300,100];

  // constantes planetes et lunes
  // const NB_PLANETE_MIN = 2;
  // const NB_PLANETE_MAX = 9;
  // const TAUX_LUNE = 60;

  // constantes epaves
  //const TAUX_TYPE_EPAVE = [50,15,30,5];
  //const NB_EPAVE_MIN = [2,1,1,1];
  //const NB_EPAVE_MAX = [12,1,1,1];

  public function __construct($posY, $posX) {
    $this->posX = $posX;
    $this->posY = $posY;
    $this->secteurType = $this->randomise_secteur();
    $this->secteurVolume = rand(VOLUME_SECTEUR_MIN,VOLUME_SECTEUR_MAX);
    $this->secteurOrdre = 0;
    $this->asteroids = array();


    switch ($this->secteurType) {
      case 0:
        return 0;
        break;
      case 1:
        $this->generer_asteroids();
        break;
      case 2:
        $this->generer_planetes();
        break;
      case 3:
        $this->generer_epaves();
        break;
      case 4:
        // Trous noir, rien à générer
        break;
    }
  }

  private function randomise_secteur() {
    $t=mt_rand(1,1000);
    $type=0;
    if($t <= TAUX_ASTEROIDE) {
      $type=1;
    }
    if($t <= TAUX_PLANETE) {
      $type=2;
    }
    if($t <= TAUX_EPAVE) {
      $type=3;
    }
    if($t <= TAUX_TROU_NOIR) {
      $type=4;
    }
     return $type;
  }

  private function generer_asteroids() {
    $i=0;
    while ($this->secteurVolume<>0) {
      if (rand(1,100)<=ASTEROIDE_TAUX[$i] AND $this->secteurVolume-ASTEROIDE_VOLUME[$i]>=0) {
        array_push($this->asteroids, new Asteroid(rand(MINERAI_VOLUME_MIN[$i],MINERAI_VOLUME_MAX[$i])));
        $this->secteurVolume-=ASTEROIDE_VOLUME[$i];
      }
      $i++;
      if ($i==count(ASTEROIDE_VOLUME)) {
        $i=0;
      }
    }
  }

  private function generer_planetes() {
    $planetes_nb=rand(NB_PLANETE_MIN,NB_PLANETE_MAX);
    $p=0;
    for ($i=1;$i<=$planetes_nb;$i++) {
			if (rand(1,100)<TAUX_LUNE and $p==1){ // teste si la planete est une lune
          new Lune;
      } else {
          new Planete;
      }
    	$p=1;
    }
  }

  private function generer_epaves() {
    $tirage=rand(1,100);
    $t=0; $epave_type=0;
    while ($t<100) { // recherche du type d'epave
    	$t+=TAUX_TYPE_EPAVE[$epave_type];
    	if ($tirage<=$t) {
    		$t=100;
    	} else {
    		$epave_type++;
    	}
    }
    $epaves_nb=rand(NB_EPAVE_MIN[$epave_type],NB_EPAVE_MAX[$epave_type]);   // tirage du nombre d'epaves
    for ($i=1;$i<=$epaves_nb;$i++) {
      new Epave($epave_type);
    }
  }

  public function getPosX() {
    return $this->posX;
  }

  public function getPosY() {
    return $this->posY;
  }

  public function getSecteurVolume() {
    return $this->secteurVolume;
  }

  public function getSecteurType() {
    return $this->secteurType;
  }

  public function getSecteurOrdre() {
    return $this->secteurOrdre;
  }

  public function setSecteurType($type) { // utile pour affecter les secteurs de pop
    $this->secteurType = $type;
  }

  public function setSecteurOrdre($ordre) { // utile pour affecter l'odre de pop des secteurs de pop
    $this->secteurOrdre = $ordre;
  }
}

?>
