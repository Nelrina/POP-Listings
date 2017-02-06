<?php
session_start();

require '../src/functions.php';
spl_autoload_register( 'autoload' );

$db = connexion::getInstance();
$con = $db->getDbh();

$message = "";
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>POP Listings Admin</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="../dist/css/skins/_all-skins.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="../plugins/iCheck/flat/blue.css">
    <!-- Morris chart -->
    <link rel="stylesheet" href="../plugins/morris/morris.css">
    <!-- jvectormap -->
    <link rel="stylesheet" href="../plugins/jvectormap/jquery-jvectormap-1.2.2.css">
    <!-- Date Picker -->
    <link rel="stylesheet" href="../plugins/datepicker/datepicker3.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="../plugins/daterangepicker/daterangepicker-bs3.css">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

        <!-- Main Header -->
      <header class="main-header">

        <!-- Logo -->
        <a href="index.php" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>P</b>LT</span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b>POP</b>Listings</span>
        </a>

        <!-- Header Navbar -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
        </nav>
      </header>
<body>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Lost password
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="col-md-6">
        <?php
        if(!empty($_POST)){
            $login = (isset($_POST['login']) && preg_match('#^[a-zA-Z0-9+!*,;?_.-]*$#', $_POST['login']))? $_POST['login']:'';

            // Generating new password
            $newpassword = generatePassword(8);

            // Settings manager creation
            $manager = new MSettings($con);

            // Get the email from the settings
            $mail = $manager->getEmail($login);

            if(!empty($mail))
            {
                $object = 'New password generated from POP Listings';
                $headers  = 'MIME-Version: 1.0' . "\n";
                $headers .= 'Content-type: text/html; charset=ISO-8859-1'."\n";
                $headers .= 'Reply-To: '.$mail['email']."\n";
                $headers .= 'From: "POP Listings"<'.$mail['email'].'>'."\n";
                $headers .= 'Delivered-to: '.$mail['email']."\n";
                $message = '<div style="width: 100%; text-align: center; font-weight: bold">Hi ' . $login . ' !<br />Here is your new password for the POP Listings administration.<br />Don\'t forget to change it right after login, for a more secured one.<br />Your new password : ' . $newpassword . '</div>';
                if (mail($mail['email'], $object, $message, $headers)) // Message sent
                {
                    echo '<div class="box box-success">
                        <div class="box-header with-border">
                          <h3 class="box-title">New password generated</h3>
                        </div><!-- /.box-header -->
                          <div class="box-body">
                          <p>A new password has been generated. Please check your email address.</p>
                          <p><a href="index.php"><i class="fa fa-arrow-circle-left"></i> Go back to the login form.</a></p>
                          </div>
                      </div><!-- /.box -->';

                    // Updating database with new password
                    //$manager->changePassword($newpassword);
                }
                else // Not sent
                {
                    echo '<div class="box box-danger">
                        <div class="box-header with-border">
                          <h3 class="box-title">Error</h3>
                        </div><!-- /.box-header -->
                          <div class="box-body">
                          <p>An error occured, mail couldn\'t been sent.</p>
                          </div>
                      </div><!-- /.box -->';
                }
            }
        }
        ?>
      <!-- Horizontal Form -->
          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">Lost password ?</h3>
            </div><!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" role="form" enctype="multipart/form-data" method="post" action="<?php echo basename(__FILE__); ?>">
            <div class="box-body">
              <div class="form-group">
                <label for="login" class="col-sm-2 control-label">Login</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="login" name="login" placeholder="login" value="">
                </div>
              </div>
            </div>
            <div class="box-footer">
              <button type="submit" class="btn btn-info pull-right">Generate new password</button>
            </div><!-- /.box-footer -->
          </form>
        </div><!-- /.box -->
      </div>
      <div class="col-md-6"></div>
    <!-- End Of Your Page Content Here -->
    </section><!-- /.content -->
  </div><!-- /.content-wrapper -->

  </body>
  </html>
<?php
include 'footer.php';
?>
