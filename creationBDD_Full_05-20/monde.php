<?php
include_once ("constantes_carte.php");
class Monde {
  private $sql;
  private $secteurs = array(array());
  private $x_pos=0;
  private $y_pos=0;
  private $x_depart;
  private $y_depart;

  const DECALAGE_X = array([0,-1,-1,0,1,1,1,0,-1], [0,-1,-1,0,1,1,1,0,-1], [0,-2,-2,-2,-1,0,1,2,2,2,2,2,1,0,-1,-2,-2], [0,-3,-3,-3,-3,-2,-1,0,1,2,3,3,3,3,3,3,3,2,1,0,-1,-2,-3,-3,-3], [0,-4,-4,-4,-4,-4,-3,-2,-1,0,1,2,3,4,4,4,4,4,4,4,4,4,3,2,1,0,-1,-2,-3,-4,-4,-4,-4], [0,-5,-5,-5,-5,-5,-5,-4,-3,-2,-1,0,1,2,3,4,5,5,5,5,5,5,5,5,5,5,5,4,3,2,1,0,-1,-2,-3,-4,-5,-5,-5,-5,-5]);
  const DECALAGE_Y = array([0,0,-1,-1,-1,0,1,1,1], [0,0,-1,-1,-1,0,1,1,1], [0,0,-1,-2,-2,-2,-2,-2,-1,0,1,2,2,2,2,2,1], [0,0,-1,-2,-3,-3,-3,-3,-3,-3,-3,-2,-1,0,1,2,3,3,3,3,3,3,3,2,1], [0,0,-1,-2,-3,-4,-4,-4,-4,-4,-4,-4,-4,-4,-3,-2,-1,0,1,2,3,4,4,4,4,4,4,4,4,4,3,2,1], [0,0,-1,-2,-3,-4,-5,-5,-5,-5,-5,-5,-5,-5,-5,-5,-5,-4,-3,-2,-1,0,1,2,3,4,5,5,5,5,5,5,5,5,5,5,5,4,3,2,1]);


  public function __construct() {
    $this->x_depart = intval(TAILLE_MAP_COTE/2)+1;
    $this->y_depart = intval(TAILLE_MAP_COTE/2)+1;
    $this->sql = database::getInstance();
    $this->generer_nouveau_monde();
  }

  private function generer_nouveau_monde() {
    $this->sql->vidageTables(); // -------------------> !!! vide toutes les tables bdd des objet sde la carte !!!
    for($x = 1; $x<=TAILLE_MAP_COTE; $x++){
      for($y = 1; $y<=TAILLE_MAP_COTE; $y++) {
        $this->secteurs[$x][$y] = new Secteur($x, $y, true);
      }
    }
    $this->generer_point_pop();
  }


  private function generer_point_pop() {
    // recherche du point de pop du 1er joueur
    $t=0;
    while ($t<10) {
      $posX = $this->x_depart + self::DECALAGE_X[0][$t];
      $posY = $this->y_depart + self::DECALAGE_Y[0][$t];
      $secteurId = $this->sql->getSecteurId ($posX, $posY);
      $secteurType = $this->sql->getSecteurType ($secteurId);
      if ($secteurType == 0) {
        $this->sql->modifieSecteurType ($secteurId, 99);
        $this->ajoutAsteroidesPop($posX, $posY);
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
    			$x=$this->x_depart + (COEF_POPULATION*self::DECALAGE_X[$niv][$s]) + rand(-1,1);
    			$y=$this->y_depart + (COEF_POPULATION*self::DECALAGE_Y[$niv][$s]) + rand(-1,1);
    			$t=0;
    			while ($t<10) {
            $posX = $x + self::DECALAGE_X[0][$t];
            $posY = $y + self::DECALAGE_Y[0][$t];
            $secteurId = $this->sql->getSecteurId ($posX, $posY);
            $secteurType = $this->sql->getSecteurType ($secteurId);
            if ($secteurType == 0) {
              $this->sql->modifieSecteurOrdre ($secteurId, $z);
              $this->sql->modifieSecteurType ($secteurId, 99);
              $this->ajoutAsteroidesPop($posX, $posY);
    					$t=10;
    					$z++;
    				}
    				$t++;
    			}
    			$s++;
    		}
    	}
  }

  private function ajoutAsteroidesPop($posX, $posY) {
    $nom ='S.'.$posX.'.'.$posY.'-Base'; // ----------------------------------->> A adapter
    new AsteroidBase($posX, $posY, $nom);
    // calcul des autres astéroides du secteur
    $sect_vol = VOLUME_SECTEUR_POP - VOLUME_ASTEROIDE_BASE;
    $i=0; $n=1;
    while ($sect_vol<>0) {
      if (rand(1,100)<=ASTEROIDE_TAUX[$i] AND $sect_vol-ASTEROIDE_VOLUME[$i]>=0) {
        $nom ='S.'.$posX.'.'.$posY.'-A'.$n; // ----------------------------------->> A adapter
        new Asteroid($posX, $posY, $i, $nom);
        $sect_vol-=ASTEROIDE_VOLUME[$i];
        $n++;
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
