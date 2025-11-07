<?php
session_start();
@include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    $idsp = isset($_POST['idsp']) ? $_POST['idsp'] : '';
    $tensanpham = isset($_POST['tensanpham']) ? $_POST['tensanpham'] : '';
    $gia = isset($_POST['gia']) ? $_POST['gia'] : '';
    $giamgia = isset($_POST['giamgia']) ? $_POST['giamgia'] : '';
    $image = isset($_POST['image']) ? $_POST['image'] : '';
    $soluong = isset($_POST['soluong']) ? $_POST['soluong'] : '';

    $total_price = $giamgia > 0 ? $giamgia * $soluong : $gia * $soluong;
    $thanhtien = number_format($total_price, 3, ',', '.');
    if (isset($_SESSION['iduser'])) {
        $iduser = $_SESSION['iduser'];
        $select_cart = mysqli_query($conn, "SELECT * FROM cart WHERE tensanpham = '$tensanpham' AND iduser = '$iduser'");
        if (mysqli_num_rows($select_cart) > 0) {
            echo '<script>alert("Sản phẩm đã tồn tại trong giỏ hàng");</script>';
        } else {
            $insert_product = mysqli_query($conn, "INSERT INTO cart(tensanpham, gia, giamgia, soluong, thanhtien, image, idsp, iduser) VALUES('$tensanpham', '$gia', '$giamgia', '$soluong','$thanhtien', '$image', '$idsp', '$iduser')");
            if ($insert_product) {
                echo '<script>alert("Thêm sản phẩm vào giỏ hàng thành công");</script>';
            } else {
                echo '<script>alert("Error: ' . mysqli_error($conn) . '");</script>';
            }
        }
    } else {
        echo '<script>alert("Vui lòng đăng nhập để thêm sản phẩm vào giỏ hàng");</script>';
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_comment'])) {

    $idsp = $_POST['idsp'];
    $noidung = $_POST['noidung'];

    if (isset($_SESSION['iduser'])) {
        $iduser = $_SESSION['iduser'];

        $insert_comment = mysqli_query($conn, "INSERT INTO binhluan ( noidung, thoigian, iduser, idsp) VALUES ( '$noidung', NOW(), '$iduser', '$idsp')");

        if ($insert_comment) {
            $message[] = 'Thêm bình luận thành công.';
        } else {
            $message[] = 'Lỗi: ' . mysqli_error($conn);
        }
    } else {
        echo '<script>alert("Vui lòng đăng nhập để thêm bình luận");</script>';
    }

    header('Location: chitietsanpham.php?id=' . $idsp);
    exit();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_comment'])) {
    $idsp = $_POST['idsp'];
    if (isset($_SESSION['iduser'])) {

        $idbl = $_POST['idbl'];
        // $iduser = $_SESSION['iduser'];

        $result = mysqli_query($conn, "SELECT * FROM binhluan WHERE idbl = '$idbl' ");
        if (mysqli_num_rows($result) > 0) {
            mysqli_query($conn, "DELETE FROM binhluan WHERE idbl = '$idbl' ");

            echo '<script>alert("Đã xóa bình luận");</script>';
        } else {
            '<script>alert("Xóa bình luận không thành công");</script>';
        }
        header('Location: chitietsanpham.php?id=' . $idsp);
    }
}


if (isset($_POST['save_edit'])) {
    $idsp = $_POST['idsp'];
    if (isset($_SESSION['iduser'])) {
        $iduser = $_SESSION['iduser'];
        $edit_noidung = $_POST['edit_noidung'];
        $idbl = $_POST['idbl'];

        $result = mysqli_query($conn, "SELECT * FROM binhluan WHERE idbl = '$idbl' ");
        if (mysqli_num_rows($result) > 0) {
            mysqli_query($conn, "UPDATE binhluan SET noidung = '$edit_noidung' WHERE iduser = '$iduser' AND idsp = '$idsp'");
            echo json_encode(['success' => true, 'message' => 'Đã sửa bình luận']);
            exit;
        } else {
            echo json_encode(['success' => false, 'message' => 'Sửa bình luận không thành công']);
            exit;
        }
    }
}



