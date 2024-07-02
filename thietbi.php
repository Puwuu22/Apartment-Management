<?php
include('includes/header.php'); 
include('includes/navbar.php'); 
include('includes/db.php');

// Pagination
$limit = 8;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($page - 1) * $limit;

$result = $conn->query("SELECT COUNT(MaTBi) AS MaTBi FROM ThietBi");
$deviceCount = $result->fetch_all(MYSQLI_ASSOC);
$total = $deviceCount[0]['MaTBi'];
$pages = ceil($total / $limit);

$sql = "SELECT ThietBi.MaTBi, ThietBi.TenTBi, ThietBi.SL, BoTri.MaTang, BoTri.SL AS BoTriSL
        FROM ThietBi 
        LEFT JOIN BoTri ON ThietBi.MaTBi = BoTri.MaTBi 
        LIMIT $start, $limit";
$result = $conn->query($sql);
?>

<!-- Modal Thêm Thiết Bị -->
<div class="modal fade" id="adddevice" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Thêm thiết bị</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="thietbi.php" method="POST">
        <div class="modal-body">
            <div class="form-group">
                <label>Mã thiết bị</label>
                <input type="text" name="matbi" class="form-control" placeholder="Vui lòng nhập mã thiết bị">
            </div>
            <div class="form-group">
                <label>Tên thiết bị</label>
                <input type="text" name="tentbi" class="form-control" placeholder="Vui lòng nhập tên thiết bị">
            </div>
            <div class="form-group">
                <label>Số lượng</label>
                <input type="number" name="sl" class="form-control" placeholder="Vui lòng nhập số lượng">
            </div>
            <div class="form-group">
                <label>Mã tầng</label>
                <input type="text" name="matang" class="form-control" placeholder="Vui lòng nhập mã tầng">
            </div>
            <div class="form-group">
                <label>Số lượng bố trí</label>
                <input type="number" name="botri_sl" class="form-control" placeholder="Vui lòng nhập số lượng bố trí">
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

<!-- Modal Sửa Thiết Bị -->
<div class="modal fade" id="editDeviceModal" tabindex="-1" role="dialog" aria-labelledby="editDeviceLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editDeviceLabel">Sửa thiết bị</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="thietbi.php" method="POST" id="editDeviceForm">
        <div class="modal-body">
            <input type="hidden" name="matbi" id="edit_matbi">
            <div class="form-group">
                <label>Tên thiết bị</label>
                <input type="text" name="tentbi" id="edit_tentbi" class="form-control" placeholder="Vui lòng nhập tên thiết bị">
            </div>
            <div class="form-group">
                <label>Số lượng</label>
                <input type="number" name="sl" id="edit_sl" class="form-control" placeholder="Vui lòng nhập số lượng">
            </div>
            <div class="form-group">
                <label>Mã tầng</label>
                <input type="text" name="matang" id="edit_matang" class="form-control" placeholder="Vui lòng nhập mã tầng">
            </div>
            <div class="form-group">
                <label>Số lượng bố trí</label>
                <input type="number" name="botri_sl" id="edit_botri_sl" class="form-control" placeholder="Vui lòng nhập số lượng bố trí">
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
            <button type="submit" name="update_device" class="btn btn-primary">Lưu</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="container-fluid">

