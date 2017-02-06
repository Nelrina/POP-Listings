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
        Login
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
    <?php
    // Si mon formulaire a été envoyé
    if(!empty($_POST)){

        $login = (isset($_POST['loginName']) && !empty($_POST['loginName']))? htmlspecialchars($_POST['loginName']):'';
        $pass  = (isset($_POST['loginPass']) && !empty($_POST['loginPass']))? htmlspecialchars($_POST['loginPass']):'';

        if ( (!empty($login)) && (!empty($pass)) )
        {
            // On récupère le login dans la base de données
            $q = $con->prepare('SELECT * FROM settings WHERE loggin = :login');
            $q->bindValue(':login', $login, PDO::PARAM_STR);
            $q->execute();
            $donnees = $q->fetch(PDO::FETCH_ASSOC);

            // Si on a bien un login correspondant
            if ($donnees)
            {
                // On compare le mot de passe de la bdd au mot de passe envoyé
                if (password_verify($pass, $donnees['passw']))
                {
                    // On crée les variables de session avec les champs de la table settings
                    $_SESSION['loginOK'] = "ok";
                    $_SESSION['myLogin'] = $donnees['loggin'];
                    $_SESSION['URL'] = $donnees['imgurl'];
                    $_SESSION['PATH'] = $donnees['imgpath'];
                    $_SESSION['TYPE'] = $donnees['imgtype'];
                    $_SESSION['LT'] = $donnees['linktarget'];
                    header('location: index.php');
                }
                else
                {
                    $message = "Incorrect login or password.";
                }
            }
            else
            {
                $message = "Incorrect login or password.";
            }
        }
        else
        {
            $message = "You must input your login and password";
        }
    ?>
    <div class="col-md-6">
      <div class="box box-danger">
     <div class="box-header">
      <i class="ion ion-home"></i>
      <h3 class="box-title">Error !</h3>
    </div><!-- /.box-header -->
      <div class="box-body">
          <p><?php echo $message; ?></p>
      </div>
  </div>
</div>
    <?php } ?>
    <div class="col-md-6">
  <!-- Horizontal Form -->
      <div class="box box-success">
        <div class="box-header with-border">
          <h3 class="box-title">POP Listings connection</h3>
        </div><!-- /.box-header -->
        <!-- form start -->
        <form class="form-horizontal" method="post" action="<?php echo basename(__FILE__); ?>">
          <div class="box-body">
            <div class="form-group">
              <label for="loginName" class="col-sm-3 control-label">Login</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="loginName" name="loginName" value="" />
                </div>
            </div>
            <div class="form-group">
              <label for="loginPass" class="col-sm-3 control-label">Password</label>
                <div class="col-sm-9">
                    <input type="password" class="form-control" id="loginPass" name="loginPass" value="" />
                    <br />
                    <a href="lostpass.php">Lost password ?</a>
                </div>
            </div>
          </div><!-- /.box-body -->
          <div class="box-footer">
            <button type="submit" class="btn btn-success pull-right">Log in</button>
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
