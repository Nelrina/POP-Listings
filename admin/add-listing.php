<?php
include 'header.php';
$menu = "addlist";
include 'sidebar.php';

include '../src/upload.class.php';

$nameTemp = "";
$urlTemp = "";
$catTemp = "";

// Get all categories
// Category manager creation
$myCatsMan = new MCategory($con);
$myCats = $myCatsMan->getAll();

$myListings = new MListing($con);
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Listings
  </h1>
  <ol class="breadcrumb">
    <li><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
      <li class="active"><a href="categories.php">Listings</a></li>
      <li class="active">Add new listing</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
<?php
    // Form has been sent -- BEG
    if(!empty($_POST)){
        $resup ="";
        $ok = false;
        $nameList = (isset($_POST['listName']))? htmlspecialchars($_POST['listName']):'';
        $urlList = (isset($_POST['listURL']))? strip_tags($_POST['listURL']):'';
        $catList = (isset($_POST['listCat']))? intval($_POST['listCat']):'';
        $imgList = (isset($_FILES['listImg']['name']))? htmlspecialchars($_FILES['listImg']['name']):'';

        $nameTemp = $nameList;
        $urlTemp = $urlList;
        $catTemp = $catList;

        // If one of the fields hadn't been filled
        // We display an error message and display the form again filled with fields already typed
        if($nameList=='' || $urlList=='' || $catList=='')
        {
            $error = "";
            if($nameList=='') $error .= "<p>You must input a name for your listing.</p>";
            if($urlList=='') $error  .= "<p>You must input an URL for your listing.</p>";
            if($catList=='') $error  .= "<p>You must choose a category for your listing.</p>";

            echo <<<"FLERROR"
          <div class="box box-danger">
           <div class="box-header">
            <i class="fa fa-exclamation-triangle"></i>
            <h3 class="box-title">Error !</h3>
          </div><!-- /.box-header -->
            <div class="box-body">
                <p>$error</p>
            </div>
        </div>
FLERROR;
        }
        // No errors detected, we continue the adding of the listing
        else {
            // Object Listing creation
            $newListing = new Listing();

            // A file has been chosen to be uploaded -- BEG
            if($imgList!='') {
            $myImg = new Upload($_FILES['listImg']);

            // Uploading image -- BEG
            if ($myImg->uploaded) {

                $myImg->allowed = array('image/*');

                // Check if the image must be converted to another format or else let the image to its original format
                switch ($_SESSION['TYPE']) {
                    case 'png': $myImg->image_convert = 'png';
                                break;
                    case 'gif': $myImg->image_convert = 'gif';
                                break;
                    case 'jpeg': $myImg->image_convert = 'jpeg';
                                break;
                }

                // Save uploaded image with no changes getcwd() ??
                $myImg->Process($_SESSION['PATH']);

                // Upload succeed, insert data in DB -- BEG
                if ($myImg->processed) {
                    $myImg->clean();

                    // If file has been renamed : happens when we upload a file with the same name as a file previously uploaded
                    if($myImg->file_dst_name != $imgList) $imgList = $myImg->file_dst_name;

                    // Adding listing in DB
                    $newListing->hydrate($nameList, $urlList, $imgList, $catList);
                    $myListings->add($newListing);

                    echo <<<"FLADDED"
                    <div class="box box-primary">
                        <div class="box-header">
                            <i class="fa fa-lightbulb-o"></i>
                            <h3 class="box-title">Success !</h3>
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <p>Image uploaded in {$_SESSION['PATH']} directory.</p>
                            <p>Listing <a href="{$newListing->getUrl()}">
                            <img src="{$_SESSION['URL']}/{$newListing->getImg()}" /> - {$newListing->getName()}</a> added !</p>
                        </div>
                    </div>
FLADDED;
                } // Upload succeed, insert data in DB -- END
                // Upload failed -- BEG
                else {
                    $myImg->clean();
                    echo <<<"FLDNT"
                    <div class="box box-danger">
                        <div class="box-header">
                            <i class="fa fa-exclamation-triangle"></i>
                            <h3 class="box-title">Error !</h3>
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <p>Error : {$myImg->error}</p>
                            <p>Listing not added !</p>
                        </div>
                    </div>
FLDNT;
                } // Upload failed -- BEG
            } // Uploading image -- END
        } // A file has been chosen to be uploaded -- END
        // No file has been chosen to be uploaded -- BEG
        else {
                // We add a text link
                // Adding listing in DB
                $newListing->hydrate($nameList, $urlList, $imgList, $catList);
                $myListings->add($newListing);

                echo <<<"FLADDED2"
                <div class="box box-primary">
                    <div class="box-header">
                        <i class="fa fa-lightbulb-o"></i>
                        <h3 class="box-title">Success !</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <p>No image has been uploaded.</p>
                        <p>Listing <a href="{$newListing->getUrl()}">{$newListing->getName()}</a> added as a text link !</p>
                    </div>
                </div>
FLADDED2;
            } // No file has been chosen to be uploaded -- END
            // Resetting vars
            $nameTemp = "";
            $urlTemp = "";
            $catTemp = "";
        }
    } // Form has been sent -- END
    ?>
  <!-- Your Page Content Here -->
    <div class="col-md-6">
  <!-- Horizontal Form -->
      <div class="box box-info">
        <div class="box-header with-border">
          <h3 class="box-title">Add new listing</h3>
        </div><!-- /.box-header -->
        <!-- form start -->
        <form class="form-horizontal" role="form" enctype="multipart/form-data" method="post" action="<?php echo basename(__FILE__); ?>">
          <div class="box-body">
            <div class="form-group">
              <label for="listName" class="col-sm-2 control-label">Name</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="listName" name="listName" placeholder="Name" value="<?php echo $nameTemp; ?>">
              </div>
            </div>
            <div class="form-group">
              <label for="listURL" class="col-sm-2 control-label">URL</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="listURL" name="listURL" placeholder="URL" value="<?php echo $urlTemp; ?>">
              </div>
            </div>
            <div class="form-group">
              <label for="listImg" class="col-sm-2 control-label">Image</label>
              <div class="col-sm-10">
              <input type="hidden" name="MAX_FILE_SIZE" value="102400" />
              <input type="file" id="listImg" name="listImg">
              </div>
            </div>
            <div class="form-group">
              <label for="listCat" class="col-sm-2 control-label">Category</label>
              <div class="col-sm-10">
                <select id="listCat" name="listCat" class="form-control">
                    <option value="" ></option>
                <?php
                    // Get all cats and display them in select field
                    foreach ($myCats as $cat) {
                        if($cat->getCid()==$catTemp)
                            echo "<option selected='selected' value='" . $cat->getCid() . "'>" . $cat->getCname() . "</option>";
                        else echo "<option value='" . $cat->getCid() . "'>" . $cat->getCname() . "</option>";
                    }
                ?>
              </select>
                </div>
            </div>
          <div class="box-footer">
            <button type="submit" class="btn btn-info pull-right">Add</button>
          </div><!-- /.box-footer -->
        </form>
          </div><!-- /.box-body -->
      </div><!-- /.box -->
    </div>
    <div class="col-md-6"></div>
  <!-- End Of Your Page Content Here -->
  </section><!-- /.content -->
</div><!-- /.content-wrapper -->

<?php
include 'footer.php';
?>
