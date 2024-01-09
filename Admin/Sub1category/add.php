<?php 
    include './../../Connection/conn.php';
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
    <form action="action.php" method="post">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Add Sub Category</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
          <div class="btn-group me-2">
            <button type="submit" class="btn btn-sm btn-outline-secondary" name="insert">insert</button>
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
        <div class="mb-3 px-1">
            <label for="Sub1CategoryNameKH" class="form-label">Category Title(KH)</label>
            <input type="text" class="form-control" id="Sub1CategoryNameKH" name="Sub1CategoryNameKH">
        </div>
        <div class="mb-3 px-1">
            <label for="Sub1CategoryNameEN" class="form-label">Category Title(EN)</label>
            <input type="text" class="form-control" id="Sub1CategoryNameEN" name="Sub1CategoryNameEN">
        </div>
        <div class="mb-3 px-1">
            <label for="MainCategoryID" class="form-label">Select Main Category</label>
            <select class="form-select" id="MainCategoryID" name="MainCategoryID">
                <option value="">Select Main Category</option>
                <?php
                include './../../Connection/conn.php';
                
                $mainCategoryQuery = "SELECT * FROM MainCategory_tbl";
                $mainCategoryResult = mysqli_query($conn, $mainCategoryQuery);

                while ($row = mysqli_fetch_assoc($mainCategoryResult)) {
                    echo "<option value='" . $row['MainCategoryID'] . "'>" . $row['mainCategoryTitleEN'] . "</option>";
                }
                ?>
            </select>
        </div>
        </table>
      </div>
    </main>
    </form>
  </div>
</div>

<?php include  '../../src/layouts/Admin/js.php' ?>
</body>
</html>
