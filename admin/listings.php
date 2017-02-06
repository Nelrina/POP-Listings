<?php
/*
 *
 * Displays all the listings in a datatable
 *
 */

include 'header.php';
$menu = "list";
include 'sidebar.php';

$myListings = new MListing($con);
$listTab = $myListings->getAll();

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
          <h3 class="box-title">Manage listings</h3>
            <div class="row">
                <div class="col-md-9"></div>
                <div class="col-md-3"><a href="add-listing.php" class="btn btn-success btn-block">Add a new listing</a></div>
            </div>
        </div><!-- /.box-header -->
        <div class="box-body">
          <table id="listings" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>ID</th>
                <th>Name</th>
                <th>URL</th>
                <th>Image</th>
                <th>Category</th>
                <th>Operations</th>
              </tr>
            </thead>
            <tbody>
                <?php
                    // Displaying each row of the table
                    //   Id   |   Name   |   URL   |   IMG   |   Category   |   Edit - Delete
                    foreach($listTab as $list) {
                        $catName = $myListings->getCategory($list->getCat())['cname'];
                        $image = "<img src='" . $_SESSION['URL'] . $list->getImg() . "' title='" . $list->getImg() . "' alt='" . $list->getImg() . "' />";
                        $newpage = ($_SESSION['LT'] == 1)? "target='_blank'":'';
                        echo "<tr><td>" . $list->getId() . "</td><td>" . $list->getName() . "</td><td><a href='" . $list->getUrl() . "' " . $newpage . ">" . $list->getUrl() . "</a></td><td>";
                        if($list->getImg()) echo $image;
                        else echo "text link";
                        echo "</td><td>" . $catName . "</td><td><a href='edit-listing.php?idlist=" . $list->getId() . "'  class='btn btn-warning'><i class='fa fa-edit'> Edit</i></a>
                          <a href='del-listing.php?idlist=" . $list->getId() . "'  class='btn btn-danger'><i class='fa fa-trash'> Delete</i></a></td></tr>";
            }
        ?>
            </tbody>
                <th>ID</th>
                <th>Name</th>
                <th>URL</th>
                <th>Image</th>
                <th>Category</th>
                <th>Operations</th>
              </tr>
            </tfoot>
          </table>
        </div><!-- /.box-body -->
      </div><!-- /.box -->

  <!-- End Of Your Page Content Here -->
  </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<?php
include 'footer.php';
?>
