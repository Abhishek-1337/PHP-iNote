<?php
$showSuccess = false;
$showError="";
  if($_SERVER['REQUEST_METHOD'] == 'POST')
  {
    include 'db_connect.php';
    $username = $_POST['username'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];
    $existSql = "SELECT * FROM `users12` WHERE `username` ='$username' ";
    $resultCheck = mysqli_query($conn, $existSql);
    $numRows = mysqli_num_rows($resultCheck);
    if($numRows > 0)
    {
        $showError = "Username already exist";
    }
    else
    {
        if($password == $cpassword)
        {
          $hash = password_hash($password, PASSWORD_DEFAULT);
          $sql = "INSERT INTO `users12` (`username`, `password`, `dt`) VALUES ('$username', '$hash',current_timestamp())";
          $result = mysqli_query($conn, $sql);
          if($result)
          {
            $showSuccess = true;
          }
         
        }
        else{
          $showError = "Password do not match";
        }
    }

  }
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign Up</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
  <?php
    require "nav_bar.php";
  ?>
  <?php
     if($showSuccess)
     {
       echo '<div class="alert alert-success" role="alert">
       <h4 class="alert-heading">Success!</h4>
       <p>Your account is created Successfully.</p>
       </div>';
     }
     
     if($showError)
     {
       echo '<div class="alert alert-danger" role="alert">
       <h4 class="alert-heading">Error!</h4>
       <p>'.$showError.'.</p>
       </div>';
     }
  ?>
  <div class="container mt-3">
    <form action="/cwr/php/Login/sign_up.php" method="POST">
      <h1>Sign up to our website</h1>

      <div class="form-group">
        <label for="username" class="form-label">Name</label>
        <input type="text" name="username" class="form-control" id="username">
      </div>
      <!-- <div class="form-group">
        <label for="email" class="form-label">Email address</label>
        <input type="email" class="form-control" name="email" id="email" aria-describedby="emailHelp">
        <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
      </div> -->
      <br>
      <div class="form-group">
        <label for="password">Password</label>
        <input type="text" name="password" class="form-control" id="password">
      </div>

      <br>
      <div class="form-group">
        <label for="cpassword">Confirm password</label>
        <input type="text" name="cpassword" class="form-control" id="cpassword">
      </div>
      <br>
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"></script>

</body>

</html>