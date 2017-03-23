<?php 
require_once '../common/common.php';
require_once '../common/goSMS.php';



/*
* recuperer la liste des 50 dernieres news
*/
$app->get('/getLatestNews/', function() {

     $response=array();
     $db = new DbHandler();
   
    $result=$db->getLatestNews();
    while ($news = $result->fetch_assoc()) 
      {
                $tmp = array();
                $tmp["id"] = $news["idactualite"];
                $tmp["titre"] = $news["titre"];
                $tmp["text"] = $news["text"];
                $tmp["create_time"] = $news["create_time"];
                $tmp["cover"] = $news["cover"];
                $tmp["date_publication"] = $news["date_publication"];
                $tmp["categorie"] = $news["libele"];            
          array_push($response, $tmp);
      }
            echoRespnse(200,$response);
});

/*
* Recuperer les commentaires d'une actualité
*/
$app->get('/getLatestComments/:idactualite', function($idactualite) {

     $response=array();
     $db = new DbHandler();
     if (isset($idactualite))
     {
       $idNews=htmlspecialchars($idactualite);
       verifyRequiredParamsByValue($idNews);
    $result=$db->getLatestComments($idNews);
    while ($comments = $result->fetch_assoc()) 
      {
                $tmp = array();
                $tmp["id"] = $comments["id"];
                $tmp["commentaire"] = $comments["commentaire"];
                $tmp["date"] = $comments["date"];
                $tmp["create_time"] = $comments["actualite_idactualite"];
                $tmp["login"] = $comments["login"];
   
          array_push($response, $tmp);
      }
     }
     
  
         echoRespnse(200,$response);
});


/*
* recuperer la liste des 50 dernieres news
*/
$app->get('/getLatestparutions/', function() {

     $response=array();
     $db = new DbHandler();
   
    $result=$db->getLatestParutions();
    while ($parution = $result->fetch_assoc()) 
      {
                $tmp = array();
                $tmp["id"] = $parution["id"];
                $tmp["titre"] = $parution["titre"];
                $tmp["contenu"] = $parution["contenu"];
                $tmp["create_time"] = $parution["create_time"];
                $tmp["date_parution"] = $parution["date_parution"];
                $tmp["code"] = $parution["code"]; 
                $tmp["cover"] = $parution["cover"]; 
          array_push($response, $tmp);
      }
            echoRespnse(200,$response);
});


/*
* recuperer la liste des 50 dernieres parutions
*/
$app->get('/getContentParutionByID/:parution_id', function($parution_id){

     $response=array();
     $db = new DbHandler();
    $parution_id=htmlspecialchars($parution_id);
    verifyRequiredParamsByValue($parution_id);

    $result=$db->getContentParutionByID($parution_id);
    while($parution = $result->fetch_assoc()) 
      {
          $tmp = array();
          $tmp["id"] = $parution["id"];
          $tmp["image"] = $parution["image"];
          /*$tmp["contenu"] = $parution["contenu"];
          $tmp["create_time"] = $parution["create_time"];
          $tmp["date_parution"] = $parution["date_parution"];
          $tmp["code"] = $parution["code"]; */
            
          array_push($response, $tmp);
      }
            echoRespnse(200,$response);
});

/*
* Recuperer les commentaires d'une actualité
*/
$app->get('/getLatestParuComments/:id', function($id) {

     $response=array();
     $db = new DbHandler();
     if (isset($id))
     {
       $idParu=htmlspecialchars($id);
       verifyRequiredParamsByValue($idParu);
    $result=$db->getLatestParuComments($idParu);
    while ($comments = $result->fetch_assoc()) 
      {
                $tmp = array();
                $tmp["id"] = $comments["id"];
                $tmp["commentaire"] = $comments["commentaire"];
                $tmp["date"] = $comments["date"];
                /*$tmp["create_time"] = $comments["actualite_idactualite"];*/
                $tmp["login"] = $comments["login"];
  
          array_push($response, $tmp);
      }
     }
     
  
         echoRespnse(200,$response);
});


