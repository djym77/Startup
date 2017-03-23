<?php

/*require_once '../../include/DbHandler.php';
require_once '../../include/PassHash.php';
require '../../libs/Slim/Slim.php';*/
require'../common/common.php';
require'../common/mail.php';
//require '.././libs/CorsSlim/CorsSlim.php';

//require_once '../../client/client.php';


\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();

//parametres du header qui permet un acces depuis un autre domaine ou IP
$corsOptions = array(
    "origin" => "*",
    "exposeHeaders" => array("Content-Type", "X-Requested-With", "X-authentication", "X-client"),
    "allowMethods" => array('GET', 'POST', 'PUT', 'DELETE', 'OPTIONS')
);

$cors = new \CorsSlim\CorsSlim($corsOptions);

$app->add($cors);

// ID utilisateur - variable globale
$user_id = NULL;

/**
 * Ajout de Couche intermédiaire pour authentifier chaque demande
 * Vérifier si la demande a clé API valide dans l'en-tête "Authorization"
 */
function authenticate(\Slim\Route $route) {
    // Obtenir les en-têtes de requêtes
    $headers = apache_request_headers();
    $response = array();
    $app = \Slim\Slim::getInstance();

    // Vérification de l'en-tête d'autorisation
    if (isset($headers['Authorization'])) {
        $db = new DbHandler();

        // Obtenir la clé d'api
        $api_key = $headers['Authorization'];
        // Valider la clé API
        if (!$db->isValidApiKey($api_key)) {
            //  Clé API n'est pas présente dans la table des utilisateurs
            $response["error"] = true;
            $response["message"] = "Accès Refusé. Clé API invalide";
            echoRespnse(401, $response);
            $app->stop();
        } else {
            global $user_id;
            // Obtenir l'ID utilisateur (clé primaire)
            $user_id = $db->getUserId($api_key);
        }
    } else {
        // Clé API est absente dans la en-tête
        $response["error"] = true;
        $response["message"] = "Clé API est manquante";
        echoRespnse(400, $response);
        $app->stop();
    }
}

/**
 * ----------- MÉTHODES sans authentification---------------------------------
 */


/**
*Recuperer  type motif, motif et sous_motif 
*/
$app->post('/register', function() use ($app)
{   
        $json = $app->request->getBody();
        $data = json_decode($json, true); // parse the JSON into an assoc. array   

        if ( isset($data['nom']) AND isset($data['prenom']) AND isset($data['mail']) AND isset($data['login']) AND isset($data['motPasse']) AND isset($data['contact']))
        {
            //nom,prenom,,,login,motPasse,photo,api_key,date_naissance
            $nom=htmlspecialchars($data['nom']);
            $prenom=htmlspecialchars($data['prenom']);
            $profession=(isset($data['profession']))?htmlspecialchars($data['profession']):"";
            /* $login=(isset($data['login']))?htmlspecialchars($data['login']):"";*/
            $login=htmlspecialchars($data['login']);
            $contact=htmlspecialchars($data['contact']);
            $motPasse=htmlspecialchars($data['motPasse']);
            $photo=(isset($data['photo']))?htmlspecialchars($data['photo']):"";
            $mail=htmlspecialchars($data['mail']);
            $date_naissance=(isset($data['date_naissance']))?htmlspecialchars($data['date_naissance']):"";

            verifyRequiredParamsByValue($nom);
            verifyRequiredParamsByValue($prenom);
            verifyRequiredParamsByValue($login);
            verifyRequiredParamsByValue($motPasse);
            verifyRequiredParamsByValue($mail);
            verifyRequiredParamsByValue($contact);
        }
         $db = new DbHandler();
         validateEmail($mail);
         $apikey=$db->generateApiKey();
         
        $ret_register=$db->register($nom,$prenom,$profession,$mail,$login,$motPasse,$photo,$apikey,$date_naissance,$contact);
        if($ret_register)
        {
            $response ['error']=false;
            $response ['message']="Bienvenue ".$login." votre compte est créée";
        }
        else
        {
            $response ['error']=false;
            $response ['message']="erreur de création de votre compte. veuillez réessayer svp!!";
        }
        
    echoRespnse(200,$response);
});


