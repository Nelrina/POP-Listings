<?php
include 'header.php';
$menu = "index";
include 'sidebar.php';

$myCategories = new MCategory($con);
$nbCat = $myCategories->getCatCount();

$myListings = new MListing($con);
$nbList = $myListings->getListCount();
$lastList = $myListings->getLast();
$randList = $myListings->getRandom();
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Home
  </h1>
  <ol class="breadcrumb">
    <li><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
  </ol>
</section>


<!-- Main content -->
<section class="content">
  <!-- Small boxes (Stat box) -->
  <div class="row">
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-aqua">
        <div class="inner">
          <h3><?php echo $nbList; ?></h3>
          <p>Fanlistings joined</p>
        </div>
        <div class="icon">
          <i class="ion ion-heart"></i>
        </div>
        <a href="listings.php" class="small-box-footer">Manage listings <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div><!-- ./col -->
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-green">
        <div class="inner">
          <h3><?php echo $nbCat; ?></h3>
          <p>Categories</p>
        </div>
        <div class="icon">
          <i class="ion ion-folder"></i>
        </div>
        <a href="categories.php" class="small-box-footer">Manage categories <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div><!-- ./col -->
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-yellow">
        <div class="inner">
          <h3><?php echo "<a href='" . $randList->getUrl() . "'><img src='" . $_SESSION['URL'] . $randList->getImg() . "' alt='". $randList->getName() ."' title='". $randList->getName() ."' /></a>"; ?></h3>
          <p>Random joined - <?php echo $randList->getName(); ?></p>
        </div>
        <div class="icon">
          <i class="ion ion-pound"></i>
        </div>
        <?php echo "<a class='small-box-footer' href='edit-listing.php?idlist=" . $lastList->getId() . "'>Edit <i class='fa fa-arrow-circle-right'></i></a>"; ?>
      </div>
    </div><!-- ./col -->
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-red">
        <div class="inner">
          <h3><?php echo "<a href='" . $lastList->getUrl() . "'><img src='" . $_SESSION['URL'] . $lastList->getImg() . "' alt='". $lastList->getName() ."' title='". $lastList->getName() ."' /></a>"; ?></h3>
          <p>Last joined - <?php echo $lastList->getName(); ?></p>
        </div>
        <div class="icon">
          <i class="ion ion-star"></i>
        </div>
        <?php echo "<a class='small-box-footer' href='edit-listing.php?idlist=" . $lastList->getId() . "'>Edit <i class='fa fa-arrow-circle-right'></i></a>"; ?>
      </div>
    </div><!-- ./col -->
  </div><!-- /.row -->
  <!-- Main row -->
  <div class="row">
    <!-- Left col -->
    <section class="col-lg-7">
      <!-- Custom tabs (Charts with tabs)-->
      <div class="box box-primary">
         <div class="box-header">
          <i class="ion ion-home"></i>
          <h3 class="box-title">Welcome !</h3>
        </div><!-- /.box-header -->
          <div class="box-body">
              <p>Manage your joined fanlistings or just a simple links list !</p>
          </div>
      </div>
    </section><!-- /.Left col -->
    <!-- right col (We are only adding the ID to make the widgets sortable)-->
    <section class="col-lg-5 connectedSortable">

      <!-- TO DO List -->
      <div class="box box-primary">
        <div class="box-header">
          <i class="ion ion-clipboard"></i>
          <h3 class="box-title">To Do List</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
          <ul class="todo-list">
            <li>
              <!-- checkbox -->
              <input type="checkbox" value="" name="">
              <!-- todo text -->
              <span class="text">Join PHP fanlisting</span>
              <!-- Emphasis label -->
              <small class="label label-danger"><i class="fa fa-clock-o"></i> 2 mins</small>
              <!-- General tools such as edit or delete-->
              <div class="tools">
                <i class="fa fa-edit"></i>
                <i class="fa fa-trash-o"></i>
              </div>
            </li>
            <li>
              <input type="checkbox" value="" name="">
              <span class="text">Find new fanlistings to join</span>
              <small class="label label-info"><i class="fa fa-clock-o"></i> 4 hours</small>
              <div class="tools">
                <i class="fa fa-edit"></i>
                <i class="fa fa-trash-o"></i>
              </div>
            </li>
            <li>
              <input type="checkbox" value="" name="">
              <span class="text">Visit thefanlistings.org for updates</span>
              <small class="label label-warning"><i class="fa fa-clock-o"></i> 5 day</small>
              <div class="tools">
                <i class="fa fa-edit"></i>
                <i class="fa fa-trash-o"></i>
              </div>
            </li>
            <li>
              <input type="checkbox" value="" name="">
              <span class="text">Let my collective shine like a star</span>
              <small class="label label-success"><i class="fa fa-clock-o"></i> 1 month</small>
              <div class="tools">
                <i class="fa fa-edit"></i>
                <i class="fa fa-trash-o"></i>
              </div>
            </li>
          </ul>
        </div><!-- /.box-body -->
        <div class="box-footer clearfix no-border">
          <button class="btn btn-default pull-right"><i class="fa fa-plus"></i> Add item</button>
        </div>
      </div><!-- /.box -->
    </section><!-- right col -->
  </div><!-- /.row (main row) -->

</section><!-- /.content -->
</div><!-- /.content-wrapper -->
<?php
include 'footer.php';
?>
