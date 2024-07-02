<?php
include('includes/header.php');
include('includes/navbar.php');
include('includes/db.php');
// Phân trang
$limit = 8;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($page - 1) * $limit;

$result = $conn->query("SELECT COUNT(MaHD) AS count FROM HoaDon");
$hoadonCount = $result->fetch_assoc()['count'];
$pages = ceil($hoadonCount / $limit);

$sql = "SELECT * FROM HoaDon LIMIT $start, $limit";
$result = $conn->query($sql);
?>
<!-- Modal Thêm hóa đơn -->
<div class="modal fade" id="addHoaDonModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Thêm hóa đơn</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="hoadon.php" method="POST">
        <div class="modal-body">
          <div class="form-group">
            <label>Mã hóa đơn</label>
            <input type="text" name="mahd" class="form-control" placeholder="Nhập mã hóa đơn" required>
          </div>
          <div class="form-group">
            <label>Tên hóa đơn</label>
            <input type="text" name="tenhd" class="form-control" placeholder="Nhập tên hóa đơn" required>
          </div>
          <div class="form-group">
            <label>Ngày hóa đơn</label>
            <input type="date" name="nghd" class="form-control" required>
          </div>
          <div class="form-group">
            <label>Phí phát sinh</label>
            <input type="text" name="phips" class="form-control" placeholder="Nhập phí phụ sản">
          </div>
          <div class="form-group">
            <label>Trị giá</label>
            <input type="text" name="trigia" class="form-control" placeholder="Nhập trị giá">
          </div>
          <div class="form-group">
            <label>Tình trạng</label>
            <select name="tinhtrang" class="form-control" required>
              <option value="1">Đã thanh toán</option>
              <option value="0">Chưa thanh toán</option>
            </select>
          </div>
          <div class="form-group">
            <label>Mã dịch vụ</label>
            <input type="text" name="madv" class="form-control" placeholder="Nhập mã dịch vụ" required>
          </div>
          <div class="form-group">
            <label>Mã căn hộ</label>
            <input type="text" name="mach" class="form-control" placeholder="Nhập mã căn hộ" required>
          </div>
          <div class="form-group">
            <label>Ghi chú</label>
            <textarea name="ghichu" class="form-control" placeholder="Nhập ghi chú"></textarea>
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
<!-- DataTales Example -->
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">Thông tin hóa đơn
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addHoaDonModal" style="background:#447FC2; border:none;">
          Thêm hóa đơn mới
        </button>
    </h6>
    <?php
    // Xử lý thêm hóa đơn mới
    if (isset($_POST['registerbtn'])) {
      $mahd = $_POST['mahd'];
      $tenhd = $_POST['tenhd'];
      $nghd = $_POST['nghd'];
      $phips = isset($_POST['phips']) ? $_POST['phips'] : null;
      $trigia = isset($_POST['trigia']) ? $_POST['trigia'] : null;
      $tinhtrang = $_POST['tinhtrang'];
      $madv = $_POST['madv'];
      $mach = $_POST['mach'];
      $ghichu = isset($_POST['ghichu']) ? $_POST['ghichu'] : null;

      $sql = "INSERT INTO HoaDon (MaHD, TenHD, NgHD, PhiPS, TriGia, TinhTrang, MaDV, MaCH, GhiChu) 
              VALUES ('$mahd', '$tenhd', '$nghd', '$phips', '$trigia', '$tinhtrang', '$madv', '$mach', '$ghichu')";

      if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Thêm hóa đơn mới thành công'); window.location.href='hoadon.php';</script>";
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
            <th>Ngày hóa đơn</th>
            <th>Phí phát sinh</th>
            <th>Trị giá</th>
            <th>Tình trạng</th>
            <th>Mã dịch vụ</th>
            <th>Mã căn hộ</th>
            <th>Ghi chú</th>
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
                echo "<td>" . $row['NgHD'] . "</td>";
                echo "<td>" . $row['PhiPS'] . "</td>";
                echo "<td>" . $row['TriGia'] . "</td>";
                echo "<td>" . ($row['TinhTrang'] == 1 ? 'Đã thanh toán' : 'Chưa thanh toán') . "</td>";
                echo "<td>" . $row['MaDV'] . "</td>";
                echo "<td>" . $row['MaCH'] . "</td>";
                echo "<td>" . $row['GhiChu'] . "</td>";
                echo "<td>
                    <button type='button' class='btn btn-success editBtn' 
                            data-mahd='" . $row['MaHD'] . "' 
                            data-tenhd='" . $row['TenHD'] . "' 
                            data-nghd='" . $row['NgHD'] . "' 
                            data-phips='" . $row['PhiPS'] . "' 
                            data-trigia='" . $row['TriGia'] . "' 
                            data-tinhtrang='" . $row['TinhTrang'] . "' 
                            data-madv='" . $row['MaDV'] . "' 
                            data-mach='" . $row['MaCH'] . "' 
                            data-ghichu='" . $row['GhiChu'] . "'>Sửa</button>
                  </td>";
                echo "<td>
                    <button type='button' class='btn btn-danger deleteBtn' 
                            data-mahd='" . $row['MaHD'] . "' 
                            data-toggle='modal' 
                            data-target='#deleteModal'>Xóa</button>
                  </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='11'>Không có hóa đơn nào</td></tr>";
        }
        ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
 

