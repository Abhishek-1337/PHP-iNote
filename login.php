<?php
$login = false;
$showError = false;
  if($_SERVER['REQUEST_METHOD'] == 'POST')
  {
    include 'db_connect.php';
    $username = $_POST['username'];
    $password = $_POST['password'];
    $sql = "SELECT * from users12 where username = '$username'";
    $result = mysqli_query($conn, $sql);
    $num = mysqli_num_rows($result);
    if($num ==1)
    {
        $rows = mysqli_fetch_assoc($result);
        $hash = $rows['password'];
        if(password_verify($password, $hash))
        {
          $login = true;
          session_start();
          $_SESSION['loggedin'] = true;
          $_SESSION['username'] = $username;
          header("location: /cwr/php/Login/12_crud.php");
        }
    }
    else{
    $showError = true;
    }
  }
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Log in</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
  <?php
    require "nav_bar.php";
  ?>
   
  <?php
     if($login)
     {
       echo '<div class="alert alert-success" role="alert">
       <h4 class="alert-heading">Success!</h4>
       <p>You are logged in successfully.</p>
       </div>';
     }
     if($showError)
     {
       echo '<div class="alert alert-danger" role="alert">
       <h4 class="alert-heading">Error!</h4>
       <p> Invalid credentials.</p>
       </div>';
     }
     
  ?>
  <div class="container mt-3">
    <form action="/cwr/php/Login/login.php" method="POST">
      <h1>Login to our website</h1>

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
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"></script>

</body>

</html>