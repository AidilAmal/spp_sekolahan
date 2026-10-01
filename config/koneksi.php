<?php

$server = "localhost";
$user   = "root";
$pass   = "";
$db     = "spp_sekolah";


$koneksi = mysqli_connect(
    $server,
    $user,
    $pass,
    $db
);


if(!$koneksi){
    die("Database gagal terkoneksi");
}

?>