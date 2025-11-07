<?php
session_start();
@include 'config.php';
$message = array();


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    $idsp = isset($_POST['idsp']) ? $_POST['idsp'] : '';
    $tensanpham = isset($_POST['tensanpham']) ? $_POST['tensanpham'] : '';
    $gia = isset($_POST['gia']) ? $_POST['gia'] : '';
    $giamgia = isset($_POST['giamgia']) ? $_POST['giamgia'] : '';
    $image = isset($_POST['image']) ? $_POST['image'] : '';
    $product_quantity = 1;

    $total_price = $giamgia > 0 ? $giamgia * $product_quantity : $gia * $product_quantity;
    $thanhtien = number_format($total_price, 3, ',', '.');

    if (isset($_SESSION['iduser'])) {
        $iduser = $_SESSION['iduser'];
        $select_cart = mysqli_query($conn, "SELECT * FROM cart WHERE tensanpham = '$tensanpham' AND iduser = '$iduser'");
        if (mysqli_num_rows($select_cart) > 0) {
            $message[] = 'Sản phẩm đã tồn tại trong giỏ hàng';
        } else {
            if(isset($_SESSION["add_to_cart"])){
                $_SESSION["add_to_cart"] = array();
            }
            $_SESSION["add_to_cart"][$idsp] = $product_quantity;
            $insert_product = mysqli_query($conn, "INSERT INTO cart(tensanpham, gia, giamgia, soluong, thanhtien, image, idsp, iduser) VALUES('$tensanpham', '$gia', '$giamgia', '$product_quantity','$thanhtien', '$image', '$idsp', '$iduser')");
            if ($insert_product) {
                $message[] = 'Thêm sản phẩm vào giỏ hàng thành công';
            } else {
                $message[] = 'Error: ' . mysqli_error($conn);
            }
        }
    } else {
        $message[] = 'Vui lòng đăng nhập để thêm sản phẩm vào giỏ hàng';
    }
} 
?>

<?php include 'header.php'; ?>
<!-- <h1>Xin chào <?php echo $_SESSION['iduser']; ?></h1> -->
<!-- <section id="home" class="home">
    <h1>Tiệm bánh vui vẻ</h1>
    <p>Bánh ngon đặc biệt,<br> trao gửi yêu thương của chúng tôi.</p>
    <div class="home-btn">
        <button><a href="sanpham.php">Xem ngay</a></button>
    </div>
</section>
</div> -->
<!-------------------------about------------------------------------------------------------------------------------------------------------------------->
<section id="about" class="about">
    <div class="san_pham_noi_bat">
        <div class="containerr">
            <div class="evo-owl-cate slick-initialized slick-slider">
                <div aria-live="polite" class="slick-list draggable">
                    <div class="slick-track" role="listbox" style=" opacity: 1; width: 741px; transform: translate3d(0px, 0px, 0px);">

                        <?php
                        $conn = mysqli_connect("localhost", "root", "", "cakeshop");
                        $sql = "SELECT * FROM danhmuc Limit 3";
                        $kq = mysqli_query($conn, $sql);
                        while ($row = mysqli_fetch_array($kq)) {
                            $iddanhmuc = $row["id"];
                            $anh = $row['image'];
                            $ten = $row['tendanhmuc'];
                        ?>
                            <div class="evo-feature-cate slick-slide slick-current slick-active" style="width: 237px;">
                                <a>
                                    <div class="evo-feature-image">
                                        <?php echo '<img class="lazy" src="admin/images/' . $row["image"] . '">' ?>
                                    </div>
                                    <div class="featured-content">
                                        <?php echo '<h3><a href="sanpham.php?iddanhmuc=' . $iddanhmuc . '">' . $row["tendanhmuc"] . '</a></h3>'; ?>
                                    </div>
                            </div>
                            </a>
                        <?php
                        }
                        ?>

                    </div>


                </div>
            </div>
        </div>
