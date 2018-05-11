<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<?php
include 'constantes_carte.php';

// --------------------- génération de la carte ---------------------
$val_secteur = array(array());
for ($y=1;$y<=$MAP_COTE;$y++) {
	for ($x=1;$x<=$MAP_COTE;$x++) {
		$val_secteur[$x][$y]=0;
		$type=rand(1,1000);
		if ($type<=$SEC_TAUX[1]) {
			$val_secteur[$x][$y]=1;
		}
		if ($type<=$SEC_TAUX[2]) {
			$val_secteur[$x][$y]=2;
		}
		if ($type<=$SEC_TAUX[3]) {
			$val_secteur[$x][$y]=3;
		}
		if ($type<=$SEC_TAUX[4]) {
			$val_secteur[$x][$y]=4;
		}
	}
}

// --------------------- recherche des points de pop ---------------------

// initialisation des décalages de pop
$x_dec= array();
$y_dec= array();
$x_dec[0] = array(0,-1,-1,0,1,1,1,0,-1);
$y_dec[0] = array(0,0,-1,-1,-1,0,1,1,1);
$x_dec[1] = array(0,-1,-1,0,1,1,1,0,-1);
$y_dec[1] = array(0,0,-1,-1,-1,0,1,1,1);
$x_dec[2] = array(0,-2,-2,-2,-1,0,1,2,2,2,2,2,1,0,-1,-2,-2);
$y_dec[2] = array(0,0,-1,-2,-2,-2,-2,-2,-1,0,1,2,2,2,2,2,1);
$x_dec[3] = array(0,-3,-3,-3,-3,-2,-1,0,1,2,3,3,3,3,3,3,3,2,1,0,-1,-2,-3,-3,-3);
$y_dec[3] = array(0,0,-1,-2,-3,-3,-3,-3,-3,-3,-3,-2,-1,0,1,2,3,3,3,3,3,3,3,2,1);
$x_dec[4] = array(0,-4,-4,-4,-4,-4,-3,-2,-1,0,1,2,3,4,4,4,4,4,4,4,4,4,3,2,1,0,-1,-2,-3,-4,-4,-4,-4);
$y_dec[4] = array(0,0,-1,-2,-3,-4,-4,-4,-4,-4,-4,-4,-4,-4,-3,-2,-1,0,1,2,3,4,4,4,4,4,4,4,4,4,3,2,1);
$x_dec[5] = array(0,-5,-5,-5,-5,-5,-5,-4,-3,-2,-1,0,1,2,3,4,5,5,5,5,5,5,5,5,5,5,5,4,3,2,1,0,-1,-2,-3,-4,-5,-5,-5,-5,-5);
$y_dec[5] = array(0,0,-1,-2,-3,-4,-5,-5,-5,-5,-5,-5,-5,-5,-5,-5,-5,-4,-3,-2,-1,0,1,2,3,4,5,5,5,5,5,5,5,5,5,5,5,4,3,2,1);

// recherche du point de pop du 1er joueur
$x_depart= $MAP_COTE/2;
$y_depart= $MAP_COTE/2;
$t=0;
while ($t<10) {
	if ($val_secteur[$x_depart+$x_dec[0][$t]][$y_depart+$y_dec[0][$t]]==0) {
		$val_secteur[$x_depart+$x_dec[0][$t]][$y_depart+$y_dec[0][$t]]=10;
		$t=10;
	}
$t++;
}
// recherche du point de pop des autres joueurs
$nb_niv = intval($MAP_COTE/(2*$MAP_POP_COEF)); // nb de niveaux de pop à générer
echo 'nb de niveaux:'.$nb_niv;
$z=1;
for ($niv=1;$niv<=$nb_niv;$niv++) {
		$s=1;
		while ($s<=(8*$niv)) {
			$x_pox=$x_depart + ($MAP_POP_COEF*$x_dec[$niv][$s]) + rand(-1,1);
			$y_pox=$y_depart + ($MAP_POP_COEF*$y_dec[$niv][$s]) + rand(-1,1);
			$t=1;
			while ($t<10) {
				if ($val_secteur[$x_pox+$x_dec[0][$t]][$x_pox+$y_dec[0][$t]]==0) {
					$val_secteur[	$x_pox+$x_dec[0][$t]][$y_pox+$y_dec[0][$t]]=10+$z;
					$t=10;
					$z++;
				}
				$t++;
			}
			$s++;
		}
	}


// --------------------- affichage de la carte ---------------------
echo '<table border="1"><tr>';
for ($y=1;$y<=$MAP_COTE;$y++) {
	echo '<tr>';
	for ($x=1;$x<=$MAP_COTE;$x++) {
		switch ($val_secteur[$x][$y]) {
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
	echo '<td height="20" width="20" bgcolor="'.$color.'" title="'.$x.'-'.$y.'"><div align="center">'.$val_secteur[$x][$y].'</div></td>';
	}
	echo '</tr>';
}
echo '</table>';


?>
