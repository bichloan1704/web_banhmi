<?php 
    session_start();
    
?> 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xử lí liên hệ </title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>


    
        <?php
        if (isset($_SESSION['iduser'])) {
            $iduser = $_SESSION['iduser'];
        }
            $ten = $_POST['ten'];
            $email = $_POST['email'];
            $sdt = $_POST['sdt'];
            $noidung = $_POST['noidung'];

            $conn = mysqli_connect("localhost", "root","","cakeshop");

            $sql = "INSERT INTO phanhoi(ten,email, sdt, noidung, iduser) VALUES ('$ten','$email', '$sdt','$noidung', '$iduser')";
            $kq = mysqli_query($conn, $sql);
            header("Location: index.php");
        ?>      
</body>
</html>