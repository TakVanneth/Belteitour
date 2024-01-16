<?php 
    session_start();
    if (!isset($_SESSION['userID']))  {
      header('Location: ../login.php');
      exit();
    }
    include './../../Connection/conn.php';
    $query = "SELECT * FROM About_tbl ORDER BY id DESC";
    $result = mysqli_query($conn, $query);
    
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="auto">
  <head>
    <?php include '../../src/layouts/Admin/script.php' ?>
    <script src="../../assets/js/color-modes.js"></script>
  <link href="./../../public/assets/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="./../../public/css/dashboard.css" rel="stylesheet">
<style>
  img {
    width: 100px;
  }
</style>
  </head>
  <body>
  <?php include '../../src/layouts/Admin/icon.php' ?>

  <?php include '../../src/layouts/Admin/Header.php' ?>
  <div class="container-fluid">
  <div class="row">
  <?php include '../../src/layouts/Admin/admin.php' ?>
  <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <form action="">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Main Category</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
          <div class="btn-group me-2">
            <?php if ($_SESSION['role'] == 'Admin' || $_SESSION['role'] == 'Manager') {
                echo '<button type="button" class="btn btn-sm btn-outline-secondary"><a href="' . getFullUrl('Admin/Aboutbelteitour/add.php') . '">Add</a></button>';
            } ?>
            <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
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
              <th scope="col">Image</th>
              <th scope="col">ID</th>
              <th scope="col">title</th>
              <th scope="col">Category</th>
              <th scope="col">Details</th>
              <!-- <th scope="col">Date Post</th> -->
              <?php if ($_SESSION['role'] == 'Admin' || $_SESSION['role'] == 'Manager') { ?>
              <th scope="col">Action</th>
              <?php } ?>
            </tr>
          </thead>
          <tbody>
            <?php 
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo '<td><img src="./../../public/uploads/about/' . $row['imagedetails_1'] . '" alt=""></td>';
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $row['title'] . "</td>";
                echo "<td>" . $row['Sub1CategoryID'] . "</td>";
                echo "<td>" . ' ' . "</td>";
                if ($_SESSION['role'] == 'Admin' || $_SESSION['role'] == 'Manager') {
                echo "<td>" . "<a href='edit.php?id=" . $row['id'] . "'>Edit</a>"
                . " | <a href='delete.php?id=" . $row['id'] . "' onclick=\"return confirm('Do you want to delete this Category?')\">Delete</a>" . "</td>";
                }
                echo "</tr>";
            }            
            ?>
          </tbody>
        </table>
      </div>
    </main>
    </form>
  </div>
</div>

<?php include  '../../src/layouts/Admin/js.php' ?>
</body>
</html>
