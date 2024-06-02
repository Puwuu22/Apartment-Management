<?php
include('includes/header.php'); 
include('includes/navbar.php'); 
include('includes/db.php');

// Số cư dân mỗi trang
$limit = 5;

// Lấy trang hiện tại từ URL, nếu không có mặc định là trang 1
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($page - 1) * $limit;

// Truy vấn tổng số cư dân
$result = $conn->query("SELECT COUNT(MaCD) AS MaCD FROM cudan");
$custCount = $result->fetch_all(MYSQLI_ASSOC);
$total = $custCount[0]['MaCD'];

// Tính toán tổng số trang
$pages = ceil($total / $limit);

// Truy vấn danh sách cư dân với giới hạn và bắt đầu
$sql = "SELECT * FROM cudan LIMIT $start, $limit";
$result = $conn->query($sql);
?>

<!-- Modal Thêm Cư Dân -->
<div class="modal fade" id="addadminprofile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Thêm cư dân</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="cudan.php" method="POST">

        <div class="modal-body">
            <div class="form-group">
                <label>Mã cư dân</label>
                <input type="id" name="macd" class="form-control" placeholder="VD: CD0001">
            </div>
            <div class="form-group">
                <label>Họ tên cư dân</label>
                <input type="text" name="tencd" class="form-control" placeholder="Vui lòng nhập họ tên">
            </div>
            <div class="form-group">
                <label>Giới tính</label>
                <input type="gender" name="gioitinh" class="form-control" placeholder="">
            </div>
            <div class="form-group">
                <label>Số điện thoại</label>
                <input type="text" name="sdt" class="form-control" placeholder="">
            </div>
            <div class="form-group">
                <label>Ngày sinh</label>
                <input type="date" name="ngsinh" class="form-control" placeholder="">
            </div>
            <div class="form-group">
                <label>Quê quán</label>
                <input type="text" name="quequan" class="form-control" placeholder="">
            </div>
            <div class="form-group">
                <label>Mã hộ</label>
                <input type="id" name="maho" class="form-control" placeholder="">
            </div>
            <div class="form-group">
                <label>Ngày vào ở</label>
                <input type="date" name="ngvaoo" class="form-control" placeholder="">
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

<!-- Modal Sửa Cư Dân -->
<div class="modal fade" id="editResidentModal" tabindex="-1" role="dialog" aria-labelledby="editResidentLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editResidentLabel">Sửa cư dân</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="cudan.php" method="POST" id="editResidentForm">

        <div class="modal-body">
            <input type="hidden" name="macd" id="edit_macd">
            <div class="form-group">
                <label>Họ tên cư dân</label>
                <input type="text" name="tencd" id="edit_tencd" class="form-control" placeholder="Vui lòng nhập họ tên">
            </div>
            <div class="form-group">
                <label>Giới tính</label>
                <input type="gender" name="gioitinh" id="edit_gioitinh" class="form-control" placeholder="">
            </div>
            <div class="form-group">
                <label>Số điện thoại</label>
                <input type="text" name="sdt" id="edit_sdt" class="form-control" placeholder="">
            </div>
            <div class="form-group">
                <label>Ngày sinh</label>
                <input type="date" name="ngsinh" id="edit_ngsinh" class="form-control" placeholder="">
            </div>
            <div class="form-group">
                <label>Quê quán</label>
                <input type="text" name="quequan" id="edit_quequan" class="form-control" placeholder="">
            </div>
            <div class="form-group">
                <label>Mã hộ</label>
                <input type="id" name="maho" id="edit_maho" class="form-control" placeholder="">
            </div>
            <div class="form-group">
                <label>Ngày vào ở</label>
                <input type="date" name="ngvaoo" id="edit_ngvaoo" class="form-control" placeholder="">
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
            <button type="submit" name="update_resident" class="btn btn-primary">Lưu</button>
        </div>
      </form>

    </div>
  </div>
</div>


<div class="container-fluid">

