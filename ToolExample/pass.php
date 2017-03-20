<?php
/**
 * A Library For Password
 * This is a example
 */
use Hautelook\Phpass\PasswordHash;
require_once("../vendor/autoload.php");

$passwordHasher = new PasswordHash(8,false);

$password = $passwordHasher->HashPassword('secret');    // Password Encode
var_dump($password);

$passwordMatch = $passwordHasher->CheckPassword('secret', "$2a$08$0RK6Yw6j9kSIXrrEOc3dwuDPQuT78HgR0S3/ghOFDEpOGpOkARoSu");                                // Check Password
var_dump($passwordMatch);