/*
* Recuperer les commentaires d'une actualité
*/
$app->post('/createNewComment/', function() use ($app) {

  $json=$app->request->getBody();
  $data=json_decode($json,true);
  $response['error']=array();
  $response['message']=array();
         $response['message']='Opps!veuillez réessayer svp!';
   if(isset($data['new_id']) AND !empty($data['new_id']) AND isset($data['user_id']) AND !empty($data['user_id']) AND isset($data['comment']))
        {
          $new_id = htmlspecialchars($data['new_id']);
          $user_id = htmlspecialchars($data['user_id']);
          $comment = htmlspecialchars($data['comment']);
          //$comment_date=date("Y-m-d");
          verifyRequiredParamsByValue($new_id);
          verifyRequiredParamsByValue($user_id);
          verifyRequiredParamsByValue($comment);
        }
        else
        {
          $response['error']=true;
         $response['message']='Opps!veuillez réessayer svp!';
          echoRespnse(200,$response);
          exit();
        }
        
         $db = new DbHandler();
        $ret=$db->createNewComment($comment,$new_id,$user_id);
        if($ret AND $ret!=NULL)
        {
         $response['error']=false;
         $response['message']='Commentaire posté';
        }
        else
        {
         $response['error']=true;
         $response['message']='Opps!veuillez réessayer svp!';
        }
   
         echoRespnse(200,$response);
});


/*
* Recuperer les commentaires d'une actualité
*/
$app->post('/createParutionComment/', function() use ($app) {

  $json=$app->request->getBody();
  $data=json_decode($json,true);
  $response['error']=array();
  $response['message']=array();
         $response['message']='Opps!veuillez réessayer svp!';
   if(isset($data['parution_id']) AND !empty($data['parution_id']) AND isset($data['user_id']) AND !empty($data['user_id']) AND isset($data['comment']))
        {
          $parution_id = htmlspecialchars($data['parution_id']);
          $user_id = htmlspecialchars($data['user_id']);
          $comment = htmlspecialchars($data['comment']);
          //$comment_date=date("Y-m-d");
          verifyRequiredParamsByValue($parution_id);
          verifyRequiredParamsByValue($user_id);
          verifyRequiredParamsByValue($comment);
        }
        else
        {
          $response['error']=true;
         $response['message']='Opps!veuillez réessayer svp parametre introuvable!';
          echoRespnse(200,$response);
          exit();
        }

         $db = new DbHandler();
        
        $ret=$db->createParutionComment($comment,$parution_id,$user_id);
        if($ret AND $ret!=NULL)
        {
         $response['error']=false;
         $response['message']='Commentaire posté';
        }
        else
        {
         $response['error']=true;
         $response['message']='Opps!veuillez réessayer svp!';
        }
   
         echoRespnse(200,$response);
});



/*
* Recuperer les commentaires d'une actualité
*/
$app->post('/SouscriptionService/', function() use ($app) {

  $json=$app->request->getBody();
  $data=json_decode($json,true);

  $response['error']=array();
  $response['message']=array();

         $response['message']='Opps!veuillez réessayer svp!';

   if(isset($data['service_id']) AND !empty($data['service_id']) 
      AND isset($data['user_id']) AND !empty($data['user_id']) 
      AND isset($data['frequence_id']) AND !empty($data['frequence_id']))
        {
          $service_id = htmlspecialchars($data['service_id']);
          $user_id = htmlspecialchars($data['user_id']);
          $frequence_id = htmlspecialchars($data['frequence_id']);
          $servie = htmlspecialchars($data['service']);
          $frequence = htmlspecialchars($data['frequence']);
          //$comment_date=date("Y-m-d");
          verifyRequiredParamsByValue($service_id);
          verifyRequiredParamsByValue($user_id);
          verifyRequiredParamsByValue($frequence_id);
        }
        else
        {
          $response['error']=true;
          $response['message']='Opps!veuillez réessayer svp!';
          echoRespnse(200,$response);
          exit();
        }

         $db = new DbHandler();
        
        $ret=$db->createSouscription($service_id,$user_id,4, $servie.'_'.$frequence);
        if($ret AND $ret!=NULL)
        {
         // recuperation de num du user 
         $contact=$db->getUserContact($user_id);
        // echo $contact;
         if($contact!=null)
         {
          $message="Votre souscription au service ".$servie." a été prise en compte. Merci de nous faire confiance!";
          // envoi d'sms à l'utilisateur
          $ret_SMS=SendSMS($contact,$message);

          // save historique
          //echo $ret_SMS;
          $ret_sms_part=explode('#@', $ret_SMS);

          $ret_historique=$db->saveSMSHistoriques("SUBCRIPTION_SMS", $ret_sms_part[0],$ret_sms_part[1],$ret_sms_part[2],
          $ret_sms_part[3],$ret_sms_part[4],$message);
           $response['error']=false;
         $response['message']='Souscription effectuée avec succès!:';
         }
         else
         {
          $response['error']=true;
          $response['message']='pas d\'utilisateur disponible sur l\'identifiant selectionné';
         }
          $response['error']=false;
         $response['message']='Souscription effectuée avec succès!:'.$contact;
        }
        else
        {
         $response['error']=true;
         $response['message']='Opps!veuillez réessayer svp!';
        }
   
         echoRespnse(200,$response);
});