<?php


// Xóa hóa đơn
if (isset($_POST['delete_btn'])) {
$mahd = $_POST['delete_id'];
$sql = "DELETE FROM HoaDon WHERE MaHD='$mahd'";
if ($conn->query($sql) === TRUE) {
echo "<script>alert('Xóa hóa đơn thành công'); window.location.href='hoadon.php';</script>";
} else {
echo "Lỗi: " . $conn->error;
}
}

// Sửa hóa đơn
if (isset($_POST['update_hoadon'])) {
$mahd = $_POST['mahd'];
$tenhd = $_POST['tenhd'];
$nghd = $_POST['nghd'];
$phips = isset($_POST['phips']) ? $_POST['phips'] : null;
$trigia = isset($_POST['trigia']) ? $_POST['trigia'] : null;
$tinhtrang = $_POST['tinhtrang'];
$madv = $_POST['madv'];
$mach = $_POST['mach'];
$ghichu = isset($_POST['ghichu']) ? $_POST['ghichu'] : null;
$sql = "UPDATE HoaDon SET TenHD='$tenhd', NgHD='$nghd', PhiPS='$phips', TriGia='$trigia', TinhTrang='$tinhtrang', MaDV='$madv', MaCH='$mach', GhiChu='$ghichu' WHERE MaHD='$mahd'";
 
if ($conn->query($sql) === TRUE) {
  echo "<script>alert('Cập nhật hóa đơn thành công'); window.location.href='hoadon.php';</script>";
} else {
  echo "Lỗi: " . $conn->error;
}
}
?>

   <!-- Modal Xóa Hóa Đơn -->
   <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
     <div class="modal-dialog" role="document">
       <div class="modal-content">
         <div class="modal-header">
           <h5 class="modal-title" id="deleteModalLabel">Xác nhận xóa</h5>
           <button type="button" class="close" data-dismiss="modal" aria-label="Close">
             <span aria-hidden="true">&times;</span>
           </button>
         </div>
         <form action="hoadon.php" method="POST">
           <div class="modal-body">
             <p>Bạn có chắc chắn muốn xóa hóa đơn này không?</p>
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
   <!-- Modal Sửa Hóa Đơn -->
   <div class="modal fade" id="editHoaDonModal" tabindex="-1" role="dialog" aria-labelledby="editHoaDonLabel" aria-hidden="true">
     <div class="modal-dialog" role="document">
       <div class="modal-content">
         <div class="modal-header">
           <h5 class="modal-title" id="editHoaDonLabel">Sửa hóa đơn</h5>
           <button type="button" class="close" data-dismiss="modal" aria-label="Close">
             <span aria-hidden="true">&times;</span>
           </button>
         </div>
         <form action="hoadon.php" method="POST">
           <div class="modal-body">
             <input type="hidden" name="mahd" id="edit_mahd">
             <div class="form-group">
               <label>Tên hóa đơn</label>
               <input type="text" name="tenhd" id="edit_tenhd" class="form-control" placeholder="Nhập tên hóa đơn" required>
             </div>
             <div class="form-group">
               <label>Ngày hóa đơn</label>
               <input type="date" name="nghd" id="edit_nghd" class="form-control" required>
             </div>
             <div class="form-group">
               <label>Phí phát sinh</label>
               <input type="text" name="phips" id="edit_phips" class="form-control" placeholder="Nhập phí phụ sản">
             </div>
             <div class="form-group">
               <label>Trị giá</label>
               <input type="text" name="trigia" id="edit_trigia" class="form-control" placeholder="Nhập trị giá">
             </div>
             <div class="form-group">
               <label>Tình trạng</label>
               <select name="tinhtrang" id="edit_tinhtrang" class="form-control" required>
                 <option value="1">Đã thanh toán</option>
                 <option value="0">Chưa thanh toán</option>
               </select>
             </div>
             <div class="form-group">
               <label>Mã dịch vụ</label>
               <input type="text" name="madv" id="edit_madv" class="form-control" placeholder="Nhập mã dịch vụ" required>
             </div>
             <div class="form-group">
               <label>Mã căn hộ</label>
               <input type="text" name="mach" id="edit_mach" class="form-control" placeholder="Nhập mã căn hộ" required>
             </div>
             <div class="form-group">
               <label>Ghi chú</label>
               <textarea name="ghichu" id="edit_ghichu" class="form-control" placeholder="Nhập ghi chú"></textarea>
             </div>
           </div>
           <div class="modal-footer">
             <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
             <button type="submit" name="update_hoadon" class="btn btn-primary">Lưu</button>
           </div>
         </form>
       </div>
     </div>
   </div>
   
