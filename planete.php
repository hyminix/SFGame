<?php
include_once ("constantes_carte.php");

class Planete {

  private $type;
  private $matiere;
  private $diametre;
  private $coefMinage;
  private $volumeMinerai;
  private $minerais ; // array(minerai)
  private $liste_minerais= array();

  //const MINERAI_NOM = ["Or","Argent","Plomb","Uranium","Cuivre","Titane","Aluminium","Fer"];
  //const MINERAI_TAUX = [2,5,10,15,30,40,50,70];
  //const MINERAI_NB = 8;

  // const MATIERE_PLANETE = ["Hydrogen","Hélium","Eau","Acides","Lave en fusion","Roche","Ammoniac solide","Méthane solide","Glace","Carbone"];
  //const DIAMETRE_PLANETE_MIN = [20000,20000,3000,3000,3000,3000,3000,3000,3000,2000];
  //const DIAMETRE_PLANETE_MAX = [60000,60000,8000,8000,8000,8000,10000,10000,8000,5000];
  //const MINERAI_PLANETE_MIN = [0,0,100000,100000,100000,100000,100000,100000,100000,50000];
  //const MINERAI_PLANETE_MAX = [0,0,200000,200000,200000,200000,300000,300000,200000,100000];
  //const COEF_MINAGE_PLANETE = [0,0,65,25,10,80,25,25,50,15];
  //const TAUX_TYPE_PLANETE = [25,15,5,10,10,15,10,5,5,5];

  public function __construct() {
    $this->type = 'Planète';
    $mat=rand(1,100);
    $t=0;$n=0;
	  while ($t<100)   { // tirage du type de planete
      $t+=TAUX_TYPE_PLANETE[$n];
  		if ($mat<=$t){
  			$this->matiere = MATIERE_PLANETE[$n];
        $this->diametre = rand(DIAMETRE_PLANETE_MIN[$n],DIAMETRE_PLANETE_MAX[$n]);
        $this->volumeMinerai = rand(MINERAI_PLANETE_MIN[$n],MINERAI_PLANETE_MAX[$n]);
        $this->coefMinage = COEF_MINAGE_PLANETE[$n];
  			$t=100;
  		}
	    $n++;
    }
    $nb_type_minerai = count (NOM_MINERAI);
    for ($i=0;$i<$nb_type_minerai;$i++) { // initialise la liste en fonction du nb de type de minerais
      array_push ($this->liste_minerais,0);
    }
    $this->minerais = array();
    $i=0;
    while($this->volumeMinerai>=0) {
      if(rand(1,100)<=TAUX_MINERAI[$i]) {
        $vol=rand(20,25);
        $this->volumeMinerai -= $vol;
        $this->liste_minerais[$i]+=$vol;
      }
      $i++;
      if ($i==$nb_type_minerai) {
        $i=0;
       }
     }
    $i=0;
    foreach($this->liste_minerais as $arrayQuantiteMinerai) {
      array_push($this->minerais, new Minerai($i, $arrayQuantiteMinerai));
      $i++;
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
  public function getPlaneteMinerai() {
    return $this->minerais;
  }
}


?>
