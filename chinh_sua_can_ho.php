<?php
include('includes/header.php'); 
include('includes/navbar.php'); 
include('includes/db.php');

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    $maCanHo = $_GET["id"];
    $sql = "SELECT * FROM CanHo WHERE MaCH='$MaCH'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "Không tìm thấy căn hộ";
        exit();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["MaCH"])) {
    $maCanHo = $_POST["MaCH"];
    $LoaiCH = $_POST["LoaiCH"];
    $MoTa = $_POST["MoTa"];
    $DienTich = $_POST["DienTich"];
    $Gia = $_POST["Gia"];
    $MaHo = $_POST["MaHo"];
    $MaTang = $_POST["MaTang"];
    $TinhTrang = $_POST["TinhTrang"];
    $sql = "UPDATE CanHo SET LoaiCH='$LoaiCH', TinhTrang='$TinhTrang' WHERE MaCH='$MaCH'";

    if ($conn->query($sql) === TRUE) {
        echo "Cập nhật thành công";
        header("Location: canho.php");
    } else {
        echo "Lỗi: " . $conn->error;
    }
}

$conn->close();

include('includes/scripts.php');
include('includes/footer.php');
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh sửa căn hộ</title>
</head>
<body>
    <h1>Chỉnh sửa căn hộ</h1>
    <form method="POST" action="chinh_sua_can_ho.php">
        <input type="hidden" name="MaCH" value="<?php echo $row['MaCH']; ?>">
        <label for="LoaiCH">Loại căn hộ/label>
        <input type="text" id="LoaiCH" name="LoaiCH" value="<?php echo $row['LoaiCH']; ?>"><br><br>
        <label for="TinhTrang">Tình trạng:</label>
        <select id="TinhTrang" name="TinhTrang">
            <option value="1" <?php if($row['TinhTrang'] == 2) echo 'selected'; ?>>Đang sử dụng</option>
            <option value="0" <?php if($row['TinhTrang'] == 1) echo 'selected'; ?>>Trống</option>
        </select><br><br>
        <input type="submit" value="Lưu">
    </form>
</body>
</html>
