<?php 
    include './../../Connection/conn.php';
    if(isset($_GET['id']) && !empty($_GET['id'])) {
        $id = $_GET['id'];
        $query = "SELECT * FROM MainMenu_Right_tbl WHERE MainID = $id";
        $result = mysqli_query($conn, $query);
    }
    $conn->close();
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
    <form method="POST" action="action.php" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $row['$id '] ?>">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Edit Main items</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
          <div class="btn-group me-2">
            <button type="submit" class="btn btn-sm btn-outline-secondary" name="update">update</button>
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
        <?php 
            while ($row = mysqli_fetch_assoc($result)) {
        ?>
        <div class="mb-3 px-1">
            <label for="title" class="form-label">title</label>
            <input type="text" class="form-control" id="title" name="title" value="<?php echo $row['title']; ?>">
        </div>
        <div class="mb-3 px-1">
            <label for="link" class="form-label">link</label>
            <input type="text" class="form-control" id="link" name="link" value="<?php echo $row['link']; ?>">
        </div>
        <div class="mb-3 px-1">
            <label for="sort_order" class="form-label">sort_order</label>
            <input type="text" class="form-control" id="sort_order" name="sort_order" value="<?php echo $row['sort_order']; ?>">
        </div>
        
        <div class="mb-3 px-1">
            <label for="image" class="form-label">image</label>
            <input type="file" name="image" id="image" class="form-control" value="<?php echo $row['image']; ?>">
        </div>
        <img id="preview-image" width="100%" class="mb-2">
        <?php } ?>
        </table>
      </div>
    </form>
    </main>
  </div>
</div>

<?php include  '../../src/layouts/Admin/js.php' ?>
<script src="../../public/js/jquery.min.js"></script>
<script>
    $(document).ready(function() {

        // Preview image
        $('#image').change(function() {

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
</body>
</html>