// Code xử lý thích bình luận
if (isset($_POST['like_comment'])) {
    // Xử lý thích bình luận và cập nhật CSDL
    // ...

    // Phản hồi về client (ví dụ: thông báo thành công)
    echo json_encode(['success' => true, 'message' => 'Bạn đã thích bình luận']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['submit_reply'])) {
        $parentCommentId = $_POST['parent_comment_id'];
        $replyContent = $_POST['reply_content'];
        $iduser = $_SESSION['iduser'];

        $insertReplyQuery = "INSERT INTO binhluan (iduser, idbl, noidung, thoigian) 
                            VALUES ('$iduser', '$idbl', '$replyContent', NOW(), '$parentCommentId')";
        mysqli_query($conn, $insertReplyQuery);

        echo json_encode(['status' => 'success', 'message' => 'Reply submitted successfully']);
        exit();
    }
}
?>

<?php include 'header.php'; ?>
<link rel="stylesheet" href="css/chitietsanpham.css" type="text/css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<style type="text/css">
    .title-head {
        margin-top: 0;
        font-size: 26px;
        line-height: 29px;
        font-weight: 500;
        margin-bottom: 10px;
        color: #000;
    }

    .product-price {
        font-size: 24px !important;
        font-weight: bold !important;
        color: #d0021b !important;
        display: inline-block !important;
    }

    .js-sale-text {
        font-weight: 500;
        font-size: 15px;
    }

    .js-sale-value {
        color: #ddac55;
    }

    .js-qty-box {
        display: flex;
        margin-bottom: 30px;
    }

    .js-qty-text {
        margin-right: 30px;
        display: flex;
        align-self: center;
        font-size: 16px;
    }

    .js-qty-minus,
    .js-qty-plus {
        min-width: 20px;
        height: 30px;
        border: 1px solid #40404050;
        padding: 0px 10px;
        background-color: unset;
    }

    .js-qty-minus {
        padding-left: 15px;
        border-radius: 50px 0px 0px 50px;
    }

    .js-qty-plus {
        padding-right: 11px;
        border-radius: 0px 50px 50px 0px;
    }

    #js-qty {
        width: 50px;
        height: 30px;
        min-height: 30px;
        margin: 0px;
        padding: 0px;
        border-top: 1px solid #40404050;
        border-bottom: 1px solid #40404050;
        text-align: center;
    }

    .js-des {
        font-size: 16px;
        text-transform: uppercase;
        letter-spacing: 2px;
        margin-bottom: 10px;
        padding: 5px;
        border-bottom: 1px solid #eaebf3;
        font-weight: bold;
        color: #ddac55;
    }
</style>
<div class="bread-crumb text-center bread-crumb_background" style=" background-image: url('https://pos.nvncdn.net/16a837-71503/bn/20220325_5UxI8S76E0NIJxh0znPFxEOw.png');">
    <h3>Chi tiết sản phẩm</h3>
    <ul class="breadcrumb&#x20;breadcrumb-arrow">
        <li><a href="index.php">Trang chủ</a></li>
        <li><a class="564206" href="">Chi tiết sản phẩm</a></li>
    </ul>
</div>