/*
* Recuperer la liste des services
*/
$app->get('/getAllServices/:user_id', function($user_id)
{

     $response=array();
     $db = new DbHandler();
    $user_id=htmlspecialchars($user_id);
    verifyRequiredParamsByValue($user_id);

    $result=$db->getAllServices();
    while ($service = $result->fetch_assoc()) 
      {
          $tmp = array();
          $tmp["id"] = $service["id"];
          $tmp["libelle"] = $service["libelle"];
          $tmp["image"] = $service["image"];
          $tmp["montant"] = $service["montant"];
          $tmp["description"] = $service["description"];
       
          // verifier si l'user a sousrcit au services courant
          $service_id=$service["id"];
          $isServiceSuscribed=$db->isServiceSuscribed($user_id,$service_id);
          if($isServiceSuscribed)
            { $tmp["sucribed"] = true;}
          else
          {
            $tmp["sucribed"] = false;
          }
      
  
          array_push($response, $tmp);
     }
     
  
         echoRespnse(200,$response);
});

/*
* Recuperer la liste des services pour enregistrer en local
*/
$app->get('/SaveAllServices', function()
{

     $response=array();
     $db = new DbHandler();
    //$user_id=htmlspecialchars($user_id);
    //verifyRequiredParamsByValue($user_id);

    $result=$db->getAllServices();
    while ($service = $result->fetch_assoc()) 
      {
          $tmp = array();
          $tmp["id"] = $service["id"];
          $tmp["libelle"] = $service["libelle"];
          $tmp["montant"] = $service["montant"];
          /*$tmp["create_time"] = $comments["actualite_idactualite"];*/
          $tmp["description"] = $service["description"];
  
          array_push($response, $tmp);
      }
         echoRespnse(200,$response);
});

/*
* Recuperer la liste des services ============= WEB ============
*/
$app->post('/getSouscriptionByDate', function() use ($app) {

    $json=$app->request->getBody();
    $data=json_decode( $json,true);
    $response=array();
    $date_debut=htmlspecialchars($data['date_debut'])." 00:00:00";
    $date_fin=htmlspecialchars($data['date_fin'])." 23:59:59";
    verifyRequiredParamsByValue($date_debut);
    verifyRequiredParamsByValue($date_fin);

    $response=array();
    $db = new DbHandler();
    

    $result=$db->getSouscriptionByDate($date_debut,$date_fin);
    while ($souscription = $result->fetch_assoc()) 
      {
                $tmp = array();
                $tmp["id"] = $souscription["id"];
                $tmp["souscription"] = $souscription["souscription"];
                $tmp["description"] = $souscription["description"];
                $tmp["user_id"] = $souscription["user_id"];
                $tmp["nom"] = $souscription["nom"];
                $tmp["prenom"] = $souscription["prenom"];
                $tmp["login"] = $souscription["login"];
                $tmp["service_id"] = $souscription["service_id"];
                $tmp["service"] = $souscription["service"];
                $tmp["date_souscription"] = $souscription["date_souscription"];
                $tmp["date_expiration"] = $souscription["date_expiration"];
                $tmp["frequence_id"] = $souscription["frequence_id"];
                $tmp["frequence"] = $souscription["frequence"];
                $tmp["montant"] = $souscription["montant"];
          array_push($response, $tmp);
     }
     
  
         echoRespnse(200,$response);
});

/*
* Recuperer la liste des services
*/
$app->get('/getSouscriptionByUserID/:user_id', function($user_id) use ($app) {

   /* $json=$app->request->getBody();
    $data=json_decode( $json,true);*/
    $response=array();
    $user_id=htmlspecialchars($user_id);
    verifyRequiredParamsByValue($user_id);

    $response=array();
    $db = new DbHandler();
    

    $result=$db->getSouscriptionByUserID($user_id);
    while ($souscription = $result->fetch_assoc()) 
      {
                $tmp = array();
                $tmp["id"] = $souscription["id"];
                $tmp["souscription"] = $souscription["souscription"];
                $tmp["description"] = $souscription["description"];
                $tmp["user_id"] = $souscription["user_id"];
                $tmp["nom"] = $souscription["nom"];
                $tmp["prenom"] = $souscription["prenom"];
                $tmp["login"] = $souscription["login"];
                $tmp["service_id"] = $souscription["service_id"];
                $tmp["service"] = $souscription["service"];
                $tmp["date_souscription"] = $souscription["date_souscription"];
                $tmp["date_expiration"] = $souscription["date_expiration"];
                $tmp["frequence_id"] = $souscription["frequence_id"];
                $tmp["frequence"] = $souscription["frequence"];
                $tmp["montant"] = $souscription["montant"];
          array_push($response, $tmp);
     }
     
  
         echoRespnse(200,$response);
});

