<?php 
    session_start();
    // if (!isset($_SESSION['userID'])) {
    //   header('Location: ../login.php');
    //   exit();
    // }
    if (!isset($_SESSION['userID']) || (isset($_SESSION['role']) && ($_SESSION['role'] !== 'Admin' && $_SESSION['role'] !== 'Manager'))) {
      header('Location: index.php');
      exit();
    }
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
    <form action="action.php" method="post" enctype="multipart/form-data">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Add Main Category</h1>
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
            <label for="mainCategoryTitleKH" class="form-label">Category Title(KH)</label>
            <input type="text" class="form-control" id="mainCategoryTitleKH" name="mainCategoryTitleKH">
        </div>
        <div class="mb-3 px-1">
            <label for="mainCategoryTitleEN" class="form-label">Category Title(EN)</label>
            <input type="text" class="form-control" id="mainCategoryTitleEN" name="mainCategoryTitleEN">
        </div>
        <div class="mb-3 px-1">
            <label for="sort_order" class="form-label">sort_order</label>
            <input type="text" class="form-control" id="sort_order" name="sort_order">
        </div>
        <div class="mb-3 px-1">
            <label for="Categoryimage" class="form-label">Category images</label>
            <input type="file" class="form-control" id="Categoryimage" name="Categoryimage" required>
        </div>
        <img id="preview-image" width="100%" class="mb-2">
        </table>
      </div>
    </main>
    </form>
  </div>
</div>

<?php include  '../../src/layouts/Admin/js.php' ?>
<script src="../../public/js/jquery.min.js"></script>
<script>
    
    $(document).ready(function() {

        // Preview image
        $('#Categoryimage').change(function() {

            let reader = new FileReader();

            reader.onload = (e) => {
                $('#preview-image').attr('src', e.target.result);
                $("#errorMs").hide();
            }
            reader.readAsDataURL(this.files[0]);
        });

    });
</script>
</body>
</html>
