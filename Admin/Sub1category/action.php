<?php
include './../../Connection/conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Sub1CategoryNameKH = $_POST['Sub1CategoryNameKH'];
    $Sub1CategoryNameEN = $_POST['Sub1CategoryNameEN'];
    $MainCategoryID = $_POST['MainCategoryID'];

    $query = "INSERT INTO Sub1Category_tbl (Sub1CategoryNameKH, Sub1CategoryNameEN, MainCategoryID) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssi", $Sub1CategoryNameKH, $Sub1CategoryNameEN, $MainCategoryID);

    if ($stmt->execute()) {
        echo '<script>window.location.href = "index.php";</script>';
    } else {
        echo "Error inserting main category: " . $conn->error;
    }

    $stmt->close();
}

if(isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM Sub1Category_tbl WHERE Sub1CategoryID = ?";

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
    $Sub1CategoryNameKH = $_POST['Sub1CategoryNameKH'];
    $Sub1CategoryNameEN = $_POST['Sub1CategoryNameEN'];
    $MainCategoryID = $_POST['MainCategoryID'];

    $Sub1CategoryNameKH = mysqli_real_escape_string($conn, $Sub1CategoryNameKH);
    $Sub1CategoryNameEN = mysqli_real_escape_string($conn, $Sub1CategoryNameEN);
    $MainCategoryID = mysqli_real_escape_string($conn, $MainCategoryID);

    if (isset($_GET['id']) && !empty($_GET['id'])) {
        $id = $_GET['id'];
        $query = "UPDATE Sub1Category_tbl SET Sub1CategoryNameKH = '$Sub1CategoryNameKH', Sub1CategoryNameEN = '$Sub1CategoryNameEN', MainCategoryID = '$MainCategoryID' WHERE Sub1CategoryID = $id";

        if (mysqli_query($conn, $query)) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . mysqli_error($conn);
        }
    }
}
$conn->close();
?>
