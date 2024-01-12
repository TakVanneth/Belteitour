<?php
include './../../Connection/conn.php';

// Insert new record
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['insert'])) {
    $mainCategoryTitleKH = $_POST['mainCategoryTitleKH'];
    $mainCategoryTitleEN = $_POST['mainCategoryTitleEN'];
    $sort_order = $_POST['sort_order'];

    $targetDirectory = "./../../public/uploads/";
    $uploadedFileName = $_FILES['Categoryimage']['name'];
    $tempName = $_FILES['Categoryimage']['tmp_name'];
    $fileExtension = pathinfo($uploadedFileName, PATHINFO_EXTENSION);
    $newFileName = date("Ymd_His") . '.' . $fileExtension;

    $targetFilePath = $targetDirectory . $newFileName;

    if (move_uploaded_file($tempName, $targetFilePath)) {
        $query = "INSERT INTO MainCategory_tbl (mainCategoryTitleKH, mainCategoryTitleEN, sort_order, Categoryimage) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssis", $mainCategoryTitleKH, $mainCategoryTitleEN, $sort_order, $newFileName);
    
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
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the image file name to delete later
    $fetchQuery = "SELECT Categoryimage FROM MainCategory_tbl WHERE mainCategoryID = ?";
    $stmt = $conn->prepare($fetchQuery);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $imageFile = $result->fetch_assoc()['Categoryimage'];
    $stmt->close();

    // Delete the record from the table
    $deleteQuery = "DELETE FROM MainCategory_tbl WHERE mainCategoryID = ?";
    $deleteStmt = $conn->prepare($deleteQuery);
    $deleteStmt->bind_param("i", $id);

    if ($deleteStmt->execute()) {
        // If the deletion from the table was successful, delete the associated image file
        $filePath = "./../../public/uploads/" . $imageFile;
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        echo '<script>
        alert("Items have been deleted");
        window.location.href = "index.php";
        </script>';
    } else {
        echo "Error deleting record: " . $conn->error;
    }

    $deleteStmt->close();
}

// Update existing record
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $id = $_POST['id'];
    $mainCategoryTitleKH = $_POST['mainCategoryTitleKH'];
    $mainCategoryTitleEN = $_POST['mainCategoryTitleEN'];
    $sort_order = $_POST['sort_order'];

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
            $updateQuery = "UPDATE MainCategory_tbl SET mainCategoryTitleKH = ?, mainCategoryTitleEN = ?, sort_order = ?, Categoryimage = ? WHERE MainCategoryID = ?";
            $stmt = $conn->prepare($updateQuery);
            $stmt->bind_param("ssisi", $mainCategoryTitleKH, $mainCategoryTitleEN, $sort_order, $newFileName, $id);
        } else {
            echo "Error uploading file.";
            exit();
        }
    } else {
        // Update query without changing the file
        $updateQuery = "UPDATE MainCategory_tbl SET mainCategoryTitleKH = ?, mainCategoryTitleEN = ?, sort_order = ? WHERE MainCategoryID = ?";
        $stmt = $conn->prepare($updateQuery);
        $stmt->bind_param("ssii", $mainCategoryTitleKH, $mainCategoryTitleEN, $sort_order, $id);
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
