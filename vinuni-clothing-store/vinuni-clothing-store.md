# VinUni Clothing Store

Read the source ([vinuni-clothing-store.zip](src)), pwn the web, and retrieve the flag!

Challenge URL: http://ctflag.vhc.asia:32181/login.php

## Techniques

PHP, Cookie

## Solution

Look at the file [flag.php](src/shop/src/flag.php) because it is the most suspicious.

```php
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

```

The flag comes from this `if` block.

```php
if (strcmp($client_ip, "127.0.0.1") == 0)
{
    $response->msg = getenv("FLAG");
    $response->status_code = 200;
}
```

It checks whether the client IP is the `localhost`, which is usually impossible if we are accessing the website from any machine other than the server (or I suppose).

But where is the `$client_ip` from?

```php
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
```

It is obtained from the field `REMOTE_ADDR` in the COOKIE!

Then we can use some extension such as Cookie-Editor to edit the cookie and F5 the website.

Some things to note: before obtaining the IP `127.0.0.1`, the cookie part goes through some `str_replace` and a Base64 encoding. Figure this out yourself and the field value is `MTEyMjc3Li4wMC4uMDAuLjE=`.

## The Flag

`VHC2022{y0ur_c00k13_1s_t00_d1rty_w3_c4n't_f1lt3r_1t}`