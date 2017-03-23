<?php

require_once '../../include/DbHandler.php';
require_once '../../include/PassHash.php';
require '../../libs/Slim/Slim.php';
//require '../../libs/CorsSlim/CorsSlim.php';

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
//$user_id = NULL;

/*
 * Ajout de Couche intermédiaire pour authentifier chaque demande
 * Vérifier si la demande a clé API valide dans l'en-tête "Authorization"
*/

require 'mobile.php';
//require 'activationClient.php';
/**
 * Faisant écho à la réponse JSON au client
 * @param String $status_code  Code de réponse HTTP
 * @param Int $response response Json
 */

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