<?php
###
###  WELCOME TO NConf, configuration files are located here : config/..
###
## do not change anything other
##

# look if configuration files exist
if (file_exists('config/nconf.php') ){
    require_once 'main.php';
    require_once 'include/head.php';

    if ( !isset($_SESSION["group"]) ) {
      require_once("include/login_form.php");
    } else {
      echo '<h2>Welcome to NConf</h2>';
      echo '<p>This is where you can configure your monitoring. Once you have configured your server, press "';
      if ($nemsver > 0) {
        echo 'Generate Config';
      } else {
        echo 'Generate Nagios Config';
      }
      echo '" to make them take effect immediately. If there are errors in your configuration, you will be warned on the next screen and can take action to correct the issues.</p>';
    }

    require_once 'include/foot.php';
} else {
    # NConf not yet installed/configured
    $nconfdir = dirname( $_SERVER["SCRIPT_FILENAME"] );
    require_once('config/authentication.php');
    require_once('include/functions.php');
    require_once('include/includeAllClasses.php');
    require_once('config/nconf.php');
    require_once 'include/head.php';
}



###
### Finish
### anything is loaded until here
###
?>
