<?php 

// namespace _init;



class VerifyLicence 
{
    private $ip, $mac, $lisence, $domain; // create properyy
    protected $field = array(); // 
    public $url = "https://api.devours.org/api/check-licence/index.php"; // url for post data

    // function that first executed if class verifylicence has accessed
    function __construct($ip = null, $mac = null, $lisence, $domain)
    {
        if($ip != null && $mac != null && $lisence != null && $domain != null)
        {
            // generate array for post to devours server
            $field = array(
                'ip' => $ip,
                'mac' => $mac,
                'lisence' => $lisence,
                'domain' => $domain
            );
            // array

            // set up property
            $this->field = $field;
            $this->ip = $ip;
            $this->mac = $mac;
            $this->lisence = $lisence;
            $this->domain = $domain;
            // end property
        }else{
            return false;
        }
    }
    // end constuct


    // function for check licence
    public function _init()
    {
        try {
            $ch = curl_init($this->url);
            // curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            // //set the url, number of POST vars, POST data
            // curl_setopt($ch,CURLOPT_URL, $this->url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
            curl_setopt($ch,CURLOPT_POSTFIELDS, json_encode($this->field));
            curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
            $result = curl_exec($ch);
            curl_close($ch);
            return $result;
        }catch(Exception $e){
            // show erros
            return "Error". $e;
            // end show error
        }
    }
    // end fucntion

    // just validate and get the data from _init funciton
    function validate()
    {
        return $this->_init();
    }
    // end validate
}

