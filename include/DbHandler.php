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

// ============ PARTIE DES GET ==================
 public function register($nom,$prenom,$profession,$mail,$login,$motPasse,$photo,$api_key,$date_naissance,$contact)
	 {
	 	
	 	  $password_hash = PassHash::hash($motPasse);
		$req=$this->conn->prepare("INSERT INTO user(nom,prenom,profession,mail,login,motPasse,photo,api_key,date_naissance,contact) VALUES (?,?,?,?,?,?,?,?,?,?)");
		$req->bind_param("ssssssssss",$nom,$prenom,$profession,$mail,$login,$password_hash,$photo,$api_key,$date_naissance,$contact);
		$result=$req->execute();
		//echo $req->error;
		$req->close();
		
		if ($result) {
			
			$user_id = $this->conn->insert_id;
			return $user_id;

		} else {
			// task failed to create
			return NULL;
		}
	 }

/**
 * Vérification de connexion de l'utilisateur
 * @param String $email
 * @param String $password
 * @return boolean Le statut de connexion utilisateur réussite / échec
 */
public function checkLogin_client($login, $password) {
        // Obtention de l'utilisateur par login
        $stmt = $this->conn->prepare("SELECT motPasse FROM user WHERE login = ?");

        $stmt->bind_param("s", $login);

        $stmt->execute();

        $stmt->bind_result($password_hash);

        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            // Utilisateur trouvé avec l'e-mail
            // Maintenant, vérifier le mot de passe

            $stmt->fetch();

            $stmt->close();

            if (PassHash::check_password($password_hash, $password)) {
                // Mot de passe utilisateur est correcte

                return true;
            } else {
                // mot de passe utilisateur est incorrect
                
                return false;
            }
        } else {
            

            // utilisateur n'existe pas avec l'e-mail
            return false;
        }
}

/**
* sauver la date de la derniere connexion
*/
public function setUserLastConnection($login)
{
    $stmt = $this->conn->prepare("UPDATE  user SET last_connect=CURRENT_TIMESTAMP WHERE login=?");
    $stmt->bind_param("s", $login);
    $stmt->execute();
     $stmt->close();
}


