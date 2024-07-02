<?php
include('includes/header.php'); 
include('includes/navbar.php'); 
include('includes/db.php');

// Pagination
$limit = 8;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($page - 1) * $limit;

$result = $conn->query("SELECT COUNT(MaHD) AS MaHD FROM PhuTrach");
$empCount = $result->fetch_all(MYSQLI_ASSOC);
$total = $empCount[0]['MaHD'];
$pages = ceil($total / $limit);

$sql = "SELECT pt.MaHD, hd.TenHD, pt.MaNV, nv.TenNV
        FROM PhuTrach pt
        INNER JOIN NhanVien nv ON pt.MaNV = nv.MaNV
        INNER JOIN HoaDon hd ON pt.MaHD = hd.MaHD
        LIMIT $start, $limit";
$result = $conn->query($sql);

?>


<!-- Modal Thêm phụ trách -->
<div class="modal fade" id="addphutrach" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Thêm phụ trách</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="phutrach.php" method="POST">
        <div class="modal-body">
            <div class="form-group">
                <label>Mã hóa đơn</label>
                <input type="text" name="mahd" class="form-control" placeholder="Vui lòng nhập mã hóa đơn">
            </div>
            <div class="form-group">
                <label>Mã nhân viên</label>
                <input type="text" name="manv" class="form-control" placeholder="Vui lòng nhập mã nhân viên">
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

<div class="container-fluid">

<!-- DataTales Example -->
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">Thông tin phụ trách
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addphutrach" style="background:#447FC2; border:none;">
          Thêm phụ trách mới
        </button>
    </h6>
    <?php
    if (isset($_POST['registerbtn'])) {
        $mahd = $_POST['mahd'];
        $manv = $_POST['manv'];

        $sql = "INSERT INTO PhuTrach (MaHD, MaNV) VALUES ('$mahd', '$manv')";
        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Thêm phụ trách mới thành công'); window.location.href='phutrach.php';</script>";
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
            <th>Mã hóa đơn</th>
            <th>Tên hóa đơn</th>
            <th>Mã nhân viên</th>
            <th>Tên nhân viên</th>
            <th>Sửa</th>
            <th>Xóa</th>
          </tr>
        </thead>
        <tbody>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['MaHD'] . "</td>";
                echo "<td>" . $row['TenHD'] . "</td>";
                echo "<td>" . $row['MaNV'] . "</td>";
                echo "<td>" . $row['TenNV'] . "</td>";
                echo "<td>
                    <button type='button' class='btn btn-success editBtn' data-mahd='" . $row['MaHD'] . "' data-manv='" . $row['MaNV'] . "'>Sửa</button>
                  </td>";
                echo "<td>
                    <button type='button' class='btn btn-danger deleteBtn' data-mahd='" . $row['MaHD'] . "' data-manv='" . $row['MaNV'] . "' data-toggle='modal' data-target='#deleteModal'>Xóa</button>
                  </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>Không có phụ trách</td></tr>";
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
      <form action="phutrach.php" method="POST">
        <div class="modal-body">
          <p>Bạn có chắc chắn muốn xóa phụ trách này không?</p>
          <input type="hidden" name="delete_mahd" id="delete_mahd">
          <input type="hidden" name="delete_manv" id="delete_manv">
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
        <a href="phutrach.php?page=<?= $i; ?>" class="<?= ($page == $i) ? 'active' : ''; ?>"><?= $i; ?></a>
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

        var mahd = $(this).data('mahd');
        var manv = $(this).data('manv');

        $('#edit_mahd').val(mahd);
        $('#edit_manv').val(manv);
    });

    $('.deleteBtn').on('click', function() {
        var mahd = $(this).data('mahd');
        var manv = $(this).data('manv');
        $('#delete_mahd').val(mahd);
        $('#delete_manv').val(manv);
    });
});
</script>

<?php
// Xử lý thêm phụ trách mới
if (isset($_POST['registerbtn'])) {
    $mahd = $_POST['mahd'];
    $manv = $_POST['manv'];

    $sql = "INSERT INTO PhuTrach (MaHD, MaNV) VALUES ('$mahd', '$manv')";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Thêm phụ trách mới thành công'); window.location.href='phutrach.php';</script>";
    } else {
        echo "Lỗi: " . $sql . "<br>" . $conn->error;
    }
}

// Xóa phụ trách
if (isset($_POST['delete_btn'])) {
    $mahd = $_POST['delete_mahd'];
    $manv = $_POST['delete_manv'];
    $sql = "DELETE FROM PhuTrach WHERE MaHD='$mahd' AND MaNV='$manv'";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Xóa phụ trách thành công'); window.location.href='phutrach.php';</script>";
    } else {
        echo "Lỗi: " . $conn->error;
    }
}

// Sửa phụ trách
if (isset($_POST['update_phutrach'])) {
    $mahd = $_POST['edit_mahd'];
    $manv = $_POST['edit_manv'];

    $sql = "UPDATE PhuTrach SET MaNV='$manv' WHERE MaHD='$mahd'";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Cập nhật phụ trách thành công'); window.location.href='phutrach.php';</script>";
    } else {
        echo "Lỗi: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!-- Modal Sửa phụ trách -->
<div class="modal fade" id="editEmployeeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Sửa phụ trách</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="phutrach.php" method="POST">
        <div class="modal-body">
            <div class="form-group">
                <label>Mã hóa đơn</label>
                <input type="text" name="edit_mahd" id="edit_mahd" class="form-control" readonly>
            </div>
            <div class="form-group">
                <label>Mã nhân viên</label>
                <input type="text" name="edit_manv" id="edit_manv" class="form-control" placeholder="Vui lòng nhập mã nhân viên">
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
            <button type="submit" name="update_phutrach" class="btn btn-primary">Lưu</button>
        </div>
      </form>
    </div>
  </div>
</div>
