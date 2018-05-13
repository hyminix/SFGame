<?php

class Planete {

  private $type;
  private $matiere;
  private $diametre;
  private $coefMinage;
  private $volumeMinerai;

  private $minerais ; // array(minerai)
  private $liste_minerais= array(0,0,0,0,0,0,0,0,0,0);

  const MINERAI_NOM = ["Or","Argent","Plomb","Uranium","Cuivre","Titane","Aluminium","Fer"];
  const MINERAI_TAUX = [2,5,10,15,30,40,50,70];
  const MINERAI_NB = 8;

  const MATIERE_PLANETE = ["Hydrogen","Hélium","Eau","Acides","Lave en fusion","Roche","Ammoniac solide","Méthane solide","Glace","Carbone"];
  const DIAMETRE_PLANETE_MIN = [20000,20000,3000,3000,3000,3000,3000,3000,3000,2000];
  const DIAMETRE_PLANETE_MAX = [60000,60000,8000,8000,8000,8000,10000,10000,8000,5000];
  const MINERAI_PLANETE_MIN = [0,0,100000,100000,100000,100000,100000,100000,100000,50000];
  const MINERAI_PLANETE_MAX = [0,0,200000,200000,200000,200000,300000,300000,200000,100000];
  const PLANETE_COEF_MINAGE = [0,0,65,25,10,80,25,25,50,15];
  const TAUX_PLANETE = [25,15,5,10,10,15,10,5,5,5];

  public function __construct() {
    $this->type = 'Planète';
    $mat=rand(1,100);
    $t=0;$n=0;
	  while ($t<100)   {
      $t+=self::TAUX_PLANETE[$n];
  		if ($mat<=$t){
  			$this->matiere = self::MATIERE_PLANETE[$n];
        $this->diametre = rand(self::DIAMETRE_PLANETE_MIN[$n],self::DIAMETRE_PLANETE_MAX[$n]);
        $this->volumeMinerai = rand(self::MINERAI_PLANETE_MIN[$n],self::MINERAI_PLANETE_MAX[$n]);
        $this->coefMinage = self::PLANETE_COEF_MINAGE[$n];
  			$t=100;
  			// if ($minerai_corps>0) {
  			// 	$liste_minerais=calcul_minerai($minerai_corps);
  			// 	foreach ($liste_minerais as $cle=>$valeur) {
  			// 		echo $MI_NOM[$cle+1].': '.$valeur.'<br>';
  			// 	}
  			// }
  		}
	    $n++;
    }
  }

  public function getPlaneteType() {
    return $this->type;
  }
  public function getPlaneteMatiere() {
    return $this->matiere;
  }
  public function getPlaneteDiametre() {
    return $this->diametre;
  }
}

?>
