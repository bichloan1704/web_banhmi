<?php
session_start();
@include 'config.php';

if (isset($_SESSION['iduser'])) {
   $iduser = $_SESSION['iduser'];

   $sqlUser = "SELECT * FROM users WHERE iduser = $iduser";
   $resultUser = mysqli_query($conn, $sqlUser);

   if ($resultUser) {
      $userData = mysqli_fetch_assoc($resultUser);
      $hoten = $userData['hoten'];
      $email = $userData['email'];
      $sdt = $userData['sdt'];
      $diachi = $userData['diachi'];
   }
} else {
   $hoten = '';
   $email = '';
   $sdt = '';
   $diachi = '';
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['dat_hang'])) {
   $iduser = $_SESSION['iduser'];
   $ten = isset($_POST['ten']) ? $_POST['ten'] : '';
   $email = isset($_POST['email']) ? $_POST['email'] : '';
   $sdt = isset($_POST['sdt']) ? $_POST['sdt'] : '';
   $ghichu = isset($_POST['ghichu']) ? $_POST['ghichu'] : '';
   $diachi = isset($_POST['diachi']) ? $_POST['diachi'] : '';

   $phuongthucthanhtoan = isset($_POST['phuongthucthanhtoan']) ? $_POST['phuongthucthanhtoan'] : '';
   $tongtien = isset($_POST['tongtien']) ? $_POST['tongtien'] : '';

   // Set the $ngaydathang variable
   $ngaydathang = date('Y-m-d');

   $trangthai = 'Đang chờ xác nhận';

   $query = "INSERT INTO donhang(ten, email, sdt, diachi, ghichu, ngaydathang, phuongthucthanhtoan, tongtien, trangthai, iduser) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
   $stmt = mysqli_prepare($conn, $query);
   mysqli_stmt_bind_param($stmt, "sssssssssi", $ten, $email, $sdt, $diachi, $ghichu, $ngaydathang, $phuongthucthanhtoan, $tongtien, $trangthai, $iduser);
   mysqli_stmt_execute($stmt);
   $iddh = mysqli_insert_id($conn);

   $sql = "SELECT * FROM cart where iduser= $iduser";
   $result = mysqli_query($conn, $sql);

   while ($row = mysqli_fetch_assoc($result)) {
      $idsp = $row['idsp'];
      $soluong = $row['soluong'];
      $gia = $row['gia'];
      $giamgia = $row['giamgia'];

      $total_price = ($giamgia > 0) ? ($giamgia * $soluong) : ($gia * $soluong);

      $query1 = "INSERT INTO chitietdonhang(iddh, idsp, soluong, gia, ngaydathang) VALUES(?, ?, ?, ?, ?)";
      $stmt1 = mysqli_prepare($conn, $query1);
      mysqli_stmt_bind_param($stmt1, "iiids", $iddh, $idsp, $soluong, $total_price, $ngaydathang);
      mysqli_stmt_execute($stmt1);
   }

   if ($stmt && $stmt1) {
      $deleteCartQuery = "DELETE FROM cart WHERE iduser = ?";
      $deleteCartStmt = mysqli_prepare($conn, $deleteCartQuery);
      mysqli_stmt_bind_param($deleteCartStmt, "i", $iduser);
      mysqli_stmt_execute($deleteCartStmt);
      mysqli_stmt_close($deleteCartStmt);

      mysqli_stmt_close($stmt);
      mysqli_stmt_close($stmt1);

      echo '<script>alert("Đặt hàng thành công");</script>';
      echo '<script>window.location.href = "index.php";</script>';
  } else {
      echo '<script>alert("Error: ' . mysqli_error($conn) . '")</script>';
  }
}


?>







<?php include 'header.php'; ?>
<link rel="stylesheet" href="css/thanhtoan.css" type="text/css">
<style>
   .main {
      display: flex;
      justify-content: space-between;
      margin-top: -45px;
   }

   .main-content {
      flex: 1;
      margin-right: 20px;
      position: sticky;

   }

   .sidebar {
      flex: 1;
   }
</style>

