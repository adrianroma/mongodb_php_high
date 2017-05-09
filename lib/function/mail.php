<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of json
 *
 * @author aromerov
 */
require 'vendor/autoload.php';

class lib_function_mail {
    
    public $core;
    
    public $api_key_send_grid ='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';
    
    //put your code here
    public function __construct() {

  
    

    //$this->SEND_MAIL('service@feedtofood.com','service','status','status');
       
    }
    
    private function SEND_MAIL($from_email='service@feedtofood.com',$subject='service',$message='status',$type='status'){
        
//    $sendgrid = new SendGrid($this->api_key_send_grid);
//    $email = new SendGrid\Email();
//    $email->addTo('ak360s@gmail.com')
//    ->setFrom($from_email)
//    ->setSubject($subject)
//    ->setHtml("<h>Welcome to</h><a href='http://www.feedtofood.com'>Feed to Food</a>");
      
        
        $request_body = json_decode('{
  "personalizations": [
    {
      "to": [
        {
          "email": "ak360s@gmail.com"
        }
      ],
      "subject": "Hello World from the SendGrid PHP Library!"
    }
  ],
  "from": {
    "email": "service@feedtofood.com"
  },
  "content": [
    {
      "type": "text/plain",
      "value": "Hello, Email!"
    }
  ]
}');

$sg = new \SendGrid('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');


$response = $sg->client->mail()->send()->post($request_body);
echo $response->statusCode();
echo $response->body();
echo $response->headers();
       
//202HTTP/1.1 202 Accepted Server: nginx Date: Tue, 31 Jan 2017 05:24:10 GMT Content-Type: text/plain; charset=utf-8 Content-Length: 0 Connection: keep-alive X-Message-Id: AFasS0uATR6xu4xyqe_bpw X-Frame-Options: DENY Access-Control-Allow-Origin: https://sendgrid.api-docs.io Access-Control-Allow-Methods: POST Access-Control-Allow-Headers: Authorization, Content-Type, On-behalf-of, x-sg-elas-acl Access-Control-Max-Age: 600 X-No-CORS-Reason: https://sendgrid.com/docs/Classroom/Basics/API/cors.html

//   try {
//    $sendgrid->send($email);
//     
//    } catch(\SendGrid\Exception $e) {
//    echo $e->getCode();
//    foreach($e->getErrors() as $er) {
//        echo $er;
//    }
//    }
        
    }
    
}