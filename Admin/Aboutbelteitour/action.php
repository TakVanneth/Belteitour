<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include './../../Connection/conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['insert'])) {
    $mainCategory = isset($_POST['MainCategory']) ? $_POST['MainCategory'] : '';
    $subCategory = isset($_POST['SubCategory']) ? $_POST['SubCategory'] : '';
    $title = $_POST['title'];
    $content = $_POST['content'];

    $imageDetails = array_fill(1, 11, '');

    for ($i = 1; $i <= 11; $i++) {
        $fieldName = 'imagedetails_' . $i;
        if (isset($_FILES[$fieldName]) && $_FILES[$fieldName]['size'] > 0) {

            $imageName = $title . '_' . $fieldName . '_' . time() . '_' . $i;
    
            $extension = pathinfo($_FILES[$fieldName]['name'], PATHINFO_EXTENSION);
    
            $imageDetails[$i] = $imageName . '_' . $_FILES[$fieldName]['name'];
    
            $uploadPath = './../../public/uploads/about/' . $imageDetails[$i];
            move_uploaded_file($_FILES[$fieldName]['tmp_name'], $uploadPath);
        }
    }
    $query = "INSERT INTO About_tbl (Sub1CategoryID, title, content, imagedetails_1, imagedetails_2, imagedetails_3, imagedetails_4, imagedetails_5, imagedetails_6, imagedetails_7, imagedetails_8, imagedetails_9, imagedetails_10, imagedetails_11) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("isssssssssssss", $subCategory, $title, $content, $imageDetails[1], $imageDetails[2], $imageDetails[3], $imageDetails[4], $imageDetails[5], $imageDetails[6], $imageDetails[7], $imageDetails[8], $imageDetails[9], $imageDetails[10], $imageDetails[11]);
    
    if ($stmt->execute()) {
        echo '<script>window.location.href = "index.php";</script>';
    } else {
        echo "Error inserting data: " . $stmt->error;
    }
    $stmt->close();
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $recordId = isset($_POST['record_id']) ? $_POST['record_id'] : '';
    $mainCategory = isset($_POST['MainCategory']) ? $_POST['MainCategory'] : '';
    $subCategory = isset($_POST['SubCategory']) ? $_POST['SubCategory'] : '';
    $title = $_POST['title'];
    $content = $_POST['content'];

    // Fetch old image details before updating
    $oldImageDetails = array();
    $fetchQuery = "SELECT imagedetails_1, imagedetails_2, imagedetails_3, imagedetails_4, imagedetails_5, imagedetails_6, imagedetails_7, imagedetails_8, imagedetails_9, imagedetails_10, imagedetails_11 FROM About_tbl WHERE id=?";
    $fetchStmt = $conn->prepare($fetchQuery);
    $fetchStmt->bind_param("i", $recordId);
    $fetchStmt->execute();
    $fetchStmt->bind_result($oldImageDetails[1], $oldImageDetails[2], $oldImageDetails[3], $oldImageDetails[4], $oldImageDetails[5], $oldImageDetails[6], $oldImageDetails[7], $oldImageDetails[8], $oldImageDetails[9], $oldImageDetails[10], $oldImageDetails[11]);
    $fetchStmt->fetch();
    $fetchStmt->close();

    // File upload logic
    $imageDetails = array_fill(1, 11, '');

    for ($i = 1; $i <= 11; $i++) {
        $fieldName = 'imagedetails_' . $i;
        if (isset($_FILES[$fieldName]) && $_FILES[$fieldName]['size'] > 0) {
            $imageName = $title . '_' . $fieldName . '_' . time() . '_' . $i;
            $extension = pathinfo($_FILES[$fieldName]['name'], PATHINFO_EXTENSION);
            $imageDetails[$i] = $imageName . '_' . $_FILES[$fieldName]['name'];
            $uploadPath = './../../public/uploads/about/' . $imageDetails[$i];
            move_uploaded_file($_FILES[$fieldName]['tmp_name'], $uploadPath);
        } else {
            // If no new file is uploaded, retain the old image details
            $imageDetails[$i] = $oldImageDetails[$i];
        }
    }

    // Check if any new file is uploaded
    $isAnyFileUploaded = array_filter($imageDetails, function ($value) {
        return !empty($value);
    });

    // UPDATE query
    $query = "UPDATE About_tbl SET Sub1CategoryID=?, title=?, content=?, imagedetails_1=?, imagedetails_2=?, imagedetails_3=?, imagedetails_4=?, imagedetails_5=?, imagedetails_6=?, imagedetails_7=?, imagedetails_8=?, imagedetails_9=?, imagedetails_10=?, imagedetails_11=? WHERE id=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("isssssssssssssi", $subCategory, $title, $content, $imageDetails[1], $imageDetails[2], $imageDetails[3], $imageDetails[4], $imageDetails[5], $imageDetails[6], $imageDetails[7], $imageDetails[8], $imageDetails[9], $imageDetails[10], $imageDetails[11], $recordId);

    if ($stmt->execute()) {
        // Unlink old images
        for ($i = 1; $i <= 11; $i++) {
            if (!empty($oldImageDetails[$i]) && !in_array($oldImageDetails[$i], $imageDetails)) {
                $oldImagePath = './../../public/uploads/about/' . $oldImageDetails[$i];
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
        }

        if (!empty($isAnyFileUploaded)) {
            echo '<script>window.location.href = "index.php";</script>';
        } else {
            echo "No new files uploaded. Data updated.";
        }
    } else {
        echo "Error updating data: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
?>
