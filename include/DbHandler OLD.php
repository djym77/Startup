<?php
require_once 'PassHash.php';
/**
 * Classe pour gérer toutes les opérations de db
 * Cette classe aura les méthodes CRUD pour les tables de base de données
 *
 */
class DbHandler {

    private $conn;

    function __construct() {
        require_once dirname(__FILE__) . '/DbConnect.php';
        //Ouverture connexion db
        $db = new DbConnect();
        $this->conn = $db->connect();
    }

// ===================== PARTIE DES GET ===================================

/*
* Recuperation d'acteur par moovcenter*
*/
public function getActeurByMoovcenter($idmoovcenter)
	{
		/* echo 'dans handler<br>';
		//var_dump($idmoovcenter); */
		//echo $idmoovcenter;
		
		$req=$this->conn->prepare(
			"SELECT ac.idacteur id,
					ac.matricule,
					ac.tel,
					f.libele fonction,
					ac.nom_prenom nom,
					ac.username acteur,
					mc.nom moovcenter,
					dt.nom distributeur,
					re.nom region,
					dv.nom division
			FROM acteur ac
			INNER JOIN moovcenter mc ON ac.idmoovcenter=mc.idmoovcenter
			INNER JOIN fonction f on ac.idfonction=f.idfonction
			INNER JOIN distributeur dt ON mc.distributeur_iddistributeur=dt.iddistributeur
			INNER JOIN region re ON dt.region_idregion=re.idregion
			INNER JOIN division dv ON re.division_iddivision=dv.iddivision
			WHERE ac.idmoovcenter=?");

		$req->bind_param("i",$idmoovcenter);
		$req->execute();
		$acteur=$req->get_result();
		$req->close();
		////var_dump($acteur);
		return $acteur;  
	}
/*
* Recuperation d'acteur par Distributeur*
*/
public function getActeurByDistributeur($iddistributeur)
	{
		 $req=$this->conn->prepare(
			"SELECT ac.idacteur id,
					ac.matricule,
					ac.tel,
					f.libele fonction,
					ac.nom_prenom nom_prenom,
					ac.username acteur,
					mc.nom moovcenter,
					dt.nom distributeur,
					re.nom region,
					dv.nom division
			FROM acteur ac
			INNER JOIN moovcenter mc ON ac.idmoovcenter=mc.idmoovcenter
			INNER JOIN fonction f on ac.idfonction=f.idfonction
			INNER JOIN distributeur dt ON mc.distributeur_iddistributeur=dt.iddistributeur
			INNER JOIN region re ON dt.region_idregion=re.idregion
			INNER JOIN division dv ON re.division_iddivision=dv.iddivision
			WHERE mc.distributeur_iddistributeur=?");
		$req->bind_param("i",$iddistributeur);
		$req->execute();
		$acteur=$req->get_result();
		$req->close();
		return $acteur;
	}

/*
* Recuperation d'acteur par Region*
*/
public function getActeurByRegion($idregion)
	{
		$req=$this->conn->prepare(
			"SELECT ac.idacteur id,
					ac.matricule,
					ac.tel,
					f.libele fonction,
					ac.nom_prenom nom_prenom,
					ac.username acteur,
					mc.nom moovcenter,
					dt.nom distributeur,
					re.nom region,
					dv.nom division
			FROM acteur ac
			INNER JOIN moovcenter mc ON ac.idmoovcenter=mc.idmoovcenter
			INNER JOIN fonction f on ac.idfonction=f.idfonction
			INNER JOIN distributeur dt ON mc.distributeur_iddistributeur=dt.iddistributeur
			INNER JOIN region re ON dt.region_idregion=re.idregion
			INNER JOIN division dv ON re.division_iddivision=dv.iddivision
			WHERE dt.region_idregion=?");
		$req->bind_param("i",$idregion);
		$req->execute();
		$acteur=$req->get_result();
		$req->close();
		return $acteur;
	}

/*
* Recuperation d'acteur par Division*
*/
public function getActeurByDivision($iddivision)
	{
		$req=$this->conn->prepare(
			 "SELECT ac.idacteur id,
					ac.matricule,
					ac.tel,
					f.libele fonction,
					ac.nom_prenom nom_prenom,
					ac.username acteur,
					mc.nom moovcenter,
					dt.nom distributeur,
					re.nom region,
					dv.nom division
			FROM acteur ac
			INNER JOIN moovcenter mc ON ac.idmoovcenter=mc.idmoovcenter
			INNER JOIN fonction f on ac.idfonction=f.idfonction
			INNER JOIN distributeur dt ON mc.distributeur_iddistributeur=dt.iddistributeur
			INNER JOIN region re ON dt.region_idregion=re.idregion
			INNER JOIN division dv ON re.division_iddivision=dv.iddivision
			WHERE re.division_iddivision=?");
		$req->bind_param("i",$iddivision);
		$req->execute();
		$acteur=$req->get_result();
		$req->close();
		return $acteur;
	}

/*
* Recuperation de tous les acteurs
*/
public function getAllActeurAndDetaisl()
{
	$req=$this->conn->prepare(
		"SELECT ac.idacteur id,
				ac.matricule,
				ac.tel,
				f.libele fonction,
				ac.nom_prenom nom_prenom,
				ac.username acteur,
				mc.nom moovcenter,
				dt.nom distributeur,
				re.nom region,
				dv.nom division
		FROM acteur ac
		INNER JOIN moovcenter mc ON ac.idmoovcenter=mc.idmoovcenter
		INNER JOIN fonction f ON ac.idfonction=f.idfonction
		INNER JOIN distributeur dt ON mc.distributeur_iddistributeur=dt.iddistributeur
		INNER JOIN region re ON dt.region_idregion=re.idregion
		INNER JOIN division dv ON re.division_iddivision=dv.iddivision");
	$req->execute();
	$acteurs=$req->get_result();
	$req->close();
	return $acteurs;
}

/*
* Recuperation de tous les acteurs
*/
public function getAllActeur()
{
	$req=$this->conn->prepare(
		"SELECT ac.idacteur id,
				ac.matricule,
				ac.nom_prenom acteur 				
		FROM acteur ac ");
	$req->execute();
	$acteurs=$req->get_result();
	$req->close();
	return $acteurs;
}

/*
* Recuperation d'un acteur par ID
*/
public function getActeurById($idacteur)
{
	$req=$this->conn->prepare(
		"SELECT ac.idacteur id,
				ac.matricule,
				ac.tel,
				f.libele fonction,
				ac.nom_prenom nom_prenom,
				ac.username acteur,
				mc.nom moovcenter,
				dt.nom distributeur,
				re.nom region,
				dv.nom division
		FROM acteur ac
		INNER JOIN moovcenter mc ON ac.idmoovcenter=mc.idmoovcenter
		INNER JOIN fonction f on ac.idfonction=f.idfonction
		INNER JOIN distributeur dt ON mc.distributeur_iddistributeur=dt.iddistributeur
		INNER JOIN region re ON dt.region_idregion=re.idregion
		INNER JOIN division dv ON re.division_iddivision=dv.iddivision
		WHERE ac.idacteur=?");
	$req->bind_param("i",$idacteur);
	$req->execute();
	$acteur=$req->get_result();
	$req->close();
	return $acteur;
}


//handler moov center

public function createMoovcenter($nom,$longitude,$latitude,$description,$iddistributeur)
	{
		$geolocalisation=$longitude."#".$latitude;
		$req=$this->conn->prepare("INSERT INTO moovcenter(nom,geolocalisation,description,distributeur_iddistributeur) VALUES (?,?,?,?)");
		$req->bind_param("sssi",$nom,$geolocalisation,$description,$iddistributeur);
		$result=$req->execute();
		$req->close();

		if ($result) {
			
			$moovcenter_id = $this->conn->insert_id;
			return $moovcenter_id;
		} else {
			// task failed to create
			return NULL;
		}
	}     

public function upDateMoovcenter($idmoovcenter,$nom,$longitude,$latitude,$description,$iddistributeur)
	{
		 $geolocalisation=$longitude."#".$latitude;
		$req=$this->conn->prepare("UPDATE moovcenter SET nom=?,geolocalisation=?,description=?,distributeur_iddistributeur=? WHERE idmoovcenter=?");
		$req->bind_param("sssii",$nom,$geolocalisation,$description,$iddistributeur,$idmoovcenter);
		$result=$req->execute();
		$req->close();

		if ($result) {
			
			return $idmoovcenter;
		} else {
			// task failed to create
			return NULL;
		}
	}

public function data()
	{
		$req=$this->conn->prepare(
			"SELECT mc.idmoovcenter id,
					mc.nom moovcenter,
					mc.description,
					dt.nom distributeur,
					re.nom region,
					dv.nom division
				   
			FROM moovcenter mc
			INNER JOIN distributeur dt ON mc.distributeur_iddistributeur=dt.iddistributeur
			INNER JOIN region re ON dt.region_idregion=re.idregion
			INNER JOIN division dv ON re.division_iddivision=dv.iddivision");
		$req->execute();
		$moovcenter=$req->get_result();
		$req->close();
		return $moovcenter;
	}

public function getMoovcenterById($idmoovcenter)
	{
		$req=$this->conn->prepare(
			"SELECT mc.idmoovcenter id,
					mc.nom moovcenter,
					mc.description,
					dt.nom distributeur,
					re.nom region,
					dv.nom division
				   
			FROM moovcenter mc
			INNER JOIN distributeur dt ON mc.distributeur_iddistributeur=dt.iddistributeur
			INNER JOIN region re ON dt.region_idregion=re.idregion
			INNER JOIN division dv ON re.division_iddivision=dv.iddivision
			 WHERE moovcenter.idmoovcenter=?");
		$req->bind_param("i",$idmoovcenter);
		$req->execute();
		$moovcenter=$req->get_result();
		$req->close();
		return $moovcenter;

		;
	}

public function getIDmoovcenterByName($nom)
	{
		$req=$this->conn->prepare(
			"SELECT mc.idmoovcenter id,
					mc.nom moovcenter,
					mc.description,
					dt.nom distributeur,
					re.nom region,
					dv.nom division
			FROM moovcenter mc
			INNER JOIN distributeur dt ON mc.distributeur_iddistributeur=dt.iddistributeur
			INNER JOIN region re ON dt.region_idregion=re.idregion
			INNER JOIN division dv ON re.division_iddivision=dv.iddivision
			WHERE moovcenter.nom=?");
		$req->bind_param("s",$nom);
		$req->execute();
		$moovcenter=$req->get_result();
		$req->close();
		return $moovcenter;

	}

public function getMoovcenterByDistributeur($iddistributeur)
	{
		$req=$this->conn->prepare(
			"SELECT mc.idmoovcenter id,
					mc.nom moovcenter,
					mc.description,
					dt.nom distributeur,
					re.nom region,
					dv.nom division
			FROM moovcenter mc
			INNER JOIN distributeur dt ON mc.distributeur_iddistributeur=dt.iddistributeur
			INNER JOIN region re ON dt.region_idregion=re.idregion
			INNER JOIN division dv ON re.division_iddivision=dv.iddivision
			WHERE mc.distributeur_iddistributeur=?");
		$req->bind_param("i",$iddistributeur);
		$req->execute();
		$moovcenter=$req->get_result();
		$req->close();
		return $moovcenter;
	}

public function getMoovcenterByRegion($idregion)
	{
		$req=$this->conn->prepare(
			"SELECT mc.idmoovcenter id,
					mc.nom moovcenter,
					mc.description,
					dt.nom distributeur,
					re.nom region,
					dv.nom division
				   
			FROM moovcenter mc
			INNER JOIN distributeur dt ON mc.distributeur_iddistributeur=dt.iddistributeur
			INNER JOIN region re ON dt.region_idregion=re.idregion
			INNER JOIN division dv ON re.division_iddivision=dv.iddivision
			WHERE dt.region_idregion=?");
		$req->bind_param("i",$idregion);
		$req->execute();
		$moovcenter=$req->get_result();
		$req->close();
		return $moovcenter;

	}

public function getMoovcenterByDivision($iddivision)
	{
		 $req=$this->conn->prepare(
			"SELECT mc.idmoovcenter id,
					mc.nom moovcenter,
					mc.description,
					dt.nom distributeur,
					re.nom region,
					dv.nom division
				   
			FROM moovcenter mc
			INNER JOIN distributeur dt ON mc.distributeur_iddistributeur=dt.iddistributeur
			INNER JOIN region re ON dt.region_idregion=re.idregion
			INNER JOIN division dv ON re.division_iddivision=dv.iddivision
			WHERE re.division_iddivision=?");
		$req->bind_param("i",$iddivision);
		$req->execute();
		$acteur=$req->get_result();
		$req->close();
		return $acteur;
	}


/*
* Creer un distributeur
*/
public function createDistributeur($nom,$tel,$email,$description,$idregion)
   {

		$req=$this->conn->prepare("INSERT INTO distributeur(nom,tel,email,description,region_idregion) VALUES (?,?,?,?,?)");
		$req->bind_param("ssssi",$nom,$tel,$email,$description,$idregion);
		$result=$req->execute();
		$req->close();

		if ($result) {
			
			$distributeur_id = $this->conn->insert_id;
			return $distributeur_id;
		} else {
			// task failed to create
			return NULL;
		}
   }

   /*
* MAJ d'un distributeur
*/
public function upDateDistributeur($iddistributeur,$nom,$tel,$email,$description,$idregion)
	{
		$req=$this->conn->prepare("UPDATE distributeur SET nom=?,email=?,tel=?,description=?,region_idregion=? WHERE idmoovcenter=?");
		$req->bind_param("ssssii",$nom,$tel,$email,$description,$idregion,$iddistributeur);
		$result=$req->execute();
		$req->close();

		if ($result) {
			
			return $iddistributeur;
		} else {
			// task failed to create
			return NULL;
		}

	}
	
/*
* Recuperation de tous les distributeurs
*/
public function getAllDistributeur()
	{
		$req=$this->conn->prepare(
			"SELECT dt.iddistributeur id,
					dt.nom distributeur,
					dt.description description,
					re.nom region,
					dv.nom division 
				
				FROM distributeur dt
				INNER JOIN region re ON dt.region_idregion=re.idregion
				INNER JOIN division dv ON re.division_iddivision=dv.iddivision 
			");
		$req->execute();
		$distributeur=$req->get_result();
		$req->close();
		return $distributeur;
	}

	
public function getDistributeurById($iddistributeur)
	{
		$req=$this->conn->prepare(
			"SELECT dt.iddistributeur id,
					dt.nom distributeur,
					dt.description description,
					re.nom region,
					dv.nom division
				FROM distributeur dt
				INNER JOIN region re ON dt.region_idregion=re.idregion
				INNER JOIN division dv ON re.division_iddivision=dv.iddivision 
				WHERE (dt.iddistributeur=?)
			");
		$req->bind_param("i",$iddistributeur);
		$req->execute();
		$distributeur=$req->get_result();
		$req->close();
		return $distributeur;
	}

public function getIdDistributeurByName($libele)
	{
		$req=$this->conn->prepare(
			"SELECT dt.iddistributeur id,
					dt.nom distributeur,
					dt.description description,
					re.nom region,
					dv.nom division 
					

				FROM distributeur dt
				INNER JOIN region re ON dt.region_idregion=re.idregion
				INNER JOIN division dv ON re.division_iddivision=dv.iddivision 
				WHERE (dt.nom=?)");
		$req->bind_param("s",$libele);
		$req->execute();
		$distributeur=$req->get_result();
		$req->close();
		return $distributeur;

	}

public function getDistributeurByRegion($idregion)
	{
		$req=$this->conn->prepare(
			"SELECT dt.iddistributeur id,
					dt.nom distributeur,
					dt.description description,
					re.nom region,
					dv.nom division 
					
			FROM distributeur dt
			INNER JOIN region re ON dt.region_idregion=re.idregion
			INNER JOIN division dv ON re.division_iddivision=dv.iddivision                         
			WHERE dt.region_idregion=?");
		$req->bind_param("i",$idregion);
		$req->execute();
		$distributeur=$req->get_result();
		$req->close();
		return $distributeur;

	}
	
/*
* Recuperation d'un acteur par ID
*/
public function getDistributeurByDivision($iddivision)
{
  $req=$this->conn->prepare(
		"SELECT dt.iddistributeur id,
				dt.nom distributeur,
				dt.description description,
				re.nom region,
				dv.nom division 
		FROM distributeur dt
		INNER JOIN region re ON dt.region_idregion=re.idregion
		INNER JOIN division dv ON re.division_iddivision=dv.iddivision                         
		WHERE re.division_iddivision=?");
	$req->bind_param("i",$iddivision);
	$req->execute();
	$distributeur=$req->get_result();
	$req->close();
	return $distributeur;

}

// handler region
/*
* Créeation region
*/
public function createRegion($nom,$description,$iddivision)
   {
		 $req=$this->conn->prepare("INSERT INTO region(nom,description,division_iddivision) VALUES (?,?,?)");
		$req->bind_param("ssi",$nom,$description,$iddivision);
		$result=$req->execute();
		$req->close();

		if ($result) {
			
			$distributeur_id = $this->conn->insert_id;
			return $distributeur_id;
		} else {
			// task failed to create
			return NULL;
		}
   }

/*
* MAJ Region
*/
public function upDateRegion($idregion,$nom,$description,$iddivision)
	{
		 $req=$this->conn->prepare("UPDATE region SET nom=?,description=?,division_iddivision=? WHERE idmoovcenter=?");
		$req->bind_param("ssii",$idregion,$nom,$description,$iddivision);
		$result=$req->execute();
		$req->close();

		if ($result) {
			
			return $idregion;
		} else {
			// task failed to create
			return NULL;
		}

 
	}

/*
* Recuperation region
*/
public function getAllRegion()
	{
		$req=$this->conn->prepare(
			"SELECT re.idregion id,
					re.nom region,
					re.description description,
					dv.nom division 
			FROM region re
			INNER JOIN division dv ON re.division_iddivision=dv.iddivision"
			);
		$req->execute();
		$region=$req->get_result();
		$req->close();
		return $region; 
	}

	
/*
* Recuperation region
*/
public function getAllMoovCenter()
{
	$req=$this->conn->prepare(
		"SELECT mc.idmoovcenter id,
				mc.nom moovcenter
		FROM moovcenter mc"
		);
	$req->execute();
	$region=$req->get_result();
	$req->close();
	return $region; 
}
	
/*
* Recuperation region par id
*/
public function getRegionById($idregion)
	{
		$req=$this->conn->prepare(
			"SELECT re.idregion id,
					re.nom region,
					re.description description,
					dv.nom division
			FROM region re
			INNER JOIN division dv ON re.division_iddivision=dv.iddivision
			WHERE re.idregion=?");
		$req->bind_param("i",$idregion);
		$req->execute();
		$region=$req->get_result();
		$req->close();
		return $region;

	}
/*
* Recuperation regionpar son nom
*/
public function getIdRegionByName($libele)
	{
		 $req=$this->conn->prepare(
			"SELECT re.idregion id,
					re.nom region,
					re.description description,
					dv.nom division
				   
			FROM region re
			INNER JOIN division dv ON re.division_iddivision=dv.iddivision
			WHERE re.nom=?");
		$req->bind_param("s",$libele);
		$req->execute();
		$region=$req->get_result();
		$req->close();
		return $region;

	}

/*
* Recuperation region par division
*/
public function getRegionByDivision($iddivision)
	{
		$req=$this->conn->prepare(
			"SELECT re.idregion id,
					re.nom region,
					re.description description,
					dv.nom division
			FROM region re
			INNER JOIN division dv ON re.division_iddivision=dv.iddivision
			WHERE re.division_iddivision=?");
		$req->bind_param("i",$iddivision);
		$req->execute();
		$region=$req->get_result();
		$req->close();
		return $region;
	}

//division

/*
* creation division
*/
public function createDivision($nom,$description)
   {
		 $req=$this->conn->prepare("INSERT INTO division(nom,description) VALUES (?,?)");
		$req->bind_param("ss",$nom,$description);
		$result=$req->execute();
		$req->close();

		if ($result) {
			
			$division_id = $this->conn->insert_id;
			return $division_id;
		} else {
			// task failed to create
			return NULL;
		}
   }

   /*
* MAJ division
*/
public function upDateDivision($iddivision,$nom,$description)
	{
		 $req=$this->conn->prepare("UPDATE division SET nom=?,description=? WHERE iddivision=?");
		$req->bind_param("ssi",$nom,$description,$iddivision);
		$result=$req->execute();
		$req->close();

		if ($result) {
			
			return $iddivision;
		} else {
			// task failed to create
			return NULL;
		}

 
	}

/*
* Recuperation toutes region
*/
public function getAllDivision()
	{
		$req=$this->conn->prepare(
			"SELECT dv.iddivision id,
					dv.nom division, 
					dv.description description
			 FROM division dv
			 ");
		$req->execute();
		$division=$req->get_result();
		$req->close();
		return $division; 
	}

/*
* Recuperation region par ID
*/
public function getDivisionById($iddivision)
	{
		$req=$this->conn->prepare(
			"SELECT dv.iddivision id,
					dv.nom division,
					dv.description description
			 FROM division dv 
			 WHERE dv.iddivision=?");
		$req->bind_param("i",$iddivision);
		$req->execute();
		$division=$req->get_result();
		$req->close();
		return $division;

	}

/*
* Recuperation region par nom
*/	
public function getIdDivisionByName($libele)
	{
		 $req=$this->conn->prepare("SELECT * FROM division WHERE division.nom=?");
		$req->bind_param("s",$libele);
		$req->execute();
		$division=$req->get_result();
		$req->close();
		return $division;

	}

//categorie
/*
* création categorie
*/
public function CreateCategorie($libele,$description)
	{
		$req=$this->conn->prepare("INSERT INTO categorie(libele,description) VALUES (?,?)");
		$req->bind_param("ss",$libele,$description);
		$result=$req->execute();
		$req->close();

		if ($result) {
			
			$categorie_id = $this->conn->insert_id;
			return $categorie_id;
		} else {
			// task failed to create
			return NULL;
		}

	}

/*
* MAJ categorie
*/	
public function upDateCategorie($idcategorie,$libele,$description)
	{
		$req=$this->conn->prepare("UPDATE categorie SET libele=?,description=? WHERE idcategorie=?");
		$req->bind_param("ssi",$libele,$description,$idcategorie);
		$result=$req->execute();
		$req->close();

		if ($result) {
			
		   
			return $idcategorie;
		} else {
			// task failed to create
			return NULL;
		}

	}

/*
* recuperation toutes categorie
*/
public function getAllCategorie()
	{
		$req=$this->conn->prepare("SELECT * FROM categorie");
		$req->execute();
		$categories=$req->get_result();
		$req->close();
		return $categories;
	}

/*
* création categorie par ID
*/
public function getCategorieById($idcategorie)
	{
		$req=$this->conn->prepare("SELECT * FROM categorie WHERE categorie.idcategorie=?");
		$req->bind_param("i",$idcategorie);
		$req->execute();
		$categorie=$req->get_result();
		$req->close();
		return $categorie;
	}

/*
* recuperation ID categorie par libele
*/
public function getIdCategorieBylibele($libele)
	{
		$req=$this->conn->prepare("SELECT idcategorie FROM categorie WHERE categorie.libele=?");
		$req->bind_param("s",$libele);
		$req->execute();
		$categorie=$req->get_result();
		$req->close();
		return $categorie;
	}

/*
* verification si categorie existe 
*/
public function isCategorieExiste($libele)
	{
		 $req = $this->conn->prepare("SELECT idcategorie from categorie WHERE libele = ?");
		$req->bind_param("s", $libele);
		$req->execute();
		$req->store_result();
		$num_rows = $req->num_rows;
		$req->close();
		return $num_rows > 0;
	}
	
/*
* Creation de produit
*/	
// handler produit

public function createProduit($nom_prod,$prix,$quantite,$description,$idcategorie)
   {
	 $req=$this->conn->prepare("INSERT INTO produit(nom_prod,prix,quantite, description,idcategorie) VALUES (?,?,?,?,?)");
		$req->bind_param("sdisi",$nom_prod,$prix,$quantite,$description,$idcategorie);
		$result=$req->execute();
		$req->close();

		if ($result) {
			
			$produi_id = $this->conn->insert_id;
			return $produi_id;
		} else {
			// task failed to create
			return NULL;
		}
   }

public function upDateProduit($idproduit,$nom_prod,$prix,$quantite,$description,$idcategorie)
{
 $req=$this->conn->prepare("UPDATE produit SET nom_prod=?,prix=?,quantite=?,description=?,idcategorie=? WHERE idproduit=?");
$req->bind_param("sdisii",$nom_prod,$prix,$quantite,$description,$idcategorie,$idproduit);
$result=$req->execute();
$req->close();

if ($result) {
	
	return $idproduit;
} else {
	// task failed to create
	return NULL;
}


}
/*
recuperatio des produits
*/
public function getAllProduit()
	{
		$req=$this->conn->prepare(
			"SELECT p.idproduit,
					p.nom_prod nom_prod,
					p.prix,
					p.quantite quantite,
					p.description,
				   cat.libele categorie
			FROM produit p
			INNER JOIN type_produit cat ON p.idcategorie=cat.idcategorie
			 ");
		$req->execute();
		$produits=$req->get_result();
		$req->close();
		return $produits; 
	}

	/*
recuperatio des type de produit
*/
public function getAllTypeProduit()
{
	$req=$this->conn->prepare(
		"SELECT * FROM type_produit ");
	$req->execute();
	$produits=$req->get_result();
	$req->close();
	return $produits; 
}
/*
recuêrer produit par id
*/
public function getProduitById($idproduit)
	{
		 $req=$this->conn->prepare(
			"SELECT p.idproduit,
					p.libele libele,
					p.prix,
					p.description,
				   cat.libele categorie
			FROM produit p
			INNER JOIN type_produit cat ON p.idcategorie=cat.idcategorie
			WHERE p.idproduit=?
			 ");
		 $req->bind_param("i",$idproduit);
		$req->execute();
		$produits=$req->get_result();
		$req->close();
		return $produits;

	}

/*
recuperer produit par nom
*/
public function getIdProduitByName($libele)
	{
		$req=$this->conn->prepare(
			"SELECT p.idproduit,
					p.libele,
					p.prix,
					p.description,
				   cat.libele categorie
			FROM produit p
			INNER JOIN type_produit cat ON p.idcategorie=cat.idcategorie
			WHERE p.libele=?
			 ");
		 $req->bind_param("s",$libele);
		$req->execute();
		$produits=$req->get_result();
		$req->close();
		return $produits;

	}

/*
recuperatio produit par categorie
*/
public function getProductByCategorie($idategorie)
	{
		$req=$this->conn->prepare(
			"SELECT p.idproduit,
					p.nom_prod libele,
					p.prix,
					p.description,
				   cat.libele categorie
			FROM produit p
			INNER JOIN type_produit cat ON p.idcategorie=cat.idcategorie
			WHERE p.idcategorie=?
			 ");
			 //var_dump($idategorie);
		 $req->bind_param("i",$idategorie);
		$req->execute();
		$produits=$req->get_result();
		$req->close();
		return $produits;

	}

	
/*
recuperation des types de produits
*/
public function getProductTypes()
	{
		$req=$this->conn->prepare("SELECT * FROM type_produit");
		// $req->bind_param("i",$idategorie);
		$req->execute();
		$produits=$req->get_result();
		$req->close();
		return $produits;

	}

		
/*
recuperation des assignations
*/
public function getAssignations()
	{
		$req=$this->conn->prepare("SELECT * FROM assignation");
		// $req->bind_param("i",$idategorie);
		$req->execute();
		$produits=$req->get_result();
		$req->close();
		return $produits;

	}
/*
verification si produit existe
*/
public function isProduitExiste($libele)
	{
		  $req = $this->conn->prepare("SELECT idproduit from produit WHERE libele = ?");
		$req->bind_param("s", $libele);
		$req->execute();
		$req->store_result();
		$num_rows = $req->num_rows;
		$req->close();
		return $num_rows > 0;
		
	}
	
      //hanler motif
/*
creer un motif
*/
public function CreateMotif($libele)
{
	$req=$this->conn->prepare("INSERT INTO motif(libele) VALUES (?)");
	$req->bind_param("s",$libele);
	$result=$req->execute();
	$req->close();

	if ($result) {
		
		$motif_id = $this->conn->insert_id;
		return $motif_id;
	} else {
		// task failed to create
		return NULL;
	}
}

/*
creer un type motif
*/
public function CreateTypeMotif($libele)
{
	$req=$this->conn->prepare("INSERT INTO type_motif(libele) VALUES (?)");
	$req->bind_param("s",$libele);
	$result=$req->execute();
	$req->close();

	if ($result) {
		
		$motif_id = $this->conn->insert_id;
		return $motif_id;
	} else {
		// task failed to create
		return NULL;
	}
}

/*
creer un sous motif
*/
public function CreateSousMotif($libele)
{
	$req=$this->conn->prepare("INSERT INTO sous_motif(libele) VALUES (?)");
	$req->bind_param("s",$libele);
	$result=$req->execute();
	$req->close();

	if ($result) {
		
		$motif_id = $this->conn->insert_id;
		return $motif_id;
	} else {
		// task failed to create
		return NULL;
	}

}

/*
MAJ motif
*/
public function upDateMotif($idmotif,$libele)
	{
		$req=$this->conn->prepare("UPDATE motif SET libele=? WHERE idmotif=?");
		$req->bind_param("si",$libele,$idmotif);
		$result=$req->execute();
		$req->close();

		if ($result) 
		{
			
		   
			return $idmotif;
		} 
		else 
		{
			// task failed to create
			return NULL;
		}

	}

/*
MAJ type motif
*/
public function upDateTypeMotif($idmotif,$libele)
	{
		$req=$this->conn->prepare("UPDATE type_motif SET libele=? WHERE id_typemotif=?");
		$req->bind_param("si",$libele,$idmotif);
		$result=$req->execute();
		$req->close();

		if ($result) {
			
		   
			return $idmotif;
		} else {
			// task failed to create
			return NULL;
		}

	}
/*
MAJ sous motif
*/
public function upDateSousMotif($idmotif,$libele)
	{
		$req=$this->conn->prepare("UPDATE sous_motif SET libele=? WHERE id_sousmotif=?");
		$req->bind_param("si",$libele,$idmotif);
		$result=$req->execute();
		$req->close();

		if ($result) {
			
		   
			return $idmotif;
		} else {
			// task failed to create
			return NULL;
		}

	}

/*
recuperer tout les sous motifs
*/
public function getAllSousMotif()
	{
		$req=$this->conn->prepare("SELECT * FROM sous_motif");
		$req->execute();
		$motifs=$req->get_result();
		$req->close();
		return $motifs;
	}

/*
recuperer tout les type motif
*/
public function getAllTypeMotif()
	{
	$req=$this->conn->prepare("SELECT * FROM type_motif");
	$req->execute();
	$motifs=$req->get_result();
	$req->close();
	return $motifs;
	}
/*
recuperer tout motif
*/	
public function getAllMotif()
	{
		$req=$this->conn->prepare("SELECT * FROM motif");
		$req->execute();
		$motifs=$req->get_result();
		$req->close();
		return $motifs;
	}

/*
recuperer  motif par ID
*/
public function getMotifById($idmotif)
	{
		$req=$this->conn->prepare("SELECT * FROM motif WHERE motif.idmotif=?");
		$req->bind_param("i",$idmotif);
		$req->execute();
		$motif=$req->get_result();
		$req->close();
		return $motif;
	}
/*
recuperer  type motif par ID
*/
public function getTypeMotifById($idmotif)
	{
		$req=$this->conn->prepare("SELECT * FROM type_motif WHERE id_typemotif=?");
		$req->bind_param("i",$idmotif);
		$req->execute();
		$motif=$req->get_result();
		$req->close();
		return $motif;
	}
/*
recuperer  Sous motif par ID
*/
public function getSousMotifById($idmotif)
	{
		$req=$this->conn->prepare("SELECT * FROM sous_motif WHERE id_sousmotif=?");
		$req->bind_param("i",$idmotif);
		$req->execute();
		$motif=$req->get_result();
		$req->close();
		return $motif;
	}
/*
*recuperer tout les sous motif liés a un type de motif bien données
*/	
public function getSousMotifByTypeMotif($id_typemotif)
	{
		$req=$this->conn->prepare("SELECT * FROM sous_motif sm
		INNER JOIN motif m ON m.idmotif=sm.idmotif
		INNER JOIN type_motif tm ON tm.id_typemotif=m.id_typemotif
		WHERE tm.id_typemotif=?");
		$req->bind_param("i",$id_typemotif);
		$req->execute();
		$motif=$req->get_result();
		$req->close();
		return $motif;
	}
/*
*recuperer tout les sous motif liés a un  motif bien données
*/	
public function getSousMotifByMotif($idmotif)
	{
		$req=$this->conn->prepare("SELECT sm.id_sousmotif, sm.libele AS sous_motif FROM sous_motif sm
		INNER JOIN motif m ON m.idmotif=sm.idmotif
		WHERE m.idmotif=?");
		$req->bind_param("i",$idmotif);
		$req->execute();
		$motif=$req->get_result();
		$req->close();
		return $motif;
	}

/*
*recuperer tout les  motifs liés a un  typemotif bien données
*/	
public function getMotifByTypeMotif($id_typemotif)
	{
		$req=$this->conn->prepare("SELECT m.idmotif, m.libele AS motif FROM motif m
		INNER JOIN type_motif tm ON tm.id_typemotif=m.id_typemotif
		WHERE tm.id_typemotif=?");
		$req->bind_param("i",$id_typemotif);
		$req->execute();
		$motif=$req->get_result();
		$req->close();
		return $motif;
	}
/*
recuperer  type motif par nom
*/
public function getIdMotifBylibele($libele)
	{
		$req=$this->conn->prepare("SELECT * FROM motif WHERE motif.libele=?");
		$req->bind_param("s",$libele);
		$req->execute();
		$motif=$req->get_result();
		$req->close();
		return $motif;
	}
/*
verifier si  motif par ID
*/
public function isMotifExiste($libele)
	{
		 $req = $this->conn->prepare("SELECT idmotif from motif WHERE libele = ?");
		$req->bind_param("s", $libele);
		$req->execute();
		$req->store_result();
		$num_rows = $req->num_rows;
		$req->close();
		return $num_rows > 0;
	}

/*
creer un visiteur
*/
public function createVisiteur($msisdn,$nom_prenom,$second_msisdn,$type_abonne,$profile_client,$formule,$canal_transmission)
{
	$req=$this->conn->prepare("INSERT INTO visiteurs
	(msisdn, nom,second_msisdn,type_abonne,profile_client,formule,canal_transmission)
	VALUES (?,?,?,?,?,?,?)");
	$req->bind_param("sssssss",$msisdn,$nom_prenom,$second_msisdn,$type_abonne,$profile_client,$formule,$canal_transmission);
	$result=$req->execute();
	$req->close();

	if ($result) {
		
		$visiteur_id = $this->conn->insert_id;
		return $visiteur_id;
	} else {
		// task failed to create
		return NULL;
	}

}

/*
creer une visite
*/
public function CreteVisite( $idvisite,$acteur_idacteur,$description,$traitement_effectue,$statut,$visiteurs_msisdn,$motif_rand)
{
	$req=$this->conn->prepare("INSERT INTO visite
	(idvisite,acteur_idacteur,description,
	traitement_effectue,statut,visiteurs_msisdn)
	VALUES (?,?,?,?,?,?)");
	$req->bind_param("iissss",$idvisite,$acteur_idacteur,$description,$traitement_effectue,$statut,$visiteurs_msisdn);
	$result=$req->execute();
	$req->close();

	if ($result) {
		
		$visite_id = $this->conn->insert_id;
		// recuperer la sequance de visite
		//var_dump($visite_id);
		$sequance=$this->getMotifSequance($motif_rand);
		//var_dump($sequance);
		$nouvelle_sequence=intval($sequance)+1;
		//var_dump($nouvelle_sequence);
		$ret=$this->UpdateMotifSequance	($motif_rand,$nouvelle_sequence);
		//var_dump($ret);
		return $idvisite;
	} else {
		// task failed to create
		return NULL;
	}

}

/*
creer une motif de visite
*/
public function createVisiteMotif($id_sousmotif,$idvisite)
{
	//var_dump($id_sousmotif,$idvisite);
	$req=$this->conn->prepare("INSERT INTO visite_sous_motif
	(id_sousmotif,idvisite)
	VALUES (?,?)");
	$req->bind_param("ii",$id_sousmotif,$idvisite);
	$result=$req->execute();
	$req->close();

	if ($result) {
		
		$visite_motif_id = $this->conn->insert_id;
		return $visite_motif_id;
	} else {
		// task failed to create
		return NULL;
	}
}

/*
creer une vente
*/
public function CreateVente($code_vente,$acteur_idacteur,$montant_vente,$idvisite)
{
	$req=$this->conn->prepare("INSERT INTO vente
	( code_vente, acteur_idacteur,montant_vente,idvisite)
	VALUES (?,?,?,?)");
	$req->bind_param("sidi",$code_vente,$acteur_idacteur,$montant_vente,$idvisite);
	$result=$req->execute();
	$req->close();

	if ($result) {
		
		$vente_id = $this->conn->insert_id;
		return $vente_id;
	} else {
		// task failed to create
		return NULL;
	}

}	
 
/*
creer une vente de produits
*/
public function CreateVenteProduit($retour_vente_id,$idproduit,$quantite)
{
	$req=$this->conn->prepare("INSERT INTO vente_has_produit
	(idvente,idproduit,quantite)
	VALUES (?,?,?)");
	$req->bind_param("iii",$retour_vente_id,$idproduit,$quantite);
	$result=$req->execute();
	$req->close();

	if ($result) 
	{
		
		$vente_produit_id = $this->conn->insert_id;
		return $vente_produit_id;
	} else {
		// task failed to create
		return NULL;
	}
}
 
/*
Rechercher les visites en fonction de plusieurs criteres
*/
public function SearchAllVisiteByDate($date_debut,$date_fin,$query_where)
{
	$query="
			SELECT visite.idvisite,
			visite.datevisite,
			visite.description,
			visite.traitement_effectue,
			visite.statut,
			visite.acteur_idacteur,
			visite.visiteurs_msisdn,
			type_motif.libele as type_motif,
			motif.libele AS motif,
			sous_motif.libele AS sous_motif,
			ac.nom_prenom AS acteur,
			visiteurs.nom AS visiteur,
			moovcenter.nom AS moovcenter,
			distributeur.nom AS distributeur,
			region.nom AS region,
			division.nom AS division
			FROM visite
			INNER JOIN visite_sous_motif ON visite_sous_motif.idvisite=visite.idvisite
			INNER JOIN sous_motif ON sous_motif.id_sousmotif=visite_sous_motif.id_sousmotif
			INNER JOIN motif ON motif.idmotif=sous_motif.idmotif
			INNER JOIN type_motif ON type_motif.id_typemotif=motif.id_typemotif
			INNER JOIN acteur ac ON ac.idacteur=visite.acteur_idacteur
			INNER JOIN visiteurs ON visiteurs.msisdn= visite.visiteurs_msisdn
			INNER JOIN acteur  ON visite.acteur_idacteur=acteur.idacteur
			INNER JOIN moovcenter  ON ac.idmoovcenter=moovcenter.idmoovcenter
			INNER JOIN distributeur  ON moovcenter.distributeur_iddistributeur=distributeur.iddistributeur 
			INNER JOIN region ON distributeur.region_idregion=region.idregion 
			INNER JOIN division  ON region.division_iddivision=division.iddivision
			WHERE (visite.datevisite BETWEEN ? AND ?)";
			
	if ($query_where!="" OR !empty($query_where))
	{
		$complete_query=$query.$query_where;
	}
	else
	{
		$complete_query=$query;//substr($query,strlen($query)-5,3);
	}
	//echo $complete_query; exit();
	$req = $this->conn->prepare($complete_query);
	$req->bind_param("ss", $date_debut,$date_fin);
	$req->execute();
	//$req->store_result();
	$result = $req->get_result();
	$req->close();
	return $result;
}

/*
Stat_nombre de visiteurs par decoupage
*/
public function stat_nombreViviteurDecoupage($date_debut,$date_fin,$query_where)
{
	$query="
			SELECT distinct   visite.idvisite,
				count(visite.visiteurs_msisdn) total_visiteurs,
				visite.acteur_idacteur,
				ac.nom_prenom AS acteur,
				 moovcenter.nom AS moovcenter,
				distributeur.nom AS distributeur,
				region.nom AS region,
				division.nom AS division
				FROM visite
				INNER JOIN acteur ac ON ac.idacteur=visite.acteur_idacteur
				INNER JOIN visiteurs ON visiteurs.msisdn= visite.visiteurs_msisdn
				INNER JOIN acteur  ON visite.acteur_idacteur=acteur.idacteur
				INNER JOIN moovcenter  ON ac.idmoovcenter=moovcenter.idmoovcenter
				INNER JOIN distributeur  ON moovcenter.distributeur_iddistributeur=distributeur.iddistributeur 
				INNER JOIN region ON distributeur.region_idregion=region.idregion 
				INNER JOIN division  ON region.division_iddivision=division.iddivision			
				WHERE (visite.datevisite BETWEEN ? AND ?)
				";
			
	 if ($query_where!="" OR !empty($query_where))
	 {
		$complete_query=$query.$query_where;
	}
	else
	{
		$complete_query=$query;//$query_where;
	}
	//echo $complete_query; exit();
	$req = $this->conn->prepare($complete_query);
	$req->bind_param("ss", $date_debut,$date_fin);
	$req->execute();
	//$req->store_result();
	$result = $req->get_result();
	$req->close();
	return $result;
}

/*
Stat nombre enregistrement par gourpe motif ( type, motif, et sous motif) et/par decoupage ( acteur, ....devision))
*/
public function  stat_total_visitesByGroupMotifAndDecoupage($date_debut,$date_fin,$query_condition)
{
	$query="	SELECT visite.idvisite,
				type_motif.libele as type_motif,
				COUNT(type_motif.id_typemotif) AS total_type_motif,
				motif.libele AS motif,
				COUNT( motif.idmotif) AS  total_motif,
				sous_motif.libele AS sous_motif,
				COUNT( sous_motif.id_sousmotif) total_sous_motif,
				visite.statut,		
				ac.nom_prenom AS acteur,
				visiteurs.nom AS visiteur,
				 moovcenter.nom AS moovcenter,
				distributeur.nom AS distributeur,
				region.nom AS region,
				division.nom AS division
				FROM visite
				INNER JOIN visite_sous_motif ON visite_sous_motif.idvisite=visite.idvisite
				INNER JOIN sous_motif ON sous_motif.id_sousmotif=visite_sous_motif.id_sousmotif
				INNER JOIN motif ON motif.idmotif=sous_motif.idmotif
				INNER JOIN type_motif ON type_motif.id_typemotif=motif.id_typemotif
				INNER JOIN acteur ac ON ac.idacteur=visite.acteur_idacteur
				INNER JOIN visiteurs ON visiteurs.msisdn= visite.visiteurs_msisdn
				INNER JOIN acteur  ON visite.acteur_idacteur=acteur.idacteur
				INNER JOIN moovcenter  ON ac.idmoovcenter=moovcenter.idmoovcenter
				INNER JOIN distributeur  ON moovcenter.distributeur_iddistributeur=distributeur.iddistributeur 
				INNER JOIN region ON distributeur.region_idregion=region.idregion 
				INNER JOIN division  ON region.division_iddivision=division.iddivision
				WHERE (visite.datevisite BETWEEN ? AND ?) ";
			
	// if ($query_where!="" OR !empty($query_where))
	// {
		$complete_query=$query.$query_where;
	// }
	//echo $complete_query; exit();
	$req = $this->conn->prepare($complete_query);
	$req->bind_param("ss", $date_debut,$date_fin);
	$req->execute();
	//$req->store_result();
	$result = $req->get_result();
	$req->close();
	return $result;
}

/**
*total des vente (en quantité et CA) goupé par produit/type_produit realisé par un decoupage donné (par acteur, moovcenter, distributeur, region, division)
*/
public function stat_TotalVenteByActeurGroupByProduit($date_debut,$date_fin,$query_where)
{
		$query="SELECT	vente.code_vente,
				vente.datevente,
				vente.acteur_idacteur,
				vente.montant_vente,
				vente.idvisite,			
				vente_has_produit.idvente,
				vente_has_produit.idproduit,				
				produit.prix,
				produit.description,
				produit.idcategorie AS id_type_Prod,
				type_produit.libele AS type_produit,
				produit.nom_prod AS produit,			
				COUNT( produit.idproduit) AS total,
				SUM(vente_has_produit.quantite*produit.prix) total_vente,
				ac.nom_prenom AS acteur,
				visiteurs.nom AS visiteur,
				moovcenter.nom AS moovcenter,
				distributeur.nom AS distributeur,
				region.nom AS region,
				division.nom AS division
				FROM vente
				INNER JOIN visite ON vente.idvisite=visite.idvisite
				INNER JOIN vente_has_produit ON vente_has_produit.idvente=vente.idvente
				INNER JOIN produit ON produit.idproduit=vente_has_produit.idproduit
				INNER JOIN type_produit ON type_produit.idcategorie=produit.idcategorie
				INNER JOIN acteur ac ON ac.idacteur=visite.acteur_idacteur
				INNER JOIN visiteurs ON visiteurs.msisdn= visite.visiteurs_msisdn
				INNER JOIN acteur  ON vente.acteur_idacteur=acteur.idacteur
				INNER JOIN moovcenter  ON ac.idmoovcenter=moovcenter.idmoovcenter
				INNER JOIN distributeur  ON moovcenter.distributeur_iddistributeur=distributeur.iddistributeur 
				INNER JOIN region ON distributeur.region_idregion=region.idregion 
				INNER JOIN division  ON region.division_iddivision=division.iddivision
				WHERE (vente.datevente  BETWEEN ? AND ?) ";
			
	// if ($query_where!="" OR !empty($query_where))
	// {
		$complete_query=$query.$query_where;
	// }
	//echo $complete_query; exit();
	$req = $this->conn->prepare($complete_query);
	$req->bind_param("ss", $date_debut,$date_fin);
	$req->execute();
	//$req->store_result();
	$result = $req->get_result();
	$req->close();
	return $result;
}

/**
*total des vente (en quantité et CA) par produit/type produit ET par Acteur
*/
public function stat_TotalVenteByActeurAndProduit($date_debut,$date_fin,$query_where)
{
	$query="	SELECT	vente.code_vente,
				vente.datevente,
				vente.acteur_idacteur,
				vente.montant_vente,
				vente.idvisite,			
				vente_has_produit.idvente,
				vente_has_produit.idproduit,				
				produit.prix,
				produit.description,
				produit.idcategorie AS id_type_Prod,
				type_produit.libele AS type_produit,
				produit.nom_prod AS produit,			
				COUNT( produit.idproduit) AS total,
				SUM(vente_has_produit.quantite*produit.prix) total_vente,
				ac.nom_prenom AS acteur,
				visiteurs.nom AS visiteur,
				moovcenter.nom AS moovcenter,
				distributeur.nom AS distributeur,
				region.nom AS region,
				division.nom AS division
				FROM vente
				INNER JOIN visite ON vente.idvisite=visite.idvisite
				INNER JOIN vente_has_produit ON vente_has_produit.idvente=vente.idvente
				INNER JOIN produit ON produit.idproduit=vente_has_produit.idproduit
				INNER JOIN type_produit ON type_produit.idcategorie=produit.idcategorie
				INNER JOIN acteur ac ON ac.idacteur=visite.acteur_idacteur
				INNER JOIN visiteurs ON visiteurs.msisdn= visite.visiteurs_msisdn
				INNER JOIN acteur  ON vente.acteur_idacteur=acteur.idacteur
				INNER JOIN moovcenter  ON ac.idmoovcenter=moovcenter.idmoovcenter
				INNER JOIN distributeur  ON moovcenter.distributeur_iddistributeur=distributeur.iddistributeur 
				INNER JOIN region ON distributeur.region_idregion=region.idregion 
				INNER JOIN division  ON region.division_iddivision=division.iddivision
				WHERE (vente.datevente  BETWEEN ? AND ?) ";
			
	// if ($query_where!="" OR !empty($query_where))
	// {
		$complete_query=$query.$query_where;
	// }
	echo $complete_query; exit();
	$req = $this->conn->prepare($complete_query);
	$req->bind_param("ss", $date_debut,$date_fin);
	$req->execute();
	//$req->store_result();
	$result = $req->get_result();
	$req->close();
	return $result;
}

/**
*calculer le taux de réalisation d'un objectif'
*/
public function stat_CheckTauxRealisationObjectif($date_debut,$date_fin,$query_where,$taux)
{
	$query="	SELECT	vente.code_vente,
				vente.datevente,
				vente.acteur_idacteur,
				vente.montant_vente,
				vente.idvisite,			
				vente_has_produit.idvente,
				vente_has_produit.idproduit,				
				produit.prix,
				produit.description,
				produit.idcategorie AS id_type_Prod,
				type_produit.libele AS type_produit,
				produit.nom_prod AS produit,			
				COUNT( produit.idproduit) AS total,
				SUM(vente_has_produit.quantite*produit.prix) AS total_vente,".
				$taux
				."ac.nom_prenom AS acteur,
				visiteurs.nom AS visiteur,
				moovcenter.nom AS moovcenter,
				distributeur.nom AS distributeur,
				region.nom AS region,
				division.nom AS division
				FROM vente
				INNER JOIN visite ON vente.idvisite=visite.idvisite
				INNER JOIN vente_has_produit ON vente_has_produit.idvente=vente.idvente
				INNER JOIN produit ON produit.idproduit=vente_has_produit.idproduit
				INNER JOIN type_produit ON type_produit.idcategorie=produit.idcategorie
				INNER JOIN acteur ac ON ac.idacteur=visite.acteur_idacteur
				INNER JOIN visiteurs ON visiteurs.msisdn= visite.visiteurs_msisdn
				INNER JOIN acteur  ON vente.acteur_idacteur=acteur.idacteur
				INNER JOIN moovcenter  ON ac.idmoovcenter=moovcenter.idmoovcenter
				INNER JOIN distributeur  ON moovcenter.distributeur_iddistributeur=distributeur.iddistributeur 
				INNER JOIN region ON distributeur.region_idregion=region.idregion 
				INNER JOIN division  ON region.division_iddivision=division.iddivision
				WHERE (vente.datevente  BETWEEN ? AND ?) ";
			
	// if ($query_where!="" OR !empty($query_where))
	// {
		$complete_query=$query.$query_where;
	// }
	echo $complete_query; exit();
	$req = $this->conn->prepare($complete_query);
	$req->bind_param("ss", $date_debut,$date_fin);
	$req->execute();
	//$req->store_result();
	$result = $req->get_result();
	$req->close();
	return $result;
}

/*
recuperer les objectifs crées
*/
public function getAllVisiteByDate($date_debut,$date_fin)
{
		//$query=;	
		//echo $query.$query_where; exit();	
		$req = $this->conn->prepare("
		SELECT `visite`.`idvisite`,
		`visite`.`datevisite`,
		`visite`.`description`,
		`visite`.`traitement_effectue`,
		`visite`.`statut`,
		`visite`.`acteur_idacteur`,
	    `visite`.`visiteurs_msisdn`,
		`type_motif`.`libele` as type_motif,
		`motif`.`libele` AS motif,
		`sous_motif`.`libele` AS sous_motif,
		 `acteur`.`nom_prenom` AS acteur,
		 `visiteurs`.`nom` AS visiteur
		FROM `oram_demo`.`visite`
		INNER JOIN visite_sous_motif ON `visite_sous_motif`.`idvisite`=`visite`.`idvisite`
		INNER JOIN `sous_motif` ON `sous_motif`.`id_sousmotif`=`visite_sous_motif`.`id_sousmotif`
		INNER JOIN `motif`ON `motif`.`idmotif`=`sous_motif`.`idmotif`
		INNER JOIN `type_motif` ON `type_motif`.`id_typemotif`=`motif`.`id_typemotif`
		INNER JOIN `acteur` ON `acteur`.`idacteur`=`visite`.`acteur_idacteur`
		INNER JOIN `visiteurs` ON `visiteurs`.`msisdn`= `visite`.`visiteurs_msisdn`
		WHERE (`visite`.`datevisite` BETWEEN ? AND ? ) ");
		$req->bind_param("ss", $date_debut,$date_fin);
		$req->execute();
		//$req->store_result();
		$result = $req->get_result();
		$req->close();
		return $result;
	}

 
/*
creer un objectif
*/
public function  saveObjectif($type_objectif,$valeur,$date_debut,$date_fin, $creer_par,$id_type_produit)
{
	$req=$this->conn->prepare("INSERT INTO objectif
(type_objectif,valeur,date_debut,date_fin,creer_par,id_type_produit)
	VALUES (?,?,?,?,?,?)");
	$req->bind_param("sdssii",$type_objectif,$valeur,$date_debut,$date_fin, $creer_par,$id_type_produit);
	$result=$req->execute();
	$req->close();
    $obj_id = $this->conn->insert_id;
	// if ($result) 
	// {
		
		
		return $obj_id;
	// } else {
		//task failed to create
		// return NULL;
	// }
}
/*
creer une assignation d'objectif'
*/
public function  saveAssignationObjectif($ret_objectif_id,$type_assigantion,$val_assignation)
{
	$req=$this->conn->prepare("INSERT INTO objectif_has_assignation
(idobjectif,assignation_id,assigne_a)
	VALUES (?,?,?)");
	$req->bind_param("iii",$ret_objectif_id,$type_assigantion,$val_assignation);
	$result=$req->execute();
	$req->close();
    $assign_id = $this->conn->insert_id;
	// if ($assign_id) 
	// {
		//var_dump($assign_id);
		return $assign_id;
	// } else {
		// task failed to create
		 // return NULL;
	// }
 }
 
/*
recuperer les objectifs crées
*/
public function getObjectifList()
	{
		$req = $this->conn->prepare("
		SELECT 
		objectif.idobjectif,
		objectif.type_objectif,
		objectif.valeur,
		objectif.date_debut,
		objectif.date_fin,
		objectif.date_create,
		objectif.status,
		type_produit.libele AS type_produit,
		objectif_has_assignation.assignation_id,
		objectif_has_assignation.assigne_a AS applicable_a,
		assignation.nom AS type_assigantion
		FROM oram_demo.objectif
		INNER JOIN objectif_has_assignation ON objectif_has_assignation.idobjectif=objectif.idobjectif
		INNER JOIN type_produit ON type_produit.idcategorie=objectif.id_type_produit
		INNER JOIN assignation ON assignation.id=objectif_has_assignation.assignation_id
		");
		//$req->bind_param("s", $libele);
		$req->execute();
		//$req->store_result();
		$result = $req->get_result();
		$req->close();
		return $result;
	}

 /*
 verification d'existance d'un visiteur dans la base des visiteur
 */
public function  getAssignementValeur($table_name,$assigne_a,$nom)
{
	$id="id".$table_name;
	
	$query="SELECT  ".$nom." FROM ".$table_name." WHERE  ".$id."= ?";
	//var_dump($query);
	$stmt = $this->conn->prepare($query);
    $stmt->bind_param("i", $assigne_a);
    if ($stmt->execute()) {
        $stmt->bind_result($nom_assigne_a);
        $stmt->fetch();
        $stmt->close();                
        return $nom_assigne_a;
    } else {
		//var_dump($this->conn->error);
        return $this->conn->error;
    }
}

 /*
 verification d'existance d'un visiteur dans la base des visiteur
 */
public function  getTypeAssignement($id)
{
	//$id="id".$table_name;
	
	$query="SELECT nom FROM assignation WHERE  id= ?";
	//var_dump($query);
	$stmt = $this->conn->prepare($query);
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        $stmt->bind_result($nom_assignation);
        $stmt->fetch();
        $stmt->close();                
        return $nom_assignation;
    } else {
		//var_dump($this->conn->error);
        return $this->conn->error;
    }
}
 /*
 * Vérification de l'utilisateur en double par adresse e-mail
 * @param String $email email à vérifier dans la db
 * @return boolean
 */
public function isGeneratedCodeExists($Generated_code) 
	{
			$stmt = $this->conn->prepare("SELECT code_vente FROM vente WHERE code_vente = ?");
			$stmt->bind_param("s", $Generated_code);
			$stmt->execute();
			$stmt->store_result();
			$num_rows = $stmt->num_rows;
			$stmt->close();
			return $num_rows > 0;
	}

 /*
 verification d'existance d'un visiteur dans la base des visiteur
 */
public function isVisiteurExiste($msisdn)
	{
		 $req = $this->conn->prepare("SELECT msisdn from visiteurs WHERE msisdn = ?");
		$req->bind_param("s", $msisdn);
		$req->execute();
		$req->store_result();
		$num_rows = $req->num_rows;
		$req->close();
		return $num_rows > 0;
	}
               
 /*
 verification d'existance d'un visiteur dans la base des visiteur
 */
public function getMotifSequance	($idmotif)
{
	$stmt = $this->conn->prepare("SELECT  sequance FROM motif WHERE  idmotif= ?");
    $stmt->bind_param("i", $idmotif);
    if ($stmt->execute()) {
        $stmt->bind_result($sequance);
        $stmt->fetch();
        $stmt->close();
                
        return $sequance;
    } else {
        return NULL;
    }
}

/*
 verification d'existance d'un visiteur dans la base des visiteur
 */
public function UpdateMotifSequance	($idmotif,$sequance)
{
	$stmt=$this->conn->prepare("UPDATE motif SET  sequance=? WHERE idmotif	=?");
    
    $stmt->bind_param("ii",$sequance,$idmotif);
    $stmt->execute();
    $num_affected_rows = $stmt->affected_rows;
    $stmt->close();
    return $num_affected_rows > 0;
}


	
 }  
?>
