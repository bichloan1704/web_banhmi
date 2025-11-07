<?php
session_start();
@include 'config.php';

if (isset($_POST['themtt'])) {
    $tieude = $_POST['tieude'];
    $mota = $_POST['mota'];
    $noidung = $_POST['noidung'];
    $image = $_FILES['image']['name'];
    $ngaydang = $_POST['ngaydang'];
    $p_image_tmp_name = $_FILES['image']['tmp_name'];
    $p_image_folder = 'images/' . $image;

    $insert_query = mysqli_query($conn, "INSERT INTO `tintuc` (tieude,mota, noidung,  image, ngaydang) VALUES ('$tieude', '$mota', '$noidung',  '$image', '$ngaydang')") or die('Query failed');

    if ($insert_query) {
        move_uploaded_file($p_image_tmp_name, $p_image_folder);
        header('location: tintuc.php');
    } else {
        $message[] = 'Thêm tin tức không thành công';
    }
}

if (isset($_GET['xoatt'])) {
    $delete_id = $_GET['xoatt'];
    $delete_query = mysqli_query($conn, "DELETE FROM tintuc WHERE id = $delete_id") or die('Query failed');
    if ($delete_query) {
        header('location: tintuc.php');
        $message[] = 'Tin tức đã được xóa ';
    } else {
        header('location: tintuc.php');
        $message[] = 'Xóa tin tức không thành công';
    }
}