<div class="pagination">
    <?php for ($i = 1; $i <= $pages; $i++) : ?>
        <a href="hoadon.php?page=<?= $i; ?>" class="<?= ($page == $i) ? 'active' : ''; ?>"><?= $i; ?></a>
    <?php endfor; ?>
</div>
   <!-- Scripts -->
   <?php
   include('includes/scripts.php');
   include('includes/footer.php');
   ?>
   <script>
     // Xử lý sự kiện khi nhấn nút Sửa
     $(document).ready(function() {
       $('.editBtn').on('click', function() {
         $('#editHoaDonModal').modal('show');

         var mahd = $(this).data('mahd');
         var tenhd = $(this).data('tenhd');
         var nghd = $(this).data('nghd');
         var phips = $(this).data('phips');
         var trigia = $(this).data('trigia');
         var tinhtrang = $(this).data('tinhtrang');
         var madv = $(this).data('madv');
         var mach = $(this).data('mach');
         var ghichu = $(this).data('ghichu');

         $('#edit_mahd').val(mahd);
         $('#edit_tenhd').val(tenhd);
         $('#edit_nghd').val(nghd);
         $('#edit_phips').val(phips);
         $('#edit_trigia').val(trigia);
         $('#edit_tinhtrang').val(tinhtrang);
         $('#edit_madv').val(madv);
         $('#edit_mach').val(mach);
         $('#edit_ghichu').val(ghichu);
       });

       // Xử lý sự kiện khi nhấn nút Xóa
       $('.deleteBtn').on('click', function() {
         var delete_id = $(this).data('mahd');
         $('#delete_id').val(delete_id);
       });
     });
   </script>
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