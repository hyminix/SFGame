<?php
/**
* Classe permettant de manipuler les bases de données
* Classe utilisant le design patern singleton 
* Accés depuis l'exterieur via la methode statique database::getInstance()
* @authors arrighi yannick
*/
class database {

	private static $connection = null;

	/**
	* @desc : Constructeur, initialise la connection
	* @param : $serveur, adresse du serveur, 
	*		   $utilisateur
	*		   $password
	*		   $bdd
	* @return void
	*/
	private function __construct()
	{
		try {
			// On instancie PDO et on se connecte a la base de données
			self::$connection = new PDO('mysql:host=localhost;dbname=pret', 'root', '',  array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
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

	/**
	* Methode recherchant l'utilisateur dans la base de donnée et retourne son nom, prenom, login, id 
	* @param : $login, le login
	* @param : $password : le mot de passe
	* @return : JSON array() $retour (id, login, nom, prenom, grade)
	*/
	public function getUser($login, $password) 
	{
		// On compte le nombre d'utilisateur correspondant au couple login / password
		$requete = self::$connection->prepare("SELECT count(*) FROM utilisateur WHERE login_utilisateur = :login AND password = :password");
		$requete->bindValue(':login', $login);
		$requete->bindValue(':password', $password);
		$requete->execute();

		if($requete->fetchColumn() > 0) {
		
			$connexion  = self::$connection->prepare("SELECT id_utilisateur, login_utilisateur, nom_utilisateur, prenom_utilisateur, grade FROM utilisateur WHERE login_utilisateur = :login AND password = :password");
			$connexion->bindValue(':login', $login);
			$connexion->bindValue(':password', $password);

			$connexion->execute();

			while($donnees = $connexion->fetch(PDO::FETCH_OBJ))
			{
				$retour = array(
							'id' => $donnees->id_utilisateur, 
							'login' => $donnees->login_utilisateur, 
							'nom' => $donnees->nom_utilisateur, 
							'prenom' => $donnees->prenom_utilisateur,
							'grade' => $donnees->grade
						);

				// Démarage de la session 
				session_start();
				$_SESSION["id"] = $donnees->id_utilisateur;
				$_SESSION["login"] = $donnees->login_utilisateur;
				$_SESSION["nom"] = $donnees->nom_utilisateur;
				$_SESSION["prenom"] = $donnees->prenom_utilisateur;
				$_SESSION["grade"] = $donnees->grade;

				// Definition du cookie d'une heure
				setcookie('login', $donnees->id_utilisateur, time()+3600);

				header('Content-type: application/json');
				echo json_encode($retour);
			}
		}
		else {
			echo "";
		}
	}

	/**
	* Methode retournant vrai si l'utilisateur (login) n'est pas déja présent dans la bdd
	* @param login_utilisateur
	* @return boolean
	*/
	public function verifLogin($login_utilisateur)
	{
		$connexion = self::$connection->prepare("SELECT count(*) FROM utilisateur WHERE login_utilisateur = :login_utilisateur");
		$connexion->bindValue(":login_utilisateur", strtolower($login_utilisateur), PDO::PARAM_STR);
		$connexion->execute();

		if($connexion->fetchColumn() > 0) {
			return false;
		} else {
			return true;
		}
	}

	/**
	* Methode récupérant la liste de tout les utilisateur
	* @return obj : la liste des utilisateurs
	*/
	public function getAllUtilisateur() {
		$connexion = self::$connection->prepare("SELECT * FROM utilisateur");
		$connexion->execute();
		return $connexion->fetchAll(PDO::FETCH_OBJ);
	}

	/**
	* Methode ajoutant l'utilisateur dans la bdd
	* @param nom_utilisateur : le nom
	* @param password_utilisateur : le password
	* @param grade : le grade
	* @param login_utilisateur : le login
	* @param prenom_utilisateur : le prenom
	* @param email_utilisateur : l'email
	* @return boolean
	*/
	public function addUtilisateur($nom_utilisateur, $password_utilisateur, $grade, $login_utilisateur, $prenom_utilisateur, $email_utilisateur) {
		$connexion = self::$connection->prepare("INSERT INTO utilisateur(nom_utilisateur, password, grade, login_utilisateur, prenom_utilisateur, email_utilisateur) 
												VALUES(:nom_utilisateur, :password_utilisateur, :grade, :login_utilisateur, :prenom_utilisateur, :email_utilisateur)");
		$connexion->bindValue(":nom_utilisateur", strtoupper($nom_utilisateur));
		$connexion->bindValue(":password_utilisateur", $password_utilisateur);
		$connexion->bindValue(":grade", $grade);
		$connexion->bindValue(":login_utilisateur", $login_utilisateur);
		$connexion->bindValue(":prenom_utilisateur", ucfirst($prenom_utilisateur));
		$connexion->bindValue(":email_utilisateur", $email_utilisateur);
		$connexion->execute();

		if($connexion->rowCount() > 0) {
			return true;
		} 
		return false;
	}

	/**
	* methode retournant les information de l'utilisateur
	*/
	public function getInfoUtilisateur($id) {
		$connexion = self::$connection->prepare("SELECT * FROM utilisateur WHERE id_utilisateur = :id_utilisateur");
		$connexion->bindValue("id_utilisateur", $id, PDO::PARAM_INT);
		$connexion->execute();

		return $connexion->fetch(PDO::FETCH_OBJ);
	}
	/**
	* Methode retournant la liste de tout le materiel
	* @return $resultat : la liste de tout le materiel
	*/
	public static function getAllMateriel() {

		/*$connexion = self::$connection->prepare("SELECT designation, id_materiel, nom_materiel, modele, serial, etat FROM materiel, categorie WHERE materiel.id_categorie = categorie.id_categorie ");*/
		$connexion = self::$connection->prepare("SELECT id_materiel, nom_materiel, modele, serial, etat FROM materiel");
		$connexion->execute();

		$resultat = $connexion->fetchAll(PDO::FETCH_OBJ);

		return $resultat;
	}

	/**
	* Methode ajoutant une nouvelle catégorie
	* @param nom_categorie : le nom de la catégorie
	*/
	public function addCategorie($nom_categorie) {
		$connexion = self::$connection->prepare("INSERT INTO categorie(designation) VALUES(:nom_categorie)");
		$connexion->bindValue(":nom_categorie", ucfirst($nom_categorie));

		$connexion->execute();
	}

	/**
	* Methode retournant la liste de toute les catégorie
	* @return resultat : la liste de toute les catégorie
	*/
	public function getAllCategorie() {
		$connexion = self::$connection->prepare("SELECT * FROM categorie");
		$connexion->execute();

		$resultat = $connexion->fetchAll(PDO::FETCH_OBJ);

		return $resultat;
	}

	/**
	* Methode retournant les information d'un catégorie par son id
	* @param id : l'id de la categorie
	* @return obj : les info de la catégorie
	*/
	public function getInfoCategorie($id_categorie) {
		$connexion = self::$connection->prepare("SELECT id_categorie, designation 
												FROM categorie
												WHERE id_categorie = :id_categ 
												");
		$connexion->bindValue(":id_categ", $id_categorie, PDO::PARAM_INT);
		$connexion->execute();
		$resultat = $connexion->fetch(PDO::FETCH_OBJ);
		return $resultat;
	}

	/**
	* Methode mettant à jour la designation de la catégorie par son id
	* @param id : l'id de la catégorie à modifier
	* @param nom : la désignation de la catégorie
	* @return boolean 
	*/
	public function updateCategorie($id_categorie, $designation) {
		$connexion = self::$connection->prepare("UPDATE categorie SET designation = :designation WHERE id_categorie = :id_categorie");
		$connexion->bindValue(":designation", $designation, PDO::PARAM_STR);
		$connexion->bindValue(":id_categorie", $id_categorie, PDO::PARAM_INT);
		$connexion->execute();

		if($connexion->rowCount() > 0 )
		{
			return true;
		} else {
			return false;
		}
	}

	/**
	* Methode retournant tout le materiel organisé par catégorie
	* 
	*/
	public function getAllMaterielByCategorie($id_categorie) {
		$connexion = self::$connection->prepare("SELECT materiel.id_materiel, materiel.nom_materiel 
												FROM materiel
												WHERE materiel.id_categorie = :id_categ 
												");
		$connexion->bindValue(":id_categ", $id_categorie, PDO::PARAM_INT);
		$connexion->execute();

		return $connexion->fetchAll(PDO::FETCH_OBJ);
	}

	public function getInfoMateriel($id) {
		$connexion = self::$connection->prepare("SELECT id_materiel, nom_materiel, modele, serial, etat, id_categorie, id_qr FROM materiel WHERE id_materiel = :id");
		$connexion->bindValue(':id', $id);
		$connexion->execute();

		$resultat = $connexion->fetch(PDO::FETCH_OBJ);
		
		return $resultat;
	}

	public function addMateriel($nom, $categorie, $qr, $modele, $etat, $serial) {
		$connexion = self::$connection->prepare("INSERT INTO materiel(nom_materiel,modele,serial,etat,id_categorie,id_qr) VALUES (:nom, :modele, :serial, :etat, :id_categ, :id_qr) ");
		$connexion->bindValue(':nom', $nom);
		$connexion->bindValue(':modele', $modele);
		$connexion->bindValue(':serial', $serial);
		$connexion->bindValue(':etat', $etat);
		$connexion->bindValue(':id_categ', $categorie);
		$connexion->bindValue(':id_qr', $qr);

		$connexion->execute();

	}

	/**
	* Methode métant à jours un materiel ainsi que son qrcode
	* @param id : l'id du materiel
	* @param nom : le nom du materiel
	* @param categorie : la categorie du materiel
	* @param modele : le modele du materiel
	* @param serial : le N° de serie du materiel
	* @return boolean 
	*/
	public function updateMateriel($id, $nom, $categorie, $modele, $serial) {
		$connexion = self::$connection->prepare("UPDATE materiel SET 
												nom_materiel = :nom_materiel,
												id_categorie = :categorie,
												modele = :modele,
												serial = :serial
												WHERE id_materiel = :id_materiel
												");
		$connexion->bindValue(":id_materiel", $id, PDO::PARAM_INT);
		$connexion->bindValue(":categorie", $categorie, PDO::PARAM_INT);
		$connexion->bindValue(":modele", $modele, PDO::PARAM_STR);
		$connexion->bindValue(":serial", $serial, PDO::PARAM_STR);
		$connexion->bindValue(":nom_materiel", $nom, PDO::PARAM_STR);

		$connexion->execute();
		if($connexion->rowCount() > 0){
			return true;
		} else {
			return false;
		}
	}	

	public function deleteMateriel($id) {
		$connexion = self::$connection->prepare("DELETE FROM materiel WHERE id_materiel = :id_materiel");
		$connexion->bindValue(":id_materiel", $id, PDO::PARAM_INT);
		$connexion->execute();

		if($connexion->rowCount() > 0) {
			return true;
		} else { 
			return false;
		}
	}

	public function addQr($nom) {
		$connexion = self::$connection->prepare("INSERT INTO qr(valeur) VALUES(:val)");
		$connexion->bindValue(":val", $nom);

		$connexion->execute();

		$id = self::$connection->lastInsertId();

		return $id;
	}

	public function checkReservation( $dateDeb, $dateFin, $materiel, $idReservation=null) {

		if(is_null($idReservation)) {
			$connexion = self::$connection->prepare("SELECT COUNT(reservation_materiel.id_reservation) 
													FROM reservation, reservation_materiel
													WHERE reservation_materiel.id_materiel = :materiel
													AND reservation_materiel.id_reservation = reservation.id_reservation
													AND (:dateDeb  BETWEEN datedeb AND datefin
													OR :dateFin BETWEEN datedeb AND datefin
													OR datedeb BETWEEN :dateDeb AND :dateFin
													OR datefin BETWEEN :dateDeb AND :dateFin
													)");


			$connexion->bindValue(":materiel", $materiel, PDO::PARAM_INT);
			$connexion->bindValue(":dateDeb", $dateDeb, PDO::PARAM_STR);
			$connexion->bindValue(":dateFin", $dateFin, PDO::PARAM_STR);
			$connexion->execute();
		} else {
			$connexion = self::$connection->prepare("SELECT COUNT(reservation_materiel.id_reservation) 
													FROM reservation, reservation_materiel
													WHERE reservation_materiel.id_materiel = :materiel
													AND reservation.id_reservation <> :idReservation
													AND reservation_materiel.id_reservation = reservation.id_reservation
													AND (:dateDeb  BETWEEN datedeb AND datefin
													OR :dateFin BETWEEN datedeb AND datefin
													OR datedeb BETWEEN :dateDeb AND :dateFin
													OR datefin BETWEEN :dateDeb AND :dateFin)
													");


			$connexion->bindValue(":materiel", $materiel, PDO::PARAM_INT);
			$connexion->bindValue(":idReservation", $idReservation, PDO::PARAM_INT);
			$connexion->bindValue(":dateDeb", $dateDeb, PDO::PARAM_STR);
			$connexion->bindValue(":dateFin", $dateFin, PDO::PARAM_STR);
			$connexion->execute();
		}
		
		if($connexion->fetchColumn() == 0)
		{
			return true;
		} else {

			return false;
		}
	}


	public function makeNewReservation($materiel, $categ, $qr, $dateDeb, $dateFin, $service, $demandeur, $technicien, $description) {
		$connexion = self::$connection->prepare("INSERT INTO reservation(datedeb, datefin, nom_demandeur, id_service) VALUES(:datedeb, :datefin, :nom_demandeur, :id_service)");
		$connexion->bindValue(":datedeb", $dateDeb);
		$connexion->bindValue(":datefin", $dateFin);
		$connexion->bindValue(":nom_demandeur", $demandeur);
		$connexion->bindValue(":id_service", $service);

		$connexion->execute();

		$id_resa = self::$connection->lastInsertId();

		$req = self::$connection->prepare("INSERT INTO reservation_materiel(id_reservation, id_service, id_materiel, id_categorie, id_qr, description) VALUES(:id_reservation, :id_service, :id_materiel, :id_categorie, :id_qr, :description)");
		$req->bindValue(":id_reservation", $id_resa);
		$req->bindValue(":id_service", $service);
		$req->bindValue(":id_materiel", $materiel);
		$req->bindValue(":id_categorie", $categ);
		$req->bindValue(":id_qr", $qr);
		$req->bindValue(":description", $description);
		$req->execute();

	}

	public function updateReservation($idReservation, $dateDeb, $dateFin) {
		$connexion = self::$connection->prepare("UPDATE reservation SET datedeb = :dateDeb, dateFin = :dateFin WHERE id_reservation = :idReservation");
		$connexion->bindValue(":idReservation", $idReservation, PDO::PARAM_INT);				
		$connexion->bindValue(":dateDeb", $dateDeb, PDO::PARAM_STR);
		$connexion->bindValue(":dateFin", $dateFin, PDO::PARAM_STR);
		$connexion->execute();

	}
	public function getReservationInfoById($idReservation) {
		$connexion = self::$connection->prepare("SELECT *
												FROM reservation, reservation_materiel
												WHERE reservation.id_reservation = :idReservation
												AND reservation.id_reservation = reservation_materiel.id_reservation
												");
		$connexion->bindValue(":idReservation", $idReservation);
		$connexion->execute();

		return $connexion->fetch(PDO::FETCH_OBJ);
	}

	public function deleteReservation($idReservation) {
		$connexion = self::$connection->prepare("DELETE FROM reservation_materiel 
												WHERE reservation_materiel.id_reservation = :idReservation
												 ");
		$connexion->bindValue(":idReservation", $idReservation, PDO::PARAM_INT);
		$connexion->execute();

		if($connexion->rowCount() > 0) {
			$req = self::$connection->prepare("DELETE FROM reservation 
												WHERE reservation.id_reservation = :idReservation
											");
			$req->bindValue(":idReservation", $idReservation, PDO::PARAM_INT);
			$req->execute();

			if($req->rowCount() > 0) {
				return true;
			}
		}
		return false;
	}

	public function getAllReservation() {
		$connexion = self::$connection->prepare("SELECT * FROM reservation");
		$connexion->execute();

		return $connexion->fetchAll(PDO::FETCH_OBJ);

	}

	public function checkReservationByDay($year, $month, $day) {
		$date = $year."-".$month."-".$day;
		$connexion = self::$connection->prepare("SELECT * FROM reservation WHERE :date BETWEEN dateDeb AND dateFin");
		$connexion->bindValue(":date", $date);

		$connexion->execute();
		
		if($connexion->fetchColumn() > 0) {
			return true;
		}

		return false;
		
	}

}
?>