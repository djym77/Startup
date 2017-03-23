<?php

require_once '../include/DbHandler.php';
//require_once '../include/PassHash.php';
require '.././libs/Slim/Slim.php';
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
 * Faisant écho à la réponse JSON au client
 * @param String $status_code  Code de réponse HTTP
 * @param Int $response response Json
 */
function echoRespnse($status_code, $response) {
    $app = \Slim\Slim::getInstance();
    // Code de réponse HTTP
    $app->status($status_code);

    // la mise en réponse type de contenu en JSON
    $app->contentType('application/json');

    echo utf8_encode(json_encode($response));
}

$app->run();
?>