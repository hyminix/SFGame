<?php

class Monde {

  private $secteurs = array(array());
  private $x_pos=0;
  private $y_pos=0;

  const TAILLE_MAP_LARGEUR = 45;
  const TAILLE_MAP_HAUTEUR = 45;
  const COEF_POPULATION = 9; // coef de population= nb de secteurs moyen entre 2 joueurs

  const DECALAGE_X = array([0,-1,-1,0,1,1,1,0,-1], [0,-1,-1,0,1,1,1,0,-1], [0,-2,-2,-2,-1,0,1,2,2,2,2,2,1,0,-1,-2,-2], [0,-3,-3,-3,-3,-2,-1,0,1,2,3,3,3,3,3,3,3,2,1,0,-1,-2,-3,-3,-3], [0,-4,-4,-4,-4,-4,-3,-2,-1,0,1,2,3,4,4,4,4,4,4,4,4,4,3,2,1,0,-1,-2,-3,-4,-4,-4,-4], [0,-5,-5,-5,-5,-5,-5,-4,-3,-2,-1,0,1,2,3,4,5,5,5,5,5,5,5,5,5,5,5,4,3,2,1,0,-1,-2,-3,-4,-5,-5,-5,-5,-5]);

  const DECALAGE_Y = array([0,0,-1,-1,-1,0,1,1,1], [0,0,-1,-1,-1,0,1,1,1], [0,0,-1,-2,-2,-2,-2,-2,-1,0,1,2,2,2,2,2,1], [0,0,-1,-2,-3,-3,-3,-3,-3,-3,-3,-2,-1,0,1,2,3,3,3,3,3,3,3,2,1], [0,0,-1,-2,-3,-4,-4,-4,-4,-4,-4,-4,-4,-4,-3,-2,-1,0,1,2,3,4,4,4,4,4,4,4,4,4,3,2,1], [0,0,-1,-2,-3,-4,-5,-5,-5,-5,-5,-5,-5,-5,-5,-5,-5,-4,-3,-2,-1,0,1,2,3,4,5,5,5,5,5,5,5,5,5,5,5,4,3,2,1]);

  private $x_depart= self::TAILLE_MAP_LARGEUR/2;
  private $y_depart= self::TAILLE_MAP_HAUTEUR/2;

  public function __construct() {
    for($i = 0; $i < self::TAILLE_MAP_LARGEUR; $i++){
      for($j = 0; $j < self::TAILLE_MAP_HAUTEUR; $j++) {
        $this->secteurs[$j][$i] = new Secteur($j, $i);
      }
    }

    $this->generer_point_pop();
  }


  private function generer_point_pop() {

    // recherche du point de pop du 1er joueur
    $t=0;
    while ($t<10) {
        if ($this->secteurs[$this->y_depart+self::DECALAGE_Y[0][$t]][$this->x_depart+self::DECALAGE_X[0][$t]]->getSecteurType() == 0) {
          $this->secteurs[$this->y_depart+self::DECALAGE_Y[0][$t]][$this->x_depart+self::DECALAGE_X[0][$t]]->setSecteurType(99);
    		$t=10;
    	}
    $t++;
    }
    // recherche du point de pop des autres joueurs
    $nb_niv = intval(self::TAILLE_MAP_HAUTEUR/(2*self::COEF_POPULATION)); // nb de niveaux de pop à générer
    $z=1;
    for ($niv=1;$niv<=$nb_niv;$niv++) {
    		$s=1;
    		while ($s<=(8*$niv)) {
    			$this->x_pos=$this->x_depart + (self::COEF_POPULATION*self::DECALAGE_X[$niv][$s]) + rand(-1,1);
    			$this->y_pos=$this->y_depart + (self::COEF_POPULATION*self::DECALAGE_Y[$niv][$s]) + rand(-1,1);
    			$t=0;
    			while ($t<10) {
    				if ($this->secteurs[$this->x_pos+self::DECALAGE_X[0][$t]][$this->y_pos+self::DECALAGE_Y[0][$t]]->getSecteurType() == 0) {
    						$this->secteurs[$this->x_pos+self::DECALAGE_X[0][$t]][$this->y_pos+self::DECALAGE_Y[0][$t]]->setSecteurType(99);
                // Ajouter dans l'objet base l'index de pop (ordre de pop)
    					$t=10;
    					$z++;
    				}
    				$t++;
    			}
    			$s++;
    		}
    	}

  }

  public function getSecteurs() {
    return $this->secteurs;
  }
}


?>
