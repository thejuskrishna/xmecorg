<?
ini_set ("include_path", ini_get("include_path") .
        ":/usr/addr/php/lib/php:/home/cherian/xmec.org/config");

if (!isset($HTTP_POST_VARS) && isset($_POST)) {
  $HTTP_POST_VARS = $_POST;
}
if (!isset($HTTP_GET_VARS) && isset($_GET)) {
  $HTTP_GET_VARS = $_GET;
}

require 'facebook/facebook.php';
require_once 'DB.php';
require_once 'xmec.conf';

// Preferences
define ('VISIBLE_PUBLIC', 0);
define ('VISIBLE_XMEC', 1);
define ('VISIBLE_NONE', 2);
define ('PERSONAL_EMAIL_MASK', 0xf);
define ('OFFICIAL_EMAIL_MASK', 0xf0);

//
// Globals
//

$__xmec_db = NULL;
$__xmec_user = NULL;
$__xmec_shutdown_registered = FALSE;
$__fb_user =NULL;
//
// Set error reporting level
//

if (!isset($__xmec_debug) || !$__xmec_debug)
        error_reporting(E_ERROR|E_PARSE|E_CORE_ERROR|E_CORE_WARNING);

function safeShutdown()
{
    global $__xmec_db;
    if (isset($__xmec_db) && is_subclass_of($__xmec_db, "db_common")) {
        $__xmec_db->disconnect();
    }
}

/////////////////////////////////////////////////////////////
//
// class XMEC
//
/////////////////////////////////////////////////////////////

class XMEC
{
    function &getDB()
    {
        global $__xmec_db;
        global $__xmec_dsn; // in xmec.conf
        global $__xmec_shutdown_registered;

        if (!isset($__xmec_db) ||
                !is_subclass_of($__xmec_db, "db_common")) {
            $__xmec_db = DB::connect($__xmec_dsn, false);
            if (DB::isError($__xmec_db)) {
                XMEC::error_exit($__xmec_db->getMessage());
            }
        //    if (!$__xmec_shutdown_registered) {
        //        register_shutdown_function(safeShutdown);
        //        $__xmec_shutdown_registered = TRUE;
        //    }
        }

        return $__xmec_db;
    }
    function &getUser()
    {
        global $__xmec_user;

        if (!isset($__xmec_user) ||
                get_class($__xmec_user) != "XMEC_user") {
            $__xmec_user = new XMEC_user();
        }

        return $__xmec_user;
    }

    function authenticate_user()
    {
        global $__xmec_user;

        session_cache_limiter('nocache');
        session_start();
        if (isset($_SESSION["__xmec_user"])) {
            $__xmec_user = $_SESSION["__xmec_user"];
            $user =& XMEC::getUser();
            return $user->isLoggedIn();
        }

        return FALSE;
    }

    function authenticate_fb()
    {
        global $__fb_user;

        session_cache_limiter('nocache');
        session_start();
        if (isset($_SESSION["__fb_user"])) {
            $__fb_user = $_SESSION["__fb_user"];
            return TRUE;
        }

        return FALSE;
    }

    function user_login($username, $passwd)
    {
        global $REMOTE_ADDR;
        global $REMOTE_HOST;

        $user =& XMEC::getUser();

        $user->setID($username);
        if (! $user->validateUser($passwd)) {
            return FALSE;
        }

        if (! $user->fetchInfo()) {
            return FALSE;
        }

        session_cache_limiter('nocache');
        session_start();
        $_SESSION["__xmec_user"] = $user;

        $msg = 'Login from ' . $REMOTE_HOST . ' ('. $REMOTE_ADDR . ')';
        XMEC::log('LOGIN', $user->get('id'), $msg);

        return TRUE;
    }

    function fb_login()
    {
        global $REMOTE_ADDR;
        global $REMOTE_HOST;