/**
 * Login Utilisateur Client
 * url - /login
 * method - POST
 * params - email, password
 */
$app->post('/login_user', function() use ($app) {

   /* $sjon2='{
      "email": hamed@brava.ci,
      "password": 1234
    }';*/ 
            $json_data=$app->request()->getBody();
            // vérifier les paramètres requises
           // verifyRequiredParams(array('login', 'password'));

            $login_data=json_decode($json_data, true);
            // lecture des params de post
            if( isset($login_data['login']) AND isset($login_data['password']))
            {
              $login = $login_data['login'];
              $password =$login_data['password'];
              verifyRequiredParamsByValue($login);
              verifyRequiredParamsByValue($password);
            }
          
            //$password = $app->request()->post('password');
            $response = array();

            $db = new DbHandler();
            // vérifier l'Email et le mot de passe sont corrects
            $resultCheckLogin=$db->checkLogin_client($login, $password);
           
            if ($resultCheckLogin) {
                // obtenir l'utilisateur par email
                 //$user=
                 //sauver la date de la derniere connexion
                $db->setUserLastConnection($login);
                $user = $db->getUserByLogin($login);

                if ($user != NULL) {
                   if($user["statut"]==1){
                    $response['id']=$user["id"];
                    $response['error']=false;
                    $response['message']="Vous êtes connectés avec succès";
                    $response['nom']=$user["nom"];
                    $response['prenom']=$user["prenom"] ;
                    $response['mail']=$user["mail"];
                    $response['statut']=$user["statut"] ;
                    $response['api_key']=$user["api_key"] ;
                    $response['profession']=$user["profession"] ;
                    $response['login']=$user["login"] ;
                    $response['photo']=$user["photo"] ;
                    $response['typeUser_id']=$user["typeUser_id"];
                    $response['date_naissance']=$user["date_naissance"];
                    $response['contact']=$user["contact"];
                   // $response['statut'] =  $user["statut"];
                    }
                    else {
                        $response['error'] = true;
                        $response['message'] = "Votre compte a été suspendu";
                    }
                }
                 else {
                    // erreur inconnue est survenue
                    $response['error'] = true;
                    $response['message'] = "Une erreur est survenue. Essayer à nouveau SVP.";
                }

            } else {
                // identificateurs de l'utilisateur sont erronés
                $response['error'] = true;
                $response['message'] = 'Échec de connexion. identifiants incorrects';
            }

            echoRespnse(200, $response);
        });


/**
 * Login Utilisateur Client
 * url - /login
 * method - POST
 * params - email, password
 */
$app->get('/session_client', function() {
    $db = new DbHandler();
    $session = $db->getSession_client();
    
    $response["error"] = $session['error'];
    $response["message"] = 'Connecté avec succès!';
    $response['id'] = $session['id'];
    $response['nom'] = $session['nom'];                       
    $response['prenom'] = $session['prenom'];
    $response['email'] = $session['email'];
    //$response['apiKey'] = $session['apikey'];
    $response['create_time'] = $session['create_time'];
    $response['num_client'] = $session['num_client'];
    $response['profil'] = $session['profil'];
    $response['nom_client'] = $session['nom_client'];
    $response['type_client'] = $session['type_client'];

    echoRespnse(200, $response);
});

//ortenir la session User TOTAl
$app->get('/session_total', function() {
    $db = new DbHandler();
    $session = $db->getSession_total();
    
    $response["error"] = $session['error'];
    $response["message"] = 'Connecté avec succès!';
    $response['idadmin'] = $session['idadmin'];
    $response['nom'] = $session['nom'];                       
    $response['prenom'] = $session['prenom'];
    $response['email'] = $session['email'];
    //$response['apiKey'] = $session['apikey'];
    $response['create_time'] = $session['create_time'];
    //$response['num_client'] = $session['num_client'];
    $response['code_profil'] = $session['code_profil'];
   // $response['nom_client'] = $session['nom_client'];

    echoRespnse(200, $response);
});


