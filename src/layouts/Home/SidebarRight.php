<style>
    .sidebarRight {
        background: #dfe9ce;
        text-align: center;
    }
    center img {
        width: 82%;
        margin: 0 auto;
        display: block; 
    }
    .menu img {
        width: 85%;
        margin: 0 auto;
        display: block; 
    }
    .main-container {
        margin-top: 10px;
    }
    .language img {
        width: 93%;
        margin: 0 auto;
        display: block; 
    }
</style>
<?php
include './Connection/conn.php';

$queryMain = "SELECT * FROM MainMenu_Right_tbl ORDER BY sort_order DESC";
$resultMain = mysqli_query($conn, $queryMain);

echo '<div class="sidebarRight">'; // Opening div for Right sidebar
echo '<div class="language"><a href=""><img src="./public/img/sr9.gif" border="0"></a></div>'; 
echo '<div><center><a href="https://belteigroup.com.kh/index2.htm"><img src="./public/img/sr3.png" border="0"></a></center></div>';
while ($rowMain = mysqli_fetch_assoc($resultMain)) {

    echo '<div class="menu">';
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
echo '<br /> <p style="color: rgb(41,100,193); text-align: left;">
&nbsp;&nbsp;&nbsp; យើងមាន ភ្ញៀវ 4 នាក់ <br/>
&nbsp;&nbsp;&nbsp; កំពុងបើកមើល <br/> <br/>

&nbsp;&nbsp;&nbsp; ចំនួនអ្នកមើល 376334</p> <br/> <br/>';

echo '</div>';

?>
