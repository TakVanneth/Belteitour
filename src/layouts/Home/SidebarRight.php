<style>
    .sidebarRight {
        background: #dfe9ce;
    }
    .sidebarRight img {
        width: 90%;
        margin: 0 auto;
        display: block; 
    }
    .link-wrapper {
        margin-bottom: 10px;
    }
    .main-container {
        /* margin-left: 9px; */
        margin-right: 9px;
    }
    .menu {
        margin-top: 5px;
    }
</style>
<?php
include './Connection/conn.php';

$queryMain = "SELECT * FROM MainMenu_Right_tbl ORDER BY sort_order DESC";
$resultMain = mysqli_query($conn, $queryMain);

echo '<div class="sidebarRight">'; // Opening div for Right sidebar
echo '<div><center><a href=""><img src="./public/img/sr9.gif" border="0"></a></center></div>';
echo '<div><center><a href="https://belteigroup.com.kh/index2.htm"><img src="./public/img/sr3.png" border="0"></a></center></div>';
echo '<div class="menu">'; 
while ($rowMain = mysqli_fetch_assoc($resultMain)) {
    echo '<div class="main-container">'; // Use a different class for the main container
    echo '<img src="./public/RightMenuimg/' . $rowMain['image'] . '" alt="">';

    $MainID = mysqli_real_escape_string($conn, $rowMain['MainID']); // Escape MainID for security

    $querySub = "SELECT * FROM SubMenu_Right_tbl WHERE MainID = $MainID ORDER BY sort_order DESC";
    $resultSub = mysqli_query($conn, $querySub);

    while ($rowSub = mysqli_fetch_assoc($resultSub)) {
        echo '<div class="link-wrapper">';
        echo '<a href="' . htmlspecialchars($rowSub['link']) . '">';
        echo '<img src="./public/RightMenuimg/' . $rowSub['image'] . '" alt="">';
        echo '</a>';
        echo '</div>';
    }

    echo '</div>';
    echo '</div>';
}

echo '</div>';
?>



<!-- <div class="sidebarRight">
    <div class="container-fluid">
        <img src="./public/img/sr9.gif" alt="">
        <img src="./public/img/sr3.png" alt="">
    </div>
    <div class="container-fluid">
        <img src="./public/img/sr17.png" alt="">
        <img src="./public/img/sr4.png" alt="">
        <img src="./public/img/sr6.png" alt="">
        <img src="./public/img/sr5.png" alt="">
    </div>
    <div class="container-fluid">
    <img src="./public/img/sr23.png" alt="">
    <img src="./public/img/sr10.png" alt="">
    <img src="./public/img/sr27.png" alt="">
    <img src="./public/img/sr28.png" alt="">
    <img src="./public/img/sr20.png" alt="">
    <img src="./public/img/sr35.png" alt="">
    <img src="./public/img/sr26.png" alt="">
    <img src="./public/img/sr18.png" alt="">
    <img src="./public/img/sr21.png" alt="">
    </div>
    <div class="container-fluid">
    <img src="./public/img/sr31.png" alt="">
    <img src="./public/img/sr33.png" alt="">
    <img src="./public/img/sr29.png" alt="">
    <img src="./public/img/sr2.png" alt="">
    <img src="./public/img/sr1.png" alt="">
    <img src="./public/img/sr11.png" alt="">
    </div>
    <div class="container-fluid">
    <img src="./public/img/sr32.png" alt="">
    <img src="./public/img/sr34.png" alt="">
    <img src="./public/img/sr13.png" alt="">
    <img src="./public/img/sr25.png" alt="">
    </div>
    <div class="container-fluid">
    <img src="./public/img/sr22.png" alt="">
    <img src="./public/img/sr36.png" alt="">
    <img src="./public/img/sr24.png" alt="">
    </div>
    <div class="container-fluid">
    <img src="./public/img/sr15.png" alt="">
    <img src="./public/img/sr8.png" alt="">
    <img src="./public/img/sr16.png" alt="">
    </div>
    <div class="container-fluid">
    <img src="./public/img/sr14.png" alt="">
    <img src="./public/img/sr12.png" alt="">
    </div>
    <div class="container-fluid">
    <img src="./public/img/sr14.png" alt="">
    <img src="./public/img/sr19.png" alt="">
    </div>
    <div class="container-fluid">
    <img src="./public/img/sr7.png" alt="">
    <img src="./public/img/sr30.png" alt="">
    </div>
</div> -->