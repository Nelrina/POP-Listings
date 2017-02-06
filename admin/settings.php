<?php
include 'header.php';
$menu = "settings";
include 'sidebar.php';

// Settings manager creation
$manager = new MSettings($con);
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Settings
    <small></small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
      <li class="active"><a href="settings.php">Settings</a></li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
      <!-- Your Page Content Here -->
      <div class="row">
      <div class="col-md-7">
    <?php
    // Si mon formulaire a été envoyé
    if(!empty($_POST)){
        $errors = "";

        // Recup $_POST concerning password
        $oldPwd = (isset($_POST['oldPwd']) && preg_match('#^[a-zA-Z0-9+!*,;?_.-]*$#', $_POST['oldPwd']))? $_POST['oldPwd']:'';
        $newPwd = (isset($_POST['newPwd']) && preg_match('#^[a-zA-Z0-9+!*,;?_.-]*$#', $_POST['newPwd']))? $_POST['newPwd']:'';
        if ($oldPwd != "" && $newPwd == "")
            $errors .= "<p><i class='fa fa-exclamation-triangle'></i>If you want to change you password please type a new password.</p>";
        else if ($oldPwd == "" && $newPwd != "")
            $errors .= "<p><i class='fa fa-exclamation-triangle'></i>If you want to choose a new password you must type your old password for verification.</p>";
        // Old password and new password are typed so we can change the DB with the new password and notify user
        else if ($oldPwd != "" && $newPwd != "")
        {
          // Modify settings in the DB
          $manager->changePassword($newPwd);

          echo <<<"FLPASS"
          <div class="box box-primary">
           <div class="box-header">
            <i class="fa fa-lightbulb-o"></i>
            <h3 class="box-title">Success !</h3>
          </div><!-- /.box-header -->
            <div class="box-body">
                <p>Password updated !</p>
            </div>
        </div>
FLPASS;
        }


        // Recup $_POST
        if ($_POST['imgUrl'] != "") {
            $imgUrl = filter_var($_POST['imgUrl'], FILTER_SANITIZE_URL);
            if (!filter_var($imgUrl, FILTER_VALIDATE_URL)) $errors .= "<p><i class='fa fa-exclamation-triangle'></i> ". $imgUrl . " is <strong>NOT</strong> a valid URL.</p>";
        } else $errors .= "<p><i class='fa fa-exclamation-triangle'></i> Please enter your domain URL.</p>";

        if ($_POST['email'] != "") {
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors .= "<p><i class='fa fa-exclamation-triangle'></i> ". $email . " is <strong>NOT</strong> a valid email.</p>";
        } else $errors .= "<p><i class='fa fa-exclamation-triangle'></i> Please enter your email.</p>";

        if ($_POST['imgPath'] != "") {
            $imgPath = filter_var($_POST['imgPath'], FILTER_SANITIZE_STRING);
            if ($imgPath == "") $errors .= "<p><i class='fa fa-exclamation-triangle'></i> ". $imgPath . " is <strong>NOT</strong> a valid directory.</p>";
        } else $errors .= "<p><i class='fa fa-exclamation-triangle'></i> Please enter your absolute images directory.</p>";

        if(isset($_POST['imgType']))
            switch ($_POST['imgType']) {
                case 'png': $imgType = 'png';
                            break;
                case 'gif': $imgType = 'gif';
                            break;
                case 'jpeg': $imgType = 'jpeg';
                            break;
                default : $imgType = 'nc';
        }

        $linkTarget = (isset($_POST['linkTarget']))? (($_POST['linkTarget']==1)?1:0):0;

        // Making the table settings for update function
        $array = array(
            "email" => $email,
            "imgPath" => $imgPath,
            "imgurl" => $imgUrl,
            "imgType" => $imgType,
            "linkTarget" => $linkTarget,
            "login" => $_SESSION['myLogin'],
        );

        // Modify settings in the DB
        $manager->update($array);

        echo <<<"FLADDED"
        <div class="box box-primary">
         <div class="box-header">
          <i class="fa fa-lightbulb-o"></i>
          <h3 class="box-title">Success !</h3>
        </div><!-- /.box-header -->
          <div class="box-body">
              <p>Settings updated !</p>
              $errors
          </div>
      </div>
FLADDED;

    // Mise à jour des variables de SESSION
    $_SESSION['URL'] = $imgUrl;
    $_SESSION['PATH'] = $imgPath;
    $_SESSION['TYPE'] = $imgType;
    $_SESSION['LT'] = $linkTarget;
    }

    // Displaying all the settings
    $mySettings = $manager->select();
    ?>
  <!-- Horizontal Form -->
      <div class="box box-warning">
        <div class="box-header with-border">
          <h3 class="box-title">Settings</h3>
        </div><!-- /.box-header -->
        <!-- form start -->
        <form class="form-horizontal" method="post" action="<?php echo basename(__FILE__); ?>">
          <div class="box-body">
              <div class="form-group">
              <label for="login" class="col-sm-4 control-label">Login</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" id="login" value="<?php echo $_SESSION['myLogin']; ?>" disabled />
              </div>
            </div>
            <div class="form-group">
              <label for="oldPwd" class="col-sm-4 control-label">Old password</label>
              <div class="col-sm-8">
                <input type="password" class="form-control" name="oldPwd" id="oldPwd" value="" />
              </div>
            </div>
            <div class="form-group">
              <label for="newPwd" class="col-sm-4 control-label">New password</label>
              <div class="col-sm-8">
                <input type="password" class="form-control" name="newPwd" id="newPwd" value="" />
              </div>
            </div>
            <div class="form-group">
              <label for="email" class="col-sm-4 control-label">Email</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" name="email" id="email" value="<?php echo $mySettings['email']; ?>" />
              </div>
            </div>
            <div class="form-group">
              <label for="imgUrl" class="col-sm-4 control-label">Image directory URL</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" name="imgUrl" id="imgUrl" value="<?php echo $mySettings['imgurl']; ?>" />
                  <?php echo "Example: http://www.domain.com/images/"; ?><br />
                  Don't forget trailing slash.
              </div>
            </div>
            <div class="form-group">
              <label for="imgPathAbs" class="col-sm-4 control-label">Absolute images directory</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" name="imgPath" id="imgPath" value="<?php echo $mySettings['imgpath']; ?>" />
                  <?php echo "Example: " . $_SERVER['DOCUMENT_ROOT'] . "/images/"; ?><br />
                  Don't forget trailing slash.
              </div>
            </div>
            <div class="form-group">
              <label for="imgType" class="col-sm-4 control-label">Convert images to</label>
              <div class="col-sm-8">
                <div class="radio"><label for="png"><input type="radio" name="imgType" id="png" value="png"
                <?php if($mySettings['imgtype'] == "png") { echo "checked"; } ?> class="" /> PNG</label></div>
                <div class="radio"><label for="jpeg"><input type="radio" name="imgType" id="jpeg" value="jpeg"
                <?php if($mySettings['imgtype'] == "jpeg") { echo "checked"; } ?> /> JPEG</label></div>
                <div class="radio"><label for="gif"><input type="radio" name="imgType" id="gif" value="gif"
                <?php if($mySettings['imgtype'] == "gif") { echo "checked"; } ?> /> GIF</label></div>
                <div class="radio"><label for="nc"><input type="radio" name="imgType" id="nc" value="nc"
                <?php if($mySettings['imgtype'] == "nc") { echo "checked"; } ?> /> Don't change</label></div>
              </div>
            </div>
            <div class="form-group">
              <label for="linkTarget" class="col-sm-4 control-label">Link target</label>
              <div class="col-sm-8">
                <select id="linkTarget" name="linkTarget" class="form-control">
                <option value="1" <?php if($mySettings['linktarget'] == 1) { echo "selected='selected'"; } ?>>_blank</option>
                <option value="0" <?php if($mySettings['linktarget'] == 0) { echo "selected='selected'"; } ?>>Same tab</option>
                </select>
              </div>
            </div>
          </div><!-- /.box-body -->
          <div class="box-footer">
            <button type="submit" class="btn btn-warning pull-right">Update settings</button>
          </div><!-- /.box-footer -->
        </form>
      </div><!-- /.box -->
    </div>
    </div><!-- /.row -->
  <!-- End Of Your Page Content Here -->
  </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<?php
include 'footer.php';
?>
