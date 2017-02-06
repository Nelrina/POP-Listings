<?php
include 'header.php';
$menu = "dellist";
include 'sidebar.php';

// Listing manager creation
$manager = new MListing($con);
$message = "";
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Listings
    <small></small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
      <li class="active"><a href="listings.html">Listings</a></li>
      <li class="active">Delete listing</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">

  <!-- Your Page Content Here -->
    <?php
    // If form sent
    if(!empty($_POST)){
        // Category manager creation
        $id = intval($_POST['idList']);

        $delListing = new Listing();

        $delListing = $manager->getOne($id);
        $nameList = $delListing->getName();
        $imgList = $delListing->getImg();

        // If there is an image
        if ($imgList != '') {
            // If image can be deleted
            if (unlink ($_SESSION['PATH'] . $imgList))
            {
                // Listing is deleted from db too
                $manager->delete($delListing);
                $message .= "Listing <b>" . $nameList . "</b> deleted !";
            }
            else $message .= "An error has occured, listing <b>" . $nameList . "</b> cannot be deleted !";
        }
        // If this is a text link
        else
        {
            // Listing is deleted from db too
                $manager->delete($delListing);
                $message .= "Listing <b>" . $nameList . "</b> deleted !";
        }
        echo <<<"FLDELETED"
        <div class="box box-danger">
         <div class="box-header">
          <i class="fa fa-lightbulb-o"></i>
          <h3 class="box-title">Info</h3>
        </div><!-- /.box-header -->
          <div class="box-body">
              <p>$message</p>
              <p><a href="listings.php"><i class="fa fa-arrow-circle-left"></i> Go back to listings.</a></p>
          </div>
      </div>
FLDELETED;
    }
    else {
      // If the form hasn't been sent
      // We create a Listing objet with the id from the _GET to fill the form
      $id = intval($_GET['idlist']);
      $delListing = new Listing();

      $delListing = $manager->getOne($id);
    ?>
<div class="col-md-6">
<!-- Horizontal Form -->
  <div class="box box-danger">
    <div class="box-header with-border">
      <h3 class="box-title">Delete listing</h3>
    </div><!-- /.box-header -->
    <!-- form start -->
    <form class="form-horizontal" role="form" method="post" action="<?php echo basename(__FILE__); ?>">
      <div class="box-body">
        <div class="form-group">
          <label for="listName" class="col-sm-2 control-label">Name</label>
          <div class="col-sm-10">
            <input type="name" class="form-control" id="inputListName" value="<?php echo $delListing->getName(); ?>" disabled>
              <input type="hidden" name="idList" value="<?php echo $delListing->getId(); ?>" />
          </div>
        </div>
        <div class="form-group">
          <label for="listURL" class="col-sm-2 control-label">URL</label>
          <div class="col-sm-10">
            <input type="name" class="form-control" id="listURL" value="<?php echo $delListing->getUrl(); ?>" disabled>
          </div>
        </div>
        <?php
            // If it's an image link, we display image
            if ($delListing->getImg() != "") {
        ?>
        <div class="form-group">
            <label class="col-sm-2 control-label">Image</label>
            <div class="col-sm-10">
            <img src="<?php echo  $_SESSION['URL'] . $delListing->getImg(); ?>" />
            </div>
        </div>
        <?php
            }
        ?>
        <div class="form-group">
          <label for="catList" class="col-sm-2 control-label">Category</label>
          <div class="col-sm-10">
              <select id="catList" class="form-control" disabled>
                <?php
                    // Display all categories
                    $cat = $manager->getCategory($delListing->getCat());
                    echo "<option selected value='" . $cat['cat'] . "'>" . $cat['cname'] . "</option>";

                ?>
          </select>
            </div>
        </div>
      <div class="box-footer">
        <button type="submit" class="btn btn-danger pull-right">Delete</button>
      </div><!-- /.box-footer -->
    </form>
      </div><!-- /.box-body -->
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