</div>
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
                                                    $id = $row['id'];
                                                    $anh = $row['image'];
                                                    $ten = $row['tensanpham'];
                                                    $soluong = $row['soluong'];
                                                    $gia = $gia = number_format($row['gia'], 0, ',', '.');
                                                    $giamgia = number_format($row['giamgia'], 0, ',', '.');
                                                ?>
                                                    <img src="images/<?php echo $row['image']; ?> " alt="<?php echo $row['tensanpham']; ?>" class="img-responsive center-block" style="opacity: 1; width: 350px;" id="big-img">
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
                                                        echo '<span class="old-price" style="margin-left: 10px;"><span class="price product-price webvuapricekm">' . $giamgia . 'đ </span></span>';
                                                        echo '<span class="special-price"><del class="price product-price-old webvuaprice" style="font-size: 19px;">' . $gia . 'đ </del></span>';
                                                    } else {
                                                        echo '<span class="old-price" style="margin-left: 10px;"><span class="price product-price webvuapricekm">' . $gia . 'đ </span></span>';
                                                    }
                                ?>
                            </div>
                            <div style="margin: 10px 0px 15px;"><?php echo $row['mota']; ?>
                            </div>
                            <div style="clear: both;"></div>
                            <div style="margin-bottom: 10px; margin-top: 10px;">
                            </div>

                        </div>
                    <?php } ?>
                    <div class="form-product" style="border-top: 1px dashed #eaebf3; padding-top: 20px;">
                        <div enctype="multipart/form-data" id="" action="" method="" class="clearfix form-inline has-validation-callback">
                            <div class="clearfix form-group">
                                <form action="" method="post" style="display: contents">
                                    <div class="js-qty-box">
                                        <div class="js-qty-text ">
                                            Số lượng :
                                        </div>
                                        <button type="button" class="js-qty-minus" onclick="changeQty(-1)">-</button>
                                        <input type="number" name="soluong" id="js-qty" value="1">
                                        <button type="button" class="js-qty-plus" onclick="changeQty(1)">+</button>
                                    </div>
                                    <script type="text/javascript">
                                        function changeImg(img) {
                                            document.getElementById("big-img").src = img;
                                        }

                                        function changeQty(n) {
                                            var qtyInput = document.getElementById("js-qty");
                                            var hiddenQtyInput = document.getElementById("hidden-soluong");

                                            var value = parseInt(qtyInput.value);

                                            if (n == -1 && value > 1) {
                                                qtyInput.value = value - 1;
                                            } else if (n == 1) {
                                                qtyInput.value = value + 1;
                                            }

                                            hiddenQtyInput.value = qtyInput.value;
                                        }
                                    </script>
                                    <div class="btn-mua ">

                                        <input type="hidden" name="idsp" value="<?php echo $id; ?>">
                                        <input type="hidden" name="tensanpham" value="<?php echo $ten; ?>">
                                        <input type="hidden" name="gia" value="<?php echo $gia; ?>">
                                        <input type="hidden" name="giamgia" value="<?php echo $giamgia; ?>">
                                        <input type="hidden" name="image" value="<?php echo $anh; ?>">
                                        <input type="hidden" name="soluong" id="hidden-soluong" value="<?php echo $soluong; ?>">
                                        <button type="submit" data-role="addtocart" name="add_to_cart" class="btn btn-lg btn-gray btn-cart btn_buy add_to_cart">
                                            <span class="txt-main">Thêm vào giỏ</span>
                                        </button>

                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
</section>
<style>
    section {
        display: flex;
        justify-content: space-between;
    }

    .comments-container {
        width: 60%;
        display: contents;
    }

    .comments {
        border: 1px solid #ccc;
        padding: 15px;
        margin-bottom: 15px;
        width: 60%;
        margin-left: 30px;
        border-radius: 40px;
        background-color: #f0dcc2;
        border: none;
    }

    .comment {
        margin-bottom: 10px;
        padding: 10px;
        border: 1px solid #ddd;
        background-color: floralwhite;
        border: none;
        border-radius: 15px;
    }

    .comment-header {
        display: flex;
        justify-content: space-between;
        margin-bottom: 8px;
    }

    .comment-content {
        margin-top: 8px;
    }

    .comment-form {
        width: 35%;
        padding: 15px;
        border: 1px solid #ccc;
        margin-right: 30px;
        background-color: #eedcc3;
        border: none;
        border-radius: 30px;
        height: 250px;
        justify-content: initial;
        text-align: center;
    }

    .comment-form textarea {
        width: 100%;
        margin-top: 8px;
        border-radius: 15px;
    }

    .comment-actions {
        color: black;
        /* background-color: #ddac55; */
    }
