<?php
include('includes/header.php'); 
include('includes/navbar.php'); 
include('includes/db.php');

// Pagination
$limit = 8;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($page - 1) * $limit;

$result = $conn->query("SELECT COUNT(MaPA) AS total FROM PhanAnh");
$reportCount = $result->fetch_assoc();
$total = $reportCount['total'];
$pages = ceil($total / $limit);

$sql = "SELECT * FROM PhanAnh LIMIT $start, $limit";
$result = $conn->query($sql);
?>

<div class="container-fluid">
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">Danh sách phản ánh</h6>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead style="background-color: #447FC2; color: white;">
          <tr>
            <th>Mã phản ánh</th>
            <th>Loại phản ánh</th>
            <th>Tiêu đề</th>
            <th>Nội dung</th>
            <th>Ngày phản ánh</th>
            <th>Tình trạng</th>
            <th>Sửa</th>
            <th>Xóa</th>
          </tr>
        </thead>
        <tbody>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['MaPA'] . "</td>";
                echo "<td>" . $row['LoaiPA'] . "</td>";
                echo "<td>" . $row['TieuDe'] . "</td>";
                echo "<td>" . $row['NoiDung'] . "</td>";
                echo "<td>" . $row['NgPA'] . "</td>";

                // Handle the switch statement separately
                $tinhTrang = '';
                switch ($row['TinhTrang']) {
                    case 1:
                        $tinhTrang = "Mới";
                        break;
                    case 2:
                        $tinhTrang = "Đang xử lý";
                        break;
                    case 3:
                        $tinhTrang = "Hoàn thành";
                        break;
                }
                echo "<td>" . $tinhTrang . "</td>";

                echo "<td>
                    <button type='button' class='btn btn-success editBtn' data-id='" . $row['MaPA'] . "' data-tinhtrang='" . $row['TinhTrang'] . "'>Sửa</button>
                </td>";

                echo "<td>
                    <button type='button' class='btn btn-danger deleteBtn' data-id='" . $row['MaPA'] . "'>Xóa</button>
                </td>";

                echo "</tr>";
             }
        } else {
            echo "<tr><td colspan='8'>Không có phản ánh nào</td></tr>";
        }
        ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<div class="pagination">
    <?php for ($i = 1; $i <= $pages; $i++) : ?>
        <a href="phananh.php?page=<?= $i; ?>" class="<?= ($page == $i) ? 'active' : ''; ?>"><?= $i; ?></a>
    <?php endfor; ?>
</div>

<?php
include('includes/scripts.php');
include('includes/footer.php');
?>

<!-- Modal Sửa Tình Trạng -->
<div class="modal fade" id="editReportModal" tabindex="-1" role="dialog" aria-labelledby="editReportLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editReportLabel">Cập nhật tình trạng phản ánh</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="phananh.php" method="POST" id="editReportForm">
        <div class="modal-body">
            <input type="hidden" name="mapa" id="edit_mapa">
            <div class="form-group">
                <label>Tình trạng</label>
                <select name="tinhtrang" id="edit_tinhtrang" class="form-control">
                    <option value="1">Mới</option>
                    <option value="2">Đang xử lý</option>
                    <option value="3">Hoàn thành</option>
                </select>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
            <button type="submit" name="update_report" class="btn btn-primary">Lưu</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Xóa Phản Ánh -->
<div class="modal fade" id="deleteReportModal" tabindex="-1" role="dialog" aria-labelledby="deleteReportLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteReportLabel">Xóa phản ánh</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="phananh.php" method="POST" id="deleteReportForm">
        <div class="modal-body">
            <input type="hidden" name="delete_mapa" id="delete_mapa">
            <p>Bạn có chắc chắn muốn xóa phản ánh này không?</p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
            <button type="submit" name="delete_report" class="btn btn-danger">Xóa</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
$(document).ready(function() {
    $('.editBtn').on('click', function() {
        $('#editReportModal').modal('show');

        var mapa = $(this).data('id');
        var tinhtrang = $(this).data('tinhtrang');

        $('#edit_mapa').val(mapa);
        $('#edit_tinhtrang').val(tinhtrang);
    });

    $('.deleteBtn').on('click', function() {
        $('#deleteReportModal').modal('show');

        var mapa = $(this).data('id');
        $('#delete_mapa').val(mapa);
    });
});
</script>

<?php
// Update report status
if (isset($_POST['update_report'])) {
    $mapa = $_POST['mapa'];
    $tinhtrang = $_POST['tinhtrang'];

    // Validate tinhtrang
    if (in_array($tinhtrang, ['1', '2', '3'])) {
        $sql = "UPDATE PhanAnh SET TinhTrang='$tinhtrang' WHERE MaPA='$mapa'";
        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Cập nhật tình trạng phản ánh thành công'); window.location.href='phananh.php';</script>";
        } else {
            echo "Lỗi: " . $conn->error;
        }
    } else {
        echo "<script>alert('Tình trạng không hợp lệ'); window.location.href='phananh.php';</script>";
    }
}

// Delete report
if (isset($_POST['delete_report'])) {
    $mapa = $_POST['delete_mapa'];

    $sql = "DELETE FROM PhanAnh WHERE MaPA='$mapa'";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Xóa phản ánh thành công'); window.location.href='phananh.php';</script>";
    } else {
        echo "Lỗi: " . $conn->error;
    }
}

$conn->close();
?>

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
