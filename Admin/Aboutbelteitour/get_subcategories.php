<?php
include './../../Connection/conn.php';

if (isset($_GET['mainCategoryId'])) {
    $mainCategoryId = $_GET['mainCategoryId'];

    $SubCategoryQuery = "SELECT * FROM Sub1Category_tbl WHERE MainCategoryID = " . $mainCategoryId;
    $SubCategoryResult = mysqli_query($conn, $SubCategoryQuery);

    echo "<select class='form-select' id='SubCategory' name='SubCategory'>";
    echo "<option value=''>Select Subcategory</option>";

    while ($row = mysqli_fetch_assoc($SubCategoryResult)) {
        echo "<option value='" . $row['Sub1CategoryID'] . "'>" . $row['Sub1CategoryNameKH'] . "</option>";
    }

    echo "</select>";
}
?>