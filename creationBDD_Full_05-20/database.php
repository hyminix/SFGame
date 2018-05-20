<?php
/**
* Classe permettant de manipuler les bases de données
* Classe utilisant le design patern singleton
* Accés depuis l'exterieur via la methode statique database::getInstance()
* @authors arrighi yannick
*/
class database {
	private static $connection;
	private static $bdd = null;
	/**
	* @desc : Constructeur, initialise la connection
	* @param : $serveur, adresse du serveur,
	*		   $utilisateur
	*		   $password
	*		   self::$bdd
	* @return void
	*/
	private function __construct()
	{
		try {
			// On instancie PDO et on se connecte a la base de données
			self::$bdd = new PDO('mysql:host=localhost;dbname=sfgame', 'root', '',  array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		} catch(PDOException $e) {
			echo "Erreur de connection à la base de données : <b>".$e->getMessage()."</b>";
		}
	}

	public static function getInstance() {
		if(self::$connection === null) {
			return new self();
		}
		return self::$connection;
	}


// ==================================================== fonctions d'ecriture =========================================================

 	// ajoute un secteur à la BDD
	public function ajoutSecteur ($x,$y,$nom) { // ajoute un secteur de position x/y
	  $req = self::$bdd->prepare('INSERT INTO secteur (pos_x, pos_y, nom) VALUES (:posx, :posy, :nom)');
		$req->bindValue(":posx", $x);
		$req->bindValue(":posy", $y);
		$req->bindValue(":nom", $nom);
	  $req->execute();
		echo '<br><b>Ajout secteur en '.$x."-".$y."</b><br>";
		return self::$bdd->lastInsertId();
	}


	public function affecteSecteurType ($secteur_id, $type) { // affecte un type à un secteur en ajoutant sa relation à la BDD
	  $req = self::$bdd->prepare('INSERT INTO rel_secteur_type (secteur_id, secteur_type_id) VALUES (:secteur_id, :secteur_type_id)');
		$req->bindValue("secteur_id", $secteur_id);
		$req->bindValue("secteur_type_id", $type);
	  $req->execute();
	}


	public function modifieSecteurOrdre ($secteur_id, $ordre) { // modifie ordre du secteur
	  $req = self::$bdd->prepare('UPDATE secteur SET ordre=:ordre WHERE id=:secteur_id');
		$req->bindValue("secteur_id", $secteur_id);
		$req->bindValue("ordre", $ordre);
	  $req->execute();
	}


	public function modifieSecteurType ($secteur_id, $type) { // modifie un type de secteur en modifiant sa relation
  $req = self::$bdd->prepare('UPDATE rel_secteur_type SET secteur_type_id=:secteur_type_id WHERE secteur_id=:secteur_id');
		$req->bindValue("secteur_id", $secteur_id);
		$req->bindValue("secteur_type_id", $type);
	  $req->execute();
	}


	public function ajoutAsteroide ($secteur_id, $taille, $nom) { // ajoute un asteroide et sa relation au secteur à la BDD et renvoi son id
	  $req = self::$bdd->prepare('INSERT INTO asteroide (taille, nom) VALUES (:taille, :nom)');
		$req->bindValue("taille", $taille);
		$req->bindValue("nom", $nom);
	  $req->execute();
	  $asteroide_id = self::$bdd->lastInsertId();
	  // ajout de la relation secteur/asteroide:
	  $req = self::$bdd->prepare('INSERT INTO rel_secteur_asteroide (secteur_id, asteroide_id) VALUES (:secteur_id, :asteroide_id)');
		$req->bindValue("secteur_id", $secteur_id);
		$req->bindValue("asteroide_id", $asteroide_id);
	  $req->execute();
	  $req->closeCursor();
	  //echo 'Secteur Id: '.$secteur_id.' --> Ajout asteroide Id: '.$asteroide_id.'<br>';
		echo '(S:'.$secteur_id.'>A:'.$asteroide_id.') - ';
	  return $asteroide_id;
	}


	public function ajoutMineraiAsteroide ($type, $quantite, $asteroide_id) { // ajoute un minerai et sa relation a l'asteroide à la BDD
	  $req = self::$bdd->prepare('INSERT INTO minerai (quantite, type) VALUES (:quantite, :type)');
		$req->bindValue("quantite", $quantite);
		$req->bindValue("type", $type);
	  $req->execute();
	  $minerai_id = self::$bdd->lastInsertId();
	  //echo ' --> Ajout minerai Id: '.$minerai_id.'<br>';
	  // ajout de la relation asteroide/minerai:
	  $req = self::$bdd->prepare('INSERT INTO rel_asteroide_minerai (asteroide_id, minerai_id) VALUES (:asteroide_id, :minerai_id)');
		$req->bindValue("asteroide_id", $asteroide_id);
		$req->bindValue("minerai_id", $minerai_id);
	  $req->execute();
	  $req->closeCursor();
	  return $minerai_id;
	}


	public function ajoutPlanete ($secteur_id, $diametre, $matiere, $nom, $lune) { // ajoute une planete/lune et sa relation au secteur à la BDD et renvoi son id
	  $req = self::$bdd->prepare('INSERT INTO planete (diametre, matiere, nom, lune) VALUES (:diametre, :matiere, :nom, :lune)');
		$req->bindValue("diametre", $diametre);
		$req->bindValue("matiere", $matiere);
		$req->bindValue("nom", $nom);
		$req->bindValue("lune", $lune);
	  $req->execute();
	  $planete_id = self::$bdd->lastInsertId();
	  // ajout de la relation secteur/asteroide:
	  $req = self::$bdd->prepare('INSERT INTO rel_secteur_planete (secteur_id, planete_id) VALUES (:secteur_id, :planete_id)');
		$req->bindValue("secteur_id", $secteur_id);
		$req->bindValue("planete_id", $planete_id);
	  $req->execute();
	  $req->closeCursor();
	  echo 'Secteur Id: '.$secteur_id.' --> Ajout planete Id: '.$planete_id.'<br>';
	  return $planete_id;
	}


	public function ajoutMineraiPlanete ($type, $quantite, $planete_id) { // ajoute un minerai et sa relation a la planete à la BDD
	  $req = self::$bdd->prepare('INSERT INTO minerai (quantite, type) VALUES (:quantite, :type)');
		$req->bindValue("quantite", $quantite);
		$req->bindValue("type", $type);
	  $req->execute();
	  $minerai_id = self::$bdd->lastInsertId();
	  // echo ' --> Ajout minerai Id: '.$minerai_id.'<br>';
	  // ajout de la relation planete/minerai:
	  $req = self::$bdd->prepare('INSERT INTO rel_planete_minerai (planete_id, minerai_id) VALUES (:planete_id, :minerai_id)');
		$req->bindValue("planete_id", $planete_id);
		$req->bindValue("minerai_id", $minerai_id);
	  $req->execute();
	  $req->closeCursor();
	  return $minerai_id;
	}


	public function ajoutEpave ($secteur_id, $type, $masse, $nom) { // ajoute une epave et sa relation au secteur à la BDD et renvoi son id
	  $req = self::$bdd->prepare('INSERT INTO epave (type, masse, nom) VALUES (:type, :masse, :nom)');
		$req->bindValue("type", $type);
		$req->bindValue("masse", $masse);
		$req->bindValue("nom", $nom);
	  $req->execute();
	  $epave_id = self::$bdd->lastInsertId();
	  // ajout de la relation secteur/asteroide:
	  $req = self::$bdd->prepare('INSERT INTO rel_secteur_epave (secteur_id, epave_id) VALUES (:secteur_id, :epave_id)');
		$req->bindValue("secteur_id", $secteur_id);
		$req->bindValue("epave_id", $epave_id);
	  $req->execute();
	  $req->closeCursor();
	  echo 'Secteur id: '.$secteur_id.' --> Ajout epave Id: '.$epave_id.'<br>';
	  return $epave_id;
	}


	public function ajoutMateriauEpave ($type, $quantite, $epave_id) { // ajoute un materiau et sa relation a l'épave à la BDD
	  $req = self::$bdd->prepare('INSERT INTO materiau (quantite, type) VALUES (:quantite, :type)');
		$req->bindValue("quantite", $quantite);
		$req->bindValue("type", $type);
	  $req->execute();
	  $materiau_id = self::$bdd->lastInsertId();
	  //echo ' --> Ajout materiau Id: '.$materiau_id.'<br>';
	  // ajout de la relation epave/materiau:
	  $req = self::$bdd->prepare('INSERT INTO rel_epave_materiau (epave_id, materiau_id) VALUES (:epave_id, :materiau_id)');
		$req->bindValue("epave_id", $epave_id);
		$req->bindValue("materiau_id", $materiau_id);
	  $req->execute();
	  $req->closeCursor();
	  return $materiau_id;
	}


	// ==================================================== fonctions de lecture =========================================================

	public function getSecteurId ($x,$y) { // renvoi l'id du secteur sélectionné
	  $req = self::$bdd->prepare('SELECT id FROM secteur WHERE pos_x = :posx AND pos_y = :posy');
		$req->bindValue("posx", $x);
		$req->bindValue("posy", $y);
		$req->execute();
	  while ($row = $req->fetch()) {
	    $secteur_id = $row['id'];
	  }
	  return $secteur_id;
	}

	public function getSecteurOrdre ($secteurId) { // renvoi l'ordre du secteur sélectionné
		$req = self::$bdd->prepare('SELECT ordre FROM secteur WHERE id = :secteur_id');
		$req->bindValue("secteur_id", $secteurId);
		$req->execute();
		while ($row = $req->fetch()) {
			$secteur_ordre = $row['ordre'];
		}
		return $secteur_ordre;
	}


	public function getSecteurType ($secteurId) { // renvoi le type du secteur sélectionné
	  $req = self::$bdd->prepare('SELECT secteur_type_id FROM rel_secteur_type WHERE secteur_id = :secteur_id');
		$req->bindValue("secteur_id", $secteurId);
		$req->execute();
	  while ($row = $req->fetch()) {
	    $secteur_type = $row['secteur_type_id'];
	  }
	  return $secteur_type;
	}


	public function getSecteurPosition ($secteurId) { // renvoi le coordonnées x/y du secteur sélectionné
		$req = self::$bdd->prepare('SELECT * FROM secteur WHERE secteur_id = :secteurId');
		$req->bindValue("secteurId", $secteurId);
		$req->execute();
		while ($row = $req->fetch()) {
			$x = $row['pos_x'];
			$y = $row['pos_y'];
		}
		return array($x,$y);
	}


	public function getNomSecteurType ($secteurType) { // renvoi le nom du type de secteur demmandé
		$nom_type = 'Vide';
		$req = self::$bdd->prepare('SELECT nom FROM secteur_type WHERE id = :secteurType');
		$req->bindValue("secteurType", $secteurType);
		$req->execute();
		while ($row = $req->fetch()) {
			$nom_type = $row['nom'];
	  }
	  return $nom_type;
	}


	public function getSecteurAsteroide ($secteurId) { // renvoi la liste des asteroides du secteur demmandé
		$req = self::$bdd->prepare('SELECT asteroide_id FROM rel_secteur_asteroide WHERE secteur_id = :secteurId');
		$req->bindValue("secteurId", $secteurId);
		$req->execute();
		$asteroideId = array();
		while ($row = $req->fetch()) {
			array_push($asteroideId, $row['asteroide_id']);
	  }
	  return $asteroideId;
	}


	public function getAsteroideTaille ($asteroideId) { // renvoi la taille en metres de l'asteroide sélectionné
		$req = self::$bdd->prepare('SELECT taille FROM asteroide WHERE id = :asteroideId');
		$req->bindValue("asteroideId", $asteroideId);
		$req->execute();
		while ($row = $req->fetch()) {
			$taille = $row['taille'];
		}
		return $taille;
	}


	public function getAsteroideNom ($asteroideId) { // renvoi le nom de l'asteroide sélectionné
		$req = self::$bdd->prepare('SELECT nom FROM asteroide WHERE id = :asteroideId');
		$req->bindValue("asteroideId", $asteroideId);
		$req->execute();
		while ($row = $req->fetch()) {
			$nom = $row['nom'];
		}
		return $nom;
	}


	public function getAsteroideMinerai ($asteroideId) { // renvoi la liste des minerais de l'asteroide demmandé
		$req = self::$bdd->prepare('SELECT minerai_id FROM rel_asteroide_minerai WHERE asteroide_id = :asteroideId');
		$req->bindValue("asteroideId", $asteroideId);
		$req->execute();
		$mineraiId = array();
		while ($row = $req->fetch()) {
			array_push($mineraiId, $row['minerai_id']);
		}
		return $mineraiId;
	}


	public function getSecteurPlanete ($secteurId) { // renvoi la liste des planetes du secteur demmandé
		$req = self::$bdd->prepare('SELECT planete_id FROM rel_secteur_planete WHERE secteur_id = :secteurId');
		$req->bindValue("secteurId", $secteurId);
		$req->execute();
		$planeteId = array();
		while ($row = $req->fetch()) {
			array_push($planeteId, $row['planete_id']);
	  }
	  return $planeteId;
	}


	public function getPlaneteNom ($planeteId) { // renvoi le nom de la planete sélectionné
		$req = self::$bdd->prepare('SELECT nom FROM planete WHERE id = :planeteId');
		$req->bindValue("planeteId", $planeteId);
		$req->execute();
		while ($row = $req->fetch()) {
			$nom = $row['nom'];
		}
		return $nom;
	}


		public function getPlaneteMinerai ($planeteId) { // renvoi la liste des minerais de la planete sélectionné
			$req = self::$bdd->prepare('SELECT minerai_id FROM rel_planete_minerai WHERE planete_id = :planeteId');
			$req->bindValue("planeteId", $planeteId);
			$req->execute();
			$mineraiId = array();
			while ($row = $req->fetch()) {
				array_push($mineraiId, $row['minerai_id']);
			}
			return $mineraiId;
		}


		public function getPlaneteDiametre ($planeteId) { // renvoi le diametre  en km de la planete sélectionné
			$req = self::$bdd->prepare('SELECT diametre FROM planete WHERE id = :planeteId');
			$req->bindValue("planeteId", $planeteId);
			$req->execute();
			while ($row = $req->fetch()) {
				$diametre = $row['diametre'];
			}
			return $diametre;
		}


		public function getPlaneteMatiere ($planeteId) { // renvoi le numéro de matiere de la planete sélectionné
			$req = self::$bdd->prepare('SELECT matiere FROM planete WHERE id = :planeteId');
			$req->bindValue("planeteId", $planeteId);
			$req->execute();
			while ($row = $req->fetch()) {
				$matiere = $row['matiere'];
			}
			return $matiere;
		}


		public function getSecteurEpave ($secteurId) { // renvoi la liste des epaves du secteur demmandé
			$req = self::$bdd->prepare('SELECT epave_id FROM rel_secteur_epave WHERE secteur_id = :secteurId');
			$req->bindValue("secteurId", $secteurId);
			$req->execute();
			$epaveId = array();
			while ($row = $req->fetch()) {
				array_push($epaveId, $row['epave_id']);
		  }
		  return $epaveId;
		}


		public function getEpaveNom ($epaveId) { // renvoi le nom de la planete sélectionné
			$req = self::$bdd->prepare('SELECT nom FROM epave WHERE id = :epaveId');
			$req->bindValue("epaveId", $epaveId);
			$req->execute();
			while ($row = $req->fetch()) {
				$nom = $row['nom'];
			}
			return $nom;
		}


		public function getEpaveMasse ($epaveId) { // renvoi la masse en tonne de l'epave sélectionné
			$req = self::$bdd->prepare('SELECT masse FROM epave WHERE id = :epaveId');
			$req->bindValue("epaveId", $epaveId);
			$req->execute();
			while ($row = $req->fetch()) {
				$masse = intval($row['masse']/1000);
			}
			return $masse;
		}


		public function getEpaveType ($epaveId) { // renvoi le numéro de type de l'epave sélectionnée
			$req = self::$bdd->prepare('SELECT type FROM epave WHERE id = :epaveId');
			$req->bindValue("epaveId", $epaveId);
			$req->execute();
			while ($row = $req->fetch()) {
				$type = $row['type'];
			}
			return $type;
		}


		public function getEpaveMateriau ($epaveId) { // renvoi la liste des materiaux de l'epave sélectionnée
			$req = self::$bdd->prepare('SELECT materiau_id FROM rel_epave_materiau WHERE epave_id = :epaveId');
			$req->bindValue("epaveId", $epaveId);
			$req->execute();
			$materiauId = array();
			while ($row = $req->fetch()) {
				array_push($materiauId, $row['materiau_id']);
			}
			return $materiauId;
		}

// ==================================================== fonctions de vidage =========================================================

public function vidageTables () { // vide toutes les tables des objets de la carte
	$req = self::$bdd->prepare("TRUNCATE TABLE secteur");
	$req->execute();
	$req = self::$bdd->prepare("TRUNCATE TABLE rel_secteur_type");
	$req->execute();
	$req = self::$bdd->prepare("TRUNCATE TABLE rel_secteur_asteroide");
	$req->execute();
	$req = self::$bdd->prepare("TRUNCATE TABLE rel_secteur_planete");
	$req->execute();
	$req = self::$bdd->prepare("TRUNCATE TABLE rel_secteur_epave");
	$req->execute();
	$req = self::$bdd->prepare("TRUNCATE TABLE asteroide");
	$req->execute();
	$req = self::$bdd->prepare("TRUNCATE TABLE rel_asteroide_minerai");
	$req->execute();
	$req = self::$bdd->prepare("TRUNCATE TABLE planete");
	$req->execute();
	$req = self::$bdd->prepare("TRUNCATE TABLE rel_planete_minerai");
	$req->execute();
	$req = self::$bdd->prepare("TRUNCATE TABLE epave");
	$req->execute();
	$req = self::$bdd->prepare("TRUNCATE TABLE rel_epave_materiau");
	$req->execute();
	$req = self::$bdd->prepare("TRUNCATE TABLE minerai");
	$req->execute();
	$req = self::$bdd->prepare("TRUNCATE TABLE materiau");
	$req->execute();
}

}
?>
