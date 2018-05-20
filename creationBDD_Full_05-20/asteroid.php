<?php
include_once ("constantes_carte.php");

class Asteroid {
  private $sql;
  private $asteroideId;
  private $volumeMinerai;
  private $minerais ; // array(minerai)
  private $liste_minerais= array();

  public function __construct($posX, $posY, $type, $nom) {
    $this->sql = database::getInstance();
    $this->volumeMinerai = rand(MINERAI_VOLUME_MIN[$type], MINERAI_VOLUME_MAX[$type]);
    $taille = rand(ASTEROIDE_TAILLE_MIN[$type],ASTEROIDE_TAILLE_MAX[$type]);
    $secteurId = $this->sql->getSecteurId ($posX, $posY);
    $this->asteroideId = $this->sql->ajoutAsteroide($secteurId, $taille, $nom);
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
    $type=0; // type de minerai
    foreach($this->liste_minerais as $arrayQuantiteMinerai) {
      array_push($this->minerais, new Minerai($type, $arrayQuantiteMinerai, $this->asteroideId,0));
      $type++;
    }
  }

  public function getAsteroideMinerai() {
    return $this->minerais;
  }

}


?>