/**
*Obtention de l'utilisateur client via son adrese email
* @param String $email
*/
public function getUserByLogin($login) {
    $stmt = $this->conn->prepare("SELECT id, nom,prenom,profession,mail,login,photo,api_key,date_naissance,contact ,typeUser_id,statut
     FROM user 
     WHERE login = ?");
    $stmt->bind_param("s", $login);
    if ($stmt->execute()) {
        $stmt->bind_result($id,$nom,$prenom,$profession,$mail,$login,$photo,$api_key,$date_naissance,$contact,$typeUser_id,$statut);
        $stmt->fetch();
        $user = array();
        $user["id"] = $id;
        $user["nom"] = $nom;
        $user["prenom"] = $prenom;
        $user["mail"] = $mail;
        $user["statut"] = $statut;
        $user["api_key"] = $api_key;
        $user["profession"] = $profession;
        $user["login"] = $login;
        $user["photo"] = $photo;
        $user["typeUser_id"]= $typeUser_id;
        $user["date_naissance"]= $date_naissance;
        $user["contact"]= $contact;
        $user["statut"]= $statut;
        
        $stmt->close();
                
        return $user;
    } else {
        return NULL;
    }
}

/*
* recuperation de la liste des 50 derniere actualités 
*/
public function getLatestNews()
	{
			
		$req=$this->conn->prepare(
							"SELECT actualite.idactualite,
						    actualite.titre,
						    actualite.text,
						    actualite.create_time,
						    actualite.date_publication,
						    actualite.etat,
						    actualite.cover,
						    actualite.cat_id,
							cat_actualite.libele
							FROM actualite
							INNER JOIN cat_actualite ON cat_actualite.id=actualite.cat_id where actualite.etat=1  GROUP BY actualite.idactualite DESC LIMIT 0,50");

		//$req->bind_param("i",$idmoovcenter);
		$req->execute();
		$news=$req->get_result();
		$req->close();
		////var_dump($acteur);
		return $news;  
	}


/*
* recuperation de la liste des 50 derniere actualités 
*/
public function getLatestComments($idNews)
	{
			
		$req=$this->conn->prepare(
		"SELECT commentaire_actualite.id,
	    commentaire_actualite.commentaire,
	    commentaire_actualite.date,
	    commentaire_actualite.actualite_idactualite,
	    commentaire_actualite.user_id,
	    commentaire_actualite.type,
		user.login
		FROM commentaire_actualite
		INNER JOIN user ON  commentaire_actualite.user_id=user.id
		INNER JOIN actualite ON commentaire_actualite.actualite_idactualite=actualite.idactualite 
		where commentaire_actualite.actualite_idactualite=? GROUP BY commentaire_actualite.id DESC LIMIT 0,100;");

		$req->bind_param("i",$idNews);
		$req->execute();
		$news=$req->get_result();
		$req->close();
		////var_dump($acteur);
		return $news;  
	}

	/*
* recuperation de la liste des 30 dernieres parutions 
*/
public function getLatestParutions()
	{
			
		$req=$this->conn->prepare("SELECT * FROM parution");
		//$req->bind_param("i",$idmoovcenter);
		$req->execute();
		$news=$req->get_result();
		$req->close();
		////var_dump($acteur);
		return $news;  
	}


/*
* recuperation de la liste des commentaires des derniere parutions 
*/
public function getLatestParuComments($idParu)
	{
			
		$req=$this->conn->prepare(
			"SELECT commentaire_parution.id,
	    commentaire_parution.commentaire,
	    commentaire_parution.date,
	    commentaire_parution.parution_id,
	    commentaire_parution.user_id,
	    commentaire_parution.type,
		user.login,
		user.id
		FROM commentaire_parution
		INNER JOIN parution ON parution.id=commentaire_parution.parution_id
		INNER JOIN user on commentaire_parution.user_id=user.id 
		WHERE  commentaire_parution.parution_id=?
		GROUP BY commentaire_parution.id DESC
		LIMIT 0,100");

		$req->bind_param("i",$idParu);
		$req->execute();
		$news=$req->get_result();
		$req->close();
		////var_dump($acteur);
		return $news;  
	}

/*
* creer un commentaire d'actualité
*/
public function createNewComment($comment,$new_id,$user_id)
	{
			
		$req=$this->conn->prepare(
			"INSERT INTO commentaire_actualite
			(commentaire, actualite_idactualite, user_id) VALUES (?,?,?)");
		$req->bind_param("sii",$comment,$new_id,$user_id);
		$result=$req->execute();
		$req->close();
		
		if ($result) {
			
			$user_id = $this->conn->insert_id;
			return $user_id;

		} else {
			// task failed to create
			return NULL;
		}
	}

/*
*  Créer un commentaire de parution
*/
public function createParutionComment($comment,$parution_id,$user_id)
	{
			
		$req=$this->conn->prepare(
			"INSERT INTO commentaire_parution
			(commentaire, parution_id, user_id) VALUES (?,?,?)");
		$req->bind_param("sii",$comment,$parution_id,$user_id);
		$result=$req->execute();
		$req->close();
		
		if ($result) {
			
			$user_id = $this->conn->insert_id;
			return $user_id;

		} else {
			// task failed to create
			return NULL;
		}
	}

/*
*  Effectuer une souscription
*/
public function createSouscription($service_id,$user_id,$frequence_id, $nom_souscription)
	{
			
		$req=$this->conn->prepare("INSERT INTO souscription 
			(service_id, frequence_id, user_id,libele,description) VALUES (?,?,?,?,?)");
		$req->bind_param("iiiss",$service_id,$frequence_id,$user_id, $nom_souscription, $nom_souscription);
		$result=$req->execute();
		$req->close();		
		if ($result) 
		{			
			$user_id = $this->conn->insert_id;
			return $user_id;
		} 
		else
		{
			return NULL;
		}
	}

/*
* recuperation de la liste des commentaires des derniere parutions 
*/
public function getUserContact($user_id)
	{
			
		$req=$this->conn->prepare("SELECT contact FROM user WHERE id=?");

		$req->bind_param("i",$user_id);
		
		 if($req->execute())
	     {
	       $req->bind_result($contact);
	       $req->fetch();  
	       return $contact;
	     }
	     else
	     {
	         return NULL;
	     } 
	}

/*
*  Effectuer une souscription
*/
public function saveSMSHistoriques($action,$statut,$api_response_sms, $Acces_Bearer,$Access_Token,$receiver,$message)
	{			
		$req=$this->conn->prepare("INSERT INTO historique_sms 
			(action, statut,response_api,accces_bearer,acces_token,destinataire,message) VALUES (?,?,?,?,?,?,?)");
		$req->bind_param("sssssss",$action,$statut,$api_response_sms, $Acces_Bearer,$Access_Token,$receiver,$message);
		
		$result=$req->execute();
		$req->close();		
		if ($result) 
		{			
			$user_id = $this->conn->insert_id;
			return $user_id;
		} 
		else
		{
			return NULL;
		}
	}

/*
* recuperation de la liste des services
*/
public function getAllServices()
	{
			
		$req=$this->conn->prepare("SELECT * FROM service");
		$req->execute();
	    $result=$req->get_result();     
	    $req->close();  
	    return $result;
	}
	/*
* recuperation de la liste des services
*/
public function getAllCategories()
	{
			
		$req=$this->conn->prepare("SELECT * FROM cat_actualite");
		$req->execute();
	    $result=$req->get_result();     
	    $req->close();  
	    return $result;
	}

/*
* recuperation de la liste des souscriptions par intervale de date
*/
public function getSouscriptionByDate($date_debut,$date_fin)
	{
			
		$req=$this->conn->prepare("SELECT souscription.id,
	    souscription.libele AS souscription,
	    souscription.description,
	    souscription.user_id,
		user.nom,
		user.prenom,
		user.login,
		souscription.service_id,
		service.libelle AS service,
	    souscription.create_time AS date_souscription,
	    souscription.date_expiration,
	    souscription.frequence_id,
		f.libele AS frequence,
		f.montant
		FROM souscription
		INNER JOIN service ON service.id=  souscription.service_id
		INNER JOIN user ON user.id=souscription.user_id
		INNER JOIN frequence_service f ON f.id=souscription.service_id
		WHERE souscription.create_time BETWEEN ? AND ?");
		$req->bind_param("ss",$date_debut,$date_fin);
		$req->execute();
	    $result=$req->get_result();     
	    $req->close();  
	    return $result;
	}

/*
* recuperation de la liste des souscriptions par User ID
*/
public function getSouscriptionByUserID($user_id)
	{
			
		$req=$this->conn->prepare("SELECT souscription.id,
	    souscription.libele AS souscription,
	    souscription.description,
	    souscription.user_id,
		user.nom,
		user.prenom,
		user.login,
		souscription.service_id,
		service.libelle AS service,
	    souscription.create_time AS date_souscription,
	    souscription.date_expiration,
	    souscription.frequence_id,
		f.libele AS frequence,
		f.montant
		FROM souscription
		INNER JOIN service ON service.id=  souscription.service_id
		INNER JOIN user ON user.id=souscription.user_id
		INNER JOIN frequence_service f ON f.id=souscription.service_id
		WHERE   souscription.user_id=?");
		$req->bind_param("i", $user_id);
		$req->execute();
	    $result=$req->get_result();     
	    $req->close();  
	    return $result;
	}

/*
* recuperation de la liste des souscriptions d'un service donné
*/
public function getSouscriptionByServiceID($service_id)
	{
			
		$req=$this->conn->prepare("SELECT souscription.id,
	    souscription.libele AS souscription,
	    souscription.description,
	    souscription.user_id,
		user.nom,
		user.prenom,
		user.login,
		souscription.service_id,
		service.libelle AS service,
	    souscription.create_time AS date_souscription,
	    souscription.date_expiration,
	    souscription.frequence_id,
		f.libele AS frequence,
		f.montant
		FROM souscription
		INNER JOIN service ON service.id=  souscription.service_id
		INNER JOIN user ON user.id=souscription.user_id
		INNER JOIN frequence_service f ON f.id=souscription.service_id
		WHERE   souscription.service_id=?");
		$req->bind_param("i", $service_id);
		$req->execute();
	    $result=$req->get_result();     
	    $req->close();  
	    return $result;
}

/*
*Recuperer la liste des des periodes d'une souscriptions d'un services donné 
*/
public function getSouscriptionPeriodeByServiceID($service_id)
	{
			
		$req=$this->conn->prepare("SELECT DISTINCT
		souscription.service_id,
	    souscription.frequence_id,
		f.libele AS frequence,
		f.montant
		FROM souscription
		INNER JOIN service ON service.id=  souscription.service_id
		INNER JOIN user ON user.id=souscription.user_id
		INNER JOIN frequence_service f ON f.id=souscription.service_id
		WHERE   souscription.service_id=?");
		$req->bind_param("i", $service_id);
		$req->execute();
	    $result=$req->get_result();     
	    $req->close();  
	    return $result;
	}

/*
*Recuperer la liste des des periodes d'une souscriptions d'un services donné 
*/
public function getSuscriberContactByservice($service_id)
{
		
	$req=$this->conn->prepare("SELECT 
	user.id,
	user.nom,
	user.prenom,
	user.contact,
	user.login
	FROM souscription
	INNER JOIN service ON service.id=  souscription.service_id
	INNER JOIN user ON user.id=souscription.user_id
	WHERE   souscription.service_id=?");
	$req->bind_param("i", $service_id);
	$req->execute();
	$result=$req->get_result();     
	$req->close();  
	return $result;
}
/*
* recuperation de la liste des frequences
*/
public function getAllFrequence()
	{
			
		$req=$this->conn->prepare("SELECT * FROM frequence_service");
		$req->execute();
	    $result=$req->get_result();     
	    $req->close();  
	    return $result;
	}

/*
*  Envoi d'une question a un expert
*/
public function sendQuestionToExpert($title,$question,$user_id)
{
		
	$req=$this->conn->prepare(
		"INSERT INTO avis_experts (title,question,user_id)
		VALUES (?,?,?)");
	$req->bind_param("ssi",$title,$question,$user_id);
	$result=$req->execute();
	$req->close();		
	if ($result) 
	{			
		$user_id = $this->conn->insert_id;
		return $user_id;
	} 
	else
	{
		return NULL;
	}
}

/*
*  reponder a une question 
*/
public function replyQuestion($question_id,$answer,$expert_id)
{	
	$statut=1;
	$req=$this->conn->prepare("UPDATE avis_experts SET 
		 reponse=?,expert_id=?,date_response=CURRENT_TIMESTAMP, statut=? 
		WHERE id=?");
	$req->bind_param("siii",$answer,$expert_id,$statut,$question_id);
	$req->execute();
	 $num_rows=$req->affected_rows;
	$req->close();		

		return $num_rows>0;
}

/*
*Recuperer la liste des des periodes d'une souscriptions d'un services donné 
*/
public function getQueryForExpertByUserID($user_id)
	{
			
		$req=$this->conn->prepare("SELECT * FROM avis_experts

		WHERE   user_id=?");
		$req->bind_param("i", $user_id);
		$req->execute();
	    $result=$req->get_result();     
	    $req->close();  
	    return $result;
	}

/**
*Orbetnir le mail d'un USER
*/
public function getUserMail($id)
{
    $stmt=$this->conn->prepare("SELECT mail FROM user WHERE id=?");
    $stmt->bind_param("i", $id);
   
    if ($stmt->execute()) {
            $stmt->bind_result($mail);
            $stmt->fetch();
            $stmt->close();
            return $mail;
        } else {
            return NULL;
        }
}

/**
*Orbetnir le titre d'une REQUETE EXPERT
*/
public function getRequesInfo($id)
{
    $stmt=$this->conn->prepare("SELECT title, user_id FROM avis_experts WHERE id=?");
    $stmt->bind_param("i", $id);
   
    if ($stmt->execute()) {
            $stmt->bind_result($title,$user_id);
            $stmt->fetch();
            $stmt->close();
            $result=array();
            $result['user_id']=$user_id;
            $result['title']=$title;

            return $result;
        } else {
            return NULL;
        }
}
//============================ TOOLS FUNCTIONS +======================

 /**
 * Génération aléatoire unique MD5 String pour utilisateur clé Api
 */
public function generateApiKey() {
    return md5(uniqid(rand(), true));
}

/*
* verifier si un user quelconque a souscrit a un service quelconque
*/
public function isServiceSuscribed($user_id,$service_id)
{
	$stmt = $this->conn->prepare("SELECT user_id FROM souscription WHERE user_id = ? AND service_id=?");
        $stmt->bind_param("ii", $user_id,$service_id);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
} 

/*
*recuperer la liste des images contituant le contenu d'nu parution
*/
public function getContentParutionByID($parution_code)
{
   $req=$this->conn->prepare("SELECT id, image FROM parution_content WHERE parution_code=?");
    $req->bind_param("s", $parution_code);
    $req->execute();
    $result=$req->get_result();     
	$req->close();  
    return $result;
}



/*
* creation d'actualité
*/
/*
* creation d'actualité
*/
public function craeteNew($titre, $texte, $image,$admin_id,$cat_id)
{
	 $req=$this->conn->prepare("INSERT INTO actualite
(titre,text,cover,cree_par,cat_id) VALUES (?,?,?,?,?)");
    $req->bind_param("sssii", $titre, $texte, $image,$admin_id,$cat_id);
   $result=$req->execute();
    //$result=$req->get_result();     
	$req->close();  
    return $result;
}


public function createParution($titre, $code, $cover)
{
	 $req=$this->conn->prepare("INSERT INTO parution
(titre,code,cover) VALUES (?,?,?)");
    $req->bind_param("sss",$titre, $code, $cover);
   $result=$req->execute();
    //$result=$req->get_result();     
	$req->close();  
    return $result;
}

public function createParutionContent($image,$num_parution)
{
	 $req=$this->conn->prepare("INSERT INTO parution_content
(parution_code,image) VALUES (?,?)");
    $req->bind_param("ss",$num_parution,$image);
   $result=$req->execute();
    //$result=$req->get_result();     
	$req->close();  
	if($result)
	{return false;}
	else
	{
		return true;
	}
  //  return $result;
}

public function createPub($titre, $description,$admin_id,$images_pub)
{
 $req=$this->conn->prepare("INSERT INTO publicite
(titre,description,cree_par,image) VALUES (?,?,?,?)");
//(titre,description,date_debut,date_fin,cree_par,image) VALUES (?,?,?,?,?,?)");
 $req->bind_param("ssis",$titre, $description,$admin_id,$images_pub);
 //$req->bind_param("ssssis",$titre, $description, $date_debut, $date_fin,$admin_id,$images_pub);
   $result=$req->execute();
   if($result)
    {
    	$insert_id=$req->insert_id; 
    	return $insert_id;
     }   
     else
     {
     	return null;
     }
	$req->close();  
    
}


/*
*insertion enregistrement du contenu ( images) des parutions
*/
public function createPubContent($images_pub,$id_pub)
{
	$req=$this->conn->prepare("INSERT INTO contenu_publicite
(affiche,idpub) VALUES (?,?)");
    $req->bind_param("si",$image,$id_pub);
    $ret_image_error=false;
    $data_size=count($images_pub);
    for($i=0;$i<$data_size;$i++) 
      {
        $image='ressources/pub/'.$images_pub[$i]['name'];
        $id_pub=$id_pub;
         $result=$req->execute();
          if($result)
          {
            $ret_image_error=true;
          }
      }
    //$result=$req->get_result();     
	$req->close();  
	if($ret_image_error)
	{return true;}
	else
	{
		return false;
	}
  //  return $result;
}

/**
*Orbetnir le nom d'un service via son id
*/
public function getServiceNameByID($id)
{
    $stmt=$this->conn->prepare("SELECT libelle FROM service WHERE id=?");
    $stmt->bind_param("i", $id);
   
    if ($stmt->execute()) {
            $stmt->bind_result($name);
            $stmt->fetch();
            $stmt->close();
            /*$result=array();
            $result['user_id']=$user_id;
            $result['title']=$title;*/
            return $name;
        } else {
            return NULL;
        }
}

/*
*insertion du contenu service lors des envois d'sms aux abonnés
*/
public function saveServiceContenu($message,$service_id,$admin_id, $nombre_dest)
{
  $req=$this->conn->prepare("INSERT INTO contenu_service
(texte,service_id,envoye_par,nombre_dest) VALUES (?,?,?,?)");
 $req->bind_param("siii",$message,$service_id,$admin_id, $nombre_dest);
   $result=$req->execute();
   if($result)
    {
    	$insert_id=$req->insert_id; 
    	return $insert_id;
     }   
     else
     {
     	return null;
     }
	$req->close();
}


/*
*insertion des destinataires d'un envoi de sms pour un service bien donné
*/
public function saveDestlist($contact_list,$id_service_contenu)
{
	$req=$this->conn->prepare("INSERT INTO destinataire_sms_service
(id_destinataire,num_destinataire,contenu_service_id) VALUES (?,?,?)");
    $req->bind_param("isi",$id_destinataire,$num_destinataire,$contenu_service_id);
    $ret_image_error=false;
    $data_size=count($contact_list);
    for($i=0;$i<$data_size;$i++) 
      {
        $id_destinataire=$contact_list[$i]['id'];
        $num_destinataire=$contact_list[$i]['contact'];
        $contenu_service_id=$id_service_contenu;
         $result=$req->execute();
          if($result)
          {
            $ret_image_error=true;
          }
      }
    //$result=$req->get_result();     
	$req->close();  
	if($ret_image_error)
	{return true;}
	else
	{
		return false;
	}
  //  return $result;
}

/*
* recuperer la derniere pub
*/

public function  getLastPUB()
{
	 $stmt=$this->conn->prepare("SELECT * FROM publicite ORDER BY id DESC LIMIT 0,1");
	 $stmt->execute();
	 $result=$stmt->get_result();
	 $stmt->close();
	 return $result;
}

/*
* listes des actualités
*/

public function  getAllNews()
{
	 $stmt=$this->conn->prepare("SELECT * FROM actualite ");
	 $stmt->execute();
	 $result=$stmt->get_result();
	 $stmt->close();
	 return $result;
}

/*
* listes des actualités
*/

public function  getAllPub()
{
	 $stmt=$this->conn->prepare("SELECT * FROM publicite");
	 $stmt->execute();
	 $result=$stmt->get_result();
	 $stmt->close();
	 return $result;
}

/*
* listes des magazine (parution)
*/

public function  getAllParution()
{
	 $stmt=$this->conn->prepare("SELECT * FROM parution");
	 $stmt->execute();
	 $result=$stmt->get_result();
	 $stmt->close();
	 return $result;
}

/*
* listes des messages envoyés ( startuopinfo et depeches)
*/

public function  getAllServicesmessages()
{
	 $stmt=$this->conn->prepare("SELECT sc.id,sc.theme,sc.texte,sc.create_time,sc.service_id,sc.envoye_par,sc.nombre_dest,s.libelle AS service FROM  contenu_service sc inner join  service s ON sc.service_id=s.id");
	 $stmt->execute();
	 $result=$stmt->get_result();
	 $stmt->close();
	 return $result;
}

/*
* listes des avis experts
*/
public function  getAllAvisExpert()
{
	 $stmt=$this->conn->prepare("SELECT ae.id,ae.title,ae.question,ae.reponse,ae.date_avis,
	 	ae.date_response,ae.user_id, ae.expert_id,ae.statut,
		u.login AS user,e.nom, e.prenom ,ae.statut
 		FROM avis_experts ae INNER JOIN user u ON ae.user_id=u.id
		LEFT JOIN administrator e ON e.id=ae.expert_id 
		UNION 
		SELECT ae.id,ae.title,ae.question,ae.reponse,ae.date_avis,
	 	ae.date_response,ae.user_id, ae.expert_id,ae.statut,
		u.login AS user,e.nom, e.prenom ,ae.statut
 		FROM avis_experts ae INNER JOIN user u ON ae.user_id=u.id
		RIGHT JOIN administrator e ON e.id=ae.expert_id;");
	 $stmt->execute();
	 $result=$stmt->get_result();
	 $stmt->close();
	 return $result;
}
/*
* listes utilisateur de l'app mobile
*/
public function  getAllUser()
{
	 $stmt=$this->conn->prepare("SELECT * FROM user");
	 $stmt->execute();
	 $result=$stmt->get_result();
	 $stmt->close();
	 return $result;
}

/*
liste des utilisateur par service
*/
/*
* recuperation de la liste des souscriptions par User ID
*/
public function getSouscripteurByService($service_id)
	{			
		$req=$this->conn->prepare("SELECT souscription.id,
	    souscription.libele AS souscription,
	    souscription.description,
	    souscription.user_id,
		user.nom,
		user.prenom,
		user.login,
		user.mail,
		user.profession,
		user.contact,
		user.photo,
		user.statut,
		souscription.service_id,
		service.libelle AS service,
	    souscription.create_time AS date_souscription,
	    souscription.date_expiration,
	    souscription.frequence_id,
		f.libele AS frequence,
		f.montant
		FROM souscription
		INNER JOIN service ON service.id=  souscription.service_id
		INNER JOIN user ON user.id=souscription.user_id
		INNER JOIN frequence_service f ON f.id=souscription.service_id
		WHERE   souscription.service_id=?");
		$req->bind_param("i", $service_id);
		$req->execute();
	    $result=$req->get_result();     
	    $req->close();  
	    return $result;
	}

/*
* Mise a jour du profil
*/
public function UpdateProfil($login,$nom,$renom,$mail,$profession,$photo,$date_naissance,$contact)
{
	 $stmt=$this->conn->prepare("UPDATE user SET nom=?, prenom=?, mail=?, profession=?, photo=?, contact=?, update_time=CURRENT_TIMESTAMP, date_naissance=?  WHERE login=?");
    $stmt->bind_param("ssssssss",$nom,$renom,$mail,$profession,$photo,$contact,$date_naissance,$login);
    $stmt->execute();
    $num_affected_rows = $stmt->affected_rows;
    $stmt->close();
    //echo 'dfdsvqdvqdvg';
    return $num_affected_rows > 0;
}
//FIN ============================================
/*
* recuperer le User de la session en cours
*/
 function geCurrentUserInfos()
 {
    if (!isset($_SESSION))
     {
         session_start();
         if (isset($_SESSION['idad']) && !empty($_SESSION['idadmin']))
		{
             $user_id=htmlspecialchars($_SESSION['idadmin']);
             //$num_client=htmlspecialchars($_SESSION['num_client']);
         }else
         {  
            $response = array();
            $app = \Slim\Slim::getInstance();
            $response["error"] =true;
            $response["message"] ="connexion perdue. Veuillez vous reconnecter" ;
            $app->stop();
         }
     }
     return  $user_id;
 }
	
	
 }  
?>
