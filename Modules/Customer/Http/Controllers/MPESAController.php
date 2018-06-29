<?php

namespace Modules\Customer\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class MPESAController extends Controller
{
    
    private $mpesa_config;
    
    public function __construct() {
        
        $this->mpesa_config = config('mpesa');
    }
    
    public function access_token(){
        
        $key = $this->mpesa_config['key'];
        $secret = $this->mpesa_config['secret'];
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $this->mpesa_config['token_url']);
        $credentials = base64_encode($key.':'.$secret);
        curl_setopt($curl, CURLOPT_HTTPHEADER, 
                array('Authorization: Basic '.$credentials)); //setting a custom header
        curl_setopt($curl, CURLOPT_HEADER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $curl_response = curl_exec($curl);

        return json_decode($curl_response);
    }
    
    
    public function encrypt(){
        
        $publicKey = 'file://'.$this->mpesa_config['certificate_path'];
        $plaintext = "19862008@Dil";

        openssl_public_encrypt($plaintext, $encrypted, $publicKey, OPENSSL_PKCS1_PADDING);

        return base64_encode($encrypted);
    }
 
}