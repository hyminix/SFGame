<?php

class Secteur {

  private $secteurType;
  private $volumeSecteur;
  private $posX;
  private $posY;
  private $asteroids;
  private $planete;
  private $epave;

  // constantes secteurs
  const TAUX_ASTEROID = 220;
  const TAUX_PLANETE = 30;
  const TAUX_EPAVE = 15;
  const TAUX_TROU_NOIR = 3;
  const VOLUME_SECTEUR_MIN = 20;
  const VOLUME_SECTEUR_MAX = 40;

  // Constantes asteroides
  const ASTEROID_TAUX = [2,7,12,30,40,50];
  const ASTEROID_VOLUME = [20,12,8,5,2,1];
  const MINERAI_VOLUME_MIN = [10000,3000,1000,300,100,50];
  const MINERAI_VOLUME_MAX = [50000,10000,3000,1000,300,100];

  // constantes planetes et lunes
  const NB_PLANETE_MIN = 2;
  const NB_PLANETE_MAX = 9;
  const TAUX_LUNE = 60;
  const LUNE_COEF_MIN = 5;
  const LUNE_COEF_MAX = 15;
  const TAUX_PLANETE_LUNE = [25,15,5,10,10,15,10,5,5,5];

  // constantes epaves
  const NB_TYPE_EPAVE = 4;
  const TAUX_TYPE_EPAVE = [50,17,30,5];
  const NB_EPAVE_MIN = [2,1,1,1];
  const NB_EPAVE_MAX = [12,1,1,1];

  public function __construct($posY, $posX) {
    $this->posX = $posX;
    $this->posY = $posY;
    $this->secteurType = $this->randomise_secteur();
    $this->volumeSecteur = rand(self::VOLUME_SECTEUR_MIN,self::VOLUME_SECTEUR_MAX);
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
        // Trous nous
        break;
    }
  }

  private function randomise_secteur() {
    $t=mt_rand(1,1000);
    $type=0;
    if($t <= self::TAUX_ASTEROID) {
      $type=1;
    }
    if($t <= self::TAUX_PLANETE) {
      $type=2;
    }
    if($t <= self::TAUX_EPAVE) {
      $type=3;
    }
    if($t <= self::TAUX_TROU_NOIR) {
      $type=4;
    }
     return $type;
  }

  private function generer_asteroids() {
    $i=0;
    while ($this->volumeSecteur<>0) {
      if (rand(1,100)<=self::ASTEROID_TAUX[$i] AND $this->volumeSecteur-self::ASTEROID_VOLUME[$i]>=0) {
        array_push($this->asteroids, new Asteroid(rand(self::MINERAI_VOLUME_MIN[$i],self::MINERAI_VOLUME_MAX[$i])));
        $this->volumeSecteur-=self::ASTEROID_VOLUME[$i];
      }
      $i++;
      if ($i==6) {
        $i=0;
      }
    }
  }

  private function generer_planetes() {
    $planetes_nb=rand(self::NB_PLANETE_MIN,self::NB_PLANETE_MAX);
    $p=0;
    for ($i=1;$i<=$planetes_nb;$i++) {
			if (rand(1,100)<self::TAUX_LUNE and $p==1){ // teste si la planete est une lune
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
    	$t+=self::TAUX_TYPE_EPAVE[$epave_type];
    	if ($tirage<=$t) {
    		$t=100;
    	} else {
    		$epave_type++;
    	}
    }
    $epaves_nb=rand(self::NB_EPAVE_MIN[$epave_type],self::NB_EPAVE_MAX[$epave_type]);   // tirage du nombre d'epaves
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

  public function getVolumeSecteur() {
    return $this->volumeSecteur;
  }

  public function getSecteurType() {
    return $this->secteurType;
  }

  public function setSecteurType($type) { // utile pour affecter les secteurs de pop
    $this->secteurType = $type;
  }
}

?>
