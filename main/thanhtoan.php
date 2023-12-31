<?php
if (isset($_SESSION['dangky'])) {
    $id_dangky = $_SESSION['id_dangky'];
    

    // Chạy câu truy vấn SQL
    $sql_khachhang = "SELECT * FROM dangky WHERE id_dangky = ?";
    $stmt = $conn->prepare($sql_khachhang);
    $stmt->bind_param("i", $id_dangky);
    $stmt->execute();

    // Lấy kết quả
    $result = $stmt->get_result();
    
    // Kiểm tra xem có dữ liệu hay không
    if ($result->num_rows > 0) {
        // Lấy dữ liệu từ kết quả
        $row_khachhang = $result->fetch_assoc();
        // Thêm các trường khác tương tự...
    } else {
        echo "Không có dữ liệu cho id_dangky = $id_dangky";
    }

}

?>
<div class="container-fluid bg-secondary mb-5">
    <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 150px">
        <h1 class="font-weight-semi-bold text-uppercase mb-3">Thông tin thanh toán</h1>
        <div class="d-inline-flex">
            <p class="m-0"><a href="">Home</a></p>
            <p class="m-0 px-2">-</p>
            <p class="m-0">Thông tin thanh toán</p>
        </div>
    </div>
</div>
<form action="main/xulythanhtoan.php" method="post">
    <!-- Page Header End -->
    <div class="container-fluid">
        <p class="m-2"><?php if (isset($_SESSION['dangky'])) {
    echo "Xin chào ".$_SESSION['dangky'];
    echo $_SESSION['id_dangky'];
} ?></p>
        <div class="row px-xl-5">
            <div class="col-lg-8 table-responsive mb-5">
                <table class="table table-bordered text-center mb-0">
                    <thead class="bg-secondary text-dark">
                        <tr>
                            <th>Sản phẩm</th>
                            <th>Hình ảnh</th>
                            <th>Giá</th>
                            <th>Số lượng</th>
                            <th>Tổng cộng</th>
                            <th>Xóa</th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                        <?php
                     $tongtien = 0; // Khởi tạo biến tổng tiền
                     if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
                         $i = 0;
                         foreach ($_SESSION['cart'] as $cart_item) {
                             $thanhtien = $cart_item['soluong'] * $cart_item['giasp'];
                             $tongtien += $thanhtien;
                             $i++;
                        ?>
                        <tr>
                            <td class="align-middle">
                                <?php echo $cart_item['tensanpham']; ?>
                            </td>
                            <td class="align-middle">
                                <img src="<?php echo $cart_item['hinhanh']; ?>" alt="" style="width: 50px;">
                            </td>
                            <td class="align-middle"><?php echo number_format($cart_item['giasp']); ?></td>
                            <td class="align-middle">
                                <div class="input-group quantity mx-auto" style="width: 100px;">
                                    <div class="input-group-btn">
                                        <a href="main/themgiohang.php?tru=<?php echo $cart_item['id']; ?>"
                                            class="btn btn-sm btn-primary btn-minus"><i class="fa fa-minus"></i></a>
                                    </div>
                                    <input type="text" class="form-control form-control-sm bg-secondary text-center"
                                        value="<?php echo $cart_item['soluong']; ?>">
                                    <div class="input-group-btn">
                                        <a href="main/themgiohang.php?cong=<?php echo $cart_item['id']; ?>"
                                            class="btn btn-sm btn-primary btn-plus"><i class="fa fa-plus"></i></a>
                                    </div>
                                </div>
                            </td>
                            <td class="align-middle"><?php echo number_format($thanhtien); ?></td>
                            <td class="align-middle"><a href="main/themgiohang.php?xoa=<?php echo $cart_item['id']; ?>"
                                    class="btn btn-sm btn-danger"><i class="fa fa-times"></i></a></td>
                        </tr>
                        <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="col-lg-4">
                <form class="mb-5" action="">
                    <div class="input-group">
                        <input type="text" class="form-control p-4" placeholder="Mã giảm giá">
                        <div class="input-group-append">
                            <button class="btn btn-primary">Áp dụng</button>
                        </div>
                    </div>
                </form>
                <div class="card border-secondary mb-5">
                    <div class="card-header bg-secondary border-0">
                        <h4 class="font-weight-semi-bold m-0">Thông tin khách hàng</h4>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3 pt-1">
                            <h6 class="font-weight-medium">Tên khách hàng</h6>
                            <h6 class="font-weight-medium"><?php echo $row_khachhang['tenkhachhang']; ?></h6>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h6 class="font-weight-medium">Số điện thoại</h6>
                            <h6 class="font-weight-medium"><?php echo $row_khachhang['dienthoai']; ?></h6>
                        </div>
                        <div class="mt-1">
                            <h6 class="font-weight-medium">Địa chỉ:</h6>
                            <h6 class="font-weight-medium"><?php echo $row_khachhang['diachi']; ?></h6>
                        </div>
                        <div class="mt-1">
                            <h6 for="" class="font-weight-medium">Hình thức thanh toán</h6>
                            <select class="form-control" id="" name="payment">
                                <option value="cash">Tiền mặt</option>
                                <option value="vnpay">VNPAY</option>
                            </select>

                        </div>
                    </div>

                    <div class="card border-secondary mb-5">
                        <div class="card-header bg-secondary border-0">
                            <h4 class="font-weight-semi-bold m-0">Thông tin</h4>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-3 pt-1">
                                <h6 class="font-weight-medium">Tổng cộng</h6>
                                <h6 class="font-weight-medium"><?php echo number_format($tongtien); ?></h6>
                            </div>
                            <div class="d-flex justify-content-between">
                                <h6 class="font-weight-medium">Phí vận chuyển</h6>
                                <h6 class="font-weight-medium"><?php ?></h6>
                            </div>
                            <div class="card-footer border-secondary bg-transparent">
                                <div class="d-flex justify-content-between mt-2">
                                    <h5 class="font-weight-bold">Total</h5>
                                    <h5 class="font-weight-bold"><?php echo number_format($tongtien); ?></h5>
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-block btn-primary my-3 py-3" type="submit" name="redirect">Thanh toán</button>

                    </div>
                </div>
            </div>
        </div>
</form>