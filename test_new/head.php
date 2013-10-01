<?php
  $_menu_number = 0;
  include_once 'xmec.inc';
    if (!XMEC::authenticate_user() && $secure_page) {
      global $PHP_SELF;
      $url = "login.php?xgetpage=$PHP_SELF";
      header("Location: $url");
      exit ;
    }

// Global variable holds the menu no. displayed.
if (!session_is_registered("_menu_number")) {
  session_register("_menu_number");
}
$current_sel = 0;
if (chop($HTTP_GET_VARS["mi"]) != "") {
  $current_sel += chop($HTTP_GET_VARS["mi"]);
  if ($current_sel && $current_sel != $_menu_number) {
    $_menu_number = $current_sel;
  }
}
$onload_str = "";
if ($_menu_number != 0) {
  $onload_str = "onload=javascript:show('".htmlentities($_menu_number)."')";
}

  $user = XMEC::getUser();
?>
<div class="Ctopleft"></div>
<div class="Ctopright"></div>