</section>
<!----------------------section3------------------------------------------------------------------------------------------------------------------------------ -->
<section class="awe-section-3">
    <div class="section_about">
        <div class="container-fluid">
            <div class="row fix-flex">
                <div class="col-md-6 col-sm-6 col-xs-12 fix-padding">
                    <div class="about-image ">
                        <img class="lazy" src="images/bangbanh3.png" data-src="images/bangbanh3.png" alt="Evo Cake" />
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12 fix-padding-right" style="height: 464px;">
                    <div class="about-content ">
                        <h3 style="color: brown;">Chào mừng các bạn đến với tiệm bánh nhỏ của chúng tôi!</h3>
                        <p>Năng lượng để tiếp tục niềm vui </br>
                            Thế giới ngọt ngào trong vòng tay bạn</br>
                            Tận hưởng sự tươi mới</br>
                            Bánh ngon là món quà dành cho bạn</br>
                            Mỗi chiếc bánh ngon, một niềm vui sẽ đến</br>
                            Không chỉ là bánh ngọt, đây là sự yêu thương.</br>
                            Tận hưởng thế giới ngọt ngào của bạn</br>
                            Sự tươi mới là đặc sản của chúng tôi</br>
                            Cảm nhận sự tốt đẹp của tình yêu</br>
                            Hương vị của niềm tự hào</br>
                            Nướng ổ bánh mì chỉ dành cho bạn</br>
                            Lâu đài thợ làm bánh</br>
                            Nghỉ giải lao, có Kitkat – bánh Kit Kat của Nestle</br>
                            Bánh dành cho lễ kỷ niệm</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ==================================================================================================================================================================== -->
