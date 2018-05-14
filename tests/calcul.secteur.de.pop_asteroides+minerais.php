<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<?php
include 'calcul_minerai.php';
include 'constantes_carte.php';

$sect_vol=$SEC_AS_VOL_POP;
echo "Volume total d'astéroides du secteur: ".$sect_vol."<br><br>";

// calcul de l'astéroide de la base:
$min_tot=rand($AS_BASE_MI_VOL_MIN,$AS_BASE_MI_VOL_MAX);
echo 'Volume asteroide: '.$AS_BASE_VOL.' ---> Volume total de minerai: '.$min_tot."<br>";
$liste_minerais=calcul_minerai($min_tot);
foreach ($liste_minerais as $cle=>$valeur) {
	echo $MI_NOM[$cle+1].': '.$valeur.'<br>';
}
echo '<br>';
$sect_vol-=$AS_BASE_VOL;

// calcul des autres asteroides
$i=1;
while ($sect_vol<>0) {
	if (rand(1,100)<=$AS_TAUX[$i] AND $sect_vol-$AS_VOL[$i]>=0) {
		$min_tot=rand($AS_MI_VOL_MIN[$i],$AS_MI_VOL_MAX[$i]);
		echo 'Volume asteroide: '.$AS_VOL[$i].' ---> Volume total de minerai: '.$min_tot."<br>";
		$liste_minerais=calcul_minerai($min_tot);
		foreach ($liste_minerais as $cle=>$valeur) {
			echo $MI_NOM[$cle+1].': '.$valeur.'<br>';
		}
		echo '<br>';
		$sect_vol-=$AS_VOL[$i];
	}
	$i++;
	if ($i==7) {
		$i=1;
	}
}

?>
