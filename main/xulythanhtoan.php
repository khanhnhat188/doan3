<?php
    session_start();
    include('../admin/connect/conn.php');
    require('../mail/sendmail.php');
    require('../admin/carbon/vendor/autoload.php');
    use Carbon\Carbon;

    $now = Carbon::now('Asia/Ho_Chi_Minh');
    $id_dangky = $_SESSION['id_dangky'];
    $mahoadon = str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
    // Lấy giá trị hình thức thanh toán từ $_POST
    if(isset($_POST['payment'])) {
        $hinhthucthanhtoan = $_POST['payment'];
    } else {
        // Xử lý nếu không có giá trị được chọn (mặc định hoặc xử lý khác tùy thuộc vào yêu cầu của bạn)
        $hinhthucthanhtoan = 'Không xác định';
    }
    $insert_hoadon = "INSERT INTO donhang (id_dangky, madonhang, trangthai, ngaydat, hinhthucthanhtoan) VALUES ('$id_dangky', '$mahoadon', '1', '$now', '$hinhthucthanhtoan')";
    $query_hoadon = mysqli_query($conn, $insert_hoadon);
    if ($query_hoadon) {
        foreach ($_SESSION['cart'] as $key => $value) {
            $id_sanpham = $value['id'];
            $soluong = $value['soluong'];
            $insert_chitiet = "INSERT INTO chitiethoadon (madonhang, id_sanpham, soluongmua) VALUES ('$mahoadon', '$id_sanpham', '$soluong')";
            $query_chitiet = mysqli_query($conn, $insert_chitiet);
        }
    $tieu_de = "Đơn hàng của bạn đã được tiếp nhận";
    $noi_dung = "<p>Cảm ơn bạn đã đặt hàng với mã đơn hàng: $mahoadon. Chúng tôi sẽ liên hệ với bạn sớm nhất có thể để xác nhận đơn hàng.<br><br>Trân trọng!</p>";
    $noi_dung = "Đơn hàng gồm các sản phẩm: <br>";
    foreach ($_SESSION['cart'] as $key => $value) {
        $noi_dung .= $value['tensanpham'] . " - " . $value['soluong'] . " cái<br>";
        $noi_dung .= "Tổng tiền: " . number_format($value['soluong'] * $value['giasp']) . " VNĐ<br>";
    }   

/*     
    $email = $_SESSION['email'];
    $mail = new Mailer();
    $mail->maildathang($tieu_de, $noi_dung, $email); */
    }
unset($_SESSION['cart']);
header("location:../index.php");