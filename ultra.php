<?php
ob_start();
session_start();

date_default_timezone_set('Europe/Istanbul');
error_reporting(E_ALL);


/*** GLOBAL ***/


/* --------------------------------------------------- ROOT */

/**
 * title: root_path()
 * desc: root_path() fonksiyonu, lazim olan dosyalari ice aktarirken kok dizini bulmam?z? kolaylastirir.
 */
define('ROOT_PATH', dirname(__FILE__));

function get_root_path($val)
{
    return ROOT_PATH . '/' . $val;
}

function root_path($val)
{
    echo get_root_path($val);
}

include get_root_path('erp-config.php');

if (_userName == '' AND _dbName == '') {
    Header('Location: installation.php');
}

// config
define('_root_path', $_SERVER['DOCUMENT_ROOT'] . '/');

// Ba?lat?y? Kural?m.
$db = new mysqli(_serverName, _userName, _userPassword);
if ($db->connect_errno) {
    echo "خطا في الاتصال بقاعدة البيانات:" . $db->connect_errno;
    exit;
}

// Veritaban?m?z? Seçelim.
$db->select_db(_dbName);
$db->query("SET NAMES 'utf8'");


function db()
{
    global $db;
    return $db;
}


// global ?n ek
$til = new stdclass;
global $til;

function dbname($val)
{
    global $til;
    return _prefix . $val;
}


function til($val = '')
{
    global $til;
    return $til;
}


$til->pg = new StdClass;
$til->pg->list_limit = 50; // bir sayfada gosterilecek listeleme limiti, tablonun row limiti


function til_include($val)
{
    require_once get_root_path('includes/' . $val . '.php');
}


/* --------------------------------------------------- THEME */

/**
 * title: get_header()
 * desc: header.php dosyas?n? include eder.
 */
function get_header()
{
    include get_root_path('content/themes/default/header.php');
}

/**
 * title: get_footer()
 * desc: footer.php dosyas?n? include eder.
 */
function get_footer()
{
    include get_root_path('content/themes/default/footer.php');
}

/**
 * title: get_sidebar()
 * desc: sidebar.php dosyas?n? include eder.
 */
function get_sidebar()
{
    include get_root_path('content/themes/default/sidebar.php');
}


/* --------------------------------------------------- URL */
/**
 * title: get_site_url()
 * desc: site adresini dondurur
 */
function get_site_url($val = '', $val_2 = false)
{
    if (_helper_site_url($val)) {
        $val = _helper_site_url($val);

        if (is_numeric($val_2)) {
            $val = $val . '?id=' . $val_2;
        } else {
            $val = $val . '?' . $val_2;
        }
    }

    if (substr($val, 0, 1) == '/') {
        return _site_url . '' . $val;
    } else {
        return _site_url . '/' . $val;
    }

}

/**
 * title: site_url()
 * desc: site adresini gosterir
 * func: get_site_url()
 */
function site_url($val = '', $val_2 = false)
{
    echo get_site_url($val, $val_2);
}

/*
 * _helper_site_url()
 *	get_site_url() fonksiyonu icin kisaltmalari olusturur
 */
function _helper_site_url($val)
{
    if ($val == 'form') {
        return 'admin/form/detail.php';
    } else if ($val == 'account') {
        return 'admin/account/detail.php';
    } else if ($val == 'payment') {
        return 'admin/payment/detail.php';
    } else if ($val == 'item') {
        return 'admin/item/detail.php';
    } else if ($val == 'message') {
        return 'admin/user/message/detail.php';
    } else if ($val == 'task') {
        return 'admin/user/task/detail.php';
    } else {
        return false;
    }
}


/**
 * title: get_template_url()
 * desc: secili teman?n klas?r adresini url olarak d?ndürür
 */
function get_template_url($val = '')
{
    return get_site_url() . '/content/themes/default/' . $val;
}

/**
 * title: template_url()
 * func: get_template_url()
 */
function template_url($val = '')
{
    echo get_template_url($val);
}


function is_home()
{
    if (til_active_site_url() == get_site_url()) {
        return true;
        exit;
    } elseif (str_replace('index.php', '', til_active_site_url()) == get_site_url()) {
        return true;
        exit;
    } else {
        return false;
    }
}


/* --------------------------------------------------- INCLUDE FUNCTIONS */
til_include('db');
til_include('lang');
til_include('login');
til_include('helper');
til_include('input');
til_include('user');
til_include('log');
til_include('options');
til_include('theme');
til_include('account');
til_include('item');
til_include('form');
til_include('case');
til_include('chartjs');
til_include('message');
til_include('upload');
til_include('task');
til_include('notification');
til_include('mail');
til_include('til-version');


/* --------------------------------------------------- ADDSLASHES */
if (!get_magic_quotes_gpc()) {
    if (isset($_GET) OR isset($_POST) OR isset($_COOKIE) OR isset($_REQUEST)) {
        $_GET = til_get_addslashes($_GET);
        $_POST = til_get_addslashes($_POST);
        $_COOKIE = til_get_addslashes($_COOKIE);
        $_REQUEST = til_get_addslashes($_REQUEST);

    }
}


/* --------------------------------------------------- DEFAULT FUNCTIONS */
is_login();


// company info
til()->fixed = '2';
til()->company = new stdclass();
til()->company->name = 'المستقبل!';
til()->company->address = 'حلب';
til()->company->district = 'حلب';
til()->company->city = 'حلب';
til()->company->country = 'سوريا';
til()->company->email = 'info@ultra.com';
til()->company->phone = '76404750';
til()->company->gsm = '76404750';
til()->company->currency = 'ل٫س';
til()->company->highlight = '#3498db';
til()->company->highlight2 = '#9b59b6';


$get_option = get_option('company');
if (!empty($get_option)) {
    foreach ($get_option as $key => $value) {
        if (!empty($value)) {
            til()->company->$key = $value;
        }
    }
}

til()->fixed = '2';
til()->price = new stdclass();
til()->price->price1 = '0';
til()->price->price2 = '0';
til()->price->price3 = '0';
til()->price->price4 = '0';
til()->price->price5 = '0';
til()->price->price6 = '0';
til()->price->item_name1 = '0';
til()->price->item_name2 = '0';
til()->price->item_name3 = '0';
til()->price->item_name4 = '0';
til()->price->item_name5 = '0';
til()->price->item_name6 = '0';
til()->price->color1 = '0';
til()->price->color2 = '0';
til()->price->color3 = '0';
til()->price->color4 = '0';
til()->price->color5 = '0';
til()->price->color6 = '0';



$get_option = get_option('price');
if (!empty($get_option)) {
    foreach ($get_option as $key => $value) {
        if (!empty($value)) {
            til()->price->$key = $value;
        }
    }
}


$_args = array(
    'taxonomy' => 'form',
    'name' => 'النماذج',
    'description' => 'اضافة او تعديل نموذج',
    'in_out' => true,
    'sms_template' => true,
    'email_template' => true,
    'color' => true,
    'bg_color' => true
);
register_form_status($_args);
unset($_args);


?>
