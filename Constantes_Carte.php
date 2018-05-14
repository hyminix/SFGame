
<?php
// // ============================== CONSTANTES DE la CARTE ==============================
define ('TAILLE_MAP_COTE',45); // nbre de secteurs par coté de la carte (ex:30 -> 30x30=90 secteurs)
define ('COEF_POPULATION',9); // coef de popultation= nb de secteurs moyen entre 2 joueurs

// // ============================== CONSTANTES DES SECTEURS ==============================
// $SEC_TYPE_NB=4;

// Chances de trouver chaque type de secteur (pour 1000):
define ('TAUX_ASTEROIDE',220); // asteroides
define ('TAUX_PLANETE',30); // planetes
define ('TAUX_EPAVE',15); // epaves
define ('TAUX_TROU_NOIR',4); // trou noir


// ============================== CONSTANTES DES ASTEROIDES ==============================
// $AS_TYPE_NB=6;

define ('VOLUME_SECTEUR_MIN',20); // volume minimum d'asteroide d'un secteur de type asteroide
define ('VOLUME_SECTEUR_MAX',40); // volume maximum d'asteroide d'un secteur de type asteroide

define ('ASTEROIDE_TAUX',array(2,7,12,30,40,50)); // Chance de trouver chaque type d'asteroide: (du plus gros au plus petit)
define ('ASTEROIDE_VOLUME',array(20,12,8,5,2,1)); // Volume dans le secteur de chaque type d'asteroide
define ('MINERAI_VOLUME_MIN',array(10000,3000,1000,300,100,50)); // Volume de minerai minimum par type d'asteroide (en tonnes)
define ('MINERAI_VOLUME_MAX',array(50000,10000,3000,1000,300,100)); // Volume de minerai maximum par type d'asteroide (en tonnes)

define ('VOLUME_SECTEUR_POP',20); // volume d'asteroides d'un secteur de pop
define ('VOLUME_ASTEROIDE_BASE',10); // volume de l'asteroide de la base
define ('MINERAI_BASE_MIN',2500); // volume de minderai minimum de l'asteroide de la base
define ('MINERAI_BASE_MAX',3500); // volume de minderai maximum de l'asteroide de la base


// // ============================== CONSTANTES DES MINERAIS ==============================
// $MI_TYPE_NB=8;

define ('NOM_MINERAI',array("Or","Argent","Plomb","Uranium","Cuivre","Titane","Aluminium","Fer")); // Nom de chaque minerai
define ('TAUX_MINERAI', array(2,5,10,15,30,40,50,70)); // Chance de trouver chaque minerai
define ('COEF_FONDERIE_MINERAI', array(10,100,200,7,500,600,750,700)); // coefficients de fonderie de chaque minerai (pour 1000):

// // ============================== CONSTANTES DES PLANETES/LUNES ==============================
// $PLA_TYPE_NB=10;
define ('NB_PLANETE_MIN',2); // nombre de planetes minimum du secteur
define ('NB_PLANETE_MAX',9); // nombre de planetes maximum du secteur
define ('TAUX_LUNE',60); // chance que la planete soit une lune
define ('LUNE_COEF_MIN',5); // coef de reduction minimum lune/planete
define ('LUNE_COEF_MAX',15); // coef de reduction maximum lune/planete

define ('MATIERE_PLANETE',array("Hydrogen","Hélium","Eau","Acides","Lave en fusion","Roche","Ammoniac solide","Méthane solide","Glace","Carbone")); // Matière de chaque type de planete/lune
define ('TAUX_TYPE_PLANETE',array(25,15,5,10,10,15,10,5,5,5)); // Chances de trouver chaque type de planete/lune (le total doit faire 100)
define ('DIAMETRE_PLANETE_MIN',array(20000,20000,3000,3000,3000,3000,3000,3000,3000,2000)); // Diamètre minimum de chaque type de planete
define ('DIAMETRE_PLANETE_MAX',array(60000,60000,8000,8000,8000,8000,10000,10000,8000,5000)); // Diamètre maximum de chaque type de planete);
define ('MINERAI_PLANETE_MIN',array(0,0,100000,100000,100000,100000,100000,100000,100000,50000)); // Volume minimum de minerai par type de planete/lune (en tonnes)
define ('MINERAI_PLANETE_MAX',array(0,0,200000,200000,200000,200000,300000,300000,200000,100000)); // Volume maximum de minerai par type de planete/lune (en tonnes)
define ('COEF_MINAGE_PLANETE',array(0,0,65,25,10,80,25,25,50,15));


// // ============================== CONSTANTES DES EPAVES ==============================

define ('NOM_EPAVE',array('Débris de structure','Station abandonnée','Epave de vaisseau','Epave extra-terrestre')); // Nom de chaque type d'épave
define ('TAUX_TYPE_EPAVE',array(50,15,30,5)); // Chances de trouver chaque type d'épave (le total doit faire 100):
define ('NB_EPAVE_MIN',array(2,1,1,1)); // Nombre mimimum d'épaves de chaque type
define ('NB_EPAVE_MAX',array(12,1,1,1)); // Nombre maximum d'épaves de chaque type
define ('QTE_MATERIAU_EPAVE_MIN',array(1,2000,500,500)); // Volume minimum de materiaux terriens par type d'épave
define ('QTE_MATERIAU_EPAVE_MAX',array(1000,10000,5000,2000)); // Volume maximum de materiaux terriens par type d'épave
define ('QTE_MATERIAU_ALIEN_EPAVE_MIN',array(0,0,0,500)); // Volume minimum de materiaux alien par type d'épave
define ('QTE_MATERIAU_ALIEN_EPAVE_MAX',array(0,0,0,2000)); // Volume maximum de materiaux alien par type d'épave


// // ============================== CONSTANTES DES MATERIAUX ==============================

define ('NOM_MATERIAU',array("Acier","Aluminium","Titane","Cuivre","Plomb","Argent","Or","Uranium","Bolognium","Carbonium")); // Nom de chaque type de materiau
define ('ORIGINE_MATERIAU',array(0,0,0,0,0,0,0,0,1,1)); // Origine de chaque matériau (1=alien)
define ('TAUX_MATERIAU_EPAVE',array(700,700,500,500,300,80,5,1,850,150)); // Chance de trouver chaque matériau dans les épaves (pour 1000=
define ('MODULE_MATERIAU_EPAVE',array(100,100,30,20,10,1,1,1,100,1)); // Modularité volumique de chaque matériau (en kg)


?>
