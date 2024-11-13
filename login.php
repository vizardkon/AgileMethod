<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../components/connect.php';


if(isset($_POST['submit'])){
    $email = $_POST['email'];
    $password = $_POST['password'];

    $select_tutor = $conn->prepare("SELECT * FROM `tutors` WHERE email = ? AND password = ?");
    $select_tutor->execute([$email, $password]);
    $result = $select_tutor->fetch(PDO::FETCH_ASSOC);

    if($select_tutor->rowCount() > 0){
        setcookie('tutor_id', $result['id'], time() + 60*60*24*30, '/');
        header('location:dashboard.php');
        exit();
    }else{
        $message[] = 'incorrect email or password!';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Login Guru</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<section class="form-container">
   <form action="" method="post" enctype="multipart/form-data" class="login">
      <h3>Welcome Back!</h3>
      <?php
      if(isset($message)){
         foreach($message as $message){
            echo '<div class="message">'.$message.'</div>';
         }
      }
      ?>
      <p>your email <span>*</span></p>
      <input type="email" name="email" placeholder="enter your email" maxlength="50" required class="box">
      <p>your password <span>*</span></p>
      <input type="password" name="password" placeholder="enter your password" maxlength="20" required class="box">
      <input type="submit" name="submit" value="login now" class="btn">
   </form>
</section>

<!-- custom js file link  -->
<script src="../js/script.js"></script>

</body>
</html>
