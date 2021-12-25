<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
<?php 
$username = "root";
$password = "";
$database = new PDO("mysql:host=localhost; dbname=sparki;",$username,$password);
?>
<div class="container mt-5">
    <form method="POST">
       <p class="font-weight-bold"> Email : </p>  <input class="form-control" type="email" name="email" required/>
       <p class="font-weight-bold"> Password : </p> <input class="form-control" type="password" name="password" required/>
        <button type="submit" class="btn btn-success mt-5" name="login">Login</button>
        <a href="register.php" class="btn btn-warning mt-5"> Sign Up</a>
    </form>
    <?php 
if(isset($_POST['login'])){
    $login = $database->prepare("SELECT * FROM users WHERE EMAIL = :email AND PASSWORD =:password");
    $login->bindParam("email",$_POST['email']);
    $login->bindParam("password",$_POST['password']);
    $login->execute();
    if($login->rowCount()===1){
        $user = $login->fetchObject();
        echo 'Welcome' . $user->NAME;
        $_SESSION['email']= $user->EMAIL;
        $_SESSION['password']= $user->PASSWORD;
        $_SESSION['name']= $user->NAME;
    }else{
    echo '<div class="alert alert-danger">Incorrect password or email</div>';
    }
}

?>
</div>


