<?php
// Form has been sent -- BEG
if(!empty($_POST)){
    $message ="";
    $ok = false;
    // Object Listing creation
    $upListing = new Listing();

    $id       = intval($_POST['idList']);
    $nameList = (isset($_POST['listName']))? htmlspecialchars($_POST['listName']):'';
    $urlList  = (isset($_POST['listURL']))? strip_tags($_POST['listURL']):'';
    $catList  = (isset($_POST['listCat']))? intval($_POST['listCat']):'';
    $imgOld   = (isset($_POST['imgOld']))? htmlspecialchars($_POST['imgOld']):'';
    $delImg   = (isset($_POST['delImg']))? (($_POST['delImg']==1)?1:0):0;
    $imgList  = (isset($_FILES['listImg']['name']))? htmlspecialchars($_FILES['listImg']['name']):'';

    // If one of the fields hadn't been filled
    // We display an error message and display the form again filled with fields already typed
    if($nameList=='' || $urlList=='')
    {
        $error = "";
        if($nameList=='') $error .= "<p>You must input a name for your listing.</p>";
        if($urlList=='') $error  .= "<p>You must input an URL for your listing.</p>";

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
    // No errors detected, we continue the modification of the listing
    // A file has been chosen to be uploaded -- BEG
    else if ($imgList !=''){
        $myImg = new Upload($_FILES['listImg']);

        // Uploading image -- BEG
        if ($myImg->uploaded) {
            // If there is an old image to delete
            if ($imgOld != '') {
                // If image can be deleted
                if (unlink ($_SESSION['PATH'] . $imgOld)) $message .= "Note : Old image <b>" . $imgOld . "</b> deleted !";
                else $message .= "Note : An error has occured, old image <b>" . $imgOld . "</b> can\'t be deleted !";
            }

            // Processing the upload of the new image
            $myImg->allowed = array('image/*');
            // Save uploaded image with no changes getcwd() ??
            $myImg->Process($_SESSION['PATH']);

            // Upload succeed, insert data in DB -- BEG
            if ($myImg->processed) {
                $myImg->clean();

                // If file has been renamed : happens when we upload a file with the same name as a file previously uploaded
                if($myImg->file_dst_name != $imgList) $imgList = $myImg->file_dst_name;

                // Modifying listing in DB
                $upListing->hydrate($id, $nameList, $urlList, $imgList, $catList);
                $myListings->update($upListing);

                echo <<<"FLADDED"
                <div class="box box-primary">
                    <div class="box-header">
                        <i class="fa fa-lightbulb-o"></i>
                        <h3 class="box-title">Success !</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <p>Image uploaded in {$_SESSION['PATH']} directory.<br />$message</p>
                        <p>Listing <a href="{$upListing->getUrl()}">
                        <img src="{$_SESSION['URL'] . $upListing->getImg()}" /> - {$upListing->getName()}</a> updated !</p>
                    </div>
                </div>
FLADDED;
            } // Upload succeed, insert data in DB -- END
            // Upload failed -- BEG
            else {
                $myImg->clean();

                // Modifying listing in DB, excepting the image
                $upListing->hydrate($id, $nameList, $urlList, $imgOld, $catList);
                $myListings->update($upListing);

                echo <<<"FLADDED2NOTIMG"
                <div class="box box-primary">
                    <div class="box-header">
                        <i class="fa fa-lightbulb-o"></i>
                        <h3 class="box-title">Success !</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <p>Error : {$myImg->error}</p>
                        <p>Old image has been kept.</p>
                        <p>Listing <a href="{$upListing->getUrl()}">
                        <img src="{$_SESSION['URL'] . $upListing->getImg()}" /> - {$upListing->getName()}</a> updated !</p>
                    </div>
                </div>
FLADDED2NOTIMG;
            } // Upload failed -- BEG
        } // Uploading image -- END
      }
    // No file has been chosen to be uploaded -- BEG
    else {
      // If the checkbox has been checked - deleting the old image
      if ($imgOld != '') {
          // If image can be deleted
          if (unlink ($_SESSION['PATH'] . $imgOld)) $message .= "Note : Old image <b>" . $imgOld . "</b> deleted !";
          else $message .= "Note : An error has occured, old image <b>" . $imgOld . "</b> can\'t be deleted !";
      }

      // Modifying to a text link
      // Updating listing in DB
      $upListing->hydrate($id, $nameList, $urlList, "", $catList);
      $myListings->add($upListing);

      echo <<<"FLADDED2"
      <div class="box box-primary">
          <div class="box-header">
              <i class="fa fa-lightbulb-o"></i>
              <h3 class="box-title">Success !</h3>
          </div><!-- /.box-header -->
          <div class="box-body">
              <p>$message</p>
              <p>Listing <a href="{$newListing->getUrl()}">{$newListing->getName()}</a> updated !</p>
          </div>
      </div>
FLADDED2;
        } // No file has been chosen to be uploaded -- END
} // Form has been sent -- END
