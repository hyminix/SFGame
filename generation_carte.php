<?php

function generation_carte() {

  // Définition des constantes
  $tauxAsteroid = 15;
  $tauxPlanete = 3;
  $tauxVaisseau = 2;

  $randAsteroide = rand(1,100);
  if($randAsteroide <= $tauxAsteroid) {
    return "asteroid";
  }

  $randPlanete = rand(1,100);
  if($randPlanete <= $tauxPlanete) {
    return "planete";
  }

  $randVaisseau = rand(1,100);
  if($randVaisseau <= $tauxVaisseau) {
    return "vaisseau";
  }

  return "vide";

}

?>
