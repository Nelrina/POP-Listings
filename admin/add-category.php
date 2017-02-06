<?php
include 'header.php';
$menu = "addcat";
include 'sidebar.php';
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
      <li class="active"><a href="categories.php">Categories</a></li>
      <li class="active">Add new category</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
      <!-- Your Page Content Here -->
    <?php
    // If form sent
    if(!empty($_POST)){
        // Getting and protecting the name typed in the form
        $nameCat = (isset($_POST['catName']) && !empty($_POST['catName']))? htmlspecialchars($_POST['catName']):'';

        if($nameCat!=''){
            // Category manager creation
            $manager = new MCategory($con);
            // Category created and filled with data from the form
            $newCategory = new Category();
            $newCategory->hydrate($nameCat);

            // Category added in DB
            $res = $manager->add($newCategory);

            // Display message box when Category is added
            echo <<<"FLADDED"
            <div class="box box-primary">
             <div class="box-header">
              <i class="fa fa-lightbulb-o"></i>
              <h3 class="box-title">Success !</h3>
            </div><!-- /.box-header -->
              <div class="box-body">
                  <p>Category $nameCat added !</p>
                  <p><a href="categories.php"><i class="fa fa-arrow-circle-left"></i> Go back to categories.</a></p>
              </div>
          </div>
FLADDED;
        }
        else {
            // Display messagebox if the name hasn't been filled
            echo <<<"FLNOTADDED"
            <div class="box box-danger">
             <div class="box-header">
              <i class="fa fa-exclamation-triangle"></i>
              <h3 class="box-title">Error !</h3>
            </div><!-- /.box-header -->
              <div class="box-body">
                  <p>You must input a name for your category.</p>
              </div>
          </div>
FLNOTADDED;
        }
    }
    ?>
    <div class="col-md-6">
  <!-- Horizontal Form -->
      <div class="box box-info">
        <div class="box-header with-border">
          <h3 class="box-title">Add new category</h3>
        </div><!-- /.box-header -->
        <!-- form start -->
        <form class="form-horizontal" method="post" action="<?php echo basename(__FILE__); ?>">
          <div class="box-body">
            <div class="form-group">
              <label for="catName" class="col-sm-2 control-label">Name</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name ="catName" id="catName" placeholder="Name" value="" />
              </div>
            </div>
          </div><!-- /.box-body -->
          <div class="box-footer">
            <button type="submit" class="btn btn-info pull-right">Add</button>
          </div><!-- /.box-footer -->
        </form>
      </div><!-- /.box -->
    </div>
    <div class="col-md-6"></div>
  <!-- End Of Your Page Content Here -->
  </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<?php
include 'footer.php';
?>