<section class="awe-section-4">
    <div class="title_dm" style="text-align: center; text-transform: uppercase;">
        <!-- <?php
                $conn = mysqli_connect("localhost", "root", "", "cakeshop");
                $sql = "SELECT * FROM danhmuc";
                echo '<h3 class="" style="font-size: 35px; padding-top: 15px;" href="products.php?iddanhmuc=' . $row["id"] . '">' . $row["tendanhmuc"] . '</h3>'
                ?>  -->
        <h3>Bánh Pizza</h3>
    </div>
    <div class="section_san_pham">
        <div class="container">
            <div class="row">
                <?php
                $conn = mysqli_connect("localhost", "root", "", "cakeshop");
                $sql = "SELECT * FROM sanpham WHERE iddanhmuc = 1 ORDER BY RAND() LIMIT 4";
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
                                <form action="" method="post" style="display: contents">
                                    <input type="hidden" name="idsp" value="<?php echo $id; ?>">
                                    <input type="hidden" name="tensanpham" value="<?php echo $ten; ?>">
                                    <input type="hidden" name="gia" value="<?php echo $gia; ?>">
                                    <input type="hidden" name="giamgia" value="<?php echo $giamgia; ?>">
                                    <input type="hidden" name="image" value="<?php echo $anh; ?>">
                                    <?php
                                    echo '<button class="btn-xem-them"><a href="chitietsanpham.php?id=' . $id . '">Xem Thêm</a></button>';
                                    ?>
                                    <button type="submit" onclick="myFunction()" class="card__cart" name="add_to_cart">
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
<!-- ================================================================================================================================================================== -->
<section class="awe-section-4">
    <div class="title_dm" style="text-align: center; text-transform: uppercase;">
        <!-- <?php
                $conn = mysqli_connect("localhost", "root", "", "cakeshop");
                $sql = "SELECT * FROM danhmuc";
                echo '<h3 class="" style="font-size: 35px; padding-top: 15px;" href="products.php?iddanhmuc=' . $row["id"] . '">' . $row["tendanhmuc"] . '</h3>'
                ?> -->
        <h3>Bánh ngọt</h3>
    </div>
    <div class="section_san_pham">
        <div class="container">
            <div class="row">
                <?php
                $conn = mysqli_connect("localhost", "root", "", "cakeshop");
                $sql = "SELECT * FROM sanpham WHERE iddanhmuc = 2 ORDER BY RAND() LIMIT 4";
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
                                    echo '<del class="card__price_1">' . $gia . 'đ </del>';
                                    echo $giamgia . "đ";
                                } else {
                                    echo $gia . "đ";
                                }
                                ?>
                            </div>
                            <div class="card__action">
                                <form action="" method="post" style="display: contents">
                                    <input type="hidden" name="idsp" value="<?php echo $id; ?>">
                                    <input type="hidden" name="tensanpham" value="<?php echo $ten; ?>">
                                    <input type="hidden" name="gia" value="<?php echo $gia; ?>">
                                    <input type="hidden" name="giamgia" value="<?php echo $giamgia; ?>">
                                    <input type="hidden" name="image" value="<?php echo $anh; ?>">
                                    <?php
                                    echo '<button class="btn-xem-them"><a href="chitietsanpham.php?id=' . $id . '">Xem Thêm</a></button>';
                                    ?>
                                    <button type="submit" onclick="myFunction()" class="card__cart" name="add_to_cart">
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
<!-- ================================================================================================================================================================= -->
<section class="awe-section-4">
    <div class="title_dm" style="text-align: center; text-transform: uppercase;">
        <!-- <?php
                $conn = mysqli_connect("localhost", "root", "", "cakeshop");
                $sql = "SELECT * FROM danhmuc";
                echo '<h3 class="" style="font-size: 35px; padding-top: 15px;" href="products.php?iddanhmuc=' . $row["id"] . '">' . $row["tendanhmuc"] . '</h3>'
                ?>  -->
        <h3>Bánh kem</h3>
    </div>
    <div class="section_san_pham">
        <div class="container">
            <div class="row">
                <?php
                $conn = mysqli_connect("localhost", "root", "", "cakeshop");
                $sql = "SELECT * FROM sanpham WHERE iddanhmuc = 3 ORDER BY RAND() LIMIT 4";
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
                                    echo '<del class="card__price_1">' . $gia . 'đ </del>';
                                    echo $giamgia . "đ";
                                } else {
                                    echo $gia . "đ";
                                }
                                ?>
                            </div>
                            <div class="card__action">
                                <form action="" method="post" style="display: contents">
                                    <input type="hidden" name="idsp" value="<?php echo $id; ?>">
                                    <input type="hidden" name="tensanpham" value="<?php echo $ten; ?>">
                                    <input type="hidden" name="gia" value="<?php echo $gia; ?>">
                                    <input type="hidden" name="giamgia" value="<?php echo $giamgia; ?>">
                                    <input type="hidden" name="image" value="<?php echo $anh; ?>">
                                    <?php
                                    echo '<button class="btn-xem-them"><a href="chitietsanpham.php?id=' . $id . '">Xem Thêm</a></button>';
                                    ?>
                                    <button type="submit" onclick="myFunction()" class="card__cart" name="add_to_cart">
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
<link rel="stylesheet" href="css/spm.css">
<!-- =================================================================================================================================================================== -->
<section class="awe-section-5">
    <div class="section_gift lazy" style="background-image: url(images/bia.jpg);">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h3 class="gift-title ">
                        Sản phẩm mới
                    </h3>
                </div>
            </div>
            <!-- <div class="row gift-gallery">
                <div class="col-md-3 col-sm-3 col-xs-6 ">
                    <a> <img class="lazy" src="admin/images/banhkem.jpg" alt="Ad4" />
                </div>
                <div class="col-md-3 col-sm-3 col-xs-6 ">
                    <a><img class="lazy" src="admin/images/banhkem2.jpg" alt="Ad3" style="height: 265px; width:300px;" />
                </div>
                <div class="col-md-3 col-sm-3 col-xs-6 ">
                    <a> <img class="lazy" src="admin/images/banhkem3.jpg" alt="Ad2" /></a>
                </div>
                <div class="col-md-3 col-sm-3 col-xs-6 ">
                    <a> <img class="lazy" src="admin/images/banhkem4.jpg" alt="Ad1" />
                </div>
            </div> -->
            <div class="row gift-list-product">
                <?php
                $conn = mysqli_connect("localhost", "root", "", "cakeshop");
                $sql = "SELECT * FROM sanpham ORDER BY id DESC LIMIT 6";
                $kq = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_assoc($kq)) {
                    $id = $row["id"];
                    $gia = number_format($row['gia'], 0, ',', '.');
                    $giamgia = number_format($row['giamgia'], 0, ',', '.');
                ?>
                    <div class="col-md-4 col-sm-6 col-xs-12 ">
                        <div class="evo-product-slide-item">
                            <div class="product-img">
                                <?php if ($row["sale"] > 0) : ?>

                                    <div class="label_product"><span class="label_sale"> <?php echo $row["sale"] ?> </span></div>
                                <?php endif; ?>
                                <a href="chitietsanpham.php?id=<?php echo $id ?>" title="" class="image-resize">
                                    <?php echo '<img src="admin/images/' . $row["image"] . '" class="lazy loaded">' ?>
                                </a>
                            </div>
                            <div class="product-detail clearfix">
                                <h3 class="pro-name">
                                    <a href="chitietsanpham.php?id=<?php echo $id ?>"><?php echo $row["tensanpham"]; ?></a>
                                </h3>

                                <div class="box-pro-prices">
                                    <p class="pro-price">
                                        <?php
                                        if ($row['giamgia'] > 0) {
                                            echo '<span class="pro-price-del"><del class="compare-price">' . $gia . 'đ </del></span>';
                                            echo $giamgia . "đ";
                                        } else {
                                            echo  $gia . "đ";
                                        }
                                        ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</section>
<!-- ==================================================================================================================================================================== -->
<section class="awe-section-6">
    <div class="container section_blogs">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="new_title ">

                        Tin tức
                    </h3>

                    <div class="evo-owl-blog evo-slick" style="display: flex;">
                        <?php
                        // $conn = mysqli_connect("localhost", "root", "", "cakeshop");
                        $sql = "SELECT * FROM tintuc LIMIT 3";
                        $kq = mysqli_query($conn, $sql);
                        while ($row = mysqli_fetch_assoc($kq)) {
                            $id = $row["id"];
                        ?>
                            <div class="news-items" style="width: 400px;">
                                <div class="clearfix evo-item-blogs">
                                    <div class="evo-article-image">
                                        <a>
                                            <?php echo '<img src="admin/images/' . $row["image"] . '">' ?>
                                            <div class="blog-date"><?php echo date('d-m-Y', strtotime($row["ngaydang"])) ?></div>
                                        </a>
                                    </div>
                                    <div class="evo-article-content">
                                        <h3 class="line-clamp">
                                            <a href="tintuc.php?id=<?php echo $id ?>"><?php echo $row["tieude"] ?></a>
                                        </h3>
                                        <p class="js-text"><?php echo $row["mota"] ?><br></p>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
<?php include 'footer.php'; ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const cards = document.querySelectorAll('.card');
        cards.forEach((card) => {
            const xemThemBtn = card.querySelector('.btn-xem-them');
            const cartIcon = card.querySelector('.card__cart');

            card.addEventListener('mouseenter', function() {
                xemThemBtn.style.display = 'block';
                cartIcon.style.display = 'block';
            });

            card.addEventListener('mouseleave', function() {
                xemThemBtn.style.display = 'none';
                cartIcon.style.display = 'none';
            });
        });
    });
</script>
<script>
    var message = <?php echo json_encode($message); ?>;
    if (message.length > 0) {
        alert(message[0]);
    }
    var productId = <?php echo json_encode($id); ?>;

    function myFunction() {
        var isProductInCart = checkProductInCart(productId);
        if (isProductInCart) {
            alert("Sản phẩm đã tồn tại trong giỏ hàng");
        }
    }

    function checkProductInCart(productId) {
        return false;
    }
</script>
</body>

</html>