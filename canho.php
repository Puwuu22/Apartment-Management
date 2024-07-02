<?php
include('includes/header.php'); 
include('includes/navbar.php'); 
include('includes/db.php');

// Handle form submission for updating apartment details
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $MaCH = $_POST['MaCH'];
    $LoaiCH = $_POST['LoaiCH'];
    $TinhTrang = $_POST['TinhTrang'];

    $updateSql = "UPDATE canho SET LoaiCH='$LoaiCH', TinhTrang='$TinhTrang' WHERE MaCH='$MaCH'";
    $conn->query($updateSql);
}

// Pagination
$limit = 6;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($page - 1) * $limit;

$result = $conn->query("SELECT COUNT(MaCH) AS MaCH FROM canho");
$empCount = $result->fetch_all(MYSQLI_ASSOC);
$total = $empCount[0]['MaCH'];
$pages = ceil($total / $limit);

// Query data
$sql = "SELECT CH.MaCH, CH.LoaiCH, CH.TinhTrang, CD.MaCD as ChuHo, CD.TenCD as TenChuHo
        FROM CanHo CH
        LEFT JOIN CuDan CD ON CH.ChuHo = CD.MaCD
        LIMIT $start, $limit";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách căn hộ</title>
    <style>

    .container {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-around;
        padding: 20px;
    }

    .card {
        flex: 1 0 30%;
        max-width: 30%;
        margin: 10px;
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 10px;
        text-align: center;
        background-color: #fff;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.2s;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .card:hover {
        transform: scale(1.05);
    }

    .occupied {
        background-color: #f8d7da;
        color: #721c24;
    }

    .vacant {
        background-color: #d4edda;
        color: #155724;
    }

    h1 {
        text-align: center;
        color: #333;
        font-size: 24px;
        margin-top: 20px;
    }

    .card h2 {
        font-size: 18px;
        margin: 10px 0;
    }

    .card p {
        margin: 5px 0;
    }

    .card a {
        display: inline-block;
        margin-top: 10px;
        padding: 10px 20px;
        background-color: #007bff;
        color: white;
        text-decoration: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.2s;
    }

    .card a:hover {
        background-color: #0056b3;
    }

    .pagination {
        display: flex;
        justify-content: center;
        margin: 20px 0;
    }

    .pagination a {
        margin: 0 5px;
        padding: 10px 15px;
        text-decoration: none;
        color: #333;
        border: 1px solid #ddd;
        border-radius: 5px;
    }

    .pagination a.active {
        background-color: #007bff;
        color: white;
        border: 1px solid #007bff;
    }

    .pagination a:hover:not(.active) {
        background-color: #ddd;
    }

    .modal {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.5);
        padding-top: 60px;
    }

    .modal-content {
        background-color: #fefefe;
        margin: 5% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
        max-width: 500px;
        border-radius: 10px;
    }

    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover, .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }

    .modal input, .modal select {
        margin-bottom: 10px;
        padding: 10px;
        width: 100%;
        box-sizing: border-box;
        border: 1px solid #ddd;
        border-radius: 5px;
    }

    .modal button {
        padding: 10px 20px;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.2s;
    }

    .modal button:hover {
        background-color: #0056b3;
    }

    </style>
</head>
<body>
    <h1 class="m-0 font-weight-bold text-primary" style="font-size: 2.5em;">Danh sách căn hộ</h1>
    <div class="container">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $class = $row['TinhTrang'] == 2 ? 'occupied' : 'vacant';
                $status = $row['TinhTrang'] == 2 ? "Đang sử dụng" : "Trống";
                echo "<div class='card $class'>
                        <h2>" . $row['MaCH'] . "</h2>
                        <p>Loại: " . $row['LoaiCH'] . "</p>
                        <p>Tình trạng: " . $status . "</p>";
                if ($row['TinhTrang'] == 2) {
                    echo "<p>Chủ hộ: " . $row['TenChuHo'] . "</p>
                          <p>Mã chủ hộ: " . $row['ChuHo'] . "</p>";
                }
                echo "<a href='#' onclick='openModal(" . json_encode($row) . ")'>Chỉnh sửa</a>
                    </div>";
            }
        } else {
            echo "<p>Không có dữ liệu</p>";
        }
        ?>
    </div>

    <div class="pagination">
        <?php for ($i = 1; $i <= $pages; $i++) : ?>
            <a href="canho.php?page=<?= $i; ?>" class="<?= ($page == $i) ? 'active' : ''; ?>"><?= $i; ?></a>
        <?php endfor; ?>
    </div>

    <!-- The Modal -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <form method="POST" id="editForm">
                <input type="hidden" name="MaCH" id="MaCH">
                <label for="LoaiCH">Loại căn hộ:</label>
                <input type="text" name="LoaiCH" id="LoaiCH" required>
                <label for="TinhTrang">Tình trạng:</label>
                <select name="TinhTrang" id="TinhTrang" required>
                    <option value="1">Trống</option>
                    <option value="2">Đang sử dụng</option>
                </select>
                <button type="submit">Chỉnh sửa</button>
            </form>
        </div>
    </div>

    <script>
        function openModal(row) {
            document.getElementById('MaCH').value = row.MaCH;
            document.getElementById('LoaiCH').value = row.LoaiCH;
            document.getElementById('TinhTrang').value = row.TinhTrang;
            document.getElementById('editModal').style.display = "block";
        }

        function closeModal() {
            document.getElementById('editModal').style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target == document.getElementById('editModal')) {
                closeModal();
            }
        }
    </script>

    <?php
    $conn->close();
    include('includes/scripts.php');
    include('includes/footer.php');
    ?>
</body>
</html>
