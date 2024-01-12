<?php 
    session_start();
    if (!isset($_SESSION['userID'])) {
      header('Location: ../../login.php');
      exit();
    }
    include './../../../constants.php';
    include './../../../Connection/conn.php';
    if(isset($_GET['MainID'])) {
        $mainID = $_GET['MainID'];
        $query = "SELECT SubMenu_Right_tbl.MainID, SubMenu_Right_tbl.SubID, SubMenu_Right_tbl.image, SubMenu_Right_tbl.title AS sub_title, SubMenu_Right_tbl.link, MainMenu_Right_tbl.title AS main_title 
                  FROM SubMenu_Right_tbl 
                  LEFT JOIN MainMenu_Right_tbl ON SubMenu_Right_tbl.MainID = MainMenu_Right_tbl.MainID 
                  WHERE SubMenu_Right_tbl.MainID = $mainID 
                  ORDER BY SubMenu_Right_tbl.sort_order DESC";
        $result = mysqli_query($conn, $query);
    } else {
        $query = "SELECT SubMenu_Right_tbl.MainID, SubMenu_Right_tbl.SubID, SubMenu_Right_tbl.image, SubMenu_Right_tbl.title AS sub_title, SubMenu_Right_tbl.link, MainMenu_Right_tbl.title AS main_title 
                  FROM SubMenu_Right_tbl 
                  LEFT JOIN MainMenu_Right_tbl ON SubMenu_Right_tbl.MainID = MainMenu_Right_tbl.MainID 
                  ORDER BY SubMenu_Right_tbl.sort_order DESC";
        $result = mysqli_query($conn, $query);
    }
    $addLink = isset($mainID) ? getFullUrl('Admin/RightMenu/SubMenu/add.php?id=' . $mainID) : getFullUrl('Admin/RightMenu/SubMenu/add.php');
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="auto">
  <head>
    <?php include '../../../src/layouts/Admin/script.php' ?>
    <script src="../../../assets/js/color-modes.js"></script>
  <link href="./../../../public/assets/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="./../../../public/css/dashboard.css" rel="stylesheet">
  </head>
  <body>
  <?php include '../../../src/layouts/Admin/icon.php' ?>

  <?php include '../../../src/layouts/Admin/Header.php' ?>
  <div class="container-fluid">
  <div class="row">
  <?php include '../../../src/layouts/Admin/admin.php' ?>
  <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <!-- <h1 class="h2">Main Right Menu</h1> -->
        <?php
        if(isset($_GET['MainID'])) {
            if(mysqli_num_rows($result) > 0) {
                $query = "SELECT * FROM MainMenu_Right_tbl WHERE MainID = $mainID";
                $title = mysqli_query($conn, $query);
                while ($row = mysqli_fetch_assoc($title)) {
                    echo '<h1 class="h2">' . $row['title'] . ' Items</h1>';
                }
            } else {
                // echo '<script>alert("No records found for MainID: ' . $mainID . '");</script>';
                // echo '<script>window.history.back();</script>';
                // exit;
                $query = "SELECT * FROM MainMenu_Right_tbl WHERE MainID = $mainID";
                $title = mysqli_query($conn, $query);
                while ($row = mysqli_fetch_assoc($title)) {
                echo '<h1 class="h2">No items found for : ' . $row['title'] . '</h1>';
                }
            }        
        } else {
            echo '<h1 class="h2">All Submenu Items</h1>';
        }
        ?>
        <div class="btn-toolbar mb-2 mb-md-0">
          <div class="btn-group me-2">
          <button type="button" class="btn btn-sm btn-outline-secondary">
            <a href="<?= $addLink ?>">Add</a>
        </button>
            <button type="button" class="btn btn-sm btn-outline-secondary"><a href="<?= getFullUrl('Admin/RightMenu') ?>">Back to Main</a></button>
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
              <th scope="col">SubID</th>
              <th scope="col">image</th>
              <th scope="col">title</th>
              <th scope="col">link</th>
              <th scope="col">Action</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
          <?php
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<tr>';
                echo '<td>' . $row['main_title'] . '</td>';
                echo '<td>' . $row['SubID'] . '</td>';
                echo '<td><img src="./../../../public/RightMenuimg/' . $row['image'] . '" alt="" style="width: 75px;"></td>';
                echo '<td>' . $row['sub_title'] . '</td>';
                echo '<td>' . $row['link'] . '</td>';
                echo "<td>";
                echo "<a href='edit.php?id=" . $row['SubID'] . "'>Edit</a>";
                echo "</td>";
                echo "<td> | <a href='#' onclick=\"confirmDelete(" . $row['SubID'] . ")\">Delete</a></td>";
                echo '</tr>';
            }
            ?>
          </tbody>
        </table>
      </div>
    </main>
  </div>
</div>

<?php include  '../../../src/layouts/Admin/js.php' ?>
<script>
        function confirmDelete(SubID) {
            if (confirm('Are you sure you want to delete this item?')) {
                window.location.href = 'action.php?id=' + SubID;
            }
        }
    </script>
</body>
</html>
