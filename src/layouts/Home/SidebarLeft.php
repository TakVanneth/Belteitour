<?php 
    include './Connection/conn.php';
    $queryMain = "SELECT * FROM MainCategory_tbl";
    $resultMain = mysqli_query($conn, $queryMain);
?>
<div class="sidebarLeft">
<ul>
    <?php 
    while ($rowMain = mysqli_fetch_assoc($resultMain)) {
        echo "<li>" . $rowMain['mainCategoryTitleEN'] . "</li>";
        echo "<ul>";

        $mainCategoryId = $rowMain['MainCategoryID'];
        $querySub = "SELECT * FROM Sub1Category_tbl WHERE MainCategoryId = $mainCategoryId";
        $resultSub = mysqli_query($conn, $querySub);

        while ($rowSub = mysqli_fetch_assoc($resultSub)) {
            echo "<li>" . $rowSub['Sub1CategoryNameEN'] . "</li>";
        }
        echo "</ul>";
    }
    ?>
</ul>      
</div>