<?php

session_start();

include "config/koneksi.php";


if(isset($_POST['login'])){


$username=$_POST['username'];
$password=$_POST['password'];


$query=mysqli_query($koneksi,

"SELECT * FROM tb_petugas 
WHERE username='$username'
AND password='$password'");


$data=mysqli_fetch_assoc($query);


if($data){


$_SESSION['login']=true;
$_SESSION['nama']=$data['nama_petugas'];
$_SESSION['level']=$data['level'];


header("location:dashboard.php");


}else{

$error="Username atau password salah";

}


}


?>


<!DOCTYPE html>

<html>

<head>

<title>Login SPP</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>


<body class="bg-light">


<div class="container">

<div class="row justify-content-center mt-5">


<div class="col-md-4">


<div class="card">


<div class="card-body">


<h3 class="text-center">

Login Admin

</h3>



<form method="POST">


<input 
class="form-control mb-3"
name="username"
placeholder="Username">


<input 
type="password"
class="form-control mb-3"
name="password"
placeholder="Password">


<button 
class="btn btn-primary w-100"
name="login">

Login

</button>


</form>



</div>

</div>


</div>


</div>

</div>


</body>

</html>