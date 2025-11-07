<?php
@include 'config.php';
// session_start();

?>



<!DOCTYPE html>
<html lang="vi-VN" data-nhanh.vn-template="T0307">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Cake Shop</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta property="og&#x3A;title" content="Th&#x1EF1;c&#x20;ph&#x1EA9;m&#x20;s&#x1EA1;ch&#x20;Nhanh.vn">
    <meta property="og&#x3A;url" content="http&#x3A;&#x2F;&#x2F;t0307.store.nhanh.vn">
    <meta property="og&#x3A;image" content="https&#x3A;&#x2F;&#x2F;pos.nvncdn.net&#x2F;16a837-71503&#x2F;store&#x2F;20200325_7rMt2KlqTHJrITcloxlSka0u.png">
    <meta name="google-site-verification" content="">
    <link href="images/logo1.png" rel="icon" type="image&#x2F;vnd.microsoft.icon">
    <link rel="preload" href="https://web.nvnstatic.net/tp/T0307/font/Quicksand-VariableFont_wght.ttf" as="font" type="font/ttf" crossorigin>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://web.nvnstatic.net/css/fontAwesome/font-awesome-4.7.0.min.css?v=23" type="text/css">
    <link rel="stylesheet" href="https://web.nvnstatic.net/js/jquery/fancybox-2.1.5/source/jquery.fancybox.css?v=23" type="text/css">
    <link rel="stylesheet" href="https://web.nvnstatic.net/css/font.css?v=23" type="text/css">
    <link rel="stylesheet" href="https://web.nvnstatic.net/js/mmenu/css/jquery.mmenu.css?v=23" type="text/css">
    <link rel="stylesheet" href="https://web.nvnstatic.net/css/jqueryUI/jqui.css?v=23" type="text/css">
    <link rel="stylesheet" href="https://web.nvnstatic.net/css/owlCarousel/owl.carousel.min.2.3.4.css?v=23" type="text/css">
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <link rel="stylesheet" href="css/card.css" type="text/css">
    <script defer type="text/javascript" src="https://web.nvnstatic.net/js/jquery/jquery.min.js?v=30"></script>
    <script defer type="text/javascript" src="https://web.nvnstatic.net/js/jquery/jquery.cookie.js?v=30"></script>
    <script defer type="text/javascript" src="https://web.nvnstatic.net/js/bootstrap/boostrap.popper.min.js?v=30"></script>
    <script defer type="text/javascript" src="https://web.nvnstatic.net/js/jquery/jquery-ui-1.10.3.custom.min.js?v=30"></script>
    <script defer type="text/javascript" src="https://web.nvnstatic.net/js/bootstrap/bootstrap.4.3.1.min.js?v=30"></script>
    <script defer type="text/javascript" src="https://web.nvnstatic.net/js/jquery/jquery.number.min.js?v=30"></script>
    <script defer type="text/javascript" src="https://web.nvnstatic.net/js/owlCarousel/owl.carousel.min.js?v=30"></script>
    <script defer type="text/javascript" src="https://web.nvnstatic.net/js/mmenu/js/jquery.mmenu.min.js?v=30"></script>
    <script defer type="text/javascript" src="https://web.nvnstatic.net/js/lib.js?v=30"></script>
    <script defer type="text/javascript" src="https://web.nvnstatic.net/tp/T0307/js/main.js?v=32"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style type="text/css"></style>
    <style type="text/css">
        img {
            max-width: 100%;
        }

        img.lazyload {
            opacity: 0.001;
            object-fit: scale-down !important;
        }

        .fb-customerchat>span>iframe.fb_customer_chat_bounce_out_v2 {
            max-height: 0 !important;
        }

        .fb-customerchat>span>iframe.fb_customer_chat_bounce_in_v2 {
            max-height: calc(100% - 80px) !important;
        }
    </style>
    <style>
        figure.image {
            clear: both;
            display: table;
            margin: .9em auto;
            min-width: 50px;
            text-align: center;
        }

        figure.image img {
            display: block;
            margin: 0 auto;
            max-width: 100%;
            min-width: 100%;
        }

        figure.image>figcaption {
            background-color: #f7f7f7;
            caption-side: bottom;
            color: #333;
            display: table-caption;
            font-size: .75em;
            outline-offset: -1px;
            padding: .6em;
            word-break: break-word;
        }
    </style>
    <script src="https://web.nvnstatic.net/js/translate/vi-vn.js" defer></script>
</head>