$app->get('/logout_client', function() {
    $db = new DbHandler();
    $session = $db->destroySession_client();
    $response["status"] = "info";
    $response["message"] = "Déconnecté avec succès";
    echoRespnse(200, $response);
});


// deconnexion user Total
$app->get('/logout_total', function() {
    $db = new DbHandler();
    $session = $db->destroySession_total();
    $response["status"] = true;
    $response["message"] = "Déconnecté avec succès";
    echoRespnse(200, $response);
});

/*
 * ------------------------ METHODES Avec AUTHENTICATION ------------------------
 */

/**
* Recuperation de la liste des User Total
*/
$app->get('/GetTotalUserList', function (){

     $db = new DbHandler();
     $TotalUsers=$db->GetTotalUserList();
      $response=array();
      $response['total_user']=array();


    if($TotalUsers!=NULL)
    {
        while ($lignes = $TotalUsers->fetch_assoc())
         {
            $response['erro']=false;
            $tmp_lines = array();
           // $tmp_lines["idligne"] = $lignes["idligne"];
            $tmp_lines["idadmin"] = $lignes["idadmin"];
            $tmp_lines["nom"] = $lignes["nom"];
            $tmp_lines["prenom"] = $lignes["prenom"];
            $tmp_lines["email"] = $lignes["email"]; 
            $tmp_lines["statut"] = $lignes["statut"];
            $tmp_lines["profil"] = $lignes["profil"];


            array_push($response['total_user'] , $tmp_lines);           
        }
    }
    else
    {
        $response['erro']=true;
    }
    echoRespnse(200,$response);
});


/**
* Recuperation de la liste des User Total
*/
$app->get('/GetClientUserList', function (){

     $db = new DbHandler();
     $TotalUsers=$db->GetClientUserList();
     $response=array();
      //$response['client_user']=array();

    if($TotalUsers!=NULL)
    {
        while ($lignes = $TotalUsers->fetch_assoc())
         {
          //  $response['erro']=false;
            $tmp_lines = array();
           // $tmp_lines["idligne"] = $lignes["idligne"];
            $tmp_lines["id"] = $lignes["idcompte"];
            $tmp_lines["nom"] = $lignes["nom"];
            $tmp_lines["prenom"] = $lignes["prenom"];
            $tmp_lines["email"] = $lignes["email"]; 
            $tmp_lines["statut"] = $lignes["statut"];
            $tmp_lines["profil"] = $lignes["profil"];
            $tmp_lines["client"] = $lignes["client"];

            //array_push($response['client_user'] , $tmp_lines);           
            array_push($response , $tmp_lines);           
         }
    }
    else
    {
       // $response['erro']=true;
    }
    echoRespnse(200,$response);
});


/**
* Recuperation de la liste des User Total
*/
$app->put('/UpdateProfil', function() use ($app) {

     $json=$app->request->getBody();
     $data=json_decode($json,true);

     verifyRequiredParamsByValue(htmlspecialchars($data['id']));
     verifyRequiredParamsByValue(htmlspecialchars($data['login']));
     $id=htmlspecialchars($data['id']);
     $nom=htmlspecialchars($data['nom']);
     $prenom=htmlspecialchars($data['prenom']);
     $mail=htmlspecialchars($data['mail']);
     //$statut=htmlspecialchars($data['statut']);
     $profession=htmlspecialchars($data['profession']);
     $photo='uploads/'.htmlspecialchars($data['photo']);
     $date_naissance=htmlspecialchars($data['date_naissance']);
     $contact=htmlspecialchars($data['contact']);
     $login=htmlspecialchars($data['login']);

     $db=new DbHandler();
    $ret_update=$db->UpdateProfil($login,$nom,$prenom,$mail,$profession,$photo,$date_naissance,$contact);
     $response=array();
    if($ret_update)
    {
        $response['error']=true;
        $response['message']='Utilisateur modifié avec succès.';
    }
    else
    {
        $response['error']=true;
        $response['message']='Echec de modification. veuillez réessayer svp.';
    }
    echoRespnse(200,$response);
});

//$app->run();
?>