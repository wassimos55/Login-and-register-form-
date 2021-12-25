<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
<div class="container" dir="rtl" style="text-align: right !important;">


<form method="POST" >
اسم : <input class="form-control" type="text" name="name" required/>
<br>
العمر : <input class="form-control" type="date" name="age" required/>
<br>
إيميل : <input class="form-control" type="email" name="email" required/>
<br>
كلمة مرور : <input class="form-control" type="text" name="password" required />
<br>
<button class="btn btn-dark" type="submit" name="register">تسجيل - Register</button>
<a href="login.php" class="btn btn-warning ">Login</a>
</form>

</div>


<?php 
$username = "root";
$password = "";
$database = new PDO("mysql:host=localhost; dbname=sparki;",$username,$password);



if(isset($_POST['register'])){
    $checkEmail = $database->prepare("SELECT * FROM users WHERE EMAIL = :EMAIL");
    $email = $_POST['email'];
    $checkEmail->bindParam("EMAIL",$email);
    $checkEmail->execute();

    if($checkEmail->rowCount()>0){
        echo '<div class="alert alert-danger" role="alert">
        هذا حساب سابقا مستخدم
      </div>';
    }else{
        $name =$_POST['name'] ;
        $password =$_POST['password'] ;
        $email = $_POST['email'];
        $age = $_POST['age'];

        $addUser = $database->prepare("INSERT INTO users(NAME,AGE,PASSWORD,EMAIL)
         VALUES(:NAME,:AGE,:PASSWORD,:EMAIL)");
        $addUser->bindParam("NAME",$name);
        $addUser->bindParam("AGE",$age);
        $addUser->bindParam("PASSWORD",$password);
        $addUser->bindParam("EMAIL",$email);
        if($addUser->execute()){
            echo '<div class="alert alert-success" role="alert">
            تم إنشاء حساب بنجاح 
          </div>';
          require_once "mail.php";
          $mail->addAddress($email);
          $mail->Subject = "رمز تحقق من بريد الكتروني";
          $mail->Body = '<h1> شكرا لتسجيلك في موقعنا</h1>';
          
          $mail->setFrom("chaawawassim@gmail.com", "Chaawa Wassim");
          $mail->send();
        }else{
            echo '<div class="alert alert-danger" role="alert">
            حدث خطا غير متوقع
          </div>';
        }
       
    }

}
?>