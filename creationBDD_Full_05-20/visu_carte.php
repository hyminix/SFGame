<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?php
include_once ("constantes_carte.php");
spl_autoload_register(function ($class_name) {
    include $class_name . '.php';
});
?>

<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Space</title>
  <link rel="stylesheet" href="style.css">
  <script src="script.js"></script>
</head>
<body>


<?php
  $sql = database::getInstance();
  //$monde = new Monde();

  // --------------------- affichage de la carte ---------------------
  echo '<table border="1"><tr>';
  for ($y=1;$y<=TAILLE_MAP_COTE;$y++) {
  	echo '<tr>';
  	for ($x=1;$x<=TAILLE_MAP_COTE;$x++) {
      $secteurId = $sql->getSecteurId($x,$y);
      $secteurType = $sql->getSecteurType($secteurId);
  		switch ($secteurType) {
  			case '0':
  				$color="#FFFFFF";
  				break;
  			case '1':
  				$color="#AAAAAA";
  				break;
  			case '2':
  				$color="#0000FF";
  				break;
  			case '3':
  				$color="#FF0000";
  				break;
  			case '4':
  				$color="#000000";
  				break;
  			case '10':
  				$color="#00FF00";
  				break;
  			default:
  				$color="#FFFF00";
  				break;
  		}
  	echo '<td height="20" width="20" bgcolor="'.$color.'" title="'.$x.'-'.$y.'"><div align="center"><a href="visu_carte.php?sid='.$secteurId.'">'.$secteurType.'</div></td>';
  	}
  	echo '</tr>';
  }
  echo '</table>';

if (isset($_GET['sid'])) {
  $id= $_GET['sid'];
} else {
  $id=0;
}

if ($id<>0) {
  echo '<br> Id du secteur: '.$id;
  $type=$sql->getSecteurType($id);
  echo '<br> Type de secteur: '.$type.' - '.$sql->getNomSecteurType($type);
  echo '<br> Ordre de pop: '.$sql->getSecteurOrdre($id);
  echo '<br><br><b> Contenu du secteur:</b>';

  if ($type==1 or $type==99) { // Asteroides ou pop
    foreach ($sql->getSecteurAsteroide($id) as $asteroideId) {
      echo '<br><br><u>Asteroides '.$asteroideId.':</u> '.$sql->getAsteroideNom($asteroideId) ;
      echo '<br> Taille: '.$sql->getAsteroideTaille($asteroideId).' m';
      echo '<br> Id Minerais: ';
      foreach ($sql->getAsteroideMinerai($asteroideId) as $mineraiId) {
        echo $mineraiId.' - ';
      }
    }
  }
  if ($type==2) { // planetes
    foreach ($sql->getSecteurPlanete($id) as $planeteId) {
      echo '<br><br><u>Planete '.$planeteId.':</u> '.$sql->getPlaneteNom($planeteId) ;
      echo '<br> Diametre: '.$sql->getPlaneteDiametre($planeteId).' km';
      echo '<br> Matière: '.MATIERE_PLANETE[$sql->getPlaneteMatiere($planeteId)];
      echo '<br> Efficacité du minage: '.COEF_MINAGE_PLANETE[$sql->getPlaneteMatiere($planeteId)].' %';
      echo '<br> Id Minerais: ';
      foreach ($sql->getPlaneteMinerai($planeteId) as $mineraiId) {
        echo $mineraiId.' - ';
      }
    }
  }
}
if ($type==3) { // epaves
  foreach ($sql->getSecteurEpave($id) as $epaveId) {
    echo '<br><br><u>Epave '.$epaveId.':</u> '.$sql->getEpaveNom($epaveId) ;
    echo '<br> Type: '.NOM_EPAVE[$sql->getEpaveType($epaveId)];
    echo '<br> Masse: '.$sql->getEpaveMasse($epaveId).' tonnes';
    echo '<br> Id Matériaux récupérables: ';
    foreach ($sql->getEpaveMateriau($epaveId) as $materiauId) {
      echo $materiauId.' - ';
    }
  }
}



 ?>

</body>
</html>
