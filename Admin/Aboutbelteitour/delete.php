<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include './../../Connection/conn.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $id = $_GET['id'];

    // Select the row to get the file names for deletion
    $selectQuery = "SELECT imagedetails_1, imagedetails_2, imagedetails_3, imagedetails_4, imagedetails_5, imagedetails_6, imagedetails_7, imagedetails_8, imagedetails_9, imagedetails_10 FROM About_tbl WHERE id = ?";
    $selectStmt = $conn->prepare($selectQuery);
    $selectStmt->bind_param("i", $id);
    $selectStmt->execute();
    $selectStmt->bind_result($imageDetails1, $imageDetails2, $imageDetails3, $imageDetails4, $imageDetails5, $imageDetails6, $imageDetails7, $imageDetails8, $imageDetails9, $imageDetails10);
    $selectStmt->fetch();
    $selectStmt->close();

    // Delete the row from the database
    $deleteQuery = "DELETE FROM About_tbl WHERE id = ?";
    $deleteStmt = $conn->prepare($deleteQuery);
    $deleteStmt->bind_param("i", $id);
    
    if ($deleteStmt->execute()) {
        // Unlink associated image files
        $imageDetails = [$imageDetails1, $imageDetails2, $imageDetails3, $imageDetails4, $imageDetails5, $imageDetails6, $imageDetails7, $imageDetails8, $imageDetails9, $imageDetails10];
        foreach ($imageDetails as $image) {
            if (!empty($image)) {
                $filePath = './../../public/uploads/about/' . $image;
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }
        }

        echo '<script>window.location.href = "index.php";</script>';
    } else {
        echo "Error deleting data: " . $deleteStmt->error;
    }
    $deleteStmt->close();
}
?>
