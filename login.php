<?php
session_start();
include('includes/header.php'); 
include('includes/db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $user['role'];
            header('Location: dashboard.php');
        } else {
            $error = "*Mật khẩu không đúng";
        }
    } else {
        $error = "*Tên đăng nhập không tồn tại";
    }

    $stmt->close();
}
?>



<div class="container">

<!-- Outer Row -->
<div class="row justify-content-center">

  <div class="col-xl-6 col-lg-6 col-md-6">

    <div class="card o-hidden border-0 shadow-lg my-5">
      <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
          <div class="col-lg-12">
            <div class="p-5">
              <div class="text-center">
                <h1 class="h4 text-gray-900 mb-2">ĐĂNG NHẬP</h1>
                <h2 class="h5 mb-2" >Hệ thống quản lý chung cư Apacare</h2>
                <?php

                    if(isset($_SESSION['status']) && $_SESSION['status'] !='') 
                    {
                        echo '<h2 class="bg-danger text-white"> '.$_SESSION['status'].' </h2>';
                        unset($_SESSION['status']);
                    }
                ?>
              </div>
              <style>
              .error-login {
                  color: red;
                  padding: 10px;
                  margin-bottom: 10px;
              }
              </style>
              <?php if(isset($error)) echo "<p class='error-login'>$error</p>"; ?>
                <form class="user" action="login.php" method="POST">
                    <div class="form-group">
                    <input type="text" name="username" class="form-control form-control-user" placeholder="Tên tài khoản" style="font-size: 1em;">
                    </div>
                    <div class="form-group">
                    <input type="password" name="password" class="form-control form-control-user" placeholder="Mật khẩu" style="font-size: 1em;">
                    </div>
                    <button type="submit" name="login_btn" class="btn btn-primary btn-user btn-block" style="font-size: 1em; font-weight: 600;"> Đăng nhập </button>
                    <hr>
                </form>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>

</div>

</div>


<?php
include('includes/scripts.php'); 
?>