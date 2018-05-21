<?php
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
  $timestamp_debut = microtime(true);
  $monde = new Monde();
  $timestamp_fin = microtime(true);
  $dureeScript=intval($timestamp_fin - $timestamp_debut);
  echo '<br><br> Durée de génération: '.$dureeScript.' secondes';
  echo '<br><br><a href="visu_carte.php"> Voir la carte</a>';

  $secteursMonde = $monde->getSecteurs();
  echo "<br><br><br><table>";
  foreach ($secteursMonde as $secteurs) {
    echo "<tr>";
     foreach ($secteurs as $sec) {
       switch ($sec->getSecteurType()) {
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
         case '99':
           $color="#FFFF00";
           break;
         default:
           $color="#FFFFFF";
           break;
       }

       echo '<td width=20 bgcolor="'.$color.'" >';
       echo "<div class='tooltip'>".$sec->getSecteurType()."";
          echo "<span class='tooltiptext'>";
            echo "Pos X: ".$sec->getPosX()."<br />";
            echo "Pos Y: ".$sec->getPosY()."<br />";
            echo "Volume: ".$sec->getSecteurVolume()."<br />";
            echo "Ordre pop: ".$sec->getSecteurOrdre()."<br />";
          echo "</span>";
        echo "</div>";
     }
     echo "</tr>";
  }
  echo "</table>";


 ?>

</body>
</html>
