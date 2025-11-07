<?php
@include 'config.php';
session_start();

if (isset($_SESSION['iduser'])) {
    $iduser = $_SESSION['iduser'];
 
    $sqlUser = "SELECT * FROM users WHERE iduser = $iduser";
    $resultUser = mysqli_query($conn, $sqlUser);
 
    if ($resultUser) {
       $userData = mysqli_fetch_assoc($resultUser);
       $ten = $userData['hoten'];
       $email = $userData['email'];
       $sdt = $userData['sdt'];
    }
 } else {
    $ten = '';
    $email = '';
    $sdt = '';
 }
?>
<!DOCTYPE html>
<html lang="vi-VN" data-nhanh.vn-template="T0307">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Cake Shop</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <link href="images/logo1.png" rel="icon" type="image&#x2F;vnd.microsoft.icon">
    <link href="/bizweb.dktcdn.net/100/366/378/themes/736342/assets/plugin.scsscce8.css?1569989874091" rel="stylesheet" type="text/css" />
    <link href="/bizweb.dktcdn.net/100/366/378/themes/736342/assets/evo-main.scsscce8.css?1569989874091" rel="stylesheet" type="text/css" />
    <link href="/cdnjs.cloudflare.com/ajax/libs/font-awesome/5.7.2/css/all.min.css" rel="stylesheet" type="text/css" />
    <link href="/bizweb.dktcdn.net/100/366/378/themes/736342/assets/evo-index.scsscce8.css?1569989874091" rel="stylesheet" type="text/css" />
    <link rel="preload stylesheet" href="https://webvua.com/plugin/style-themes-contact.css?v=102" as="style">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha512-SfTiTlX6kk+qitfevl/7LibUOeJWlt9rbyDn92a1DqWOw9vWG2MFoays0sgObmWazO5BQPiFucnnEAjpAB+/Sw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style type="text/css"></style>
    <style>
        .contact-form .input-group {
            margin-bottom: 10px;
        }

        .contact-form .input-group label {
            margin-bottom: 1px;
        }

        .mb-10 {
            margin-bottom: 10px
        }

        .box-info-contact,
        .box-send-contact {
            border: 1px solid #dddddd;
        }

        .box-info-contact li div {
            width: calc(100% - 35px);
            float: left;
            padding-left: 15px;
            margin-bottom: 5px;
            color: #696969;
            font-weight: 500;
        }

        #lienhe:before {
            background: #3b3b3b;
        }

        @media screen and (min-width: 860px) {
            #mapembeb {
                height: 593px
            }
        }

        @media screen and (max-width: 859px) {
            #mapembeb {
                height: 393px
            }
        }

        .box-info-contact li div strong {
            color: #000000;
        }

        .box-info-contact li div a {
            color: #696969;
        }

        .w-100 {
            width: 100%;
        }

        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            /* Màu nền mờ */
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 99999999999;
            display: none;
        }

        .loader {
            border: 16px solid #f3f3f3;
            /* Màu đường viền của loader */
            border-top: 16px solid #3498db;
            /* Màu đường viền của loader khi quay */
            border-radius: 50%;
            width: 120px;
            height: 120px;
            position: absolute;
            animation: spin 2s linear infinite;
            /* Animation quay */
            margin: 0 auto;
            left: 50%;
            top: 50%;
            margin-left: -60px;
            margin-top: -60px;
        }

        .lh {
            font-size: 13px;
            color: grey;
        }
    </style>
    <script src="https://web.nvnstatic.net/js/translate/vi-vn.js" defer></script>
</head>

