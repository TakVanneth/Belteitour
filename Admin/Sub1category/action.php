<?php
include './../../Connection/conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['insert'])) {
    $Sub1CategoryNameKH = $_POST['Sub1CategoryNameKH'];
    $Sub1CategoryNameEN = $_POST['Sub1CategoryNameEN'];
    $sort_order = $_POST['sort_order'];
    $DatePost = $_POST['DatePost'];
    $MainCategoryID = $_POST['MainCategoryID'];

    $targetDirectory = "./../../public/uploads";
    $uploadedFileName = $_FILES['Categoryimage']['name'];
    $tempName = $_FILES['Categoryimage']['tmp_name'];
    $fileExtension = pathinfo($uploadedFileName, PATHINFO_EXTENSION);
    $newFileName = date("Ymd_His") . '.' . $fileExtension; // Rename with current date

    $targetFilePath = $targetDirectory . $newFileName;

    if (move_uploaded_file($tempName, $targetFilePath)) {
        $query = "INSERT INTO Sub1Category_tbl (Sub1CategoryNameKH, Sub1CategoryNameEN, MainCategoryID, sort_order, DatePost, Categoryimage) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssiiss", $Sub1CategoryNameKH, $Sub1CategoryNameEN, $MainCategoryID, $sort_order, $DatePost, $newFileName);

        if ($stmt->execute()) {
            echo '<script>window.location.href = "index.php";</script>';
        } else {
            echo "Error inserting main category: " . $conn->error;
        }
        $stmt->close();
    } else {
        echo "Error uploading file.";
    }
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
    $id = $_POST['id'];
    $Sub1CategoryNameKH = $_POST['Sub1CategoryNameKH'];
    $Sub1CategoryNameEN = $_POST['Sub1CategoryNameEN'];
    $sort_order = $_POST['sort_order'];
    $DatePost = $_POST['DatePost'];
    $MainCategoryID = $_POST['MainCategoryID'];

    // File upload handling
    $targetDirectory = "./../../public/uploads/";
    $uploadedFileName = $_FILES['Categoryimage']['name'];
    $tempName = $_FILES['Categoryimage']['tmp_name'];

    // Check if a new file was uploaded
    if (!empty($uploadedFileName)) {
        $fileExtension = pathinfo($uploadedFileName, PATHINFO_EXTENSION);
        $newFileName = date("Ymd_His") . '.' . $fileExtension;
        $targetFilePath = $targetDirectory . $newFileName;

        // Fetch old image from the database
        $fetchQuery = "SELECT Categoryimage FROM Sub1Category_tbl WHERE Sub1CategoryID = ?";
        $stmt = $conn->prepare($fetchQuery);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $oldImage = $result->fetch_assoc()['Categoryimage'];
        $stmt->close();

        // Delete old file if it exists
        $oldFilePath = $targetDirectory . $oldImage;
        if (file_exists($oldFilePath)) {
            unlink($oldFilePath);
        }

        // Move uploaded file to target directory
        if (move_uploaded_file($tempName, $targetFilePath)) {
            // Update query with new file
            $updateQuery = "UPDATE Sub1Category_tbl SET Sub1CategoryNameKH = ?, Sub1CategoryNameEN = ?, sort_order = ?, DatePost = ?, MainCategoryID = ?, Categoryimage = ? WHERE Sub1CategoryID = ?";
            $stmt = $conn->prepare($updateQuery);
            $stmt->bind_param("ssiissi", $Sub1CategoryNameKH, $Sub1CategoryNameEN, $sort_order, $DatePost, $MainCategoryID, $newFileName, $id);
        } else {
            echo "Error uploading file.";
            exit();
        }
    } else {
        // Update query without changing the file
        $updateQuery = "UPDATE Sub1Category_tbl SET Sub1CategoryNameKH = ?, Sub1CategoryNameEN = ?, sort_order = ?, DatePost = ?, MainCategoryID = ? WHERE Sub1CategoryID = ?";
        $stmt = $conn->prepare($updateQuery);
        $stmt->bind_param("ssisii", $Sub1CategoryNameKH, $Sub1CategoryNameEN, $sort_order, $DatePost, $MainCategoryID, $id);
    }

    // Execute the update query
    if ($stmt->execute()) {
        echo '<script>alert("Items have been updated"); window.location.href = "index.php";</script>';
    } else {
        echo "Error updating record: " . $conn->error;
    }
    $stmt->close();
}

$conn->close();
?>