<div class="content" style="border-top: 1px solid #e1e1e1;">
   <div class="wrap">
      <form action="" method="post">
         <div class="main" style="margin-top: -45px; display: flex; width: auto;">
            <div id="step-shipping" class="main-content" style="position: sticky;">
               <div class="step">
                  <div class="step-sections" style="height: 200px;">
                     <div class="section">
                        <div class="section-header">
                           <h2 class="section-title">Thông tin giao hàng</h2>
                        </div>
                        <div class="section-content">
                           <div class="field fieldset">
                              <div id="form_update_shipping_method" class="field default">
                                 <div class="content-box mt0">
                                    <div id="form_update_location_customer_shipping" class="order-checkout__loading radio-wrapper content-box-row content-box-row-padding content-box-row-secondary ">
                                       <!-- <div class="order-checkout__loading--box">
                                          <div class="order-checkout__loading--circle"></div>
                                       </div> -->
                                       <?php
                                       if (isset($_SESSION['iduser'])) {
                                          $iduser = $_SESSION['iduser']; ?>
                                          <input type="hidden" name="iduser" id="iduser" value="<?php echo $iduser; ?>" required>
                                       <?php } ?>
                                       <!-- <input type="hidden" name="ngaydathang" id="ngaydathang" required>
                                       <script>
                                          var today = new Date();
                                          var ngaydathang = today.getDate() + '-' + (today.getMonth() + 1) + '-' + today.getFullYear();
                                          document.getElementById('ngaydathang').value = ngaydathang;
                                       </script> -->

                                       <div class="field">
                                          <div class="field-input-wrapper">
                                             <label class="field-label" for="billing_address_full_name">Họ và tên</label>
                                             <input placeholder="Họ và tên" class="field-input" size="30" type="text" id="billing_address_full_name" name="ten" value="<?php echo $hoten; ?>" required>
                                          </div>
                                       </div>
                                       <div class="field  field-two-thirds ">
                                          <div class="field-input-wrapper">
                                             <label class="field-label" for="checkout_user_email">Email</label>
                                             <input placeholder="Email" class="field-input" size="30" type="email" id="checkout_user_email" name="email" value="<?php echo $email; ?>" required>
                                          </div>
                                       </div>
                                       <div class="field field-required field-third ">
                                          <div class="field-input-wrapper">
                                             <label class="field-label" for="billing_address_phone">Số điện thoại</label>
                                             <input placeholder="Số điện thoại" class="field-input" size="30" maxlength="15" type="tel" name="sdt" value="<?php echo $sdt; ?>" required>
                                          </div>
                                       </div>
                                       <div class="field ">
                                          <div class="field-input-wrapper">
                                             <label class="field-label" for="billing_address_address1">Địa chỉ</label>
                                             <input placeholder="Địa chỉ" class="field-input" size="30" type="text" name="diachi" id="billing_address_address1" value="<?php echo $diachi; ?>" required>
                                          </div>
                                       </div>
                                       <div class="field ">
                                          <div class="field-input-wrapper">
                                             <label class="field-label" for="billing_address_address1">Ghi chú</label>
                                             <input placeholder="Ghi chú" class="field-input" size="30" type="text" name="ghichu" id="billing_address_address1">
                                          </div>
                                       </div>

                                    </div>
                                    <div class="field field-show-floating-label  field-half ">
                                       <div class="field-input-wrapper field-input-wrapper-select" style="width: 237px;">
                                          <select class="field-input" id="customer_shipping_ward" style="padding-top: 0.5em;padding-bottom: 0.38em;" name="phuongthucthanhtoan" required>
                                             <option selected disabled hidden>Phương thức thanh toán</option>
                                             <option value="Thanh toán khi nhận hàng">Thanh toán khi nhận hàng</option>
                                             <option value="Zalo Pay">Zalo Pay</option>
                                          </select>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <br>
               <br>
               <br>
               <br>
               <br>
               <br>
               <div class="step-footer" id="step-footer-checkout">
                  <button type="submit" class="step-footer-continue-btn btn" name="dat_hang" style="margin-right: 55px;">
                     <span class="btn-content">Đặt hàng</span>
                  </button>
                  <a href="cart.php" style="padding-right: 150px;">Quay lại giỏ hàng</a>
               </div>
            </div>
            

            <div class="sidebar" style="padding-top: 0px;position: sticky;">
               <div class="sidebar-content">
                  <div class="order-summary order-summary-is-expanded">
                     <h2 class="visually-hidden">Thông tin đơn hàng</h2>
                     <div class="order-summary-sections">
                        <?php
                        if (isset($_SESSION['iduser'])) {
                           $iduser = $_SESSION['iduser']; ?>
                           <div class="order-summary-section order-summary-section-product-list" data-order-summary-section="line-items">
                              <table class="product-table">
                                 <?php
                                 $conn = mysqli_connect("localhost", "root", "", "cakeshop");
                                 $sql = "SELECT * FROM cart where iduser= $iduser";
                                 $kq = mysqli_query($conn, $sql);
                                 $grand_total = 0;

                                 while ($row = mysqli_fetch_assoc($kq)) {
                                    $idsp = $row['idsp'];
                                    $id = $row['id'];
                                    $anh = $row['image'];
                                    $tensanpham = $row['tensanpham'];
                                    $gia = number_format($row['gia'], 3, ',', '.');
                                    $giamgia = number_format($row['giamgia'], 3, ',', '.');
                                    $soluong = $row["soluong"];


                                    $total_price = $row['giamgia'] > 0 ? $row['giamgia'] * $soluong : $row['gia'] * $soluong;
                                    // $grand_total += $total_price;
                                 ?>
                                    <tbody>
                                       <tr class="product">
                                          <td class="product-image" style="padding: 5px;">
                                             <div class="product-thumbnail">
                                                <div class="product-thumbnail-wrapper">
                                                   <!-- <input type="checkbox" name="" value="<?php echo $row['id']; ?>" checked> -->
                                                   <input type="hidden" name="idsp" value="<?php echo $idsp; ?>">
                                                   <img class="product-thumbnail-image" alt="" src="images/<?php echo $anh ?>">
                                                </div>
                                                <input type="hidden" name="soluong" value="<?php echo $soluong; ?>">
                                                <span class="product-thumbnail-quantity" aria-hidden="true"><?php echo $soluong ?></span>
                                             </div>
                                          </td>
                                          <td class="product-description">
                                             <span class="product-description-name order-summary-emphasis"><?php echo $tensanpham ?></span>
                                          </td>
                                          <td class="product-quantity visually-hidden"></td>
                                          <td class="product-price">
                                             <input type="hidden" name="gia" value="<?php echo $total_price; ?>">
                                             <span class="order-summary-emphasis"><?php echo number_format($total_price, 3, ',', '.') ?>đ</span>
                                          </td>
                                       </tr>
                                    </tbody>
                                 <?php } ?>
                              </table>
                           </div>
                        <?php } ?>
                        <div class="order-summary-section order-summary-section-discount">
                           <div id="form_discount_add">
                              <div class="fieldset">
                                 <div class="field  ">
                                    <div class="field-input-btn-wrapper">
                                       <div class="field-input-wrapper">
                                          <label class="field-label">Mã giảm giá</label>
                                          <input placeholder="Mã giảm giá" class="field-input" size="30" type="text" id="discountcodedesk" name="discount.code" value="">
                                       </div>
                                       <button type="button" id="enterdiscountdesk" class="field-input-btn btn btn-default btn-disabled">
                                          <span class="btn-content">Sử dụng</span>
                                          <i class="btn-spinner icon icon-button-spinner"></i>
                                       </button>
                                    </div>
                                    <p class="field-message field-message-error desk"></p>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="order-summary-section order-summary-section-total-lines payment-lines">
                           <table class="total-line-table">
                              <thead>
                                 <tr>
                                    <th scope="col"><span class="visually-hidden">Mô tả</span></th>
                                    <th scope="col"><span class="visually-hidden">Giá</span></th>
                                 </tr>
                              </thead>
                              <tbody>
                                 <tr class="total-line total-line-subtotal">
                                    <td class="total-line-name">Tạm tính</td>
                                    <td class="total-line-price">
                                       <span class="order-summary-emphasis">
                                          <?php
                                          $grand_total = 0;
                                          $kq = mysqli_query($conn, $sql);
                                          while ($row = mysqli_fetch_assoc($kq)) {
                                             $total_price = $row['giamgia'] > 0 ? $row['giamgia'] * $row['soluong'] : $row['gia'] * $row['soluong'];
                                             $grand_total += $total_price;
                                          }

                                          $tongtien = number_format($grand_total, 3, ',', '.');
                                          ?>
                                          <?php echo $tongtien ?>đ
                                       </span>
                                    </td>
                                 </tr>

                                 <tr class="total-line total-line-shipping">
                                    <td class="total-line-name">Phí vận chuyển</td>
                                    <td class="total-line-price">
                                       <span class="order-summary-emphasis" id="orderfeeShipShow">
                                          —
                                       </span>
                                    </td>
                                 </tr>
                              </tbody>
                              <tfoot class="total-line-table-footer">
                                 <tr class="total-line">
                                    <td class="total-line-name payment-due-label">
                                       <span class="payment-due-label-total">Tổng cộng</span>
                                    </td>
                                    <td class="total-line-name payment-due">
                                       <span class="payment-due-currency">VND</span>
                                       <span class="payment-due-price" id="totalorder">
                                          <input type="hidden" name="tongtien" value="<?php echo $tongtien; ?>">
                                          <?php
                                          $grand_total = 0;
                                          $kq = mysqli_query($conn, $sql);
                                          while ($row = mysqli_fetch_assoc($kq)) {
                                             $total_price = $row['giamgia'] > 0 ? $row['giamgia'] * $row['soluong'] : $row['gia'] * $row['soluong'];
                                             $grand_total += $total_price;
                                          }
                                          $tongtien = number_format($grand_total, 3, ',', '.');
                                          ?>
                                          <?php echo $tongtien ?>
                                       </span>
                                    </td>
                                 </tr>
                              </tfoot>
                           </table>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </form>
   </div>
</div>


</body>

</html>