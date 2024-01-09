<?php 
    include './../../Connection/conn.php';
    $query = "SELECT s.Sub1CategoryID, s.Sub1CategoryNameKH, s.Sub1CategoryNameEN, s.MainCategoryID, s.Date, m.mainCategoryTitleEN
    FROM Sub1Category_tbl s
    LEFT JOIN MainCategory_tbl m ON s.MainCategoryID = m.MainCategoryID";

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
        <h1 class="h2">Sub1 Category</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
          <div class="btn-group me-2">
          <button type="button" class="btn btn-sm btn-outline-secondary"><a href="<?=getFullUrl('Admin/Sub1category/add.php')?>">Add</a></button>
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
              <th scope="col">ID</th>
              <th scope="col">Categiry Name(KH)</th>
              <th scope="col">Categiry Name(EN)</th>
              <th scope="col">Main Category</th>
              <th scope="col">Date Post</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
          <?php
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['Sub1CategoryID'] . "</td>";
                echo "<td>" . $row['Sub1CategoryNameKH'] . "</td>";
                echo "<td>" . $row['Sub1CategoryNameEN'] . "</td>";
                echo "<td>";

                if ($row['mainCategoryTitleEN'] !== null) {
                    echo $row['mainCategoryTitleEN'];
                } else {
                    echo "No main category found";
                }

                echo "</td>";
                echo "<td>" . $row['Date'] . "</td>";
                echo "<td>" . "<a href='edit.php?id=" . $row['Sub1CategoryID'] . "'>Edit</a>" 
                . " | <a href='action.php?id=" . $row['Sub1CategoryID'] . "'>Delete</a>" . "</td>";
                echo "</tr>";
                  }
              ?>
          </tbody>
        </table>
      </div>
    </main>
  </div>
</div>

<?php include  '../../src/layouts/Admin/js.php' ?>

</body>
</html>