<body id="lama-theme" class="tp_background tp_text_color">
    <div id="content">
        <div id="menu">
            <ul>
                <li class="selected text-center"><a href=""><img src="images/logo1.png" alt="Logo"></a></li>
                <li class="mobile_child">
                    <a href="/" title="Trang chủ" class=" current">
                        Trang chủ
                    </a>
                </li>
                <li class="mobile_child">
                    <a href="sanpham.php" title="Sản phẩm" class="current">
                        Sản phẩm
                    </a>
                    <?php
                    $conn = mysqli_connect("localhost", "root", "", "cakeshop");
                    $sql = "SELECT * FROM danhmuc";
                    $kq = mysqli_query($conn, $sql);
                    $categories = array();
                    while ($row = mysqli_fetch_array($kq)) {
                        $iddanhmuc = $row["id"];
                        $tendanhmuc = $row['tendanhmuc'];
                        $categories[] = array('id' => $iddanhmuc, 'name' => $tendanhmuc);
                    }
                    ?>
                    <ul class="mobile_lvlup lv2" role="menu">
                        <?php
                        foreach ($categories as $category) {
                        ?>
                            <li><a href="sanpham.php?iddanhmuc=<?php echo $category['id']; ?>" class="current" title="Bánh Mì"> <?php echo $category['name']; ?></a></li>
                        <?php } ?>
                    </ul>
                </li>
                <li class="mobile_child">
                    <a href="tintuc.php" title="Tin tức" class=" current">
                        Tin tức
                    </a>
                </li>
                <li class="mobile_child">
                    <a href="lienhe.php" title="Liên hệ" class=" current">
                        Liên hệ
                    </a>
                </li>

            </ul>
        </div>
        <header class="tp_header">
            <div class="header-content">
                <div class="d-flex d-lg-none flex-wrap header_mobile">
                    <div class="click_menu col-3">
                        <a href="#menu"><span><i class="fa fa-bars" aria-hidden="true"></i></span></a>
                    </div>
                    <div class="col-9 right_">
                        <div class="logo_small col-6">
                            <a href="">
                                <img src="images/logo1.png" alt="Logo">
                            </a>
                        </div>
                        <div class="item_mobile col-6">
                            <div class="lare-icon">
                                <div class="cart-bag">
                                    <div style="position: relative;" onclick="window.location.href='cart.php';">
                                        <i class="fa fa-shopping-bag" aria-hidden="true"></i>
                                        <?php
                                        if (isset($_SESSION['iduser'])) {
                                            $iduser = $_SESSION['iduser'];
                                            // $role = $_SESSION['role'];
                                            $select_rows = mysqli_query($conn, "SELECT * FROM cart where iduser= $iduser ") or die('query failed');
                                            $row_count = mysqli_num_rows($select_rows);
                                        } else {
                                            $select_rows = 0;
                                            $row_count = 0;
                                        }
                                        ?>
                                        <span class="cout_cart"><?php echo $row_count; ?></span>
                                    </div>
                                </div>
                                <div class="user">
                                    <i class="fa fa-user-plus" aria-hidden="true"></i>
                                    <div class="groupc">
                                        <?php
                                        session_start();
                                        @include 'config.php';
                                        $hoten = "";

                                        if (!isset($_SESSION['iduser'])) {
                                        ?>
                                            <a class="button_gradient" href="dangnhap.php">Đăng nhập</a>
                                            <a class="dk" href="dangky.php">Đăng ký</a>
                                            <?php
                                        } else {
                                            $conn = mysqli_connect("localhost", "root", "", "cakeshop");
                                            $sql = "SELECT hoten, role FROM users WHERE iduser = '{$_SESSION['iduser']}'";
                                            $result = mysqli_query($conn, $sql);

                                            if ($result) {
                                                $row = mysqli_fetch_assoc($result);
                                                $hoten = $row['hoten'];
                                                $role = $row['role'];

                                                if ($role === 'thanhvien') {
                                            ?>
                                                    <a class="button_gradient" href="profile.php"><i class="fa fa-user" aria-hidden="true"></i> <?php echo $hoten ?></a>
                                                    <a href="dangxuat.php"><i class="fa fa-sign-in" aria-hidden="true"></i> Đăng xuất </a>
                                                <?php
                                                } else if ($role === 'admin') {
                                                ?>
                                                    <a class="button_gradient" href="dangnhap.php">Đăng nhập</a>
                                                    <a class="dk" href="dangky.php">Đăng ký</a>
                                        <?php
                                                }
                                            }
                                        }
                                        ?>

                                    </div>


                                </div>
                                <div class="seach"><i class="fa fa-search" aria-hidden="true"></i>
                                    <div class="searchmini">
                                        <form action="/search" method="get" class="form-group search-bar" role="search">
                                            <input type="text" name="q" placeholder="Tìm kiếm..." class="button_gradient form-control auto-search ">
                                            <button type="submit" class=" btn icon-fallback-text">
                                                <span class="fa fa-search"></span>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container top-header d-none d-lg-flex flex-wrap">
                    <div class="col-md-2 lare-logo">
                        <a href="" class="d-inline-block">
                            <img src="images/logo1.png" alt="Logo">
                        </a>
                    </div>
                    <div class="col-md-8 menu-item">
                        <ul class="nav nav-pills header_menu tp_menu">
                            <li class="tp_menu_item"><a class="tp_menu_item" href="index.php" title="Trang chủ">Trang chủ </a></li>
                            <li class="tp_menu_item">
                                <a class="tp_menu_item" href="sanpham.php" title="Sản phẩm">Sản phẩm
                                    <span class="caret"></span>
                                </a>
                                <?php
                                $conn = mysqli_connect("localhost", "root", "", "cakeshop");
                                $sql = "SELECT * FROM danhmuc";
                                $kq = mysqli_query($conn, $sql);
                                $categories = array();
                                while ($row = mysqli_fetch_array($kq)) {
                                    $iddanhmuc = $row["id"];
                                    $tendanhmuc = $row['tendanhmuc'];
                                    $categories[] = array('id' => $iddanhmuc, 'name' => $tendanhmuc);
                                }
                                ?>
                                <ul class="list_sp tp_menu">
                                    <?php
                                    foreach ($categories as $category) {
                                    ?>
                                        <li class="dropdown-submenu clearfix tp_menu_item">
                                            <a class="lv2 tp_menu_item" href="sanpham.php?iddanhmuc=<?php echo $category['id']; ?>"><?php echo $category['name']; ?>
                                            </a>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </li>

                            <li class="tp_menu_item"><a class="tp_menu_item" href="tintuc.php" title="Tin tức">Tin tức </a></li>
                            <li class="tp_menu_item"><a class="tp_menu_item" href="lienhe.php" title="Liên hệ">Liên hệ </a></li>
                        </ul>
                    </div>
                    <div class="lare-icon col-md-2">
                        <div class="cart-bag">
                            <div style="position: relative;" onclick="window.location.href='cart.php';">
                                <i class="fa fa-shopping-bag" aria-hidden="true"></i>
                                <?php
                                if (isset($_SESSION['iduser'])) {
                                    $iduser = $_SESSION['iduser'];
                                    $role = 'thanhvien';  

                                    $select_rows = mysqli_query($conn, "SELECT * FROM cart INNER JOIN users ON cart.iduser = users.iduser WHERE cart.iduser = $iduser AND users.role = '$role'") or die('query failed');
                                    $row_count = mysqli_num_rows($select_rows);
                                } else {
                                    $select_rows = 0;
                                    $row_count = 0;
                                }
                                ?>

                                <span class="cout_cart"><?php echo $row_count; ?></span>
                            </div>
                            <div class="top-cart-content">
                                <div class="header-minicart">
                                    <?php
                                    if (isset($_SESSION['row_count']) && $_SESSION['row_count'] == 0) {
                                        echo '<p class="text-center">Giỏ hàng không có sản phẩm !</p>';
                                    } else {
                                        echo '<p class="text-center">Giỏ hàng có ' . $row_count . ' sản phẩm !</p>';
                                    }
                                    ?>

                                </div>
                            </div>
                        </div>
                        <div class="user">
                            <i class="fa fa-user-plus" aria-hidden="true"></i>
                            <div class="groupc">
                                <?php

                                $hoten = "";

                                if (!isset($_SESSION['iduser'])) {
                                ?>
                                    <a class="button_gradient" href="dangnhap.php">Đăng nhập</a>
                                    <a class="dk" href="dangky.php">Đăng ký</a>
                                    <?php
                                } else {
                                    $conn = mysqli_connect("localhost", "root", "", "cakeshop");
                                    $sql = "SELECT hoten, role FROM users WHERE iduser = '{$_SESSION['iduser']}'";
                                    $result = mysqli_query($conn, $sql);

                                    if ($result) {
                                        $row = mysqli_fetch_assoc($result);
                                        $hoten = $row['hoten'];
                                        $role = $row['role'];

                                        if ($role === 'thanhvien') {
                                    ?>
                                            <a class="button_gradient" href="profile.php"><i class="fa fa-user" aria-hidden="true"></i> <?php echo $hoten ?></a>
                                            <a href="dangxuat.php"><i class="fa fa-sign-in" aria-hidden="true"></i> Đăng xuất </a>
                                        <?php
                                        } else if ($role === 'admin') {
                                        ?>
                                            <a class="button_gradient" href="dangnhap.php">Đăng nhập</a>
                                            <a class="dk" href="dangky.php">Đăng ký</a>
                                <?php
                                        }
                                    }
                                }
                                ?>
                            </div>

                        </div>
                        <div class="seach">
                            <div class="searchmini">
                                <form id="search-form" role="search">
                                    <div class="form-input">
                                        <input type="text" id="key-search" name="key-search" placeholder="Tìm kiếm..." class="button_gradient form-control auto-search ">
                                        <button type="submit" class="search-btn">
                                            <span class="fa fa-search"></span>
                                        </button>
                                    </div>
                                </form>
                            </div>
                            <div id="search-results">
                            </div>
                        </div>
                    </div>
                </div>
        </header>
</body>

</html>