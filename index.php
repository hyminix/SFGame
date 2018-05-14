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
  if(!isset($_GET['posx'])) {
    $monde = new Monde();
  }
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
       // echo "<a href='index.php?posx=".$sec->getPosX()."&posy=".$sec->getPosY()."'>S</a>";
       echo "</td>";
     }
     echo "</tr>";
  }
  echo "</table>";


 ?>

</body>
</html>