</style>
<section>
    <div class="comments-container">
        <div class="comments">
            <h2>Bình Luận</h2>

            <?php
            $idsp = $_GET['id'];
            $conn = mysqli_connect("localhost", "root", "", "cakeshop");
            $sql = "SELECT binhluan.*, users.hoten 
                FROM binhluan
                LEFT JOIN users ON binhluan.iduser = users.iduser
                WHERE binhluan.idsp = $idsp ORDER BY binhluan.thoigian DESC";
            $kq = mysqli_query($conn, $sql);

            while ($row = mysqli_fetch_assoc($kq)) {
                $hoten = $row['hoten'];
                $noidung = $row['noidung'];
                $thoigian = $row['thoigian'];
                $idbl = $row['idbl'];
            ?>

                <form action="chitietsanpham.php" method="post" class="comment-action-form">
                    <div class="comment">
                        <div class="comment-header">
                            <strong><?php echo $hoten ?></strong>
                            <small><?php echo $thoigian ?></small>
                        </div>
                        <div class="comment-content">
                            <p><?php echo $noidung ?></p>
                        </div>
                        <div class="comment-actions">

                            <input type="hidden" name="idbl" value="<?php echo $idbl; ?>">
                            <input type="hidden" name="idsp" value="<?php echo $idsp; ?>">
                            <?php
                            if (isset($_SESSION['iduser'])) { ?>

                                <!-- <button type="button" class="reply-comment-btn" data-comment-id="<?php echo $idbl; ?>">Trả lời</button>

                                <button type="submit" name="like_comment">Thích</button> -->
                                <?php
                                if ($row['iduser'] == $_SESSION['iduser']) : ?>
                                    <button style="border: none; border-radius: 5px;" type="submit" class="edit-btn" name="edit_comment">Sửa</button>
                                    <button style="border: none; border-radius: 5px;" type="submit" name="delete_comment">Xóa</button>
                            <?php endif;
                            }
                            ?>

                        </div>

                    </div>
                </form>

            <?php
            }
            ?>

        </div>

        <div class="comment-form">
            <h2 style="text-align: initial;">Thêm Bình Luận</h2>
            <?php if (isset($_SESSION['iduser'])) : ?>
                <form action="chitietsanpham.php" method="post">
                    <input type="hidden" name="idsp" value="<?php echo $idsp; ?>">
                    <textarea name="noidung" placeholder="Bình luận của bạn" required></textarea>
                    <button type="submit" name="submit_comment" style="border: none; padding: 5px; margin: 10px; border-radius: 10px; background-color: burlywood;">Gửi</button>
                </form>
            <?php else : ?>
                <p>Vui lòng đăng nhập để thêm bình luận.</p>
            <?php endif; ?>

        </div>
    </div>