if (isset($_POST['update_product'])) {
    $id = $_POST['id'];
    $tieude = $_POST['tieude'];
    $ngaydang = $_POST['ngaydang'];

    if ($_FILES['update_p_image']['name']) {
        $file_name = $_FILES['update_p_image']['name'];
        $file_tmp = $_FILES['update_p_image']['tmp_name'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $allowed_extensions = array("jpeg", "jpg", "png");

        if (in_array($file_ext, $allowed_extensions)) {
            $target = "images/" . basename($file_name);

            if (move_uploaded_file($file_tmp, $target)) {
                $sql_update_image = "UPDATE tintuc SET image = '$file_name' WHERE id = $id";
                mysqli_query($conn, $sql_update_image);
            } else {
                echo "Error while moving the image file.";
            }
        } else {
            echo "Only JPEG or PNG image files are supported.";
        }
    }

    $mota = $_POST['suamota'];
    $noidung = $_POST['suanoidung'];

    $update_query = $conn->prepare("UPDATE tintuc SET tieude = ?, mota = ?, noidung = ?, ngaydang = ? WHERE id = ?");
    $update_query->bind_param("ssssi", $tieude, $mota, $noidung, $ngaydang, $id);

    $tieude = $_POST['tieude'];
    $ngaydang = $_POST['ngaydang'];
    $id = $_POST['id'];

    if ($update_query->execute()) {
        $message[] = 'Sửa tin tức thành công';
        header('location: tintuc.php');
    } else {
        $message[] = 'Sửa tin tức không thành công';
        header('location: tintuc.php');
    }


    $update_query->close();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="logo1.png" rel="icon" type="image&#x2F;vnd.microsoft.icon">
    <link rel="stylesheet" href="../css/style.css" type="text/css">
    <link rel="stylesheet" href="../css/card.css" type="text/css">
    <!-- <link rel="stylesheet" href="chitietsanpham.css" type="text/css"> -->

    <!-- Boxicons -->
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- My CSS -->
    <link rel="stylesheet" href="style_qlsp.css">
    <link rel="stylesheet" href="style.css">
    <title>Tin tức</title>
    <style>
        a:hover {
            text-decoration: none;
        }

        .edit-product {
            max-height: 500px;
            overflow-y: auto;
        }

        .expandable-textarea {
            resize: vertical;
            width: 100%;
            box-sizing: border-box;

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
        <button onclick="myFunction()" style="background-color: #ae9886;border: none;height: 36px;padding: 5px 10px; margin: 10px;font-size: large;border-radius: 10px;color: white;">Thêm tin tức</button>
        <div class="container" id="add-product" style="display: none;">
            <section>

                <form action="" method="post" class="add-product-form" enctype="multipart/form-data">

                    <input type="text" name="tieude" placeholder="Tiêu đề" class="box" required>
                    <label for="image" style="font-size: 15px; color: #9f9191;">Hình ảnh 1</label>
                    <input type="file" name="image" accept="image/png, image/jpg, image/jpeg" class="box" required>
                    <label for="mota" style="font-size: 15px; color: #9f9191;">Mô tả</label><br>
                    <textarea id="mota" name="mota" class="expandable-textarea" placeholder="Nhập mô tả" style=" width: 458px; height: 50px; border: 1px solid #eae3d8; border-radius: 5px;">
					</textarea>

                    <script>
                        ClassicEditor
                            .create(document.querySelector('#mota'))
                            .catch(error => {
                                console.error(error);
                            });
                    </script>
                    <br>
                    <label for="noidung" style="font-size: 15px; color: #9f9191;">Nội dung</label><br>
                    <textarea id="noidung" name="noidung" class="expandable-textarea" placeholder="Nhập nội dung" style=" width: 458px; height: 50px; border: 1px solid #eae3d8; border-radius: 5px;">
					</textarea>

                    <script>
                        ClassicEditor
                            .create(document.querySelector('#noidung'))
                            .catch(error => {
                                console.error(error);
                            });
                    </script>
                    <br>
                    Ngày đăng <br>
                    <input type="date" name="ngaydang">
                    <input type="submit" value="Thêm tin tức" name="themtt" class="btn">
                </form>

            </section>
        </div>
        <!-- MAIN -->


    </section>
    <script>
        function myFunction() {
            var x = document.getElementById("add-product");
            if (x.style.display === "none") {
                x.style.display = "block";
            } else {
                x.style.display = "none";
            }
        }
    </script>
    <!-- CONTENT -->
    <style>
        .scrollable-td {
            height: 200px;
            overflow-y: auto;
        }
    </style>

    <section class="display-product-table" style=" padding-left: 260px;">

        <table class="table table-striped">

            <thead style="text-align: center;">
                <th>Hình ảnh</th>
                <th style="width: 150px;">Tiêu đề</th>
                <th style="width: 250px;">Mô tả</th>
                <th>Nội dung</th>
                <th>Ngày đăng</th>
                <th>Hành động</th>
            </thead>

            <tbody>
                <?php

                $select_products = mysqli_query($conn, "SELECT * FROM tintuc");
                if (mysqli_num_rows($select_products) > 0) {
                    while ($row = mysqli_fetch_assoc($select_products)) {
                ?>

                        <tr>
                            <td><img src="images/<?php echo $row['image']; ?>" style="height: 150px; width: 900px" alt=""></td>
                            <td style=""><?php echo $row['tieude']; ?></td>
                            <td><?php echo $row['mota']; ?></td>
                            <td ><div class="scrollable-td"><?php echo $row['noidung']; ?></div> </td>
                            <td style=""><?php echo $row['ngaydang']; ?></td>
                            <td>
                                <a href="tintuc.php?xoatt=<?php echo $row['id']; ?>" class="delete-btn" onclick="return confirm('Bạn muốn xóa tin tức này');"> <i class="fas fa-trash"></i> Xóa </a>
                                <a href="tintuc.php?suatt=<?php echo $row['id']; ?>" class="option-btn"> <i class="fas fa-edit"></i> Sửa </a>
                            </td>
                        </tr>

                <?php
                    };
                } else {
                    echo "<div class='empty'>Thêm tin tức không thành công</div>";
                };
                ?>
            </tbody>
        </table>
    </section>

    <section class="edit-form-container">

        <?php

        if (isset($_GET['suatt'])) {
            $edit_id = $_GET['suatt'];
            $edit_query = mysqli_query($conn, "SELECT * FROM tintuc WHERE id = $edit_id");
            if (mysqli_num_rows($edit_query) > 0) {
                while ($fetch_edit = mysqli_fetch_assoc($edit_query)) {
        ?>

                    <form action="" method="post" enctype="multipart/form-data" class="edit-product">
                        <img src="photo/<?php echo $fetch_edit['image']; ?>" height="200" alt="">
                        <input type="hidden" name="id" value="<?php echo $fetch_edit['id']; ?>">
                        <table>

                        </table>
                        Tiêu đề:
                        <input type="text" class="box" required name="tieude" value="<?php echo $fetch_edit['tieude']; ?>">
                        <input type="file" class="box" name="update_p_image" accept="image/png, image/jpg, image/jpeg">
                        <label for="suamota" style="font-size: 15px; color: #9f9191;">Mô tả</label><br>
                        <textarea id="suamota" name="suamota" class="expandable-textarea" style="width: 458px; height: 50px; border: 1px solid #eae3d8; border-radius: 5px;"><?php echo $fetch_edit['mota']; ?></textarea>

                        <script>
                            ClassicEditor
                                .create(document.querySelector('#suamota'))
                                .catch(error => {
                                    console.error(error);
                                });
                        </script>
                        <br>
                        <textarea id="suanoidung" name="suanoidung" class="expandable-textarea" style="width: 458px; height: 50px; border: 1px solid #eae3d8; border-radius: 5px;"><?php echo $fetch_edit['noidung']; ?></textarea>

                        <script>
                            ClassicEditor
                                .create(document.querySelector('#suanoidung'))
                                .catch(error => {
                                    console.error(error);
                                });
                        </script>
                        <br>
                        Ngày đăng <br>
                        <input type="date" name="ngaydang" value="<?php echo $fetch_edit['ngaydang']; ?>">
                        <input type="submit" value="Sửa tin tức" name="update_product" class="btn">
                        <input type="reset" value="Thoát" id="close-edit" class="option-btn">
                    </form>

        <?php
                };
            };
            echo "<script>document.querySelector('.edit-form-container').style.display = 'flex';</script>";
        };
        ?>

    </section>


    <script src="script.js"></script>
    <script>
        var closeButton = document.getElementById('close-edit');
        closeButton.addEventListener('click', function() {
            var editFormContainer = document.querySelector('.edit-form-container');
            editFormContainer.style.display = 'none';
        });
    </script>

  
</body>

</html>