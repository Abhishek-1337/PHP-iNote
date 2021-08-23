<?php

session_start();
if(!isset($_SESSION['username']) && $_SESSION['loggedin'] != true)
{
  header("location: /cwr/php/Login/login.php");
  exit;
}

$delete = false;
$insert = false;
$update = false;

include 'db_connect.php';


if(isset($_GET['delete']))
{
  $sno = $_GET['delete'];
  $sql = "DELETE FROM `notes` WHERE `sno` = $sno";
  mysqli_query($conn,$sql);
  $delete = true;
  // echo "deleted";
}
else if(isset($_POST['submitForm']))
 {

   $title = $_POST['title'];
   $desc = $_POST['desc'];

   $sql = "INSERT INTO `notes` ( `title`, `description`) VALUES ( '$title', '$desc')";
   $result = mysqli_query($conn,$sql);

   if(!$result)
   {
     echo "Note is not submitted. There is an error";
   }
   else{

    $insert = true;
   }

 }
 else if(isset($_POST['update']))
 {
   $titleNew = $_POST['titleEdit'];
   $descNew = $_POST['descEdit'];
   $snoNew = $_POST['snoEdit'];

   $sql = "UPDATE `notes` SET `title` = '$titleNew', `description` = '$descNew', `time` = CURRENT_TIME() WHERE `notes`.`sno` = $snoNew ";
   $result = mysqli_query($conn, $sql);

   if($result)
   {
     $update = true;
   }

   if(!$result)
   {
     echo "Note is not submitted. There is an error";
   }
 }

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">

</head>

<body>


  <!-- Button trigger modal -->
  <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
    Launch demo modal
  </button> -->

  <!-- Modal -->
  <div class="modal fade edit" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editModalLabel">Edit this note</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="/cwr/12_crud.php" method="POST">
            <h1>Add a Note</h1>
            <input type="hidden" name="snoEdit" id="snoEdit">

            <div class="form-group">
              <label for="text" class="form-label">Note title</label>
              <input type="text" class="form-control" name="titleEdit" id="titleEdit">
            </div>
            <br>
            <div class="form-group">
              <label for="desc">Note Description</label>
              <textarea name="descEdit" class="form-control" id="descEdit" rows="3"></textarea>
            </div>
            <br>

            <!-- <button type="submit" name="update" class="btn btn-primary">Update Note</button> -->
        </div>
        <div class="modal-footer d-block mr-auto">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" name="update">Save changes</button>
        </div>
        </form>
      </div>
    </div>
  </div>
  <?php
    require 'nav_bar.php';
  ?>
  <?php
    

    if($delete)
    {
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
        <strong>Success!</strong> Your note has been deleted successfully
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
          ×
        </button>
      </div>";

    }

    if($insert)
    {
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
        <strong>Success!</strong> Your note has been inserted successfully
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
          <span aria-hidden='true'>×</span>
        </button>
      </div>";
    }

    if($update)
    {

        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
        <strong>Success!</strong> Your note has been updated successfully
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
          <span aria-hidden='true'>×</span>
        </button>
      </div>";
    }
  ?>

  <div class="container mt-3">
    <form action="/cwr/php/Login/12_crud.php" method="POST">
      <h1>Add a Note</h1>

      <div class="form-group">
        <label for="text" class="form-label">Note title</label>
        <input type="text" class="form-control" name="title" id="title">
      </div>
      <br>
      <div class="form-group">
        <label for="desc">Note Description</label>
        <textarea name="desc" class="form-control" id="desc" cols="50" rows="10"></textarea>
      </div>
      <br>

      <button type="submit" name="submitForm" class="btn btn-primary">Submit</button>
    </form>
    <br>
  </div>

  <div class="container mt-3 my-4">

    <table class="table" id="myTable">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Title</th>
          <th scope="col">Description</th>
          <th scope="col">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php

        $sql1 = "SELECT * FROM `notes`" ;
        $result2 = mysqli_query($conn, $sql1);
        $sno = 0;
        while($rows = mysqli_fetch_assoc($result2))
        {
          $sno = $sno+1;
          // echo "<br>".$rows['sno'].". Title ".$rows['title']." Description ".$rows['description'];
          echo  "<tr>
          <th scope='row'>".$sno."</th>
          <td>".$rows['title']."</td>
          <td>".$rows['description']."</td>
          <td><button class='edit btn btn-sm btn-primary' id='".$rows['sno']."'>Edit</button>     <button class='delete btn btn-sm btn-primary' id='d".$rows['sno']."'>Delete</button></td>
        </tr>";
        }
    ?>
      </tbody>
    </table>


  </div>
  <hr>

  <!-- Javascript-->
  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
    integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
    crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
    integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
    crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
    integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
    crossorigin="anonymous"></script>
  <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
  <script>
    $(document).ready(function () {
      $('#myTable').DataTable();
    });
  </script>
  <script>
    edits = document.getElementsByClassName('edit');
    Array.from(edits).forEach((element) => {
      element.addEventListener("click", (e) => {
        console.log("edit ", e.target.parentNode.parentNode);
        tr = e.target.parentNode.parentNode;
        title = tr.getElementsByTagName("td")[0].innerText;
        description = tr.getElementsByTagName("td")[1].innerText;
        console.log(title, description);
        titleEdit.value = title;
        descEdit.value = description;
        snoEdit.value = e.target.id;
        $('#editModal').modal('toggle');
      })
    })

    deletes = document.getElementsByClassName('delete');
    Array.from(deletes).forEach((element) => {
      element.addEventListener("click", (e) => {
        console.log("edit ", e.target.parentNode.parentNode);

        sno = e.target.id.substr(1,);

        if (confirm("Are you sure you want to delete this note?")) {
          console.log("Yes");
          window.location = `/cwr/php/Login/12_crud.php?delete=${sno}`;
        }
        else {
          console.log("No");
        }


      })
    })
  </script>


</body>

</html>