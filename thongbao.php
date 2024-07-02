<?php
include('includes/header.php'); 
include('includes/navbar.php'); 
include('includes/db.php');

// Pagination
$limit = 8;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($page - 1) * $limit;

$result = $conn->query("SELECT COUNT(MaTB) AS MaTB FROM ThongBao");
$tbCount = $result->fetch_all(MYSQLI_ASSOC);
$total = $tbCount[0]['MaTB'];
$pages = ceil($total / $limit);

$sql = "SELECT * FROM ThongBao LIMIT $start, $limit";
$result = $conn->query($sql);
?>

<!-- Modal Thêm Thông Báo -->
<div class="modal fade" id="addNotification" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Thêm Thông Báo</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="thongbao.php" method="POST">
        <div class="modal-body">
            <div class="form-group">
                <label>Mã Thông Báo</label>
                <input type="text" name="matb" class="form-control" placeholder="Vui lòng nhập mã thông báo" required>
            </div>
            <div class="form-group">
                <label>Loại Thông Báo</label>
                <input type="text" name="loaitb" class="form-control" placeholder="Vui lòng nhập loại thông báo" required>
            </div>
            <div class="form-group">
                <label>Tiêu Đề</label>
                <input type="text" name="tieude" class="form-control" placeholder="Vui lòng nhập tiêu đề" required>
            </div>
            <div class="form-group">
                <label>Nội Dung</label>
                <textarea name="noidung" class="form-control" placeholder="Vui lòng nhập nội dung" required></textarea>
            </div>
            <div class="form-group">
                <label>Ngày Thông Báo</label>
                <input type="datetime-local" name="ngtb" class="form-control" required>
            </div>
            <div class="form-group">
              <label>Mã Cư Dân</label>
              <input type="text" name="macd" id="edit_macd" class="form-control" required>
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



<!-- Modal Sửa Thông Báo -->
<div class="modal fade" id="editNotificationModal" tabindex="-1" role="dialog" aria-labelledby="editNotificationModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editNotificationModalLabel">Sửa Thông Báo</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="thongbao.php" method="POST">
        <div class="modal-body">
            <div class="form-group">
                <label>Mã Thông Báo</label>
                <input type="text" name="matb" id="edit_matb" class="form-control" readonly>
            </div>
            <div class="form-group">
                <label>Loại Thông Báo</label>
                <input type="text" name="loaitb" id="edit_loaitb" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Tiêu Đề</label>
                <input type="text" name="tieude" id="edit_tieude" class="form-control" required>
            </div> 
            <div class="form-group">
                <label>Nội Dung</label>
                <textarea name="noidung" id="edit_noidung" class="form-control" required></textarea>
            </div>
            <div class="form-group">
                <label>Ngày Thông Báo</label>
                <input type="datetime-local" name="ngtb" id="edit_ngtb" class="form-control" required>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
            <button type="submit" name="update_notification" class="btn btn-primary">Lưu</button>
        </div>
      </form>
    </div>
  </div>
</div>


