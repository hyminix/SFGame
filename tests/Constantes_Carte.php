<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?php
// ============================== VARIABLES DE la carte ==============================
$MAP_COTE=100; // nbre de secteurs par cot� de la carte (ex:30 -> 30x30=90 secteurs)
$MAP_POP_COEF=9; // coef de popultation= nb de secteurs moyen entre 2 joueurs

// ============================== VARIABLES DES SECTEURS ==============================
$SEC_TYPE_NB=4;

// Chance de trouver chaque type de secteur (pour 1000):
$SEC_TAUX[1]=250; // asteroides
$SEC_TAUX[2]=30; // planetes
$SEC_TAUX[3]=15; // epaves
$SEC_TAUX[4]=3; // trou noir

$SEC_AS_VOL_MIN=20; // volume minimum d'asteroide d'un secteur de type asteroide
$SEC_AS_VOL_MAX=40; // volume maximum d'asteroide d'un secteur de type asteroide
$SEC_AS_VOL_POP=20; // volume d'asteroides d'un secteur de pop

// ============================== VARIABLES DES ASTEROIDES ==============================
$AS_TYPE_NB=6;

// Chance de trouver chaque type d'asteroide:
$AS_TAUX[1]=2;
$AS_TAUX[2]=7;
$AS_TAUX[3]=12;
$AS_TAUX[4]=30;
$AS_TAUX[5]=40;
$AS_TAUX[6]=50;

// Volume dans le secteur de chaque type d'asteroide:
$AS_VOL[1]=20;
$AS_VOL[2]=12;
$AS_VOL[3]=8;
$AS_VOL[4]=5;
$AS_VOL[5]=2;
$AS_VOL[6]=1;
$AS_BASE_VOL=10; // asteroide de la base

// Volume de minerai par type d'asteroide:
$AS_MI_VOL_MIN[1]=10000; $AS_MI_VOL_MAX[1]=50000;
$AS_MI_VOL_MIN[2]=3000; $AS_MI_VOL_MAX[2]=10000;
$AS_MI_VOL_MIN[3]=1000; $AS_MI_VOL_MAX[3]=3000;
$AS_MI_VOL_MIN[4]=300; $AS_MI_VOL_MAX[4]=1000;
$AS_MI_VOL_MIN[5]=100; $AS_MI_VOL_MAX[5]=300;
$AS_MI_VOL_MIN[6]=50; $AS_MI_VOL_MAX[6]=100;
$AS_BASE_MI_VOL_MIN=2500; $AS_BASE_MI_VOL_MAX=3500; // asteroide de la base


// ============================== VARIABLES DES MINERAIS ==============================
$MI_TYPE_NB=8;

// Nom de chaque type de minerai
$MI_NOM[1]='Or';
$MI_NOM[2]='Argent';
$MI_NOM[3]='Plomb';
$MI_NOM[4]='Uranium';
$MI_NOM[5]='Nickel';
$MI_NOM[6]='Cuivre';
$MI_NOM[7]='Aluminium';
$MI_NOM[8]='Fer';

// Chance de trouver chaque minerai:
$MI_TAUX[1]=2;
$MI_TAUX[2]=5;
$MI_TAUX[3]=10;
$MI_TAUX[4]=15;
$MI_TAUX[5]=30;
$MI_TAUX[6]=40;
$MI_TAUX[7]=50;
$MI_TAUX[8]=70;

// coefficients de fonderie (pour 1000):
$MI_FOND_COEF[1]=10;
$MI_FOND_COEF[2]=100;
$MI_FOND_COEF[3]=200;
$MI_FOND_COEF[4]=7;
$MI_FOND_COEF[5]=500;
$MI_FOND_COEF[6]=600;
$MI_FOND_COEF[7]=750;
$MI_FOND_COEF[8]=700;