<!-- DataTales Example -->
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">Thông tin cư dân
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addadminprofile" style="background:#447FC2; border:none;">
              Thêm cư dân mới 
            </button>
    </h6>
  </div>
  <div class="card-body">

    <div class="table-responsive">
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead style="background-color: #447FC2; color: white;">
          <tr>
            <th>Mã cư dân</th>
            <th>Họ tên</th>
            <th>Giới tính</th>
            <th>Số điện thoại</th>
            <th>Ngày sinh</th>
            <th>Quê quán</th>
            <th>Mã hộ</th>
            <th>Ngày vào ở</th>
            <th>Sửa</th>
            <th>Xóa</th>
          </tr>
        </thead>
        <tbody>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['MaCD'] . "</td>";
                echo "<td>" . $row['TenCD'] . "</td>";
                echo "<td>" . $row['GioiTinh'] . "</td>";
                echo "<td>" . $row['SDT'] . "</td>";
                echo "<td>" . $row['NgSinh'] . "</td>";
                echo "<td>" . $row['QueQuan'] . "</td>";
                echo "<td>" . $row['MaHo'] . "</td>";
                echo "<td>" . $row['NgVaoO'] . "</td>";
                echo "<td>
                    <button type='button' class='btn btn-success editBtn' data-id='" . $row['MaCD'] . "' data-ten='" . $row['TenCD'] . "' data-gioitinh='" . $row['GioiTinh'] . "' data-sdt='" . $row['SDT'] . "' data-ngsinh='" . $row['NgSinh'] . "' data-quequan='" . $row['QueQuan'] . "' data-maho='" . $row['MaHo'] . "' data-ngvaoo='" . $row['NgVaoO'] . "'>Sửa</button>
                </td>";
                echo "<td>
                    <button type='button' class='btn btn-danger deleteBtn' data-toggle='modal' data-target='#deleteModal' data-id='" . $row['MaCD'] . "'>Xóa</button>
                </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='10'>Không có cư dân nào</td></tr>";
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
      <form action="cudan.php" method="POST">
        <div class="modal-body">
          <p>Bạn có chắc chắn muốn xóa cư dân này không?</p>
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
        <a href="cudan.php?page=<?= $i; ?>" class="<?= ($page == $i) ? 'active' : ''; ?>"><?= $i; ?></a>
    <?php endfor; ?>
</div>
<?php
include('includes/scripts.php');
include('includes/footer.php');
?>

<script>
$(document).ready(function() {
    $('.editBtn').on('click', function() {
        $('#editResidentModal').modal('show');

        var macd = $(this).data('id');
        var tencd = $(this).data('ten');
        var gioitinh = $(this).data('gioitinh');
        var sdt = $(this).data('sdt');
        var ngsinh = $(this).data('ngsinh');
        var quequan = $(this).data('quequan');
        var maho = $(this).data('maho');
        var ngvaoo = $(this).data('ngvaoo');

        $('#edit_macd').val(macd);
        $('#edit_tencd').val(tencd);
        $('#edit_gioitinh').val(gioitinh);
        $('#edit_sdt').val(sdt);
        $('#edit_ngsinh').val(ngsinh);
        $('#edit_quequan').val(quequan);
        $('#edit_maho').val(maho);
        $('#edit_ngvaoo').val(ngvaoo);
    });

    $('.deleteBtn').on('click', function() {
        var delete_id = $(this).data('id');
        $('#delete_id').val(delete_id);
    });
});
</script>


<?php
// Xóa cư dân
if (isset($_GET['delete'])) {
    $macd = $_GET['delete'];
    $sql = "DELETE FROM cudan WHERE MaCD='$macd'";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Xóa cư dân thành công'); window.location.href='cudan.php';</script>";
    } else {
        echo "Lỗi: " . $conn->error;
    }
}

// Sửa cư dân
if (isset($_POST['update_resident'])) {
    $macd = $_POST['macd'];
    $tencd = $_POST['tencd'];
    $gioitinh = $_POST['gioitinh'];
    $sdt = $_POST['sdt'];
    $ngsinh = $_POST['ngsinh'];
    $quequan = $_POST['quequan'];
    $maho = $_POST['maho'];
    $ngvaoo = $_POST['ngvaoo'];

    $sql = "UPDATE cudan SET TenCD='$tencd', GioiTinh='$gioitinh', SDT='$sdt', NgSinh='$ngsinh', QueQuan='$quequan', MaHo='$maho', NgVaoO='$ngvaoo' WHERE MaCD='$macd'";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Cập nhật cư dân thành công'); window.location.href='cudan.php';</script>";
    } else {
        echo "Lỗi: " . $conn->error;
    }
}

$conn->close();
?>
