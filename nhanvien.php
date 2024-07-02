<?php
include('includes/header.php'); 
include('includes/navbar.php'); 
include('includes/db.php');

// Pagination
$limit = 8;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($page - 1) * $limit;

$result = $conn->query("SELECT COUNT(MaNV) AS MaNV FROM nhanvien");
$empCount = $result->fetch_all(MYSQLI_ASSOC);
$total = $empCount[0]['MaNV'];
$pages = ceil($total / $limit);

$sql = "SELECT * FROM nhanvien LIMIT $start, $limit";
$result = $conn->query($sql);
?>

<!-- Modal Thêm nhân viên -->
<div class="modal fade" id="addemployee" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Thêm nhân viên</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="nhanvien.php" method="POST">
        <div class="modal-body">
            <div class="form-group">
                <label>Mã nhân viên</label>
                <input type="text" name="manv" class="form-control" placeholder="Vui lòng nhập mã nhân viên" required>
            </div>
            <div class="form-group">
                <label>Họ tên nhân viên</label>
                <input type="text" name="tennv" class="form-control" placeholder="Vui lòng nhập họ tên" required>
            </div>
            <div class="form-group">
                <label>Giới tính</label>
                <input type="text" name="gioitinh" class="form-control" placeholder="" required>
            </div>
            <div class="form-group">
                <label>Số điện thoại</label>
                <input type="text" name="sdt" class="form-control" placeholder="" required>
            </div>
            <div class="form-group">
                <label>Địa chỉ</label>
                <input type="text" name="diachi" class="form-control" placeholder="" required>
            </div>
            <div class="form-group">
                <label>Ngày vào làm</label>
                <input type="date" name="ngvl" class="form-control" placeholder="" required>
            </div>
            <div class="form-group">
                <label>Loại nhân viên</label>
                <input type="text" name="loainv" class="form-control" placeholder="" required>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
            <button type="submit" name="registerbtn" class="btn btn-primary">Lưu</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Sửa Nhân Viên -->
<div class="modal fade" id="editEmployeeModal" tabindex="-1" role="dialog" aria-labelledby="editEmployeeLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editEmployeeLabel">Sửa nhân viên</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="nhanvien.php" method="POST" id="editEmployeeForm">
        <div class="modal-body">
            <input type="hidden" name="manv" id="edit_manv">
            <div class="form-group">
                <label>Họ tên nhân viên</label>
                <input type="text" name="tennv" id="edit_tennv" class="form-control" placeholder="Vui lòng nhập họ tên">
            </div>
            <div class="form-group">
                <label>Giới tính</label>
                <input type="text" name="gioitinh" id="edit_gioitinh" class="form-control" placeholder="">
            </div>
            <div class="form-group">
                <label>Số điện thoại</label>
                <input type="text" name="sdt" id="edit_sdt" class="form-control" placeholder="">
            </div>
            <div class="form-group">
                <label>Địa chỉ</label>
                <input type="text" name="diachi" id="edit_diachi" class="form-control" placeholder="">
            </div>
            <div class="form-group">
                <label>Ngày vào làm</label>
                <input type="date" name="ngvl" id="edit_ngvl" class="form-control" placeholder="">
            </div>
            <div class="form-group">
                <label>Loại nhân viên</label>
                <input type="text" name="loainv" id="edit_loainv" class="form-control" placeholder="">
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
            <button type="submit" name="update_employee" class="btn btn-primary">Lưu</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="container-fluid">

