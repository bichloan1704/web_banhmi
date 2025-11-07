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
	<link rel="stylesheet" href="chitietsanpham.css" type="text/css">
	
	<!-- Boxicons -->
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
	<script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- My CSS -->
	<link rel="stylesheet" href="style_qlsp.css">
    <link rel="stylesheet" href="style.css">
	<title>Chi tiết sản phẩm</title>
	<style>
		a:hover{
            text-decoration: none;
        }
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
		<!-- NAVBAR -->
		<section class="product margin-top-30">
        <div class="container ">
            <div class="row details-product padding-bottom-10">
                <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12 product-bottom">
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-lg-6 col-md-6">
                            <div class="relative product-image-block">
                                <div class="slider-big-video clearfix margin-bottom-10">
                                    <div class="slider slider-for slick-initialized slick-slider">
                                        <div aria-live="polite" class="slick-list draggable">
                                            <div class="slick-track" role="listbox" style="opacity: 1; width: 2260px;">
                                                <a href="" class="slick-slide slick-current slick-active" data-slick-index="0" aria-hidden="false" tabindex="-1" role="option" aria-describedby="slick-slide20" rel="lightbox-demo" style="width: 565px; position: relative; left: 0px; top: 0px; z-index: 999; opacity: 1;">
                                                    <?php
                                                    $conn = mysqli_connect("localhost", "root", "", "cakeshop");
                                                    $sql = "SELECT * FROM sanpham WHERE id = " . $_GET['id'];
                                                    $kq = mysqli_query($conn, $sql);
                                                    while ($row = mysqli_fetch_array($kq)) {
														$gia = number_format($row['gia'], 0, ',', '.');
                    									$giamgia = number_format($row['giamgia'], 0, ',', '.');
                                                    ?>
                                                        <img src="images/<?php echo $row['image']; ?> " alt="<?php echo $row['tensanpham']; ?>" class="img-responsive center-block" style="opacity: 1; width:350px" id="big-img">

                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-lg-6 col-md-6 details-pro">
                            <div class="product-top clearfix" style="margin-bottom: 10px;">
                                <h1 class="title-head"><?php echo $row['tensanpham']; ?></h1>
                            </div>
                            <div itemprop="offers" style="border-top: 1px dashed #eaebf3; margin-bottom: 10px; padding-top: 15px;">
                                <div class="price-box clearfix">
                                    <?php
                                                        if ($giamgia > 0) {
                                                            echo '<span class="old-price" style="margin-left: 10px;"><span class="price product-price ">' . $giamgia . 'đ </span></span>';
                                                            echo '<span class="special-price"><del class="price product-price-old webvuaprice" style="font-size: 19px;">' . $gia . 'đ </del></span>';
                                                        } else {
                                                            echo '<span class="old-price" style="margin-left: 10px;"><span class="price product-price ">' . $gia . 'đ </span></span>';
                                                        }
                                    ?>

                                </div>
                                <div style="margin: 10px 0px 15px;"><?php echo $row['mota']; ?>
                                </div>
                                <div style="clear: both;"></div>
                                <div style="margin-bottom: 10px; margin-top: 10px;">

                                </div>

                            </div>
                        
                        <div class="form-product" style="border-top: 1px dashed #eaebf3; padding-top: 20px;">
                            <form enctype="multipart/form-data" id="" action="" method="" class="clearfix form-inline has-validation-callback">
                                <div class="clearfix form-group">
                                    <div class="js-qty-box">
                                        <div class="js-qty-text ">

                                            Số lượng : <?php echo $row['soluong']; ?>
                                        </div>
                                        
                                    
                                    
                                </div>
                            </form>
                        </div>
						<?php } ?>							
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>  
</body>

</html>