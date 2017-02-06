<?php
/*
 *
 * Displays all the listings
 *
 */

include 'header.php';
//include 'sidebar.php';

$managerL = new MListing($con);
$myListings = $managerL->getAll();

// Settings manager creation
$managerS = new MSettings($con);
// Displaying all the settings
$mySettings = $managerS->select();

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
    <li class="active">Listings</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">

  <!-- Your Page Content Here -->

<div class="box">
        <div class="box-header">
          <h3 class="box-title">Joined listings</h3>
            <div class="row">
                <div class="col-md-9"></div>
            </div>
        </div><!-- /.box-header -->
        <div class="box-body"> 
            <?php
                foreach($myListings as $list) {
                    //$catName = $managerL->getCategory($list->getCat())['cname'];
                    $image = "<img src='" . $mySettings['domurl'] . $list->getImg() . "' title='" . $list->getName() . "' alt='" . $list->getName() . "' />";
                    $newpage = ($mySettings['linktarget'] == 1)? "target='_blank'":'';
                    echo "<a href='" . $list->getUrl() . "' " . $newpage . ">";
                    if($list->getImg()) echo $image;
                    else echo $list->getName();
                    echo "</a>";
                }
            ?>
        </div><!-- /.box-body -->
      </div><!-- /.box -->

  <!-- End Of Your Page Content Here -->
  </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<?php
include 'footer.php';
?>
