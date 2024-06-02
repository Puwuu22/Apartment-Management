<?php
include('includes/header.php'); 
include('includes/navbar.php'); 
?>


<div class="modal fade" id="addadminprofile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Thêm cư dân</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="code.php" method="POST">

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


<div class="container-fluid">

<!-- DataTales Example -->
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">Thông tin cư dân
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addadminprofile">
              Thêm cư dân mới 
            </button>
    </h6>
  </div>

  <div class="card-body">

    <div class="table-responsive">

      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
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
     
          <tr>
            <td> 1 </td>
            <td> Funda of WEb IT</td>
            <td> funda@example.com</td>
            <td> *** </td>
            <th> *** </th>
            <th> *** </th>
            <th> *** </th>
            <th> *** </th>
            <td>
                <form action="" method="post">
                    <input type="hidden" name="edit_id" value="">
                    <button  type="submit" name="edit_btn" class="btn btn-success">Sửa</button>
                </form>
            </td>
            <td>
                <form action="" method="post">
                  <input type="hidden" name="delete_id" value="">
                  <button type="submit" name="delete_btn" class="btn btn-danger">Xóa</button>
                </form>
            </td>
          </tr>
        
        </tbody>
      </table>

    </div>
  </div>
</div>

</div>
<!-- /.container-fluid -->

<?php
include('includes/scripts.php');
include('includes/footer.php');
?>