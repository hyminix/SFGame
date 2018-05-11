<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?php

function calcul_minerai($ast_vol) {
	include 'Constantes_Carte.php';
	$liste_minerais= array(0,0,0,0,0,0,0,0);
	$i=1;
	While ($ast_vol>=0) {
		$tirage=rand(1,100);
		If ($tirage<=$MI_TAUX[$i]) {
			//echo $mi_name[$i].' : '.$tirage.'<br>';
			$vol=rand(20,25);
			$ast_vol -= $vol;
			$liste_minerais[$i-1]+=$vol;		
		}
		$i++;
		if ($i==9) {
			$i=1;
		}
	}
	return $liste_minerais;
}
?>