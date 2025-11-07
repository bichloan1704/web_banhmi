<?php
session_start();
@include 'config.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="logo1.png" rel="icon" type="image&#x2F;vnd.microsoft.icon">
    <link rel="stylesheet" href="../css/style.css" type="text/css">
    <link rel="stylesheet" href="../css/card.css" type="text/css">
    <!-- Boxicons -->
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- My CSS -->
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="style_qlsp.css">
    <title>Quản lý bán bánh</title>
    <style>
        
    </style>
</head>

<body>

<?php include('sidebar.php') ?>


    <!-- CONTENT -->
    <section id="content">
        <!-- NAVBAR -->
        <nav>
            <i class='bx bx-menu'></i>
            <a href="#" class="nav-link">Categories</a>

            <input type="checkbox" id="switch-mode" hidden>
            <label for="switch-mode" class="switch-mode"></label>
            <a href="#" class="notification">
                <i class='bx bxs-bell'></i>
                <span class="num">8</span>
            </a>
            <a href="#" class="profile">
                <img src="logo1.png">
            </a>
        </nav>
        <h2 style="text-align: center;padding: 10px; font-weight: bold;">Doanh thu</h2>
        
        <button type="button" id="myBtn" onclick="myFunction()">Change the height of this button</button>

<script>
  var isTall = false;

  function myFunction() {
    var button = document.getElementById("myBtn");

    // Toggle the height based on the current state
    if (isTall) {
      button.style.height = "50px"; // Change to the desired short height
    } else {
      button.style.height = "100px"; // Change to the desired tall height
    }

    // Update the state for the next click
    isTall = !isTall;
  }
</script>


</body>

</html>