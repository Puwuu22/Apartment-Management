<?php
include('includes/header.php'); 
include('includes/navbar.php'); 
include('includes/db.php');

// Pagination
$limit = 8;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($page - 1) * $limit;

$result = $conn->query("SELECT COUNT(MaDV) AS MaDV FROM dichvu");
$serviceCount = $result->fetch_all(MYSQLI_ASSOC);
$total = $serviceCount[0]['MaDV'];
$pages = ceil($total / $limit);

$sql = "SELECT * FROM dichvu LIMIT $start, $limit";
$result = $conn->query($sql);
?>

<!-- Modal Thêm dịch vụ -->
<div class="modal fade" id="addService" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Thêm dịch vụ</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="dichvu.php" method="POST">
        <div class="modal-body">
            <div class="form-group">
                <label>Mã dịch vụ</label>
                <input type="text" name="madv" class="form-control" placeholder="Vui lòng nhập mã dịch vụ">
            </div>
            <div class="form-group">
                <label>Tên dịch vụ</label>
                <input type="text" name="tendv" class="form-control" placeholder="Vui lòng nhập tên dịch vụ">
            </div>
            <div class="form-group">
                <label>Phí dịch vụ</label>
                <input type="text" name="phidv" class="form-control" placeholder="Vui lòng nhập phí dịch vụ">
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

<!-- Modal Sửa Dịch Vụ -->
<div class="modal fade" id="editServiceModal" tabindex="-1" role="dialog" aria-labelledby="editServiceLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editServiceLabel">Sửa dịch vụ</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="dichvu.php" method="POST" id="editServiceForm">
        <div class="modal-body">
            <input type="hidden" name="madv" id="edit_madv">
            <div class="form-group">
                <label>Tên dịch vụ</label>
                <input type="text" name="tendv" id="edit_tendv" class="form-control" placeholder="Vui lòng nhập tên dịch vụ">
            </div>
            <div class="form-group">
                <label>Phí dịch vụ</label>
                <input type="text" name="phidv" id="edit_phidv" class="form-control" placeholder="Vui lòng nhập phí dịch vụ">
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
            <button type="submit" name="update_service" class="btn btn-primary">Lưu</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="container-fluid">

<!-- DataTales Example -->
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">Thông tin dịch vụ
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addService" style="background:#447FC2; border:none;">
          Thêm dịch vụ mới
        </button>
    </h6>
    <?php
    if (isset($_POST['registerbtn'])) {
        $madv = $_POST['madv'];
        $tendv = $_POST['tendv'];
        $phidv = $_POST['phidv'];

        $sql = "INSERT INTO dichvu (MaDV, TenDV, PhiDV) VALUES ('$madv', '$tendv', '$phidv')";
        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Thêm dịch vụ mới thành công'); window.location.href='dichvu.php';</script>";
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
            <th>Mã dịch vụ</th>
            <th>Tên dịch vụ</th>
            <th>Phí dịch vụ</th>
            <th>Sửa</th>
            <th>Xóa</th>
          </tr>
        </thead>
        <tbody>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['MaDV'] . "</td>";
                echo "<td>" . $row['TenDV'] . "</td>";
                echo "<td>" . $row['PhiDV'] . "</td>";
                echo "<td>
                    <button type='button' class='btn btn-success editBtn' data-id='" . $row['MaDV'] . "' data-ten='" . $row['TenDV'] . "' data-phi='" . $row['PhiDV'] . "'>Sửa</button>
                  </td>";
                echo "<td>
                    <button type='button' class='btn btn-danger deleteBtn' data-id='" . $row['MaDV'] . "' data-toggle='modal' data-target='#deleteModal'>Xóa</button>
                  </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>Không có dịch vụ</td></tr>";
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
      <form action="dichvu.php" method="POST">
        <div class="modal-body">
          <p>Bạn có chắc chắn muốn xóa dịch vụ này không?</p>
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
        <a href="dichvu.php?page=<?= $i; ?>" class="<?= ($page == $i) ? 'active' : ''; ?>"><?= $i; ?></a>
    <?php endfor; ?>
</div>

<?php
include('includes/scripts.php');
include('includes/footer.php');
?>

<script>
$(document).ready(function() {
    $('.editBtn').on('click', function() {
        $('#editServiceModal').modal('show');

        var madv = $(this).data('id');
        var tendv = $(this).data('ten');
        var phidv = $(this).data('phi');

        $('#edit_madv').val(madv);
        $('#edit_tendv').val(tendv);
        $('#edit_phidv').val(phidv);
    });

    $('.deleteBtn').on('click', function() {
        var delete_id = $(this).data('id');
        $('#delete_id').val(delete_id);
    });
});
</script>

<?php
// Xử lý thêm dịch vụ mới
if (isset($_POST['registerbtn'])) {
    $madv = $_POST['madv'];
    $tendv = $_POST['tendv'];
    $phidv = $_POST['phidv'];

    $sql = "INSERT INTO dichvu (MaDV, TenDV, PhiDV) VALUES ('$madv', '$tendv', '$phidv')";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Thêm dịch vụ mới thành công'); window.location.href='dichvu.php';</script>";
    } else {
        echo "Lỗi: " . $sql . "<br>" . $conn->error;
    }
}

// Xóa dịch vụ
if (isset($_POST['delete_btn'])) {
    $madv = $_POST['delete_id'];
    $sql = "DELETE FROM dichvu WHERE MaDV='$madv'";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Xóa dịch vụ thành công'); window.location.href='dichvu.php';</script>";
    } else {
        echo "Lỗi: " . $conn->error;
    }
}

// Sửa dịch vụ
if (isset($_POST['update_service'])) {
    $madv = $_POST['madv'];
    $tendv = $_POST['tendv'];
    $phidv = $_POST['phidv'];

    $sql = "UPDATE dichvu SET TenDV='$tendv', PhiDV='$phidv' WHERE MaDV='$madv'";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Cập nhật dịch vụ thành công'); window.location.href='dichvu.php';</script>";
    } else {
        echo "Lỗi: " . $conn->error;
    }
}

$conn->close();
?>
