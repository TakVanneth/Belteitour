<?php
include './../../Connection/conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["insert"])) {
    $title = $_POST['title'];
    $link = $_POST['link'];
    $sort_order = $_POST['sort_order'];

    $targetDirectory = "./../../public/RightMenuimg/";
    $uploadedFileName = $_FILES['image']['name'];
    $tempName = $_FILES['image']['tmp_name'];
    $fileExtension = pathinfo($uploadedFileName, PATHINFO_EXTENSION);
    $newFileName = date("Ymd_His") . '.' . $fileExtension; // Rename with current date

    $targetFilePath = $targetDirectory . $newFileName;

    if (move_uploaded_file($tempName, $targetFilePath)) {
        $query = "INSERT INTO MainMenu_Right_tbl (title, link, sort_order, image) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssis", $title, $link, $sort_order, $newFileName);

        if ($stmt->execute()) {
            echo '<script>window.location.href = "index.php";</script>';
        } else {
            echo "Error inserting main items: " . $conn->error;
        }
        $stmt->close();
    } else {
        echo "Error uploading file.";
    }
}
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT image FROM MainMenu_Right_tbl WHERE MainID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $imageFile = $result->fetch_assoc()['image'];
    $stmt->close();

    $deleteQuery = "DELETE FROM MainMenu_Right_tbl WHERE MainID = ?";
    $deleteStmt = $conn->prepare($deleteQuery);
    $deleteStmt->bind_param("i", $id);

    if ($deleteStmt->execute()) {
        $filePath = "./../../public/RightMenuimg/" . $imageFile;
        if (file_exists($filePath)) {
            unlink($filePath);
        }
        echo 
        '<script>
        alert("Items have been deleted");
        window.location.href = "index.php";
        </script>';

    } else {
        echo "Error deleting record: " . $conn->error;
    }

    $deleteStmt->close();
}
// if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
//     $id = $_POST['id'];
//     $title = $_POST['title'];
//     $link = $_POST['link'];
//     $sort_order = $_POST['sort_order'];

//     echo $id . " / " . $title . " / " . $link . " / " . $sort_order;

// }

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $link = $_POST['link'];
    $sort_order = $_POST['sort_order'];
    
    $targetDirectory = "./../../public/RightMenuimg/";
    $uploadedFileName = $_FILES['image']['name'];
    $tempName = $_FILES['image']['tmp_name'];
    $fileExtension = pathinfo($uploadedFileName, PATHINFO_EXTENSION);
    $newFileName = date("Ymd_His") . '.' . $fileExtension;

    $targetFilePath = $targetDirectory . $newFileName;

    $fetchQuery = "SELECT image FROM MainMenu_Right_tbl WHERE MainID = ?";
    $stmt = $conn->prepare($fetchQuery);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $oldImage = $result->fetch_assoc()['image'];
    $stmt->close();

    if (!empty($uploadedFileName)) {
        $oldFilePath = $targetDirectory . $oldImage;
        if (file_exists($oldFilePath)) {
            unlink($oldFilePath);
        }

        if (move_uploaded_file($tempName, $targetFilePath)) {
            $updateQuery = "UPDATE MainMenu_Right_tbl SET title = ?, link = ?, sort_order = ?, image = ? WHERE MainID = ?";
            $stmt = $conn->prepare($updateQuery);
            $stmt->bind_param("ssisi", $title, $link, $sort_order, $newFileName, $id);
        } else {
            echo "Error uploading file.";
            exit();
        }
    } else {
        $updateQuery = "UPDATE MainMenu_Right_tbl SET title = ?, link = ?, sort_order = ? WHERE MainID = ?";
        $stmt = $conn->prepare($updateQuery);
        $stmt->bind_param("ssii", $title, $link, $sort_order, $id);
    }

    if ($stmt->execute()) {
        echo '<script>alert("Items have been updated"); window.location.href = "index.php";</script>';
    } else {
        echo "Error updating record: " . $conn->error;
    }
    $stmt->close();
}
$conn->close();
?>