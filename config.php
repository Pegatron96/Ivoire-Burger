<?php


//Connexion via Google Oauth 2.0

require_once "GoogleAPI/vendor/autoload.php";

$gClient = new Google_Client();
$gClient->SetClientId("878078002246-5dd183btufq6gq56u3ihqjc2ilvveghh.apps.googleusercontent.com");
$gClient->SetClientSecret("vtlTRqELKgHlEegToXc9m7D6");
$gClient->SetredirectUri("http://localhost/ivoire-burger/g-callback.php");
$gClient->addScope("https://www.googleapis.com/auth/plus.login https://www.googleapis.com/auth/userinfo.email");



