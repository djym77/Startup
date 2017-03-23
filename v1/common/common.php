<?php 

/**
 * Vérification params nécessaires posté ou non
 */
function verifyRequiredParamsByValue($param) {
    $error = false;
    $error_fields = "";
   /* $request_params = array();
    $request_params = $_REQUEST;*/
    // Manipulation params de la demande PUT
    if ($_SERVER['REQUEST_METHOD'] == 'PUT')
     {
        $app = \Slim\Slim::getInstance();
       // parse_str($app->request()->getBody(), $request_params);
    }
   // foreach ($param as $field) {
        if (!isset($param) || strlen(trim($param)) <= 0) 
        {
            $error = true;
            //$error_fields .= $param . ', ';
        }

    if ($error) 
    {
        //Champ (s) requis sont manquants ou vides
        // echo erreur JSON et d'arrêter l'application
        $response = array();
        $app = \Slim\Slim::getInstance();
        $response["error_or"] = true;
        $response["message_or"] = 'Un ou plusieurs champ(s) requis  manquent ou sont incorrects(s). Veuillez les corriger et réssayer';
        echoRespnse(200, $response);
        $app->stop();
    }
    //}
}
    /**
 * Vérification params nécessaires posté ou non
 */
function verifyRequiredParams($param) {
    $error = false;
    $error_fields = "";
    $request_params = array();
    $request_params = $_REQUEST;
    // Manipulation params de la demande PUT
    if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
        $app = \Slim\Slim::getInstance();
       parse_str($app->request()->getBody(), $request_params);
    }
    foreach ($param as $field) {
        if (!isset($request_params[$field]) || strlen(trim($request_params[$field])) <= 0) {
            $error = true;
            $error_fields .= $field . ', ';
        }
    }
}

    /**
 * Vérification params nécessaires posté ou non
 */
function verifyRequiredParamsFromArray($required_fields,$param) 
    {
        $error = false;
        $error_fields = "";
        $request_params = array();
        $request_params = $_REQUEST;
        // Manipulation params de la demande PUT
        if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
            $app = \Slim\Slim::getInstance();
        //parse_str($app->request()->getBody(), $request_params);
    }
	
	$k=0;
	$field_count=count($param);
   // foreach ($param as $param_field) {        
            
        /*for ($i=0; $i<$field_count; $i++)
        {*/
    	if(!isset($param['numero']) || strlen(trim($param['numero'])) <= 0 || !isset($param['montant']) || empty($param['montant'])) 
    	{ // ||
          $error = true;
       	  //$error_fields .= $required_fields[$i] . '='.$param['montant'].', ';	
   		}
    	//}

    if ($error) {
        //Champ (s) requis sont manquants ou vides
        // echo erreur JSON et d'arrêter l'application
        $response = array();
        $app = \Slim\Slim::getInstance();
        $response["error_or"] = true;
        $response["message_or"] = 'Un ou plusieurs champ(s) requis  manquent ou sont incorrects(s). Veuillez les corriger et réssayer';
        echoRespnse(200, $response);
        $app->stop();
    }
}


    /**
 * Vérification params nécessaires posté ou non lors de la creation des OCC
 */
function verifyRequiredParamsFromArrayOCC($required_fields,$param) 
    {
        $error = false;
        $error_fields = "";
        $request_params = array();
        $request_params = $_REQUEST;
        // Manipulation params de la demande PUT
        if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
            $app = \Slim\Slim::getInstance();
        //parse_str($app->request()->getBody(), $request_params);
    }
    
    $k=0;
    $field_count=count($param);
   // foreach ($param as $param_field) {        
            
        /*for ($i=0; $i<$field_count; $i++)
        {*/
        if(!isset($param['operation']) || strlen(trim($param['operation'])) <= 0 
            || !isset($param['nom']) || empty($param['nom']) 
            || !isset($param['type']) || empty($param['type']) 
            || !isset($param['recharge_initial']) || empty($param['recharge_initial'])) 
        { 
          $error = true;
          //$error_fields .= $required_fields[$i] . '='.$param['montant'].', '; 
        }
        //}
//var_dump($param);
    if ($error) {
        //Champ (s) requis sont manquants ou vides
        // echo erreur JSON et d'arrêter l'application
        $response = array();
        $app = \Slim\Slim::getInstance();
        $response["error_or"] = true;
        $response["message_or"] = 'Un ou plusieurs champ(s) requis  manquent ou sont incorrects(s). Veuillez les corriger et réssayer.';
        echoRespnse(200, $response);
        $app->stop();
    }
}

/**
 * Validation adresse e-mail
 */
function validateEmail($email)
{
    $app = \Slim\Slim::getInstance();
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response["error"] = true;
        $response["message"] = "Adresse e-mail n'est pas valide";
        echoRespnse(400, $response);
        $app->stop();
    }
}

/**
 * Validation adresse e-mail
 */
function isValidateEmail($email) {
    $app = \Slim\Slim::getInstance();
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        /*$response["error"] = true;
        $response["message"] = "Adresse e-mail n'est pas valide";
        echoRespnse(400, $response);
        $app->stop();*/
        return false;
    }
    else
    {
        /*$response["error"] = true;
        $response["message"] = "Adresse e-mail n'est pas valide";*/
        return true;
    }

}

/**
*Generer un code Aleatoire
*/
function GenerateCodeRand($length) {
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

/**
*Generer un mot de passe
*/
function GeneratePass($length) {
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstwxyz)/&(-_@}';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

/**
* Génération aléatoire unique MD5 String pour utilisateur clé Api
*/
 function generateApiKey() {
    return md5(uniqid(rand(), true));
}


function sendMail($to, $message)
{

    mail( "basopro1@gmail.com" , "Hello Test" , "Ceci est un teste" );
}

/**
* @param  code_or_occ  le co
* @param  type  le type d'operation ( Ordre de rechargement ou ordre de création de carte)
* @param  nbr_ligne_annonces
* @param  nbr_comptee le nombre de ligne comptee
* @param  ip_client l'adresse Ip du client (USER)
* @param  message_api le message retournée par l'API
*/
/*function setOR_OCC_logs( $code_or_occ, $type,$action,$nbr_ligne_annoncees,$nbr_ligne_comptees,$ip_client,$error,$message_api,$user_id)
    {
        $retour=$db->CreateOR_OCC_logs($code_or_occ, $type,$action,$nbr_ligne_annoncees,$nbr_ligne_comptees,$ip_client,$error,$message_api,$user_id);

        if ($retour==1)
            {return true;}
        else
        {return false;}
    }*/

    /*
    *recuperation de l'adresse IP
    */
    function getUserIP()
    {
        $client  = @$_SERVER['HTTP_CLIENT_IP'];
        $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
        $remote  = $_SERVER['REMOTE_ADDR'];

        if(filter_var($client, FILTER_VALIDATE_IP))
        {
            $ip = $client;
        }
        elseif(filter_var($forward, FILTER_VALIDATE_IP))
        {
            $ip = $forward;
        }
        else
        {
            $ip = $remote;
        }

        return $ip;
    }
?>