<?php 
    session_start();
    if (!isset($_SESSION['userID'])) {
      header('Location: ../login.php');
      exit();
    }
    include './../../Connection/conn.php';
    
    function hasAssociatedSubMenu($conn, $mainID) {
        $query = "SELECT COUNT(*) as count FROM SubMenu_Right_tbl WHERE MainID = $mainID";
        $result = mysqli_query($conn, $query);
        $data = mysqli_fetch_assoc($result);
        return $data['count'] > 0;
    }
  
    $query = "SELECT * FROM MainMenu_Right_tbl ORDER BY sort_order DESC";
    $result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="auto">
<head>
    <?php include '../../src/layouts/Admin/script.php' ?>
    <script src="../../assets/js/color-modes.js"></script>
    <link href="./../../public/assets/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="./../../public/css/dashboard.css" rel="stylesheet">
</head>
<body>
    <?php include '../../src/layouts/Admin/icon.php' ?>
    <?php include '../../src/layouts/Admin/Header.php' ?>
    <div class="container-fluid">
        <div class="row">
            <?php include '../../src/layouts/Admin/admin.php' ?>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Main Right Menu</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group me-2">
                            <button type="button" class="btn btn-sm btn-outline-secondary"><a href="<?=getFullUrl('Admin/RightMenu/add.php')?>">Add</a></button>
                            <button type="button" class="btn btn-sm btn-outline-secondary"><a href="<?=getFullUrl('Admin/RightMenu/SubMenu')?>">Sub Menu</a></button>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle d-flex align-items-center gap-1">
                            <svg class="bi"><use xlink:href="#calendar3"/></svg>
                            This week
                        </button>
                    </div>
                </div>
                <div class="table-responsive small">
                    <table class="table table-striped table-sm">
                        <thead>
                            <tr>
                                <th scope="col">MainID</th>
                                <th scope="col">image</th>
                                <th scope="col">title</th>
                                <th scope="col">link</th>
                                <th scope="col">sub menu</th>
                                <th scope="col">Action</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo '<tr>';
                                    echo '<td>' . $row['MainID'] . '</td>';
                                    echo '<td><img src="./../../public/RightMenuimg/' . $row['image'] . '" alt="" style="width: 75px;"></td>';
                                    echo '<td>' . $row['title'] . '</td>';
                                    echo '<td>' . $row['link'] . '</td>';
                                    echo '<td><a href="SubMenu/index.php?MainID=' . $row['MainID'] . '">views</a></td>';

                                    $hasSubMenu = hasAssociatedSubMenu($conn, $row['MainID']);
                                    
                                    echo "<td>";
                                    echo "<a href='edit.php?id=" . $row['MainID'] . "'>Edit</a>";
                                    echo "</td>";
                                    echo "<td>";
                                    
                                    if ($hasSubMenu) {
                                        echo " | <span onclick=\"alert('You can\'t delete this main item because it has associated sub items.');\">Delete</span>";
                                    } else {
                                        echo " | <a href='#' onclick=\"confirmDelete(" . $row['MainID'] . ")\">Delete</a>";
                                    }
                                    echo "</td>";
                                    echo '</tr>';
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </main>
        </div>
    </div>

    <?php include  '../../src/layouts/Admin/js.php' ?>

    <script>
        function confirmDelete(mainID) {
            if (confirm('Are you sure you want to delete this item?')) {
                window.location.href = 'action.php?id=' + mainID;
            }
        }
    </script>
</body>
</html>
