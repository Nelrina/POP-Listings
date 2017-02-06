<?php
/*
 *
 * Displays all the categories in a datatable
 * 
 */

include 'header.php';
$menu = "cat";
include 'sidebar.php';

$myCategories = new MCategory($con);
$catTab = $myCategories->getAll();
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Categories
  </h1>
  <ol class="breadcrumb">
    <li><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
    <li class="active">Categories</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">

  <!-- Your Page Content Here -->

<div class="box">
    <div class="box-header">
      <h3 class="box-title ">Manage categories</h3>
        <div class="row">
        <div class="col-md-9"></div>
        <div class="col-md-3"><a href="add-category.php" class="btn btn-success btn-block">Add a new category</a></div>
        </div>
    </div><!-- /.box-header -->
    <div class="box-body">
      <table id="categories" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Operations</th>
          </tr>
        </thead>
        <tbody>
            <?php
                // Displaying each row of the table
                //   Id   |   Name   |   Edit - Delete
                foreach($catTab as $cat) {
                    echo "<tr><td>" . $cat->getCid() . "</td><td>" . $cat->getCname() . "</td>
                          <td><a href='edit-category.php?idcat=" . $cat->getCid() . "'  class='btn btn-warning'><i class='fa fa-edit'> Edit</i></a>
                          <a href='del-category.php?idcat=" . $cat->getCid() . "'  class='btn btn-danger'><i class='fa fa-trash'> Delete</i></a></td></tr>";
    }
            ?>
        </tbody>
        <tfoot>
          <tr>
            <th>ID</th>
            <th>Name</th>
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
