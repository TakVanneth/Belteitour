<?php 
include './Connection/conn.php';
$queryMain = "SELECT * FROM MainCategory_tbl ORDER BY sort_order DESC";
$resultMain = mysqli_query($conn, $queryMain);
?>
  <style>
        .sidebarLeft img {
        width: 92%;
        margin: 0 auto;
        display: block; 
    }
    .sidebarLeft {
            border-right: 0.5px solid #7BA46A;
        }
  </style>
<div class="sidebarLeft">
    <?php 
    while ($rowMain = mysqli_fetch_assoc($resultMain)) {
        echo '<div class="container">';
        // echo "<h2>" . $rowMain['mainCategoryTitleEN'] . "</h2>";
        echo '<img src="./public/uploads/' . $rowMain['Categoryimage'] . '" alt="' . $rowMain['mainCategoryTitleEN'] . '">';

        $mainCategoryId = $rowMain['MainCategoryID'];
        $querySub = "SELECT * FROM Sub1Category_tbl WHERE MainCategoryId = $mainCategoryId ORDER BY sort_order DESC";
        $resultSub = mysqli_query($conn, $querySub);

        while ($rowSub = mysqli_fetch_assoc($resultSub)) {
            echo '<a href="index.php?id=' . $rowSub['Sub1CategoryID'] . '">';
            echo '<img src="./public/uploads/' . $rowSub['Categoryimage'] . '" alt="' . $rowSub['Sub1CategoryNameEN'] . '">';
            echo '</a>';
        }
        echo '</div>'; // Close the container for each main category
    }
    ?>   
</div>
