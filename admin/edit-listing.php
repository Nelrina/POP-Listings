<?php
include 'header.php';
$menu = "editlist";
include 'sidebar.php';

require '../src/upload.class.php';

// Get all categories
// Category manager creation
$myCatsMan = new MCategory($con);
$myCats = $myCatsMan->getAll();

$manager = new MListing($con);
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
      <li class="active">Edit listing</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
<?php

// Form has been sent -- BEG
if(!empty($_POST)){
    $message ="";

    // Object Listing creation
    $upListing = new Listing();

    $idListi  = intval($_POST['idList']);
    $nameList = (isset($_POST['listName']))? htmlspecialchars($_POST['listName']):'';
    $urlList  = (isset($_POST['listUrl']))? strip_tags($_POST['listUrl']):'';
    $catList  = (isset($_POST['listCat']))? intval($_POST['listCat']):'';
    $imgOld   = (isset($_POST['imgOld']))? htmlspecialchars($_POST['imgOld']):'';
    $delImg   = (isset($_POST['delImg']))? (($_POST['delImg']==1)?1:0):0;
    $imgList  = (isset($_FILES['listImg']['name']))? htmlspecialchars($_FILES['listImg']['name']):'';

    echo ($delImg==1)?"coché":"pas coché";
    // If one of the fields hadn't been filled
    // We display an error message and display the form again filled with fields already typed
    if($nameList=='' || $urlList==''){
        $error = "";
        if($nameList=='') $error .= "<p>You must input a name for your listing.$nameList</p>";
        if($urlList=='') $error  .= "<p>You must input an URL for your listing.$urlList</p>";

        echo <<<"FLERROR"
      <div class="box box-danger">
       <div class="box-header">
        <i class="fa fa-exclamation-triangle"></i>
        <h3 class="box-title">Error !</h3>
      </div><!-- /.box-header -->
        <div class="box-body">
            <p>$error</p>
            <p><a href="edit-listings.php?idlist=$idListi"><i class="fa fa-arrow-circle-left"></i> Go back to edit.</a></p>
        </div>
    </div>
FLERROR;
    }
    // No errors detected, we continue the modification of the listing
    // A file has been chosen to be uploaded -- BEG
    //--------------------------------------------------------
    elseif ($imgList !=''){
        $myImg = new Upload($_FILES['listImg']);

        // Uploading image -- BEG
        if ($myImg->uploaded) {
            // If there is an old image to delete
            if ($imgOld != '') { echo "Suppression ancienne image";
                // If image can be deleted
                if (unlink ($_SESSION['PATH'] . $imgOld)) $message .= "Note : Old image <b>" . $imgOld . "</b> deleted !";
                else $message .= "Note : An error occured, old image <b>" . $imgOld . "</b> can\'t be deleted !";
            }

            // Processing the upload of the new image
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
            if ($myImg->processed) { echo "Upload nouvelle image OK";
                $myImg->clean();

                // If file has been renamed : happens when we upload a file with the same name as a file previously uploaded
                if($myImg->file_dst_name != $imgList) $imgList = $myImg->file_dst_name;

                // Modifying listing in DB
                $upListing->hydrate($nameList, $urlList, $imgList, $catList, $idListi);
                $manager->update($upListing);

                $src = $_SESSION['URL'] . $upListing->getImg();
                $url = $upListing->getUrl();
                echo <<<"FLADDED"
                <div class="box box-primary">
                    <div class="box-header">
                        <i class="fa fa-lightbulb-o"></i>
                        <h3 class="box-title">Success !</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <p>Image uploaded in {$_SESSION['PATH']} directory.<br />$message</p>
                        <p>Listing <a href="$url">
                        <img src="$src" /> - {$upListing->getName()}</a> updated !</p>
                        <p><a href="listings.php"><i class="fa fa-arrow-circle-left"></i> Go back to listings.</a></p>
                    </div>
                </div>
FLADDED;
            } // Upload succeed, insert data in DB -- END
            // Upload failed -- BEG
            else { echo "Upload nouvelle image raté";
                $myImg->clean();

                // Modifying listing in DB, excepting the image
                $upListing->hydrate($nameList, $urlList, "", $catList, $idListi);
                $manager->update($upListing);

                $url = $upListing->getUrl();
                echo <<<"FLADDED2NOTIMG"
                <div class="box box-primary">
                    <div class="box-header">
                        <i class="fa fa-lightbulb-o"></i>
                        <h3 class="box-title">Success !</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <p>Error : {$myImg->error}
                        You can try to upload an image later.</p>
                        <p>Listing <a href="$url">{$upListing->getName()}</a> updated !</p>
                        <p><a href="listings.php"><i class="fa fa-arrow-circle-left"></i> Go back to listings.</a></p>
                    </div>
                </div>
FLADDED2NOTIMG;
            } // Upload failed -- BEG
        } // Uploading image -- END
      }//------------------------------------------------------------
    // No file has been chosen to be uploaded -- BEG

    else { echo "Pas de nouvelle image à uploader";
      // If the checkbox has been checked - deleting the old image
      if ($delImg == 1) { echo "On supprime ancienne image";
          // If image can be deleted
          if (unlink ($_SESSION['PATH'] . $imgOld)) {
            // Modifying to a text link
            $message .= "Note : Old image <b>" . $imgOld . "</b> deleted !";
            $upListing->hydrate($nameList, $urlList, "", $catList, $idListi);
          }
          else {
            $message .= "Note : An error has occured, old image <b>" . $_SESSION['PATH'] . $imgOld . "</b> can\'t be deleted !";
            $upListing->hydrate($nameList, $urlList, $imgOld, $catList, $idListi);
          }
      }
      else {
        $upListing->hydrate($nameList, $urlList, $imgOld, $catList, $idListi);
      }

      $manager->update($upListing);

      $src = $_SESSION['URL'] . $upListing->getImg();
      $url = $upListing->getUrl();
      echo <<<"FLUP"
      <div class="box box-primary">
          <div class="box-header">
              <i class="fa fa-lightbulb-o"></i>
              <h3 class="box-title">Success !</ h3>
          </div><!-- /.box-header -->
          <div class="box-body">
              <p>$message</p>
              <p>Listing <a href="$url">
              <img src="$src" /> - {$upListing->getName()}</a> updated !</p>
              <p><a href="listings.php"><i class="fa fa-arrow-circle-left"></i> Go back to listings.</a></p>
          </div>
      </div>
FLUP;
        } // No file has been chosen to be uploaded -- END
} // Form has been sent -- END
else {
    // Displaying the listing to edit
    // We create a Listing objet with the id from the _GET to fill the form
    $id = intval($_GET['idlist']);
    $editListing = new Listing();

    $editListing = $manager->getOne($id);
?>
  <!-- Your Page Content Here -->
    <div class="col-md-6">
  <!-- Horizontal Form -->
      <div class="box box-success">
        <div class="box-header with-border">
          <h3 class="box-title">Edit listing</h3>
        </div><!-- /.box-header -->
        <!-- form start -->
        <form class="form-horizontal" role="form" enctype="multipart/form-data" method="post" action="<?php echo basename(__FILE__); ?>">
          <div class="box-body">
            <div class="form-group">
              <label for="listName" class="col-sm-2 control-label">Name</label>
              <div class="col-sm-10">
                <input type="name" class="form-control" id="listName" name="listName" value="<?php echo $editListing->getName(); ?>" />
                <input type="hidden" name="idList" value="<?php echo $editListing->getId(); ?>" />
              </div>
            </div>
            <div class="form-group">
              <label for="listUrl" class="col-sm-2 control-label">URL</label>
              <div class="col-sm-10">
                <input type="name" class="form-control" id="listUrl" name="listUrl" value="<?php echo $editListing->getUrl(); ?>" />
              </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Image</label>
                <div class="col-sm-10">
                <?php
                    // If it's an image link, we display image
                    if ($editListing->getImg() != "") {
                ?>
                    <input type="hidden" id="imgOld" name="imgOld" value="<?php echo $editListing->getImg(); ?>" />
                    <img src="<?php echo $_SESSION['URL'] . $editListing->getImg(); ?>" title="<?php echo $editListing->getImg(); ?>" alt="<?php echo $editListing->getImg(); ?>" /><br />
                    <label for="delImg"><input type="checkbox" name="delImg" id="delImg" value="1" /> Delete image ?</label>
                <?php
                    }
                ?>
                    <input type="hidden" name="MAX_FILE_SIZE" value="102400" />
                    <input type="file" id="listImg" name="listImg">
                </div>
            </div>
            <div class="form-group">
              <label for="listCat" class="col-sm-2 control-label">Category</label>
              <div class="col-sm-10">
                <select id="listCat" name="listCat" class="form-control">
                <?php
                    // Get all cats and display them in select field
                    foreach ($myCats as $cat) {
                        if($cat->getCid() == $editListing->getCat())
                            echo "<option selected='selected' value='" . $cat->getCid() . "'>" . $cat->getCname() . "</option>";
                        else echo "<option value='" . $cat->getCid() . "'>" . $cat->getCname() . "</option>";
                    }
                ?>
              </select>
                </div>
            </div>
          <div class="box-footer">
            <button type="submit" class="btn btn-success pull-right">Edit</button>
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
