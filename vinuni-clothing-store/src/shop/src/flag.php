<?php
    //U are not there yet :P 

    header('Content-Type: application/json');

    extract($_SERVER);
    extract($_COOKIE);

    if($_COOKIE['REMOTE_ADDR'])
    { 
        $client_ip=$_COOKIE['REMOTE_ADDR'];
	$client_ip=base64_decode($client_ip);
	$client_ip=trim($client_ip);
    }
    else
    {
        $client_ip=$_SERVER['REMOTE_ADDR'];
    }
    
    $client_ip= str_replace("0.", "", $client_ip);
    $client_ip= str_replace("7.", "", $client_ip);
    $client_ip= str_replace("12", "", $client_ip);

    $response = new stdClass();
    $response->status_code = 403;
    $response->msg = "Error 403 forbidden, this website can only be accessed by the localhost";

    if (strcmp($client_ip, "127.0.0.1") == 0)
    {
        $response->msg = getenv("FLAG");
        $response->status_code = 200;
    }
    echo json_encode($response);
?>
