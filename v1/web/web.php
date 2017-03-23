<?php 
require_once '../common/common.php';
require_once '../common/goSMS.php';
require_once '../common/mail.php';




/*
* Recuperer la liste des services
*/
$app->get('/getAllServices', function() {

     $response=array();
     $db = new DbHandler();
    

    $result=$db->getAllServices();
    while ($service = $result->fetch_assoc()) 
      {
                $tmp = array();
                $tmp["id"] = $service["id"];
                $tmp["libelle"] = $service["libelle"];
                $tmp["image"] = $service["image"];
                $tmp["montant"] = $comments["montant"];
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
* Recuperer la liste des services d'un abonnée
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
* Recuperer la liste des souscriptions d'un services donné ======== WEB ===
*/
$app->get('/getSouscriptionByServiceID/:service_id', function($service_id) {

   /* $json=$app->request->getBody();
    $data=json_decode( $json,true);*/
    $response=array();
    $service_id=htmlspecialchars($service_id);
    verifyRequiredParamsByValue($service_id);

    $response=array();
    $db = new DbHandler();
    

    $result=$db->getSouscriptionByServiceID($service_id);
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
* Recuperer la liste des des periodes d'une souscriptions d'un services donné ======== WEB ===
*/
$app->get('/getSouscriptionPeriodeByServiceID/:service_id', function($service_id) {

   /* $json=$app->request->getBody();
    $data=json_decode( $json,true);*/
    $response=array();
    $service_id=htmlspecialchars($service_id);
    verifyRequiredParamsByValue($service_id);

    $response=array();
    $db = new DbHandler();
    

    $result=$db->getSouscriptionPeriodeByServiceID($service_id);
    while ($souscription = $result->fetch_assoc()) 
      {
                $tmp = array();
                $tmp["service_id"] = $souscription["service_id"];
                $tmp["frequence_id"] = $souscription["frequence_id"];
                $tmp["frequence"] = $souscription["frequence"];
                $tmp["montant"] = $souscription["montant"];
          array_push($response, $tmp);
     }
     
         echoRespnse(200,$response);
});

/*
* Recuperer la liste des des periodes d'une souscriptions d'un services donné ======== WEB ===
*/
$app->post('/getSuscriberContactByservice', function()use ($app) {

    $json=$app->request->getBody();
    $data=json_decode( $json,true);
    $response=array();
    $service_id=htmlspecialchars($data['service_id']);
    //$frequence_id=htmlspecialchars($data['frequence_id']);
    verifyRequiredParamsByValue($service_id); 

    $response=array();
    $db = new DbHandler();

    $result=$db->getSuscriberContactByservice($service_id);
    while ($contact = $result->fetch_assoc()) 
      {
                $tmp = array();
                $tmp["id"] = $contact["id"];
                $tmp["nom"] = $contact["nom"];
                $tmp["prenom"] = $contact["prenom"];
                $tmp["login"] = $contact["login"];
                $tmp["contact"] = $contact["contact"];
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
* Recuperer la liste des frequences
*/
$app->get('/getAllCategories', function() {

     $response=array();
     $db = new DbHandler();
    

    $result=$db->getAllCategories();
    while ($service = $result->fetch_assoc()) 
      {
          $tmp = array();
          $tmp["id"] = $service["id"];
          $tmp["libele"] = $service["libele"];
          $tmp["description"] = $service["description"];
      
          array_push($response, $tmp);
     }
     
         echoRespnse(200,$response);
});

/*
* Repondre a une question 
*/
$app->post('/replyQuestion/', function() use ($app) {
  $json=$app->request->getBody();
  $data=json_decode($json,true);
  $response['error']=array();
  $response['message']=array();
         $response['message']='Opps!veuillez réessayer svp!';
   if(isset($data['answer']) AND !empty($data['answer']) AND isset($data['expert_id']) AND !empty($data['expert_id']) AND isset($data['question_id']) AND !empty($data['question_id']) )
        {
          $answer = htmlspecialchars($data['answer']);
          $expert_id = htmlspecialchars($data['expert_id']);
        /*$date_now = date_create();
          $date=date_format($date_now, 'Y-m-d H:i:s');*/
         /* $answer = htmlspecialchars($data['answer']);*/
           $question_id = htmlspecialchars($data['question_id']);
          //$comment_date=date("Y-m-d");
          verifyRequiredParamsByValue($answer);
          verifyRequiredParamsByValue($expert_id);
          verifyRequiredParamsByValue($question_id);
        }
        else
        {
          $response['error']=true;
         $response['message']='Opps!veuillez réessayer svp!';
          echoRespnse(200,$response);
          exit();
        }
        
         $db = new DbHandler();
        $ret=$db->replyQuestion($question_id,$answer,$expert_id);
        if($ret)
        {
          $QueryInfo=$db->getRequesInfo($question_id);

          $user_mail=$db->getUserMail($QueryInfo['user_id']);
         
          if(!empty($user_mail) AND $user_mail!="")
          {
            //var_dump($user_mail); exit();
             // $body_to_Controller=$answer;
            smtpmailer($user_mail, 'basopro1@gmail.com', $from_name = 'STARTUP', $QueryInfo['title'], $answer, $is_gmail = true);
          }
         $response['error']=false;
         $response['message']='Réponse envoyée avec succès.';
        }
        else
        {
         $response['error']=true;
         $response['message']='Opps!veuillez réessayer svp!';
        }
   
         echoRespnse(200,$response);
});

/*
* Creer une actualité
*/
$app->post('/craeteNew',function () use ($app){

  $json=$app->request->getBody();
  $data=json_decode($json,true);
  $titre=htmlspecialchars($data['titre']);
  $texte=htmlspecialchars($data['text']);
  $image=htmlspecialchars($data['image']);
  $cat_id=htmlspecialchars($data['cat_id']);
  verifyRequiredParamsByValue($titre);
  verifyRequiredParamsByValue($texte);
  verifyRequiredParamsByValue($cat_id);
  if($image=="")
  {
    $image="ressources/news/default.png";
  }

  $db = new DbHandler();
  $admin_id=1;
  //$admin_id=geCurrentUserInfos();
   $image2="ressources/actualite/".$image;
  $ret_create=$db->craeteNew($titre, $texte, $image2,$admin_id,$cat_id);

  if($ret_create)
    { 
      $response['error']=false;
      $response['message']="Actualité créée avec succès!";
    }
    else
    { 
      $response['error']=true;
      $response['message']="Echec. Veuillez réessayer.";
    }

    echoRespnse(200,$response);
});


/*
* Creer une actualité
*/
$app->post('/craeteParution/',function () use ($app){
  $json=$app->request->getBody();
  $data=json_decode($json,true);
  $titre=htmlspecialchars($data['titre']);
  $num_parution=htmlspecialchars($data['num_parution']);
  $images_parution=$data['img'];
  //$images=$_FILES['photo']['tmp_name'];
  verifyRequiredParamsByValue($titre);
  verifyRequiredParamsByValue($num_parution);
  //verifyRequiredParamsByValue($cat_id);
  $cover=$images_parution[0]['name'];
  $db = new DbHandler();
  $admin_id=1;
  $hhh='tail tableau: '.count($images_parution);
	//var_dump($hhh,$images_parution); exit();
	  
  $ret_create=$db->createParution($titre, $num_parution, $cover);

  $ret_image_error=false;
  
  if($ret_create)
    { 
     
      for($i=0;$i<count($images_parution);$i++) 
      {
        $image='ressources/parution/'.$images_parution[$i]['name'];
          $ret_images=$db->createParutionContent($image,$num_parution);
          if($ret_images)
          {
            $ret_image_error=true;
          }
      }

      $response['error']=false;
      $response['mesage']="Parution créée avec succès!";
    }
    else
    { 
      if($ret_image_error)
        {
          $response['error']=true;
          $response['mesage']="Echec. Certaines images de la parution n'on pas été enregistrées. Veuillez réessayer";
        }
        else
        {
          $response['error']=true;
          $response['mesage']="Echec. Veuillez réessayer.";
        }
      
    }

    echoRespnse(200,$response);
});

/*
* Créer une parution de magazine
*/
$app->post('/craetePub',function () use ($app){
  $json=$app->request->getBody();
  $data=json_decode($json,true);
  $titre=htmlspecialchars($data['titre']);
  $description=htmlspecialchars($data['description']);
  //$date_debut=htmlspecialchars($data['date_debut']);
 // $date_fin=htmlspecialchars($data['date_fin']);
  $images_pub=htmlspecialchars($data['img']);
  //$images=$_FILES['photo']['tmp_name'];
  verifyRequiredParamsByValue($titre);
 /* verifyRequiredParamsByValue($date_debut);
  verifyRequiredParamsByValue($date_fin);*/
  verifyRequiredParamsByValue($images_pub);

  //$cover=$images_parution[0]['name'];
  $db = new DbHandler();
  $admin_id=1;
  //$admin_id=geCurrentUserInfos();
  //$hhh='tail tableau: '.count($images_parution);
  //var_dump($hhh,$images_parution); exit();
    $images_pub="ressources/publicite/".$images_pub;
  $id_pub=$db->createPub($titre, $description,$admin_id,$images_pub);

  $ret_image_error=false;
  
  if($id_pub!=null AND $id_pub>0)
    {  
      $response['error']=false;
      $response['mesage']="Publicité créée avec succès!";
    }
    else
    { 
      if($ret_image_error)
        {
          $response['error']=true;
          $response['mesage']="Echec. Certaines images de la publicité n'on pas été enregistrées. Veuillez réessayer";
        }
        else
        {
          $response['error']=true;
          $response['mesage']="Echec. Veuillez réessayer.";
        }
      
    }

    echoRespnse(200,$response);
});


/*
* Envoi des information ( StartUpInfo, depeches) aux abonnés
*/
$app->post('/push_service_data',function()use ($app){

  $json=$app->request->getBody();
  $data=json_decode($json,true);
  $service_id=htmlentities($data['service_id']);
  $message=htmlspecialchars($data['message']);
  $contact_list=array();

  verifyRequiredParamsByValue($service_id);
  verifyRequiredParamsByValue($message);
  $db = new DbHandler();
  // recuperation des contcts des souscripteurs de ce service
  $result=$db->getSuscriberContactByservice($service_id);

    while ($contact = $result->fetch_assoc()) 
      {
          $tmp = array();
          $tmp["id"] = $contact["id"];
          $tmp["nom"] = $contact["nom"];
          $tmp["prenom"] = $contact["prenom"];
          $tmp["login"] = $contact["login"];
          $tmp["contact"] = $contact["contact"];
          array_push($contact_list, $tmp);
     }
  // recuperer le nom du service concerné
      $service_name=$db->getServiceNameByID($service_id);
  // envoi des messages
     // var_dump($contact_list,$service_name) ;exit();
  foreach ($contact_list as $key => $value) {
    
      $ret_SMS=SendSMS($value['contact'],$message);
      sleep(1);
      $ret_sms_part=explode('#@', $ret_SMS);

      $ret_historique=$db->saveSMSHistoriques($service_name, $ret_sms_part[0],$ret_sms_part[1],$ret_sms_part[2],
      $ret_sms_part[3],$ret_sms_part[4],$message);
  }

  $admin_id=1;
  //$admin_id=geCurrentUserInfos();
  $nombre_dest=count($contact_list);
  // save du message dans contenu service
    $id_service_contenu=$db->saveServiceContenu(substr($message, 0,200),$service_id,$admin_id, $nombre_dest);
  // save de la liste des destinataires
  if($id_service_contenu!=null)
  {
   $ret_dest_list=$db->saveDestlist($contact_list,$id_service_contenu);
  }
  $response['error']=false;
  $response['message']="Envoi d'SMS effectué. veuillez consulter l'historiqe des SMS pour plus de details";
echoRespnse(200,$response);
});


/*
* liste des news
*/
$app->get('/getAllNew',function (){
  $db = new DbHandler();
  $response=array();
  $result=$db->getAllNews();
  while($new=$result->fetch_assoc())
  {
    $tmp=array();
    $tmp['id']=$new['idactualite'];
    $tmp['titre']=$new['titre'];
    $tmp['text']=$new['text'];
    $tmp['create_time']=$new['create_time'];
    $tmp['date_publication']=$new['date_publication'];
    $tmp['etat']=$new['etat'];
    $tmp['cree_par']=$new['cree_par'];
    $tmp['cree_par']=$new['cree_par'];
    $tmp['cat_id']=$new['cat_id'];
    $tmp['cover']=$new['cover'];

    array_push($response, $tmp);
  }
  echoRespnse(200,$response);
});

/*
* liste des news
*/
$app->get('/getAllNew',function (){
  $db = new DbHandler();
  $response=array();
  $result=$db->getAllNews();
  while($new=$result->fetch_assoc())
  {
    $tmp=array();
    $tmp['id']=$new['idactualite'];
    $tmp['titre']=$new['titre'];
    $tmp['text']=$new['text'];
    $tmp['create_time']=$new['create_time'];
    $tmp['date_publication']=$new['date_publication'];
    $tmp['etat']=$new['etat'];
    $tmp['cree_par']=$new['cree_par'];
    $tmp['cree_par']=$new['cree_par'];
    $tmp['cat_id']=$new['cat_id'];
    $tmp['cover']=$new['cover'];

    array_push($response, $tmp);
  }
  echoRespnse(200,$response);
});

/*
* Liste des PUB
*/
$app->get('/getAllPub',function (){
  $db = new DbHandler();
  $response=array();
  $result=$db->getAllPub();
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
* Liste des PUB
*/
$app->get('/getAllParution',function (){
  $db = new DbHandler();
  $response=array();
  $result=$db->getAllParution();
  while($pub=$result->fetch_assoc())
  {
    $tmp=array();
    $tmp['id']=$pub['id'];
    $tmp['titre']=$pub['titre'];
    $tmp['num_parution']=$pub['code'];
    $tmp['contenu']=$pub['contenu'];
    $tmp['date_parution']=$pub['date_parution'];
    $tmp['create_time']=$pub['create_time'];
    $tmp['cover']=$pub['cover'];
    $tmp['cree_par']=$pub['cree_par'];
    
    array_push($response, $tmp);
  }
  echoRespnse(200,$response);
});

/*
* Liste des messages services (startupInfo,depeches)
*/
$app->get('/getAllServicesmessages',function (){
  $db = new DbHandler();
  $response=array();
  $result=$db-> getAllServicesmessages();
  while($pub=$result->fetch_assoc())
  {
    $tmp=array();
    $tmp['id']=$pub['id'];
    $tmp['theme']=$pub['theme'];
    $tmp['texte']=$pub['texte'];
    $tmp['create_time']=$pub['create_time'];
    $tmp['service_id']=$pub['service_id'];
    $tmp['envoye_par']=$pub['envoye_par'];
    $tmp['nombre_dest']=$pub['nombre_dest'];
    $tmp['service']=$pub['service'];
    array_push($response, $tmp);
  }
  echoRespnse(200,$response);
});

/*
* Liste des messages des avis d'expert
*/
$app->get('/getAllAvisExpert',function (){
  $db = new DbHandler();
  $response=array();
  $result=$db-> getAllAvisExpert();
  while($pub=$result->fetch_assoc())
  {
    $tmp=array();
    $tmp['id']=$pub['id'];
    $tmp['title']=$pub['title'];
    $tmp['question']=$pub['question'];
    $tmp['reponse']=$pub['reponse'];
    $tmp['date_avis']=$pub['date_avis'];
    $tmp['user_id']=$pub['user_id'];
    $tmp['expert_id']=$pub['expert_id'];
    $tmp['statut']=$pub['statut'];
    $tmp['user']=$pub['user'];
    $tmp['expert']=$pub['nom'].' '.$pub['prenom'];
    

    array_push($response, $tmp);
  }
  echoRespnse(200,$response);
});

/*
* Liste des users mobile
*/
$app->get('/getAllUser',function (){
  $db = new DbHandler();
  $response=array();
  $result=$db-> getAllUser();
  while($pub=$result->fetch_assoc())
  {
    $tmp=array();
    $tmp['id']=$pub['id'];
    $tmp['nom']=$pub['nom'];
    $tmp['prenom']=$pub['prenom'];
    $tmp['profession']=$pub['profession'];
    $tmp['mail']=$pub['mail'];
    $tmp['login']=$pub['login'];
    $tmp['photo']=$pub['photo'];
    $tmp['statut']=$pub['statut'];
    $tmp['date_naissance']=$pub['date_naissance'];
    $tmp['last_connect']=$pub['last_connect'];
  
    array_push($response, $tmp);
  }
  echoRespnse(200,$response);
});

/*
* Liste des users mobile
*/
$app->get('/getSouscripteurByService/:service_id',function ($service_id){
  
  verifyRequiredParamsByValue($service_id);
  $db = new DbHandler();
  $response=array();
  $result=$db-> getSouscripteurByService($service_id);
  while($pub=$result->fetch_assoc())
  {
    $tmp=array();
    $tmp['id']=$pub['id'];
    $tmp['description']=$pub['description'];
    $tmp['user_id']=$pub['user_id'];
    $tmp['nom']=$pub['nom'];
    $tmp['prenom']=$pub['prenom'];
    $tmp['login']=$pub['login'];
    $tmp['mail']=$pub['mail'];
    $tmp['profession']=$pub['profession'];
    $tmp['contact']=$pub['contact'];
    $tmp['statut']=$pub['statut'];
    $tmp['service_id']=$pub['service_id'];
    $tmp['service']=$pub['service'];
    $tmp['service']=$pub['service'];
    $tmp['date_souscription']=$pub['date_souscription'];
    $tmp['montant']=$pub['montant'];
    $tmp['photo']=$pub['photo'];
  
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


/*
* recuperer le User de la session en cours
*/
function geCurrentUserInfos()
{
    if (!isset($_SESSION))
     {
         session_start();
         if (isset($_SESSION['id']) && !empty($_SESSION['id']))
        {
             $user_id=htmlspecialchars($_SESSION['id']);
             //$num_client=htmlspecialchars($_SESSION['num_client']);
         }else
         {  
                        $response = array();
           $app = \Slim\Slim::getInstance();
            $response["error"] =true;
            $response["message"] ="Session terminée. Veuillez vous reconnecter" ;
            echoRespnse(200,$response);
            $app->stop();
           
         }
     }
     return  $user_id;
}

?>