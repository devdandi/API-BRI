<?php 

class BRI 
{
    protected $url ="https://sandbox.partner.api.bri.co.id/oauth/client_credential/accesstoken?grant_type=client_credentials";
    protected $private_key = "";
    protected $customer_key = "";

    public $path;
    public $verb;



    function __construct()
    {

    }
    function requestHeader($token, $timestamp, $getSignature)
    {
        return array(
            "Authorization:Bearer " . $token,
            "BRI-Timestamp:" . $timestamp,
            "BRI-Signature:" . $getSignature
        );
    }
    function getAccessToken()
    {
       
        $data = "client_id=$this->customer_key&client_secret=$this->private_key";
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$this->url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");  //for updating we have to use PUT method.
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
        $result = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $json = json_decode($result, true);

        // return access token
        return $json['access_token'];
        // end return

    }
    function generateSignature($payloads)
    {
        $signPayload = hash_hmac('sha256', $payloads, $this->private_key, true);
        return base64_encode($signPayload);
    }
    function checkInquiry()
    {
        $NoRek = "888801000157508";
        $secret = $this->private_key;
        $timestamp = gmdate("Y-m-d\TH:i:s.000\Z");
        $token = $this->getAccessToken();
        $path = "/sandbox/v2/inquiry/".$NoRek;
        $verb = "GET";
        $body="";
        
        $payloads = "path=$path&verb=$verb&token=Bearer $token&timestamp=$timestamp&body=";
        $getSignature = $this->generateSignature($payloads);


        $urlGet ="https://partner.api.bri.co.id/sandbox/v2/inquiry/".$NoRek;
        $chGet = curl_init();
        curl_setopt($chGet,CURLOPT_URL,$urlGet);

        
        curl_setopt($chGet, CURLOPT_HTTPHEADER, $this->requestHeader($token, $timestamp, $getSignature));
        curl_setopt($chGet, CURLINFO_HEADER_OUT, true);


        // curl_setopt($chGet, CURLOPT_CUSTOMREQUEST, "GET");  //for updating we have to use PUT method.
        curl_setopt($chGet, CURLOPT_RETURNTRANSFER, true);

        $resultGet = curl_exec($chGet);
        $httpCodeGet = curl_getinfo($chGet, CURLINFO_HTTP_CODE);
        // $info = curl_getinfo($chGet);
        // print_r($info);
        curl_close($chGet);
        return $resultGet;
    }

}
