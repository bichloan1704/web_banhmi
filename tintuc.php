<?php
session_start();
@include 'config.php';


?>
<?php include 'header.php'; ?>
<link rel="stylesheet" href="css/spm.css" type="text/css">

<div class="bread-crumb text-center bread-crumb_background" style=" background-image: url('https://pos.nvncdn.net/16a837-71503/bn/20220325_5UxI8S76E0NIJxh0znPFxEOw.png');">
    <h3>Tin tức</h3>
    <ul class="breadcrumb&#x20;breadcrumb-arrow">
        <li><a href="index.php">Trang chủ</a></li>
        <li><a class="564206" href="tintuc.php">
            <?php
                if (isset($_GET['id']) && !empty($_GET['id'])) {
                    $sql = "SELECT * FROM tintuc WHERE id = " . $_GET['id'];
                    $kq = mysqli_query($conn, $sql);
                    if ($kq) {
                        while ($row = mysqli_fetch_assoc($kq)) {
                            echo $row["tieude"];
                        }
                    } else {
                        echo "Error executing query: " . mysqli_error($conn);
                    }
                } else {
                    echo "Tin tức";
                }
            ?>
    </ul>
</div>

<div class="container article-wraper margin-top-20 margin-bottom-20">
    <div class="row">
        <section class="right-content ">
            <article class="article-main ">
                <div class="row">
                    <?php
                    $conn = mysqli_connect("localhost", "root", "", "cakeshop");
                    if (isset($_GET['id'])) {
                        $sql = "SELECT * FROM tintuc WHERE id = " . $_GET['id'];
                        $kq = mysqli_query($conn, $sql);
                        while ($row = mysqli_fetch_assoc($kq)) {
                    ?>
                            <div class="col-md-12 col-lg-9 evo-article margin-bottom-10">
                                <h1 class="title-head" style="font-size: 1.2em;color: #333;text-decoration: none; font-weight: bold;">
                                    <a><?php echo $row["tieude"]; ?></a>
                                </h1>
                                <div style="display: flex; padding: 15px 0px 5px;">
                                    <span style="padding-top: 5px; padding-right: 10px; padding-bottom: 5px;"><?php echo $row["ngaydang"]; ?></span>
                                </div>
                                <div class="article-details evo-toc-content">
                                    <div>
                                        <h2 style="font-size: 1.42857em;color: #333;text-decoration: none; font-weight: bold;">
                                            <a><?php echo $row["ten"]; ?></a>
                                        </h2>
                                        <p style="font-size: 0.9em;color: #686565; ">
                                            <?php echo $row["noidung"]; ?>
                                        </p>
                                        <div>
                                            <div>
                                                <a title="" href="" target="_blank" rel="noopener noreferrer" data-fancybox-group="img-lightbox">
                                                    <img id="" title=" " src="" alt="" />
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                    } else {
                        // $sql = "SELECT * FROM tintuc"; 
                        ?>
                        <section class="awe-section-6">
                            <div class="container section_blogs">
                                <div class="container">
                                    <div class="row">
                                        <div class="">
                                            <div class="evo-owl-blog evo-slick" style="display: flex; flex-wrap: wrap;    justify-content: space-around">
                                                <?php
                                                // $conn = mysqli_connect("localhost", "root", "", "cakeshop");
                                                $sql = "SELECT * FROM tintuc ";
                                                $kq = mysqli_query($conn, $sql);
                                                while ($row = mysqli_fetch_assoc($kq)) {
                                                    $id = $row["id"];
                                                ?>
                                                    <div class="news-items" style="width: 390px;">
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
                    <?php  }
                    ?>
                    <div class="clearfix"></div>
                </div>
            </article>
        </section>
    </div>
</div>
<?php include 'footer.php'; ?>
</body>

</html>