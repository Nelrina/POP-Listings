<?php
include 'header.php';
$menu = "delcat";
include 'sidebar.php';

// Category manager creation
$manager = new MCategory($con);
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Categories
    <small></small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
      <li class="active"><a href="categories.html">Categories</a></li>
      <li class="active">Delete category</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">

  <!-- Your Page Content Here -->
    <?php
    // If form sent
    if(!empty($_POST)){
        $id = (isset($_POST['idCat']) && !empty($_POST['idCat']))? intval($_POST['idCat']):'';

        $newCategory = new Category();

        // Get the category we want to delete
        $newCategory = $manager->getOne($id);
        $nameCat = $newCategory->getCname();

        // Deleting category from the DB
        $res = $manager->delete($newCategory);

        // Display a message box when category is deleted
        echo <<<"FLDELETED"
        <div class="box box-danger">
         <div class="box-header">
          <i class="fa fa-lightbulb-o"></i>
          <h3 class="box-title">Success !</h3>
        </div><!-- /.box-header -->
          <div class="box-body">
              <p>Category $nameCat deleted !</p>
              <p><a href="categories.php"><i class="fa fa-arrow-circle-left"></i> Go back to categories.</a></p>
          </div>
      </div>
FLDELETED;
    }
    else {
        // If the form hasn't been sent
        // We create a Category objet with the id from the _GET to fill the form
        $id = (isset($_GET['idcat']) && !empty($_GET['idcat']))? intval($_GET['idcat']):'';
        $delCategory = new Category();
        
        // Show the category we want to delete
        $delCategory = $manager->getOne($id);
        $myId = $delCategory->getCid();
    ?>
<div class="col-md-6">
  <!-- Horizontal Form -->
      <div class="box box-danger">
        <div class="box-header with-border">
          <h3 class="box-title">Delete category ?</h3>
          <?php
            switch ($manager->getListCountFromCat($myId)) {
                case 0:
                    echo "<h4><i class='fa fa-info'></i> This category doesn't contains listings.</h4>";
                    break;
                case 1:
                    echo "<h4><i class='fa fa-warning'></i> Warning this category contains 1 listing !</h4>";
                    break;
                default:
                    echo "<h4><i class='fa fa-warning'></i> Warning this category contains <b>" . $manager->getListCountFromCat($myId) . "</b> listings !</h4>";
                    break;
            }
          ?>
        </div><!-- /.box-header -->
        <!-- form start -->
        <form class="form-horizontal" method="post" action="<?php echo basename(__FILE__); ?>">
          <div class="box-body">
            <div class="form-group">
              <label for="catName" class="col-sm-3 control-label">Name</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="catName" name="catName" value="<?php echo $delCategory->getCname(); ?>" disabled>
                  <input type="hidden" name="idCat" value="<?php echo $myId; ?>" />
              </div>
            </div>
          </div><!-- /.box-body -->
          <div class="box-footer">
            <button type="submit" class="btn btn-danger pull-right">Delete</button>
          </div><!-- /.box-footer -->
        </form>
      </div><!-- /.box -->
    </div>
    <div class="col-md-6"></div>
  <!-- End Of Your Page Content Here -->
    <?php } ?>
  </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<?php
include 'footer.php';
?>
