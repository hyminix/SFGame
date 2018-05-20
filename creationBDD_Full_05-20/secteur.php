<?php
include_once ("constantes_carte.php");

class Secteur {
  private $sql;
  private $secteurType;
  private $secteurVolume;
  private $secteurOrdre;
  private $posX;
  private $posY;
  private $nom;
  private $asteroids;
  private $planete;
  private $epave;

  public function __construct($posX, $posY, $nouveauSecteur = NULL) {
    $this->sql = database::getInstance();
    $this->posX = $posX;
    $this->posY = $posY;
    $this->nom = 'S.'.$this->posX.'-'.$this->posY; // ----------------------------------->> A adapter
    if($nouveauSecteur) {
      $this->generer_nouveau_secteur();
    }
  }

  private function generer_nouveau_secteur() {
    $this->secteurType = $this->randomise_secteur();
    $this->secteurVolume = rand(VOLUME_SECTEUR_MIN,VOLUME_SECTEUR_MAX);
    $this->secteurOrdre = 0;
    $this->asteroids = array();
    $this->sql->ajoutSecteur($this->posX, $this->posY, $this->nom);
    $secteurId = $this->sql->getSecteurId ($this->posX, $this->posY);
    $this->sql->affecteSecteurType ($secteurId, $this->secteurType);

    switch ($this->secteurType) {
      case 0:
        return 0;
        break;
      case 1:
        $this->generer_asteroides();
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

  private function generer_asteroides() {
    $i=0; $n=1;
    while ($this->secteurVolume<>0) {
      if (rand(1,100)<=ASTEROIDE_TAUX[$i] AND $this->secteurVolume-ASTEROIDE_VOLUME[$i]>=0) {
        $nom ='S.'.$this->posX.'.'.$this->posY.'-A'.$n; // ----------------------------------->> A adapter
        array_push($this->asteroids, new Asteroid($this->posX, $this->posY, $i, $nom));
        $this->secteurVolume-=ASTEROIDE_VOLUME[$i];
        $n++;
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
          $lune=1;
      } else {
          $lune=0;
      }
      new Planete($this->posX, $this->posY, $lune);
    	$p=1;
    }
  }

  private function generer_epaves() {
    $tirage=rand(1,100);
    $t=0; $type=0;
    while ($t<100) { // recherche du type d'epave
    	$t+=TAUX_TYPE_EPAVE[$type];
    	if ($tirage<=$t) {
    		$t=100;
    	} else {
    		$type++;
    	}
    }
    $epaves_nb=rand(NB_EPAVE_MIN[$type],NB_EPAVE_MAX[$type]);   // tirage du nombre d'epaves
    for ($i=1;$i<=$epaves_nb;$i++) {
      $nom ='S.'.$this->posX.'.'.$this->posY.'-E'.$i; // ----------------------------------->> A adapter
      new Epave($this->posX, $this->posY, $type, $nom);
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
