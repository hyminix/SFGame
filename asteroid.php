<?php

class Asteroid {

  private $volumeMinerai;
  private $minerais ; // array(minerai)
  private $liste_minerais= array(0,0,0,0,0,0,0,0);

  const MINERAI_NOM = ["Or","Argent","Plomb","Uranium","Cuivre","Titane","Aluminium","Fer"];
  const MINERAI_TAUX = [2,5,10,15,30,40,50,70];
  const MINERAI_NB = 8;

  public function __construct($volumeMinerai) {
    $this->volumeMinerai = $volumeMinerai;
    $this->minerais = array();
    $i=0;
  	while($this->volumeMinerai>=0) {
  		if(rand(1,100)<=self::MINERAI_TAUX[$i]) {
        $vol=rand(20,25);
  			$this->volumeMinerai -= $vol;
  			$this->liste_minerais[$i]+=$vol;
  		}
  		$i++;
  		if ($i==self::MINERAI_NB) {
  			$i=0;
  	   }
     }
    $i=0;
    foreach($this->liste_minerais as $arrayQuantiteMinerai) {
      array_push($this->minerais, new Minerai($i, $arrayQuantiteMinerai));
      $i++;
    }
  }

  public function getAsteroideMinerai() {
    return $this->minerais;
  }

}

?>
