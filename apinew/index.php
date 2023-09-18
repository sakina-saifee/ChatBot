<?php

$request = json_decode(file_get_contents("php://input")); //dialog flow se value utha rahe jo hame json mai bejh raha
$order_id = $request->queryResult->parameters->orderId;

$url= "https://orderstatusapi-dot-organization-project-311520.uc.r.appspot.com/api/getOrderStatus";

$data = array(
    "orderId"=>$order_id    
);
$datahttps = http_build_query($data);

$ch=curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $datahttps);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response=curl_exec($ch);


if($err=curl_error($ch)){
    echo json_encode(["status"=>"error"]);
}else{
    $shipdate = json_decode($response);
    $speech = "your order id will be shipped on " . $shipdate->shipmentDate;
    $ojb = array(
        "speech"=>$speech,
        "displayText"=>$speech
    );
    //$request = $request->queryResult->fulfillmentMessages;
    // $response = json_decode(file_get_contents("data.json"));
    // $response->fulfillmentMessages[0]->text->text[0] = $speech;
    // $response->outputContexts[0]->parameters->orderId = $order_id;
     $response  = array(
         "fulfillmentMessages" => [
             array(
                
                 "text" => array(
                     "text" => [
                         $speech
    
                     ]
                 )
             )
         ]

                 );
   
    header('Content-Type: application/json');
    //$response = json_decode(file_get_contents("data.json"));
    echo json_encode($response);

    
}



?>