<!-- DataTales Example -->
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">Thông tin nhân viên
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addemployee" style="background:#447FC2; border:none;">
          Thêm nhân viên mới
        </button>
    </h6>
    <?php
    if (isset($_POST['registerbtn'])) {
        $manv = $_POST['manv'];
        $tennv = $_POST['tennv'];
        $gioitinh = $_POST['gioitinh'];
        $sdt = $_POST['sdt'];
        $diachi = $_POST['diachi'];
        $ngvl = $_POST['ngvl'];
        $loainv = $_POST['loainv'];

        $sql = "INSERT INTO nhanvien (MaNV, TenNV, GioiTinh, SDT, DiaChi, NgVL, LoaiNV) VALUES ('$manv', '$tennv', '$gioitinh', '$sdt', '$diachi', '$ngvl', '$loainv')";
        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Thêm nhân viên mới thành công'); window.location.href='nhanvien.php';</script>";
        } else {
            echo "Lỗi: " . $sql . "<br>" . $conn->error;
        }
    }
    ?>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead style="background-color: #447FC2; color: white;">
          <tr>
            <th>Mã nhân viên</th>
            <th>Họ tên</th>
            <th>Giới tính</th>
            <th>Số điện thoại</th>
            <th>Địa chỉ</th>
            <th>Ngày vào làm</th>
            <th>Loại nhân viên</th>
            <th>Sửa</th>
            <th>Xóa</th>
          </tr>
        </thead>
        <tbody>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['MaNV'] . "</td>";
                echo "<td>" . $row['TenNV'] . "</td>";
                echo "<td>" . $row['GioiTinh'] . "</td>";
                echo "<td>" . $row['SDT'] . "</td>";
                echo "<td>" . $row['DiaChi'] . "</td>";
                echo "<td>" . $row['NgVL'] . "</td>";
                echo "<td>" . $row['LoaiNV'] . "</td>";
                echo "<td>
                    <button type='button' class='btn btn-success editBtn' data-id='" . $row['MaNV'] . "' data-ten='" . $row['TenNV'] . "' data-gioitinh='" . $row['GioiTinh'] . "' data-sdt='" . $row['SDT'] . "' data-diachi='" . $row['DiaChi'] . "' data-ngvl='" . $row['NgVL'] . "' data-loainv='" . $row['LoaiNV'] . "'>Sửa</button>
                  </td>";
                echo "<td>
                    <button type='button' class='btn btn-danger deleteBtn' data-id='" . $row['MaNV'] . "' data-toggle='modal' data-target='#deleteModal'>Xóa</button>
                  </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='9'>Không có nhân viên</td></tr>";
        }
        ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

</div>
<!-- /.container-fluid -->

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteModalLabel">Xác nhận xóa</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="nhanvien.php" method="POST">
        <div class="modal-body">
          <p>Bạn có chắc chắn muốn xóa nhân viên này không?</p>
          <input type="hidden" name="delete_id" id="delete_id">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
          <button type="submit" name="delete_btn" class="btn btn-danger">Xóa</button>
        </div>
      </form>
    </div>
  </div>
</div>

<style>
.pagination {
    display: flex;
    justify-content: center;
    margin: 20px 0;
}

.pagination a {
    margin: 0 10px;
    padding: 10px 20px;
    text-decoration: none;
    color: black;
    border: 1px solid #ddd;
}

.pagination a.active {
    background-color: #1361BA;
    color: white;
    border: 1px solid #1361BA;
}

.pagination a:hover:not(.active) {
    background-color: #ddd;
}
</style>

<!-- Hiển thị nút phân trang -->
<div class="pagination">
    <?php for ($i = 1; $i <= $pages; $i++) : ?>
        <a href="nhanvien.php?page=<?= $i; ?>" class="<?= ($page == $i) ? 'active' : ''; ?>"><?= $i; ?></a>
    <?php endfor; ?>
</div>

<?php
include('includes/scripts.php');
include('includes/footer.php');
?>

<script>
$(document).ready(function() {
    $('.editBtn').on('click', function() {
        $('#editEmployeeModal').modal('show');

        var manv = $(this).data('id');
        var tennv = $(this).data('ten');
        var gioitinh = $(this).data('gioitinh');
        var sdt = $(this).data('sdt');
        var diachi = $(this).data('diachi');
        var ngvl = $(this).data('ngvl');
        var loainv = $(this).data('loainv');

        $('#edit_manv').val(manv);
        $('#edit_tennv').val(tennv);
        $('#edit_gioitinh').val(gioitinh);
        $('#edit_sdt').val(sdt);
        $('#edit_diachi').val(diachi);
        $('#edit_ngvl').val(ngvl);
        $('#edit_loainv').val(loainv);
    });

    $('.deleteBtn').on('click', function() {
        var delete_id = $(this).data('id');
        $('#delete_id').val(delete_id);
    });
});
</script>

<?php


// Xóa nhân viên
if (isset($_POST['delete_btn'])) {
    $manv = $_POST['delete_id'];
    $sql = "DELETE FROM nhanvien WHERE MaNV='$manv'";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Xóa nhân viên thành công'); window.location.href='nhanvien.php';</script>";
    } else {
        echo "Lỗi: " . $conn->error;
    }
}

// Sửa nhân viên
if (isset($_POST['update_employee'])) {
    $manv = $_POST['manv'];
    $tennv = $_POST['tennv'];
    $gioitinh = $_POST['gioitinh'];
    $sdt = $_POST['sdt'];
    $diachi = $_POST['diachi'];
    $ngvl = $_POST['ngvl'];
    $loainv = $_POST['loainv'];

    $sql = "UPDATE nhanvien SET TenNV='$tennv', GioiTinh='$gioitinh', SDT='$sdt', DiaChi='$diachi', NgVL='$ngvl', LoaiNV='$loainv' WHERE MaNV='$manv'";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Cập nhật nhân viên thành công'); window.location.href='nhanvien.php';</script>";
    } else {
        echo "Lỗi: " . $conn->error;
    }
}

$conn->close();
?>
