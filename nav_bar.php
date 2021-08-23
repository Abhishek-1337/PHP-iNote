<?php
if(isset($_SESSION['username']) && $_SESSION['loggedin']==true)
{
  $loggedin = true;
}
else{
  $loggedin = false;
}
echo '<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">3
      <a class="navbar-brand" href="#">iNote</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
           <a class="nav-link active" aria-current="page" href="/cwr/php/Login/12_crud.php">Home</a>
         </li>';
        if($loggedin)
        {
          echo '
          <li class="nav-item">
            <a class="nav-link active" href="/cwr/php/Login/logout.php" tabindex="-1" aria-disabled="true">Logout</a>
          </li>';

        }
        else{

          echo '<li class="nav-item">
            <a class="nav-link active" href="/cwr/php/Login/login.php">Login</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="/cwr/php/Login/sign_up.php">Signup</a>
          </li>';
        }
        echo '</ul>
        <form class="d-flex">
          <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
          <button class="btn btn-outline-success" type="submit">Search</button>
        </form>
      </div>
    </div>
</nav>';
?>