// ============================== VARIABLES DES PLANETES/LUNES ==============================
$PLA_TYPE_NB=10;
$PLA_NB_MIN=2; $PLA_NB_MAX=9; // nombre de planetes du secteur
$LUNE_TAUX=60; // chance que la planete soit une lune
$LUNE_COEF_MIN=5; $LUNE_COEF_MAX=15; // coef de reduction lune/planete

// Mati�re de chaque type de planete/lune
$PLA_MAT[1]="Hydrog�ne";
$PLA_MAT[2]="H�lium";
$PLA_MAT[3]="Eau";
$PLA_MAT[4]="Acides";
$PLA_MAT[5]="Lave en fusion";
$PLA_MAT[6]="Roche";
$PLA_MAT[7]="Ammoniac solide";
$PLA_MAT[8]="M�thane solide";
$PLA_MAT[9]="Glace";
$PLA_MAT[10]="Carbone";

// Diam�tre de chaque type de planete
$PLA_DIA_MIN[1]=20000; $PLA_DIA_MAX[1]=60000;
$PLA_DIA_MIN[2]=20000; $PLA_DIA_MAX[2]=60000;
$PLA_DIA_MIN[3]=3000; $PLA_DIA_MAX[3]=8000;
$PLA_DIA_MIN[4]=3000; $PLA_DIA_MAX[4]=8000;
$PLA_DIA_MIN[5]=3000; $PLA_DIA_MAX[5]=8000;
$PLA_DIA_MIN[6]=3000; $PLA_DIA_MAX[6]=8000;
$PLA_DIA_MIN[7]=3000; $PLA_DIA_MAX[7]=10000;
$PLA_DIA_MIN[8]=3000; $PLA_DIA_MAX[8]=10000;
$PLA_DIA_MIN[9]=3000; $PLA_DIA_MAX[9]=8000;
$PLA_DIA_MIN[10]=2000; $PLA_DIA_MAX[10]=5000;

// Chance de trouver chaque planete/lune:
$PLA_TAUX[1]=25;
$PLA_TAUX[2]=15;
$PLA_TAUX[3]=5;
$PLA_TAUX[4]=10;
$PLA_TAUX[5]=10;
$PLA_TAUX[6]=15;
$PLA_TAUX[7]=10;
$PLA_TAUX[8]=5;
$PLA_TAUX[9]=5;
$PLA_TAUX[10]=5;

// Volume de minerai par type de planete/lune:
$PLA_MI_VOL_MIN[1]=0; $PLA_MI_VOL_MAX[1]=0;
$PLA_MI_VOL_MIN[2]=0; $PLA_MI_VOL_MAX[2]=0;
$PLA_MI_VOL_MIN[3]=100000; $PLA_MI_VOL_MAX[3]=200000;
$PLA_MI_VOL_MIN[4]=100000; $PLA_MI_VOL_MAX[4]=200000;
$PLA_MI_VOL_MIN[5]=100000; $PLA_MI_VOL_MAX[5]=200000;
$PLA_MI_VOL_MIN[6]=100000; $PLA_MI_VOL_MAX[6]=200000;
$PLA_MI_VOL_MIN[7]=100000; $PLA_MI_VOL_MAX[7]=300000;
$PLA_MI_VOL_MIN[8]=100000; $PLA_MI_VOL_MAX[8]=300000;
$PLA_MI_VOL_MIN[9]=100000; $PLA_MI_VOL_MAX[9]=200000;
$PLA_MI_VOL_MIN[10]=50000; $PLA_MI_VOL_MAX[10]=100000;

// Coeficient d'efficacit� du minage de chaque planete/lune:
$PLA_MI_COEF[1]=0;
$PLA_MI_COEF[2]=0;
$PLA_MI_COEF[3]=65;
$PLA_MI_COEF[4]=25;
$PLA_MI_COEF[5]=10;
$PLA_MI_COEF[6]=80;
$PLA_MI_COEF[7]=25;
$PLA_MI_COEF[8]=25;
$PLA_MI_COEF[9]=50;
$PLA_MI_COEF[10]=15;

?>
