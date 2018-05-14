<?php
include_once ("constantes_carte.php");
class Monde {

  private $secteurs = array(array());
  private $x_pos=0;
  private $y_pos=0;

  //const TAILLE_MAP_LARGEUR = 45;
  //const TAILLE_MAP_HAUTEUR = 45;
  //const TAILLE_MAP_COTE = 30;
  //const COEF_POPULATION = 9; // coef de population= nb de secteurs moyen entre 2 joueurs

  const DECALAGE_X = array([0,-1,-1,0,1,1,1,0,-1], [0,-1,-1,0,1,1,1,0,-1], [0,-2,-2,-2,-1,0,1,2,2,2,2,2,1,0,-1,-2,-2], [0,-3,-3,-3,-3,-2,-1,0,1,2,3,3,3,3,3,3,3,2,1,0,-1,-2,-3,-3,-3], [0,-4,-4,-4,-4,-4,-3,-2,-1,0,1,2,3,4,4,4,4,4,4,4,4,4,3,2,1,0,-1,-2,-3,-4,-4,-4,-4], [0,-5,-5,-5,-5,-5,-5,-4,-3,-2,-1,0,1,2,3,4,5,5,5,5,5,5,5,5,5,5,5,4,3,2,1,0,-1,-2,-3,-4,-5,-5,-5,-5,-5]);
  const DECALAGE_Y = array([0,0,-1,-1,-1,0,1,1,1], [0,0,-1,-1,-1,0,1,1,1], [0,0,-1,-2,-2,-2,-2,-2,-1,0,1,2,2,2,2,2,1], [0,0,-1,-2,-3,-3,-3,-3,-3,-3,-3,-2,-1,0,1,2,3,3,3,3,3,3,3,2,1], [0,0,-1,-2,-3,-4,-4,-4,-4,-4,-4,-4,-4,-4,-3,-2,-1,0,1,2,3,4,4,4,4,4,4,4,4,4,3,2,1], [0,0,-1,-2,-3,-4,-5,-5,-5,-5,-5,-5,-5,-5,-5,-5,-5,-4,-3,-2,-1,0,1,2,3,4,5,5,5,5,5,5,5,5,5,5,5,4,3,2,1]);

  private $x_depart = TAILLE_MAP_COTE/2;
  private $y_depart = TAILLE_MAP_COTE/2;

  public function __construct() {
    for($i = 0; $i<TAILLE_MAP_COTE; $i++){
      for($j = 0; $j<TAILLE_MAP_COTE; $j++) {
        $this->secteurs[$j][$i] = new Secteur($j, $i);
      }
    }
    $this->generer_point_pop();
  }


  private function generer_point_pop() {
    // recherche du point de pop du 1er joueur
    $t=0;
    while ($t<10) {
      $x = $this->x_depart + self::DECALAGE_X[0][$t];
      $y = $this->y_depart + self::DECALAGE_Y[0][$t];
      if ($this->secteurs[$y][$x]->getSecteurType() == 0) {
        $this->secteurs[$y][$x]->setSecteurType(99);
        $this->asteroidesPop();
        $t=10;
    	}
    $t++;
    }
    // recherche du point de pop des autres joueurs
    $nb_niv = intval(TAILLE_MAP_COTE/(2*COEF_POPULATION)); // nb de niveaux de pop à générer
    $z=1;
    for ($niv=1;$niv<=$nb_niv;$niv++) {
    		$s=1;
    		while ($s<=(8*$niv)) {
    			$this->x_pos=$this->x_depart + (COEF_POPULATION*self::DECALAGE_X[$niv][$s]) + rand(-1,1);
    			$this->y_pos=$this->y_depart + (COEF_POPULATION*self::DECALAGE_Y[$niv][$s]) + rand(-1,1);
    			$t=0;
    			while ($t<10) {
            $x = $this->x_pos + self::DECALAGE_X[0][$t];
            $y = $this->y_pos + self::DECALAGE_Y[0][$t];
            if ($this->secteurs[$y][$x]->getSecteurType() == 0) {
              $this->secteurs[$y][$x]->setSecteurType(99);
              $this->secteurs[$y][$x]->setSecteurOrdre($z);
              $this->asteroidesPop();
    					$t=10;
    					$z++;
    				}
    				$t++;
    			}
    			$s++;
    		}
    	}

  }

  private function asteroidesPop() {
    $sect_vol=VOLUME_SECTEUR_POP;
    // calcul de l'astéroide de la base:
    $min_base=rand(MINERAI_BASE_MIN,MINERAI_BASE_MAX);
    new Asteroid($min_base);
    $sect_vol-=VOLUME_ASTEROIDE_BASE;
    // calcul des autres astéroides du secteur
    $i=0;
    while ($sect_vol<>0) {
      if (rand(1,100)<=ASTEROIDE_TAUX[$i] AND $sect_vol-ASTEROIDE_VOLUME[$i]>=0) {
        new Asteroid(rand(MINERAI_VOLUME_MIN[$i],MINERAI_VOLUME_MAX[$i]));
        $sect_vol-=ASTEROIDE_VOLUME[$i];
      }
      $i++;
      if ($i==count(ASTEROIDE_VOLUME)) {
        $i=0;
      }
    }
  }

  public function getSecteurs() {
    return $this->secteurs;
  }
}


?>
