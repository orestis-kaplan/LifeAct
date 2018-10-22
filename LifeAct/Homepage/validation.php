<?php
require 'C:\xampp\htdocs\LifeAct\Register\connect.php';
if(isset($_POST['usname'])&&empty($_POST['usname']));{

  $user_name=trim($_POST['usname']);

  $query = mysqli_query($conn,
    "SELECT * FROM users WHERE name = '".$user_name."'"
  );

  if($query){
    $row_count = mysqli_num_rows($query);
    if($row_count!==0){
      echo "$user_name is valid";
    }else{
        echo "$user_name is not valid";
      }
  }else{
    echo 'something went wrong';
  }


}
 ?>
