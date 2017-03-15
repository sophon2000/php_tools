<?php

require_once("../vendor/autoload.php");

$passwordHasher = new PasswordHash(8,false);

$password = $passwordHasher->HashPassword('secret');
var_dump($password);

$passwordMatch = $passwordHasher->CheckPassword('secret', "$2a$08$0RK6Yw6j9kSIXrrEOc3dwuDPQuT78HgR0S3/ghOFDEpOGpOkARoSu");
var_dump($passwordMatch);