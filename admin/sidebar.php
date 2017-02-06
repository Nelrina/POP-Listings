<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

<!-- sidebar: style can be found in sidebar.less -->
<section class="sidebar">

  <!-- Sidebar Menu -->
  <ul class="sidebar-menu">
    <li><a href="index.php"><i class="fa fa-link"></i> <span>Home</span></a></li>
    <li class="header">CATEGORIES</li>
    <!-- Optionally, you can add icons to the links -->
    <li<?php if($menu == "cat" ) echo ' class="active"'; ?>><a href="categories.php"><i class="fa fa-link"></i> <span>View all categories</span></a></li>
    <li<?php if($menu == "addcat" ) echo ' class="active"'; ?>><a href="add-category.php"><i class="fa fa-link"></i> <span>Add new category</span></a></li>
    <li class="header">FANLISTINGS</li>
    <!-- Optionally, you can add icons to the links -->
    <li<?php if($menu == "list" ) echo ' class="active"'; ?>><a href="listings.php"><i class="fa fa-link"></i> <span>View all listings</span></a></li>
    <li<?php if($menu == "addlist" ) echo ' class="active"'; ?>><a href="add-listing.php"><i class="fa fa-link"></i> <span>Add new listing</span></a></li>
    <li class="header">SETTINGS</li>
    <!-- Optionally, you can add icons to the links -->
    <li<?php if($menu == "settings" ) echo ' class="active"'; ?>><a href="settings.php"><i class="fa fa-link"></i> <span>Settings</span></a></li>
    <li><a href="logout.php"><i class="fa fa-link"></i> <span>Logout</span></a></li>
  </ul><!-- /.sidebar-menu -->
</section>
<!-- /.sidebar -->
</aside>