/*
* Recuperer la liste des frequences
*/
$app->get('/getAllFrequence', function() {

     $response=array();
     $db = new DbHandler();
  
    $result=$db->getAllFrequence();
    while ($service = $result->fetch_assoc()) 
      {
          $tmp = array();
          $tmp["id"] = $service["id"];
          $tmp["libele"] = $service["libele"];
          $tmp["intervale"] = $service["intervale"];
          $tmp["nature_intervale"] = $service["nature_intervale"];
          $tmp["montant"] = $service["montant"];
  
          array_push($response, $tmp);
     }
     
         echoRespnse(200,$response);
});

/*
* Recuperer les commentaires d'une actualité
*/
$app->post('/sendQuestionToExpert/', function() use ($app) {

  $json=$app->request->getBody();
  $data=json_decode($json,true);
  $response['error']=array();
  $response['message']=array();
         $response['message']='Opps!veuillez réessayer svp!';
   if(isset($data['question']) AND !empty($data['question']) AND isset($data['user_id']) AND !empty($data['user_id']) )
        {
          $question = htmlspecialchars($data['question']);
          $user_id = htmlspecialchars($data['user_id']);
          $title = htmlspecialchars($data['title']);
          //$comment_date=date("Y-m-d");
          verifyRequiredParamsByValue($question);
          verifyRequiredParamsByValue($user_id);
          //verifyRequiredParamsByValue($title);
        }
        else
        {
          $response['error']=true;
         $response['message']='Opps!veuillez réessayer svp!';
          echoRespnse(200,$response);
          exit();
        }
        
         $db = new DbHandler();
        $ret=$db->sendQuestionToExpert($title,$question,$user_id);
        if($ret AND $ret!=NULL)
        {
         $response['error']=false;
         $response['message']='requetes envoyée avec succès. Nos experts vous ferons un retour dand un bref délais';
        }
        else
        {
         $response['error']=true;
         $response['message']='Opps!veuillez réessayer svp!';
        }
   
         echoRespnse(200,$response);
});

/*
* Recuperer les commentaires d'une actualité
*/
$app->get('/getQueryForExpertByUserID/:user_id', function($user_id) {

 /* $json=$app->request->getBody();
  $data=json_decode($json,true);*/
  $response=array();
 
  $user_id = htmlspecialchars($user_id);
  $db = new DbHandler();
  $result=$db->getQueryForExpertByUserID($user_id);
        while ($query = $result->fetch_assoc()) 
      {
        $tmp = array();
        $tmp["id"] = $query["id"];
        $tmp["title"] = $query["title"];
        $tmp["question"] = $query["question"];
        $tmp["statut"] = $query["statut"];
        $tmp["reponse"] = ($query["reponse"]!=null)?$query["reponse"]:'';
        $tmp["user_id"] = $query["user_id"];
        $tmp["expert_id"] = ($query["expert_id"]!=null)?$query["expert_id"]:'';
        $tmp["date_avis"] = $query["date_avis"];
        $tmp["date_response"] =($query["date_response"]!=null)?$query["date_response"]:'';
        array_push($response, $tmp);
     }
         echoRespnse(200,$response);
});

/*
* recuperation des de la pub
*/
$app->get('/getlastPub',function (){
  $db = new DbHandler();
  $response=array();
  $result=$db->getLastPUB();
  while($pub=$result->fetch_assoc())
  {
    $tmp=array();
    $tmp['id']=$pub['id'];
    $tmp['titre']=$pub['titre'];
    $tmp['idate_creationd']=$pub['date_creation'];
    $tmp['date_debut']=$pub['date_debut'];
    $tmp['date_fin']=$pub['date_fin'];
    $tmp['description']=$pub['description'];
    $tmp['image']=$pub['image'];
    array_push($response, $tmp);
  }
  echoRespnse(200,$response);
});

/*
* Funtion pour convertir les dates en format francais
*/
function format_date($original='', $format="%Y-%m-%d") {
    $format = ($format=='date' ? "%Y-%m-%d" : $format);
    $format = ($format=='datetime' ? "%Y-%m-%d %H:%M:%S" : $format);
    $format = ($format=='mysql-date' ? "%%Y-%m-%d" : $format);
    $format = ($format=='mysql-datetime' ? "%%Y-%m-%d %H:%M:%S" : $format);
    return (!empty($original) ? strftime($format, strtotime($original)) : "" );
} 


?>