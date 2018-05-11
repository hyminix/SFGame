<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<?php
include 'constantes_carte.php';

// tirage du type d'épave:
$epave=rand(1,100);
$t=0;$type=0;
while ($t<100) {
	$t+=$EPA_TAUX[$type];
	if ($epave<=$t) {
		$type_epave=$EPA_NOM[$type];
		$t=100;
	} else {
		$type++;
	}
}

// tirage du nbre d'épaves:
$nb_epave=rand($EPA_NB_MIN[$type],$EPA_NB_MAX[$type]);
echo $nb_epave.' épaves<br>';
for ($i=1;$i<=$nb_epave;$i++) {
		$mat_epave=rand($EPA_MAT_VOL_MIN[$type],$EPA_MAT_VOL_MAX[$type]);
		$matalien_epave=rand($EPA_MATALIEN_VOL_MIN[$type],$EPA_MATALIEN_VOL_MAX[$type]);
	echo "<b>Type d'épave: ".$type_epave."</b><br>";
	echo "Matériaux récupérables: ".$mat_epave." tonnes<br>";
	echo "Matériaux alien récupérables: ".$matalien_epave." tonnes<br>";
	$liste_mat=calculMatEpave($mat_epave*1000,$matalien_epave*1000); // *1000 pour passer en kg
	foreach ($liste_mat as $cle=>$valeur) {
		echo $MAT_NOM[$cle].': '.$valeur.' kg<br>';
	}
	echo '<br>';
}


function calculMatEpave($mat,$matalien) {
	include 'constantes_carte.php';
	$nb_mat=0;
	$liste_mat=array();
	foreach ($MAT_NOM as $cle=>$valeur) {
		array_push($liste_mat,0);
		$nb_mat++;
	}
	$i=0;
	While ($mat>0) {
		if ($MAT_ORI[$i]==0) { // test si materiau humain
			$tirage=rand(1,1000);
			If ($tirage<=$MAT_EPA_TAUX[$i]) {
				$mat-=$MAT_MODU[$i];
				$liste_mat[$i]+=$MAT_MODU[$i];
			}
		}
		$i++;
		if ($i==$nb_mat) {
			$i=0;
		}
	}
	$i=0;
	While ($matalien>0) {
		if ($MAT_ORI[$i]==1) { // test si materiau alien
			$tirage=rand(1,1000);
			If ($tirage<=$MAT_EPA_TAUX[$i]) {
				$matalien-=$MAT_MODU[$i];
				$liste_mat[$i]+=$MAT_MODU[$i];
			}
		}
		$i++;
		if ($i==$nb_mat) {
			$i=0;
		}
	}
	return $liste_mat;
}

?>
