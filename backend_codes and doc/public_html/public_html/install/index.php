<?php
require_once('../includes/lb_helper.php'); //Include LicenseBox external/client api helper file
$api = new LicenseBoxAPI(); //Initialize a new LicenseBoxAPI object
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <title>GoGrocer - Installer</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.1/css/bulma.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" />
    <style type="text/css">
    body, html {
    background: #F7F7F7;
    }
    </style>
  </head>
  <body>
    <?php
    $errors=FALSE;
    $step = isset($_GET['step']) ? $_GET['step'] : '';
    ?>
    <div class="container main_body"> <div class="section" >
      <div class="column is-6 is-offset-3">
        <center><h1 class="title" style="padding-top: 20px">
        GoGrocer Installer
        </h1><br></center>
        <div class="box">
          <?php
          switch ($step) {
          default:
          ?>
          <div class="tabs is-fullwidth">
            <ul>
              <li class="is-active">
                <a>
                  <span><b>Requirements</b></span>
                </a>
              </li>
              <li>
                <a>
                  <span>Verify</span>
                </a>
              </li>
              <li>
                <a>
                  <span>Database</span>
                </a>
              </li>
              <li>
                <a>
                  <span>Finish</span>
                </a>
              </li>
            </ul>
          </div>
          <?php  
          /*Add or remove your script's requirements below*/
          if(phpversion() < "5.4")
          {$errors = TRUE;
          echo "<div class='notification is-danger' style='padding:12px;'><i class='fa fa-times'></i> Current PHP version is ".phpversion()."! minimum PHP 5.4 or higher required.</div>";}
          else{echo "<div class='notification is-success' style='padding:12px;'><i class='fa fa-check'></i> You are running PHP version ".phpversion()."</div>";}
          if(!extension_loaded('mysqli'))
          {$errors = TRUE; 
          echo "<div class='notification is-danger' style='padding:12px;'><i class='fa fa-times'></i> MySQLi PHP extension missing!</div>";}
          else{echo "<div class='notification is-success' style='padding:12px;'><i class='fa fa-check'></i> MySQLi PHP extension available</div>";}
          ?>
          <div style='text-align: right;'>
            <?php if($errors==TRUE){ ?>
            <a href="#" class="button is-link" disabled>Next</a>
            <?php }else{ ?>
            <a href="index.php?step=0" class="button is-link gen-env">Next</a>
            <?php } ?>
          </div>
          <?php
          break;
          case "0":
          ?>
          <div class="tabs is-fullwidth">
            <ul>
              <li>
                <a>
                  <span><i class="fa fa-check-circle"></i> Requirement</span>
                </a>
              </li>
              <li class="is-active">
                <a>
                  <span><b>Verify</b></span>
                </a>
              </li>
              <li>
                <a>
                  <span>Database</span>
                </a>
              </li>
              <li>
                <a>
                  <span>Finish</span>
                </a>
              </li>
            </ul>
          </div>
          <?php
          $license_code = null;
          $client_name = null;
          if(!empty($_POST['license'])&&!empty($_POST['client'])){
          $license_code = $_POST["license"];
          $client_name = $_POST["client"];
          /*Once we have the license code and client's name we can use LicenseBoxAPI's activate_license() function for activating/installing the license, if the third parameter is empty a local license file will be created which can be used for background license checks.*/
          $activate_response = $api->activate_license($_POST['license'],$_POST['client']);
          if(empty($activate_response))
          {
          $msg='Server unavailable.';
          }
          else
          {
          $msg=$activate_response['message'];
          }
          if ($activate_response['status'] != 'true') {
          ?>
          <form action="index.php?step=0" method="POST">
            <div class="notification is-danger"><?php echo ucfirst($msg); ?></div>
            <div class="field">
              <label class="label">License code</label>
              <div class="control">
                <input class="input" type="text" placeholder="enter your purchase/license code" name="license" required>
              </div>
            </div>
            <div class="field">
              <label class="label">Your name</label>
              <div class="control">
                <input class="input" type="text" placeholder="enter your name/envato username" name="client" required>
              </div>
            </div>
            <div style='text-align: right;'>
              <button type="submit" class="button is-link">Verify</button>
            </div>
          </form>
          <?php
          } else {
          ?>
          <form action="index.php?step=1" method="POST">
            <div class="notification is-success"><?php echo ucfirst($msg); ?></div>
            <input type="hidden" name="lcscs" id="lcscs" value="<?php echo ucfirst($activate_response['status']); ?>">
            <div style='text-align: right;'>
              <button type="submit" class="button is-link">Next</button>
            </div>
          </form>
          <?php
          }
          ?>
          <?php
          }else{  ?>
          <form action="index.php?step=0" method="POST">
            <div class="field">
              <label class="label">License codes</label>
              <div class="control">
                <input class="input" type="text" placeholder="enter your purchase/license code" name="license" required>
              </div>
            </div>
            <div class="field">
              <label class="label">Your name</label>
              <div class="control">
                <input class="input" type="text" placeholder="enter your name/envato username" name="client" required>
              </div>
            </div>
            <div style='text-align: right;'>
              <button type="submit" class="button is-link">Verify</button>
            </div>
          </form>
          <?php } ?>
          <?php
          break;
          case "1":
          ?>
          <div class="tabs is-fullwidth">
            <ul>
              <li>
                <a>
                  <span><i class="fa fa-check-circle"></i> Requirements</span>
                </a>
              </li>
              <li>
                <a>
                  <span><i class="fa fa-check-circle"></i> Verify</span>
                </a>
              </li>
              <li class="is-active">
                <a>
                  <span><b>Database</b></span>
                </a>
              </li>
              <li>
                <a>
                  <span>Finish</span>
                </a>
              </li>
            </ul>
          </div>
          <?php
          if($_POST&&isset($_POST["lcscs"])){
          $valid = $_POST["lcscs"];
          $db_host = strip_tags(trim($_POST["host"]));
          $db_user = strip_tags(trim($_POST["user"]));
          $db_pass = strip_tags(trim($_POST["pass"]));
          $db_name = strip_tags(trim($_POST["name"]));
          /*Let's import the sql file into the given database*/
          if(!empty($db_host))
          {
$myfile = fopen("../source/.env", "w") or die("Unable to open file!");
$txt = "";
fwrite($myfile, $txt);
$txt = "APP_NAME=Laravel
APP_ENV=local
APP_KEY=base64:2mk/sb/Yav9JkfMV1Jz8GXegjwNXrYc572MjTkki9VQ=
APP_DEBUG=true
APP_LOG_LEVEL=debug
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=".$db_name."
DB_USERNAME=".$db_user."
DB_PASSWORD=".$db_pass."

BROADCAST_DRIVER=log
CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_DRIVER=sync

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_DRIVER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null

PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=";
fwrite($myfile, $txt);
fclose($myfile);
          $con = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
          if (mysqli_connect_errno())
          {
          ?>
          <form action="index.php?step=1" method="POST">
            <div class='notification is-danger'>Failed to connect to MySQL: <?php echo mysqli_connect_error(); ?></div>
            <input type="hidden" name="lcscs" id="lcscs" value="<?php echo $valid; ?>">
            <div class="field">
              <label class="label">Database Host</label>
              <div class="control">
                <input class="input" type="text" id="host" placeholder="enter your database host" name="host" required>
              </div>
            </div>
            <div class="field">
              <label class="label">Database Username</label>
              <div class="control">
                <input class="input" type="text" id="user" placeholder="enter your database username" name="user" required>
              </div>
            </div>
            <div class="field">
              <label class="label">Database Password</label>
              <div class="control">
                <input class="input" type="text" id="pass" placeholder="enter your database password" name="pass">
              </div>
            </div>
            <div class="field">
              <label class="label">Database Name</label>
              <div class="control">
                <input class="input" type="text" id="name" placeholder="enter your database name" name="name" required>
              </div>
            </div>
            <div style='text-align: right;'>
              <button type="submit" class="button is-link">Import</button>
            </div>
          </form>
          <?php
          exit;
          }
          $templine = '';
          $filename = 'database.sql';
          $lines = file($filename);
          foreach ($lines as $line) {
          if (substr($line, 0, 2) == '--' || $line == '')
          continue;
          $templine .= $line;
          $query = false;
          if (substr(trim($line), -1, 1) == ';') {
          $query = mysqli_query($con, $templine);
          $templine = '';
          }
          }
          ?>
          <form action="index.php?step=2" method="POST">
            <div class='notification is-success'>Database was successfully imported.</div>
            <input type="hidden" name="dbscs" id="dbscs" value="true">
            <div style='text-align: right;'>
              <button type="submit" class="button is-link">Next</button>
            </div>
          </form>
          <?php
          }
          else
          {
          ?>
          <form action="index.php?step=1" method="POST">
            <input type="hidden" name="lcscs" id="lcscs" value="<?php echo $valid; ?>">
            <div class="field">
              <label class="label">Database Host</label>
              <div class="control">
                <input class="input" type="text" id="host" placeholder="enter your database host" name="host" required>
              </div>
            </div>
            <div class="field">
              <label class="label">Database Username</label>
              <div class="control">
                <input class="input" type="text" id="user" placeholder="enter your database username" name="user" required>
              </div>
            </div>
            <div class="field">
              <label class="label">Database Password</label>
              <div class="control">
                <input class="input" type="text" id="pass" placeholder="enter your database password" name="pass">
              </div>
            </div>
            <div class="field">
              <label class="label">Database Name</label>
              <div class="control">
                <input class="input" type="text" id="name" placeholder="enter your database name" name="name" required>
              </div>
            </div>
            <div style='text-align: right;'>
              <button type="submit" class="button is-link">Import</button>
            </div>
          </form>
          <?php
          }
          ?>
          <?php
          }
          else
          {
          ?>
          <div class='notification is-danger'>Sorry, something went wrong.</div>
          <?php
          }
          ?>
          <?php
          break;
          case "2":
          ?>
          <div class="tabs is-fullwidth">
            <ul>
              <li>
                <a>
                  <span><i class="fa fa-check-circle"></i> Requirements</span>
                </a>
              </li>
              <li>
                <a>
                  <span><i class="fa fa-check-circle"></i> Verify</span>
                </a>
              </li>
              <li>
                <a>
                  <span><i class="fa fa-check-circle"></i> Database</span>
                </a>
              </li>
              <li class="is-active">
                <a>
                  <span><b>Finish</b></span>
                </a>
              </li>
            </ul>
          </div>
          <?php
          if($_POST&&isset($_POST["dbscs"])){
          $valid = $_POST["dbscs"];
          // rmdir("install");
          // rmdir("includes");
          ?>
          <center>
            <p><strong>Application is successfully installed.</strong></p><br>
            <p><strong>
              <?php
                $config['base_url'] = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
                $config['base_url'] .= "://".$_SERVER['HTTP_HOST'];
                $config['base_url'] .= str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);
                $base = $config['base_url'];
              ?>
              <a href="<?php echo str_replace("install/", "", $base); ?>">Click Here to go</a>
            </strong></p><br>
          </center>
          <?php
          }
          else
          {
          ?>
          <div class='notification is-danger'>Sorry, something went wrong.</div>
          <?php
          }
          ?>
          <?php
          break;}
          ?>
        </div>
      </div>
    </div>
  </div>
  <div class="content has-text-centered">
    <p>
      Made with ❤️ in India . All Rights Reserved. Powered by <a target="_blank" rel="noopener noreferrer" href="https://tecmanic.com/" >Tecmanic</a>.
    </p>
    <br>
  </div>
</body>
</html>