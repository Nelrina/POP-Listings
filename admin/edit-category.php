<?php
include 'header.php';
$menu = "editcat";
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
      <li class="active">Edit category</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">

  <!-- Your Page Content Here -->
<?php
// If form sent
if(!empty($_POST)){
    $nameCat = (isset($_POST['newCatName']) && !empty($_POST['newCatName']))? htmlspecialchars($_POST['newCatName']):'';
    $idCat = (isset($_POST['idCat']) && !empty($_POST['idCat']))? intval($_POST['idCat']):'';

    if ($nameCat != '')
    {
        $newCategory = new Category();
        $newCategory->hydrate($nameCat, $idCat);

        // Update Category in the DB
        $manager->update($newCategory);

        // Display a message box when Category is edited
        echo <<<"FLEDITED"
            <div class="box box-success">
             <div class="box-header">
              <i class="fa fa-lightbulb-o"></i>
              <h3 class="box-title">Success !</h3>
            </div><!-- /.box-header -->
              <div class="box-body">
                  <p>Category $nameCat edited !</p>
                  <p><a href="categories.php"><i class="fa fa-arrow-circle-left"></i> Go back to categories.</a></p>
              </div>
          </div>
FLEDITED;
    }
    else
    {
        // Display a message box if the user delete the name and don't type a new name and gives a link to go back to the edit form of the Categoy
        echo <<<"FLNOTADDED"
        <div class="box box-danger">
            <div class="box-header">
                <i class="fa fa-exclamation-triangle"></i>
                <h3 class="box-title">Error !</h3>
            </div><!-- /.box-header -->
            <div class="box-body">
                <p>You must input a name for your category.</p>
                <p><a href="edit-category.php?idcat=$idCat"><i class="fa fa-arrow-circle-left"></i> Go back to edit.</a></p>
            </div>
        </div>
FLNOTADDED;
    }
    }
else {
    // If the form hasn't been sent
    // We create a Category objet with the id from the _GET to fill the form
    $id = (isset($_GET['idcat']) && !empty($_GET['idcat']))? intval($_GET['idcat']):'';
    $editCategory = new Category();

    $editCategory = $manager->getOne($id);
?>
    <div class="col-md-6">
    <!-- Horizontal Form -->
      <div class="box box-success">
        <div class="box-header with-border">
          <h3 class="box-title">Edit category</h3>
        </div><!-- /.box-header -->
        <!-- form start -->
        <form class="form-horizontal" method="post" action="<?php echo basename(__FILE__); ?>">
          <div class="box-body">
            <div class="form-group">
              <label for="newCatName" class="col-sm-3 control-label">Category name</label>
              <div class="col-sm-9">
                <input type="name" class="form-control" id="newCatName" name="newCatName" value="<?php echo $editCategory->getCname(); ?>" />
                <input type="hidden" name="idCat" value="<?php echo $editCategory->getCid(); ?>" />
              </div>
            </div>
          </div><!-- /.box-body -->
          <div class="box-footer">
            <button type="submit" class="btn btn-success pull-right">Edit</button>
          </div><!-- /.box-footer -->
        </form>
      </div><!-- /.box -->
    </div>
    <div class="col-md-6"></div>
    <?php } ?>
  <!-- End Of Your Page Content Here -->
  </section><!-- /.content -->
</div><!-- /.content-wrapper -->

<?php
include 'footer.php';
?>