<!-- DataTales Example -->
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">Thông tin thiết bị
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#adddevice" style="background:#447FC2; border:none;">
          Thêm thiết bị mới
        </button>
    </h6>
    <?php
    if (isset($_POST['registerbtn'])) {
        $matbi = $_POST['matbi'];
        $tentbi = $_POST['tentbi'];
        $sl = $_POST['sl'];
        $matang = $_POST['matang'];
        $botri_sl = $_POST['botri_sl'];

        $sql1 = "INSERT INTO ThietBi (MaTBi, TenTBi, SL) VALUES ('$matbi', '$tentbi', $sl)";
        $sql2 = "INSERT INTO BoTri (MaTBi, MaTang, SL) VALUES ('$matbi', '$matang', $botri_sl')";
        if ($conn->query($sql1) === TRUE && $conn->query($sql2) === TRUE) {
            echo "<script>alert('Thêm thiết bị mới thành công'); window.location.href='thietbi.php';</script>";
        } else {
            echo "Lỗi: " . $sql1 . "<br>" . $conn->error;
        }
    }
    ?>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead style="background-color: #447FC2; color: white;">
          <tr>
            <th>Mã thiết bị</th>
            <th>Tên thiết bị</th>
            <th>Số lượng</th>
            <th>Mã tầng</th>
            <th>Số lượng bố trí</th>
            <th>Sửa</th>
            <th>Xóa</th>
          </tr>
        </thead>
        <tbody>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['MaTBi'] . "</td>";
                echo "<td>" . $row['TenTBi'] . "</td>";
                echo "<td>" . $row['SL'] . "</td>";
                echo "<td>" . $row['MaTang'] . "</td>";
                echo "<td>" . $row['BoTriSL'] . "</td>";
                echo "<td>
                    <button type='button' class='btn btn-success editBtn' data-id='" . $row['MaTBi'] . "' data-ten='" . $row['TenTBi'] . "' data-sl='" . $row['SL'] . "' data-matang='" . $row['MaTang'] . "' data-botri_sl='" ."'>Sửa</button>
                  </td>";
                echo "<td>
                    <button type='button' class='btn btn-danger deleteBtn' data-id='" . $row['MaTBi'] . "' data-toggle='modal' data-target='#deleteModal'>Xóa</button>
                  </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='8'>Không có thiết bị</td></tr>";
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
      <form action="thietbi.php" method="POST">
        <div class="modal-body">
          <p>Bạn có chắc chắn muốn xóa thiết bị này không?</p>
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
        <a href="thietbi.php?page=<?= $i; ?>" class="<?= ($page == $i) ? 'active' : ''; ?>"><?= $i; ?></a>
    <?php endfor; ?>
</div>

<?php
include('includes/scripts.php');
include('includes/footer.php');
?>

<script>
$(document).ready(function() {
    $('.editBtn').on('click', function() {
        $('#editDeviceModal').modal('show');

        var matbi = $(this).data('id');
        var tentbi = $(this).data('ten');
        var sl = $(this).data('sl');
        var matang = $(this).data('matang');
        var botri_sl = $(this).data('botri_sl');

        $('#edit_matbi').val(matbi);
        $('#edit_tentbi').val(tentbi);
        $('#edit_sl').val(sl);
        $('#edit_matang').val(matang);
        $('#edit_botri_sl').val(botri_sl);
    });

    $('.deleteBtn').on('click', function() {
        var delete_id = $(this).data('id');
        $('#delete_id').val(delete_id);
    });
});
</script>

<?php
// Xử lý thêm thiết bị mới
if (isset($_POST['registerbtn'])) {
    $matbi = $_POST['matbi'];
    $tentbi = $_POST['tentbi'];
    $sl = $_POST['sl'];
    $matang = $_POST['matang'];
    $botri_sl = $_POST['botri_sl'];

    $sql1 = "INSERT INTO ThietBi (MaTBi, TenTBi, SL) VALUES ('$matbi', '$tentbi', $sl)";
    $sql2 = "INSERT INTO BoTri (MaTBi, MaTang, SL) VALUES ('$matbi', '$matang', $botri_sl)";
    if ($conn->query($sql1) === TRUE && $conn->query($sql2) === TRUE) {
        echo "<script>alert('Thêm thiết bị mới thành công'); window.location.href='thietbi.php';</script>";
    } else {
        echo "Lỗi: " . $sql1 . "<br>" . $conn->error;
    }
}

// Xóa thiết bị
if (isset($_POST['delete_btn'])) {
    $matbi = $_POST['delete_id'];
    $sql1 = "DELETE FROM ThietBi WHERE MaTBi='$matbi'";
    $sql2 = "DELETE FROM BoTri WHERE MaTBi='$matbi'";
    if ($conn->query($sql1) === TRUE && $conn->query($sql2) === TRUE) {
        echo "<script>alert('Xóa thiết bị thành công'); window.location.href='thietbi.php';</script>";
    } else {
        echo "Lỗi: " . $conn->error;
    }
}

// Sửa thiết bị
if (isset($_POST['update_device'])) {
    $matbi = $_POST['matbi'];
    $tentbi = $_POST['tentbi'];
    $sl = $_POST['sl'];
    $matang = $_POST['matang'];
    $botri_sl = $_POST['botri_sl'];

    $sql1 = "UPDATE ThietBi SET TenTBi='$tentbi', SL=$sl WHERE MaTBi='$matbi'";
    $sql2 = "UPDATE BoTri SET MaTang='$matang', SL=$botri_sl WHERE MaTBi='$matbi'";
    if ($conn->query($sql1) === TRUE && $conn->query($sql2) === TRUE) {
        echo "<script>alert('Cập nhật thiết bị thành công'); window.location.href='thietbi.php';</script>";
    } else {
        echo "Lỗi: " . $conn->error;
    }
}

$conn->close();
?>
