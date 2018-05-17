<?php
include_once ("constantes_carte.php");

class Asteroid {
  private $asteroideId;
  private $volumeMinerai;
  private $minerais ; // array(minerai)
  private $liste_minerais= array();

  public function __construct($volumeMinerai, $asteroideId) {
    $this->volumeMinerai = $volumeMinerai;
    $this->asteroideId = $asteroideId;
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
    $i=0; // type de minerai
    foreach($this->liste_minerais as $arrayQuantiteMinerai) {
      array_push($this->minerais, new Minerai($i, $arrayQuantiteMinerai, $asteroideId));
      $i++;
    }
  }

  public function getAsteroideMinerai() {
    return $this->minerais;
  }

}


?>