<!-- DataTales Example -->
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">Thông Tin Thông Báo
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addNotification" style="background:#447FC2; border:none;">
          Thêm Thông Báo Mới
        </button>
    </h6>
    <?php
    if (isset($_POST['registerbtn'])) {
        $matb = $_POST['matb'];
        $loaitb = $_POST['loaitb'];
        $tieude = $_POST['tieude'];
        $noidung = $_POST['noidung'];
        $ngtb = $_POST['ngtb'];
        $macd = $_POST['macd']; // Lấy mã cư dân từ form
    
        // Thêm thông báo vào bảng ThongBao
        $sql = "INSERT INTO ThongBao (MaTB, LoaiTB, TieuDe, NoiDung, NgTB) 
                VALUES ('$matb', '$loaitb', '$tieude', '$noidung', '$ngtb')";
    
        if ($conn->query($sql) === TRUE) {
            // Nếu thêm thông báo thành công, thêm mã cư dân và mã thông báo vào bảng TB_CD
            $sql = "INSERT INTO TB_CD (MaTB, MaCD) VALUES ('$matb', '$macd')";
    
            if ($conn->query($sql) === TRUE) {
                echo "<script>alert('Thêm thông báo mới thành công'); window.location.href='thongbao.php';</script>";
            } else {
                echo "Lỗi khi thêm vào bảng TB_CD: " . $conn->error;
            }
        } else {
            echo "Lỗi khi thêm vào bảng ThongBao: " . $conn->error;
        }
    }
    ?>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead style="background-color: #447FC2; color: white;">
          <tr>
            <th>Mã Thông Báo</th>
            <th>Loại</th>
            <th>Tiêu Đề</th>
            <th>Nội Dung</th>
            <th>Ngày Thông Báo</th>
            <th>Sửa</th>
            <th>Xóa</th>
          </tr>
        </thead>
        <tbody>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['MaTB'] . "</td>";
                echo "<td>" . $row['LoaiTB'] . "</td>";
                echo "<td>" . $row['TieuDe'] . "</td>";
                echo "<td>" . $row['NoiDung'] . "</td>";
                echo "<td>" . $row['NgTB'] . "</td>";
                echo "<td>
                    <button type='button' class='btn btn-success editBtn' data-id='" . $row['MaTB'] . "' data-loai='" . $row['LoaiTB'] . "' data-tieu='" . $row['TieuDe'] . "' data-noi='" . $row['NoiDung'] . "' data-ngtb='" . $row['NgTB'] . "'>Sửa</button>
                  </td>";
                echo "<td>
                    <button type='button' class='btn btn-danger deleteBtn' data-id='" . $row['MaTB'] . "' data-toggle='modal' data-target='#deleteModal'>Xóa</button>
                  </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='7'>Không có thông báo</td></tr>";
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
      <form action="thongbao.php" method="POST">
        <div class="modal-body">
          <p>Bạn có chắc chắn muốn xóa thông báo này không?</p>
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
        <a href="thongbao.php?page=<?= $i; ?>" class="<?= ($page == $i) ? 'active' : ''; ?>"><?= $i; ?></a>
    <?php endfor; ?>
</div>

<?php
include('includes/scripts.php');
include('includes/footer.php');
?>

<script>
$(document).ready(function() {
    $('.editBtn').on('click', function() {
        $('#editNotificationModal').modal('show');

        var matb = $(this).data('id');
        var loaitb = $(this).data('loai');
        var tieude = $(this).data('tieu');
        var noidung = $(this).data('noi');
        var ngtb = $(this).data('ngtb');

        $('#edit_matb').val(matb);
        $('#edit_loaitb').val(loaitb);
        $('#edit_tieude').val(tieude);
        $('#edit_noidung').val(noidung);
        $('#edit_ngtb').val(ngtb);
    });

    $('.deleteBtn').on('click', function() {
        var delete_id = $(this).data('id');
        $('#delete_id').val(delete_id);
    });
});
</script>

<?php
// Xóa thông báo
if (isset($_POST['delete_btn'])) {
    $matb = $_POST['delete_id'];
    $sql = "DELETE FROM ThongBao WHERE MaTB='$matb'";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Xóa thông báo thành công'); window.location.href='thongbao.php';</script>";
    } else {
        echo "Lỗi: " . $conn->error;
    }
}

// Sửa thông báo
if (isset($_POST['update_notification'])) {
    $matb = $_POST['matb'];
    $loaitb = $_POST['loaitb'];
    $tieude = $_POST['tieude'];
    $noidung = $_POST['noidung'];
    $ngtb = $_POST['ngtb'];

    $sql = "UPDATE ThongBao SET LoaiTB='$loaitb', TieuDe='$tieude', NoiDung='$noidung', NgTB='$ngtb' WHERE MaTB='$matb'";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Cập nhật thông báo thành công'); window.location.href='thongbao.php';</script>";
    } else {
        echo "Lỗi: " . $conn->error;
    }
}

$conn->close();
?>