<body id="lama-theme" class="tp_background tp_text_color">
    <?php include 'header.php'; ?>

    <div class="bread-crumb text-center bread-crumb_background" style=" background-image: url('https://pos.nvncdn.net/16a837-71503/bn/20220325_5UxI8S76E0NIJxh0znPFxEOw.png');">
        <h3>Liên hệ</h3>
        <ul class="breadcrumb&#x20;breadcrumb-arrow">
            <li><a href="index.php">Trang chủ</a></li>
            <li><a class="564206" href="sanpham.php">Liên hệ</a></li>
        </ul>
    </div>
    <div class="layout-pageContact">

        <div class="wrapper-bodycontact">
            <div class="wrapbox-content-contact">
                <div class="container pd-top">
                    <div class="row widthContent">
                        <div class="col-lg-6 col-md-6 col-12 wrapbox-content-left">
                            <div class="box-info-contact">
                                <div class="wrapbox-contact">
                                    <ul class="row w-100">
                                        <li class="col-md-12 col-xs-12">
                                            <span><i class="fa fa-map-marker"></i></span>
                                            <div><strong class=''>
                                                    Địa chỉ</strong><br><span class=''>
                                                    470 Trần Đại Nghĩa, Đà Nẵng</span></div>
                                        </li>
                                    </ul>
                                    <ul class="row w-100">
                                        <li class="col-md-6 col-xs-12">
                                            <span><i class="fa fa-phone"></i></span>
                                            <div><a class="cta-clicktocall" href="tel:09xxxxxxxx" rel="noopener"><strong class=''>Điện thoại</strong><br>
                                                    <span class=''>0123456789</span></a>
                                            </div>
                                        </li>
                                        <li class="col-md-6 col-xs-12">
                                            <span><i class="fa fa-envelope-o"></i></span>
                                            <div><strong class=''>Email</strong><br>
                                                <span class=''>cakeshop123@gmail.com</span>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="box-send-contact">
                                <form action="xulyienhe.php" method="post" id="formcontact">
                                    <input type="hidden" id="txtidprocontact" name="txtidprocontact" value="">
                                    <h2 class=''>Gửi thắc mắc cho chúng tôi</h2>
                                    <div class=''>Nếu bạn có thắc mắc gì, có thể gửi yêu cầu cho chúng tôi, và chúng tôi sẽ liên lạc lại với bạn sớm nhất có thể.</div>
                                    <p></p>
                                    <div class="alert alert-danger w-100" id="errormes" style="display:none">
                                        <span>Bạn đã gửi tin nhắn thành công</span>
                                    </div>
                                    <div id="col-left contactFormWrapper">
                                        <div class="contact-form">
                                            <div class="row">
                                                <div class="col-sm-12 col-xs-12">
                                                    <div class="input-group">
                                                        <label for="" class="">Tên của bạn</label>
                                                        <input required="" type="text" name="ten" class="form-control mg-0" placeholder="Nhập tên của bạn" value="<?php echo $ten; ?>" aria-describedby="basic-addon1">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-xs-12 capep">
                                                    <div class="input-group">
                                                        <label for="" class="">Email của bạn</label>
                                                        <input type="text" name="email" class="form-control mg-0" placeholder="Nhập email của bạn" value="<?php echo $email; ?>" aria-describedby="basic-addon1">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-xs-12 capep">
                                                    <div class="input-group">
                                                        <label for="" class="">Số điện thoại của bạn</label>
                                                        <input pattern="[0-9]{10,12}" required="" type="text" name="sdt" class="form-control mg-0" placeholder="Nhập số điện thoại của bạn" value="<?php echo $sdt; ?>" aria-describedby="basic-addon1">
                                                    </div>
                                                </div>
                                                <div style="clear:both"></div>
                                                <style>
                                                    .capd12 {
                                                        width: 100% !important;
                                                    }
                                                </style>
                                                <div style="clear:both"></div>
                                                <div class="col-sm-12 col-xs-12">
                                                    <div class="input-group">
                                                        <label for="" class="">Nội dung</label>
                                                        <textarea name="noidung" placeholder="Nhập nội dung" class='mg-0'></textarea>
                                                    </div>
                                                </div>

                                                <div class="col-sm-12 col-xs-12 ">
                                                    <!-- <button type='button' onclick="sendContactWebvua(); return false" name="lienhe" id="lienhe" class="button dark cta-submitform">GỬI CHO CHÚNG TÔI</button> -->
                                                    <input type="submit" type='button' onclick="sendContactWebvua(); return false" name="lienhe" id="lienhe" class="button dark cta-submitform">
                                                </div>
                                            </div>
                                        </div>
                                        <input id="9776ccad23f5492b885a285cc75ef736" name="g-recaptcha-response" type="hidden" value="03AAYGu2Qg3M2UlACMOktKTVq1VOzuna2SM6LNY2V1giMLcaVOY6pdFujfx9t9iyxNiOAxnM0idjr_fSUBBLIQly5ap2oDpSpsAREi5N_vp_vcWUqroNSwO2XvQcs9DosGNWEC1LpjNOev8EVD6_WAkl7zeavBLVD8f_B5rnWUXYmAfDL1PHJ8mvZGCi6pig8_GTEu3Mkh9vbxa0KoGasu54Of0S4P8rlo1YsZK81zZHy9d8lU2ghWpzNsJ2CtnajC5Q89D3CtfAndfcO1qda-oGNs1zp8wTq5ihA_uRJGhRFeH7oKSPBte5xyHhvy7_XibQYbI7osRAZblwbQbBPNUy34q9NzFHvSjMTZ2EJ22yNTa_nLmks9U02dAFlvrYynnFkzvEW6L0OT1Vuenn1IK8HrqB1wSCS63dMpvQAsNgFEid_-TxD_j5AZqM9c1V0SX4VCIkJqROQwv31ZHIpK7hG1nha4dPxlfOL0H-bs1ecCZAxUBOkXcBHOUuJUDslwX_yxoqZ8B66EX-x7P6KVEpXI8QS_Z2bf4pHUFGmoReim33WVcjD6bwA">
                                        <script src="https://www.google.com/recaptcha/api.js?render=6LdD18MUAAAAAHqKl3Avv8W-tREL6LangePxQLM-"></script>
                                        <script>
                                            grecaptcha.ready(function() {
                                                grecaptcha.execute('6LdD18MUAAAAAHqKl3Avv8W-tREL6LangePxQLM-', {
                                                    action: 'submit'
                                                }).then(function(token) {
                                                    document.getElementById('9776ccad23f5492b885a285cc75ef736').value = token;
                                                });
                                            });
                                        </script>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-12 wrapbox-content-right">
                            <div class="box-map-contact ">
                                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3835.7332975516097!2d108.24978007468239!3d15.975298241946591!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3142108997dc971f%3A0x1295cb3d313469c9!2zVHLGsOG7nW5nIMSQ4bqhaSBo4buNYyBDw7RuZyBuZ2jhu4cgVGjDtG5nIHRpbiB2w6AgVHJ1eeG7gW4gdGjDtG5nIFZp4buHdCAtIEjDoG4!5e0!3m2!1svi!2s!4v1697387399690!5m2!1svi!2s" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include 'footer.php'; ?>
 
</body>

</html>