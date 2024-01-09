<?php
include './../../Connection/conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mainCategoryTitleKH = $_POST['mainCategoryTitleKH'];
    $mainCategoryTitleEN = $_POST['mainCategoryTitleEN'];


    $query = "INSERT INTO MainCategory_tbl (mainCategoryTitleKH, mainCategoryTitleEN) VALUES (?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $mainCategoryTitleKH, $mainCategoryTitleEN);

    if ($stmt->execute()) {
        echo '<script>window.location.href = "index.php";</script>';
    } else {
        echo "Error inserting main category: " . $conn->error;
    }

    $stmt->close();
}

if(isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM MainCategory_tbl WHERE mainCategoryID = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo '<script>window.location.href = "index.php";</script>';
    } else {
        echo "Error deleting record: " . $conn->error;
    }

    $stmt->close();
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $mainCategoryTitleKH = $_POST['mainCategoryTitleKH'];
    $mainCategoryTitleEN = $_POST['mainCategoryTitleEN'];

    $mainCategoryTitleKH = mysqli_real_escape_string($conn, $mainCategoryTitleKH);
    $mainCategoryTitleEN = mysqli_real_escape_string($conn, $mainCategoryTitleEN);

    if (isset($_GET['id']) && !empty($_GET['id'])) {
        $id = $_GET['id'];
        $query = "UPDATE MainCategory_tbl SET mainCategoryTitleKH = '$mainCategoryTitleKH', mainCategoryTitleEN = '$mainCategoryTitleEN' WHERE MainCategoryID = $id";

        if (mysqli_query($conn, $query)) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . mysqli_error($conn);
        }
    }
}
$conn->close();
?>
