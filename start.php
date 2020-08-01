<?php


include '_init/VerifyLicence.php';


$config = file_get_contents('_init/files/config/config.json');
$config_json = json_decode($config, true);
if($config_json['status'] == "disable")
{
    // generate the key
    $licence = generateKey();
    // end key
    
    // input domain name
    echo "Enter domain name: ";
    $input_domain = fopen('php://stdin','r');
    $domain = trim(fgets($input_domain));
    // end input domain name
    
    // initialize class verify
    $verify = new VerifyLicence('0','0',$licence,$domain);
    // end class
    $data = json_decode($verify->validate(), true);

    $config_json['status'] = "active";
    $config_json['data']['licence_key'] = $licence;

    $newJson = json_encode($config_json);
    file_put_contents('_init/files/config/config.json', $newJson);
    echo "Your licence key is: " . $licence. " This is auto added to configuration files.";
}else{
    echo 'Your licence is activated right now, not for sale. If you sale this tools i will disable the API \n';
    echo 'Now enjoy to use this tools, see documentation on my repository ot visit my website: https://devours.org.';
}

// fucntion for generate key 
function generateKey()
{  
    $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    return 'L-'.substr(str_shuffle($permitted_chars), 0, 16).'devdandi';
}
// end key