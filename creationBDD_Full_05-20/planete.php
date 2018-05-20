<?php
include_once ("constantes_carte.php");

class Planete {
  private $sql;
  private $planeteId;
  private $lune;
  private $matiere;
  private $diametre;
  private $coefMinage;
  private $volumeMinerai;
  private $minerais ; // array(minerai)
  private $liste_minerais= array();

  public function __construct($posX, $posY, $lune) {
    $this->sql = database::getInstance();
    $this->lune = 0;
    $mat=rand(1,100);
    $t=0;$n=0;
	  while ($t<100)   { // tirage du type de planete
      $t+=TAUX_TYPE_PLANETE[$n];
  		if ($mat<=$t){
  			$this->matiere = $n;
        $this->coefMinage = COEF_MINAGE_PLANETE[$n];
        if ($lune==1) {
          $lune_coef = rand(LUNE_COEF_MIN,LUNE_COEF_MAX);
          $this->diametre = rand(DIAMETRE_PLANETE_MIN[$n],DIAMETRE_PLANETE_MAX[$n])/$lune_coef;
          $this->volumeMinerai = rand(MINERAI_PLANETE_MIN[$n],MINERAI_PLANETE_MAX[$n])/$lune_coef;
          $nom ='S.'.$posX.'.'.$posY.'-L'.$n; // ----------------------------------->> A adapter
        } else {
          $this->diametre = rand(DIAMETRE_PLANETE_MIN[$n],DIAMETRE_PLANETE_MAX[$n]);
          $this->volumeMinerai = rand(MINERAI_PLANETE_MIN[$n],MINERAI_PLANETE_MAX[$n]);
          $nom ='S.'.$posX.'.'.$posY.'-P'.$n; // ----------------------------------->> A adapter
        }
    		$t=100;
        $secteurId = $this->sql->getSecteurId ($posX, $posY);
        $this->planeteId = $this->sql->ajoutPlanete ($secteurId, $this->diametre, $this->matiere, $nom, $lune);
  		}
	    $n++;
    }
    $nb_type_minerai = count (NOM_MINERAI);
    for ($i=0;$i<$nb_type_minerai;$i++) { // initialise la liste en fonction du nb de type de minerais
      array_push ($this->liste_minerais,0);
    }
    $this->minerais = array();
    $i=0;
    //while($this->volumeMinerai>=0) {
    while($this->volumeMinerai>0) {
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
      array_push($this->minerais, new Minerai($i, $arrayQuantiteMinerai, $this->planeteId,1));
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
