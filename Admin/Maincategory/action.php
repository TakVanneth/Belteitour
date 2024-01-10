<?php
include './../../Connection/conn.php';

// Insert new record
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['insert'])) {
    $mainCategoryTitleKH = $_POST['mainCategoryTitleKH'];
    $mainCategoryTitleEN = $_POST['mainCategoryTitleEN'];

    $targetDirectory = "./../../public/uploads/";
    $uploadedFileName = $_FILES['Categoryimage']['name'];
    $tempName = $_FILES['Categoryimage']['tmp_name'];
    $fileExtension = pathinfo($uploadedFileName, PATHINFO_EXTENSION);
    $newFileName = date("Ymd_His") . '.' . $fileExtension;

    $targetFilePath = $targetDirectory . $newFileName;

    if (move_uploaded_file($tempName, $targetFilePath)) {
        $query = "INSERT INTO MainCategory_tbl (mainCategoryTitleKH, mainCategoryTitleEN, Categoryimage) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sss", $mainCategoryTitleKH, $mainCategoryTitleEN, $newFileName);
    
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

// Delete record by ID
if (isset($_GET['id']) && !empty($_GET['id'])) {
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

// Update existing record
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $id = $_POST['id'];
    $mainCategoryTitleKH = $_POST['mainCategoryTitleKH'];
    $mainCategoryTitleEN = $_POST['mainCategoryTitleEN'];

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
        $fetchQuery = "SELECT Categoryimage FROM MainCategory_tbl WHERE MainCategoryID = ?";
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
            $updateQuery = "UPDATE MainCategory_tbl SET mainCategoryTitleKH = ?, mainCategoryTitleEN = ?, Categoryimage = ? WHERE MainCategoryID = ?";
            $stmt = $conn->prepare($updateQuery);
            $stmt->bind_param("sssi", $mainCategoryTitleKH, $mainCategoryTitleEN, $newFileName, $id);
        } else {
            echo "Error uploading file.";
            exit();
        }
    } else {
        // Update query without changing the file
        $updateQuery = "UPDATE MainCategory_tbl SET mainCategoryTitleKH = ?, mainCategoryTitleEN = ? WHERE MainCategoryID = ?";
        $stmt = $conn->prepare($updateQuery);
        $stmt->bind_param("ssi", $mainCategoryTitleKH, $mainCategoryTitleEN, $id);
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
