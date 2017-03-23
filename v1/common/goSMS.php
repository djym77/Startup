<?php

    function SendSMS($numero,$message)
    {
       if (!isset($_SESSION))
       {
           session_start();
       }
  //  $receiver=array();
       if(isset($numero) AND isset($message) AND !empty($message) AND !empty($numero))
      {
       $_SESSION["msisdn"]=$numero;
       $_SESSION["message"]=$message;
      }
      else
      {
        return "error#@#@#@#@".$numero;
      } 

      //Integration d'envoie de Sms
     /* echo $_POST["msisdn"];
      echo $_SESSION["msisdn"];
      echo $_POST["message"];
      echo $_SESSION["message"];*/
  /********************Generation du Token**********************************************/
     $client_id = 'FI991U5V1LMp8nNkld2iPedSdyN9EKw6'; ///I have created an app in my account that gives me both the id and key
     $client_secret = 'ksDmvZMrKKAnvahl';
     $api_request_url = 'https://api.orange.com/oauth/v2/token';  //grant_type=client_credentials   or grant_type=public
     $api_request_parameters =array('grant_type' =>'client_credentials');
     $code=base64_encode($client_id.":".$client_secret);
     $ch = curl_init();
     curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
     curl_setopt($ch, CURLOPT_POST, TRUE);
     curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($api_request_parameters)); //$api_request_parameters;
     curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Basic Rkk5OTFVNVYxTE1wOG5Oa2xkMmlQZWRTZHlOOUVLdzY6a3NEbXZaTXJLS0FudmFobA=='));
     curl_setopt($ch, CURLOPT_USERAGENT, 'https://api.orange.com');
     curl_setopt($ch, CURLOPT_TIMEOUT, 5);
     curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
     curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
     curl_setopt($ch, CURLOPT_URL, $api_request_url);
  $api_response = curl_exec($ch);
     if($errno = curl_error($ch))
     {
       echo "<p>".$errno."</p>";
     }
     curl_close($ch);
     //echo  $api_response;
     $obj = json_decode($api_response);
     // print $obj->{'access_token'}; // 1234
     $Acces_Bearer=$obj->{'token_type'};
     $Access_Token=$obj->{'access_token'};
 /********************* Fin Generation du Token ****************************************/
/*********************** Envoi du Sms ***************************************************/
    $receiver['phone']="225".$_SESSION["msisdn"];
    $senderAddress="22509600003"; //First sender 08681957    //second sender 07868963
    $receiver['phone2']="22509600003";
    $sms=$_SESSION["message"];
    $api_request_url_for_send_sms="https://api.orange.com/smsmessaging/v1/outbound/tel%3A%2B22509600003/requests";
    $api_request_url_for_send_data=array("address"=>"tel:+".$receiver['phone'],"senderAddress"=>"tel:+".$receiver['phone2'],"outboundSMSTextMessage"=>array("message"=>"
$sms"));
   $json_retour =array("outboundSMSMessageRequest"=>$api_request_url_for_send_data);

    $chaine = curl_init();
//curl_setopt($chaine, CURLOPT_RETURNTRANSFER,TRUE);
    curl_setopt($chaine, CURLOPT_POST,TRUE);
   curl_setopt($chaine, CURLOPT_POSTFIELDS,json_encode($json_retour));
    $header[] ="Authorization: $Acces_Bearer $Access_Token";
    $header[] ="Content-Type: application/json";
    curl_setopt($chaine, CURLOPT_HTTPHEADER,$header);
    curl_setopt($chaine, CURLOPT_USERAGENT,'https://api.orange.com');
    curl_setopt($chaine, CURLOPT_TIMEOUT,30);
    curl_setopt($chaine, CURLOPT_CONNECTTIMEOUT,30);
    curl_setopt($chaine, CURLOPT_FOLLOWLOCATION,TRUE);
    curl_setopt($chaine, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    //curl_setopt($chaine, CURLOPT_SSL_VERIFYPEER,-1);
    curl_setopt($chaine, CURLOPT_VERBOSE, 1);
    curl_setopt($chaine, CURLOPT_URL,$api_request_url_for_send_sms);
    $api_response_sms = curl_exec($chaine);
    if($errnosms = curl_error($chaine))
     {

      return "error#@".$errnosms."#@".$Acces_Bearer."#@".$Access_Token."#@".
      $receiver['phone'];
      //echo "<p>".$errnosms."</p>";
      //echo "<br>";
     }
     else
     {
       return "succes#@".$api_response_sms."#@".$Acces_Bearer."#@".$Access_Token."#@".
      $receiver['phone'];
     }

      //echo "<br/>";
      //echo $api_response_sms;
      // echo "<br/>";
        //Fin integration

}

?>