</section>
<script>
    $(document).ready(function() {
        $('.edit-btn').click(function(e) {
            e.preventDefault();
            var commentElement = $(this).closest('.comment');
            var contentElement = commentElement.find('.comment-content');

            var currentContent = contentElement.text().trim(); // loại bỏ khoảng trắng đầu và cuối chuỗi cmt

            var inputElement = $('<input type="text" class="edit-comment-input" name="edit_noidung" value="' + currentContent + '">');

            contentElement.html(inputElement);

            var saveButton = $('<button type="button" name="save_edit" class="save-edit-btn">Lưu</button>');

            commentElement.find('.comment-actions').append(saveButton);

            $(this).hide();

            saveButton.click(function() {
                var editedContent = inputElement.val();

                $.ajax({
                    type: "POST",
                    url: "chitietsanpham.php",
                    data: {
                        save_edit: true,
                        idsp: <?php echo $idsp; ?>,
                        iduser: <?php echo $iduser; ?>,
                        idbl: <?php echo $idbl; ?>,
                        edit_noidung: editedContent
                    },
                    dataType: 'json',
                    success: function(response) {
                        console.log(response);
                        if (response.success) {
                            contentElement.html(editedContent);
                            $('.edit-btn').show();
                            saveButton.remove();
                            alert(response.message);
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log('AJAX Error:', status, error);
                    }
                });
            });

        });
    });
</script>
<script>
    $(document).ready(function() {
        $('.reply-comment-btn').on('click', function() {
            var idbl = $(this).data('comment-id'); 
            var replyForm = '<form class="reply-form" data-comment-id="' + idbl + '">' +
                '<textarea name="reply_content" placeholder="Enter your reply" required></textarea>' +
                '<button type="button" class="submit-reply-btn">Reply</button>' +
                '</form>';

            $('.reply-form').remove();

            $(this).closest('.comment-actions').append(replyForm);
        });

        $(document).on('click', '.submit-reply-btn', function() {
            var idbl = $(this).closest('.reply-form').data('comment-id'); 
            var replyContent = $(this).closest('.reply-form').find('textarea').val();

            $.ajax({
                type: 'POST',
                url: 'chitietsanpham.php',
                data: {
                    submit_reply: true,
                    parent_comment_id: idbl,
                    reply_content: replyContent
                },
                success: function(response) {
                    console.log(response);
                },
                error: function(error) {
                    console.error('Error submitting reply:', error);
                }
            });
        });

    });
</script>


<br><br><br><br>


<section class="awe-section-4" style="display: block;">
    <div class="title_dm" style="text-align: center; text-transform: uppercase;">
        <h2>Sản phẩm liên quan</h2>
    </div>
    <div class="section_san_pham">
        <div class="container">
            <div class="row">
                <?php
                $conn = mysqli_connect("localhost", "root", "", "cakeshop");
                $id =  $_GET['id'];
                $sql1= "SELECT * FROM sanpham where id = $id";
                $kq1= mysqli_query($conn,$sql1);
                $row1= mysqli_fetch_assoc($kq1);
                $iddm= $row1['iddanhmuc'];
                $sql = "SELECT * FROM sanpham
                WHERE iddanhmuc = $iddm
                LIMIT 4; ";
                $kq = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_assoc($kq)) {
                    $id = $row['id'];
                    $anh = $row['image'];
                    $ten = $row['tensanpham'];
                    $gia = number_format($row['gia'], 0, ',', '.');
                    $giamgia = number_format($row['giamgia'], 0, ',', '.');
                ?>
                    <div class="col-md-3">
                        <div class="card" style="position: relative;">
                            <div class="card__img">
                                <?php echo '<img src="admin/images/' . $row["image"] . '">' ?>
                            </div>
                            <?php if ($row["sale"] > 0) : ?>
                                <div class="label_product"><span class="label_sale"><?php echo $row["sale"] ?></span></div>
                            <?php endif; ?>
                            <div class="card__title">
                                <?php echo $row["tensanpham"] ?>
                            </div>
                            <div class="card__price">
                                <?php

                                if ($row['giamgia'] > 0) {
                                    echo '<del class="card__price_1">' . $gia . 'đ   </del>';
                                    echo $giamgia . "đ";
                                } else {
                                    echo $gia . "đ";
                                }
                                ?>
                            </div>
                            <div class="card__action">
                                <form action="" method="post">
                                    <input type="hidden" name="idsp" value="<?php echo $id; ?>">
                                    <input type="hidden" name="tensanpham" value="<?php echo $ten; ?>">
                                    <input type="hidden" name="gia" value="<?php echo $gia; ?>">
                                    <input type="hidden" name="giamgia" value="<?php echo $giamgia; ?>">
                                    <input type="hidden" name="image" value="<?php echo $anh; ?>">
                                    <?php
                                    echo '<button class="btn-xem-them"><a href="chitietsanpham.php?id=' . $id . '">Xem Thêm</a></button>';
                                    ?>
                                    <button type="submit" class="card__cart" name="add_to_cart">
                                        <i class='bx bxs-cart-alt'></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
</section>

</body>

</html>