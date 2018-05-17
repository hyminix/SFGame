<?php
define ('BDD_USER','user');
define ('BDD_PASS','cosmos');

function ajoutSecteurBdd ($x,$y,$nom) { // ajoute un secteur à la BDD
  try {
  $bdd = new PDO('mysql:host=localhost;dbname=sfgame;charset=utf8', BDD_USER, BDD_PASS, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
  } catch (PDOException $e) { print "Erreur !: " . $e->getMessage() . "<br/>"; die(); }
  $req = $bdd->prepare('INSERT INTO secteur (pos_x, pos_y, nom) VALUES (:posx, :posy, :nom)');
  $req->execute(array(
  'posx' => $x,
  'posy' => $y,
  'nom' => $nom,
  ));
  $req->closeCursor();
}


function affecteSecteurTypeBdd ($x,$y,$type) { // affecte un type à un secteur en ajoutant sa relation à la BDD
  try {
    $bdd = new PDO('mysql:host=localhost;dbname=sfgame;charset=utf8', BDD_USER, BDD_PASS, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
  } catch (PDOException $e) { print "Erreur !: " . $e->getMessage() . "<br/>"; die(); }
  // recuperation de l'id du secteur de coordonnées x,y:
  $req = $bdd->prepare('SELECT id FROM secteur WHERE pos_x = :posx AND pos_y = :posy');
  $req->execute(array(
    'posx' => $x,
    'posy' => $y,
  ));
  while ($row = $req->fetch()) {
    $secteur_id = $row['id'];
  }
  // ajout de la relation secteur/type:
  $req = $bdd->prepare('INSERT INTO rel_secteur_type (secteur_id, secteur_type_id) VALUES (:secteur_id, :secteur_type_id)');
  $req->execute(array(
  'secteur_id' => $secteur_id,
  'secteur_type_id' => $type,
  ));
  $req->closeCursor();
}


function ajoutAsteroideBdd ($x,$y,$taille,$nom) { // ajoute un asteroide et sa relation au secteur à la BDD et renvoi son id
  try {
   $bdd = new PDO('mysql:host=localhost;dbname=sfgame;charset=utf8', BDD_USER, BDD_PASS, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
  } catch (PDOException $e) { print "Erreur !: " . $e->getMessage() . "<br/>"; die(); }
  $req = $bdd->prepare('INSERT INTO asteroide (taille, nom) VALUES (:taille, :nom)');
  $req->execute(array(
  'taille' => $taille,
  'nom' => $nom,
  ));
  $asteroide_id = $bdd->lastInsertId();
  // recuperation de l'id du secteur de coordonnées x,y:
  $req = $bdd->prepare('SELECT id FROM secteur WHERE pos_x = :posx AND pos_y = :posy');
  $req->execute(array(
    'posx' => $x,
    'posy' => $y,
  ));
  while ($row = $req->fetch()) {
    $secteur_id = $row['id'];
  }
  // ajout de la relation secteur/asteroide:
  $req = $bdd->prepare('INSERT INTO rel_secteur_asteroide (secteur_id, asteroide_id) VALUES (:secteur_id, :asteroide_id)');
  $req->execute(array(
  'secteur_id' => $secteur_id,
  'asteroide_id' => $asteroide_id,
  ));
  $req->closeCursor();
  echo 'Id secteur:'.$secteur_id.' --> Id asteroide:'.$asteroide_id.'<br>';
  return $asteroide_id;
}


function ajoutMineraiAsteroideBdd ($type, $quantite, $asteroide_id) { // ajoute un minerai et sa relation a l'asteroide à la BDD
  try {
   $bdd = new PDO('mysql:host=localhost;dbname=sfgame;charset=utf8', BDD_USER, BDD_PASS, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
  } catch (PDOException $e) { print "Erreur !: " . $e->getMessage() . "<br/>"; die(); }
  $req = $bdd->prepare('INSERT INTO minerai (quantite, type) VALUES (:quantite, :type)');
  $req->execute(array(
  'quantite' => $quantite,
  'type' => $type,
  ));
  $minerai_id = $bdd->lastInsertId();
  echo ' --> Id minerai:'.$minerai_id.'<br>';
  // ajout de la relation asteroide/minerai:
  $req = $bdd->prepare('INSERT INTO rel_asteroide_minerai (asteroide_id, minerai_id) VALUES (:asteroide_id, :minerai_id)');
  $req->execute(array(
  'asteroide_id' => $asteroide_id,
  'minerai_id' => $minerai_id,
  ));
  $req->closeCursor();
  return $minerai_id;
}



// ==================================================== fonctions de lecture =========================================================

function getSecteurIdBdd ($x,$y) { // renvoi l'id du secteur sélectionné
  try {
    $bdd = new PDO('mysql:host=localhost;dbname=sfgame;charset=utf8', BDD_USER, BDD_PASS, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
  } catch (PDOException $e) { print "Erreur !: " . $e->getMessage() . "<br/>"; die(); }
  $req = $bdd->prepare('SELECT id FROM secteur WHERE pos_x = :posx AND pos_y = :posy');
  $req->execute(array(
    'posx' => $x,
    'posy' => $y,
  ));
  while ($row = $req->fetch()) {
    $secteur_id = $row['id'];
  }
  return $secteur_id;
}


 ?>
