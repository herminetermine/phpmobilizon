<?php

include_once (__DIR__.'/PHPMobilizon/phpmobilizon.php');
include_once (__DIR__.'/config.php');

// Create a new Object PHPMobilizion
$phpmobilizion = new \PhpMobilizon\PHPMobilizon(MOBILIZON_URL);
// or use:
// new \PhpMobilizon\PHPMobilizon(MOBILIZON_URL,MOBILIZON_EMAIL,MOBILIZON_PASSWORD );

// activate debugmode to echo error messages
$phpmobilizion->setDebug(true);

// No need to login to get public event data
$x= $phpmobilizion->Query();
echo "---------------------------";
var_dump($x);
echo "---------------------------";

// Login to get accestoken, set login data first, no need if set in constructor
$phpmobilizion->setEmail(MOBILIZON_EMAIL);
$phpmobilizion->setPassword(MOBILIZON_PASSWORD);

// Execute login to get access & refreshtoken
$phpmobilizion->Login();
// or use  $phpmobilizion->Login(MOBILIZON_EMAIL,MOBILIZON_PASSWORD);

// test the refreshtokencall
$phpmobilizion->Refresh();
$phpmobilizion->CreateEvent(
    '2873',
    'TEST Event',
    'Test Description',
    '2021-12-18 11:00:00',
    '2021-12-18 15:00:00',
    'TENTATIVE',
    'UNLISTED'
);

die("TEST ENDE");