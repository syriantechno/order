<?php
ob_start();
session_start();
?>
<?php include('erp-config.php'); ?>
<?php include('includes/til-version.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>المستقبل</title>

    <!-- CSS -->
    <link href="<?php echo _site_url . '/content/themes/default/css/bootstrap.min.css'; ?>" rel="stylesheet">
    <link href="<?php echo _site_url . '/content/themes/default/css/font-awesome.min.css'; ?>" rel="stylesheet">
    <link href="<?php echo _site_url . '/content/themes/default/css/ultra.css'; ?>" rel="stylesheet">
    <link href="<?php echo _site_url . '/content/themes/default/css/app.css'; ?>" rel="stylesheet">


    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="<?php echo _site_url . '/content/themes/default/js/bootstrap.min.js'; ?>"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>

    </style>

</head>
<body class="body">

<?php $bg_number = rand(1, 5); ?>

<style>

    body {
        background: url('<?php echo _site_url; ?>/content/themes/default/img/login/bg.jpg') no-repeat  fixed;
        background-position: left;
        background-size: cover;
    }

    div.h20 {
        height: 20px;
    }

    .bg_opacity {
        background-color: rgba(0, 0, 0, 0.5);
        height: 100%;
        width: 100%;
        z-index: -1;

        top: 0;
        left: 0;
    }

    .loginbox {

        background-color: #ffffff63;
        padding: 30px;
        position: absolute;
        top: 0;
        bottom: 0;
        width: 30%;
    }

    .loginbox form input {
        font-size: 16px;
        padding: 10px 14px !important;
        border-radius: 3px;
    }

    .loginbox .btn {
        border-radius: 3px;
    }

    .loginbox .social_box {
        text-align: right;
        background-color: rgba(241, 242, 242, 0.7);
        margin: 0 -30px -30px -30px;
        padding: 30px;
        border-bottom-left-radius: 4px;
        border-bottom-right-radius: 4px;
    }

    .loginbox .social_box a i.fa {
        font-size: 22px;
    }

    .loginbox .social_box a {
        display: inline-block;
        width: 40px;
        height: 40px;
        padding-top: 10px;
        text-align: center;
        border-radius: 360px;
        color: #fff;
        background-color: #3b5998;
        border-color: rgba(0, 0, 0, 0.2);
    }

    .loginbox .social_box a:hover {
        opacity: 0.9;
    }

    .loginbox .social_box a.sbox-facebook {
        background-color: #3b5998;
    }

    .loginbox .social_box a.sbox-twitter {
        background-color: #55acee;
    }

    .loginbox .social_box a.sbox-instagram {
        background-color: #3f729b;
    }

    .loginbox .social_box a.sbox-google-plus {
        background-color: #dd4b39;
    }

    .loginbox .social_box a.sbox-github {
        background-color: #444;
    }


    /* validation icin error style */
    input.error {
        border-color: #843534;
        -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075), 0 0 6px #ce8483;
        box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075), 0 0 6px #ce8483;
    }

    label.error {
        font-weight: normal;
        font-size: 11px;
        background-color: #FDD8D8;
        padding: 4px 6px;
        margin-top: 5px;
        border-radius: 2px;
    }

    #terms-error { /* bunu sadece checkbox icin yazdik, terms(kurallar) */
        position: absolute;
        margin-top: 20px;
        margin-left: -20px;
    }

</style>

<?php

$login_form_error = false;
if (isset($_POST['username'])) {

    // Ba?lat?y? Kural?m.
    $db = new mysqli(_serverName, _userName, _userPassword);
    if ($db->connect_errno) {
        echo "Ba?lant? Hatas?:" . $db->connect_errno;
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


    function dbname($val)
    {
        global $til;
        return _prefix . $val;
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
     *  get_site_url() fonksiyonu icin kisaltmalari olusturur
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

    include('includes/input.php');
    include('includes/helper.php');
    include('includes/db.php');
    include('includes/user.php');
    include('includes/notification.php');

    $username = trim(addslashes($_POST['username']));
    $password = trim(addslashes($_POST['password']));

    if ($q_login = db()->query("SELECT * FROM " . dbname('users') . " WHERE username='$username' AND password='$password'")) {
        if ($q_login->num_rows > 0) {
            $login = $q_login->fetch_assoc();
            $_SESSION['login_id'] = $login['id'];

            if ($q_select = db()->query("SELECT * FROM " . dbname('users') . " WHERE (role='1' OR role='2') AND id='" . $_SESSION['login_id'] . "' ")) {
                if ($q_select->num_rows) {
                    if ($query = @file_get_contents('http://api.ultra.org/version.php?version=' . til()->version . '&user_ip=' . $_SERVER['SERVER_ADDR'])) {
                        if (is_json($query)) {
                            $query = json_decode($query);

                            if ($query->version > til()->version) {
                                if ($q_select = db()->query("SELECT * FROM " . dbname('messages') . " WHERE choice='" . $query->version . "' AND type='notification' AND rec_u_id='" . $_SESSION['login_id'] . "' ")) {
                                    if (!$q_select->num_rows) {
                                        if (add_notification(array('rec_u_id' => $_SESSION['login_id'], 'title' => 'ultra ' . $query->version . ' sürümü haz?r.', 'message' => $query->url, 'writing' => 'fa fa-download', 'choice' => $query->version))) {

                                            header("Location:" . _site_url);
                                        } else {
                                            header("Location:" . _site_url);
                                        }
                                    } else {
                                        header("Location:" . _site_url);
                                    }
                                } else {
                                    header("Location:" . _site_url);
                                }
                            } else {
                                header("Location:" . _site_url);
                            }
                        } else {
                            header("Location:" . _site_url);
                        }
                    } else {
                        header("Location:" . _site_url);
                    }
                } else {
                    header("Location:" . _site_url);
                }
            } else {
                header("Location:" . _site_url);
            }
        } else {
            $login_form_error = true;
        }
    }
} else {
    $username = "admin";
    $password = "admin";
}
?>


<div class="container-fluid">
    <div class="row">
        <div class="col-md-7"></div>
        <div class="col-xs-16 col-md-15">
            <div class="loginbox">

                <div>
                    <img src="<?php echo _site_url; ?>/content/themes/default/img/logo_header.png"
                         class="img-responsive" style="margin: auto;     padding-top: 25%;
    padding-bottom: 40px;">

                </div>
                <div class="h20"></div>

                <?php if ($login_form_error): ?>
                    <div class="alert alert-danger alert-loginError" role="alert"><strong><i
                                    class="fa fa-exclamation-triangle"></i> خطا </strong>اسم المستخدم وكلمة المرور غير
                        صحيحة
                    </div>
                    <style type="text/css">
                        .alert-loginError {
                            animation: alertloginError 200ms infinite;
                            animation-iteration-count: 5;
                        }

                        @keyframes alertloginError {
                            0% {
                                border-color: #a94442;
                            }
                            100% {
                                border-color: #ebccd1;
                            }
                        }
                    </style>

                <?php endif; ?>

                <form name="form_login" id="form_login" action="" method="POST" class="validation">
                    <div class="form-group">
                        <input type="text" name="username" id="username" class="form-control input-lg required email"
                               value="<?php echo @$username; ?>" placeholder="اسم المستخدم" style="width: 45%; margin: auto; height: 40px;" >
                    </div> <!-- /.form-group -->
                    <div class="form-group">
                        <input type="password" name="password" id="password" class="form-control input-lg required"
                               value="<?php echo @$password; ?>" placeholder="كلمة المرور" style="width: 45%; margin: auto; height: 40px;">
                    </div> <!-- /.form-group -->

                    <div class="row">
                        <div class="text-center">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox"> <span
                                            class="text">حفظ معلومات الدخول</span>
                                </label>
                            </div> <!-- /.checkbox -->
                        </div> <!-- /.col-md-6 -->
                        <div class="col-md-6">
                        </div> <!-- /.col-md-6 -->
                    </div> <!-- /.row -->

                    <div class="text-center">
                        <button class="btn btn-success  btn-lg">تسجيل الدخول</button>
                    </div> <!-- /.text-right -->
                    <div class="h20"></div>

                </form>
                <div class="h20"></div>
                <div class="h20"></div>
                <div class="social_box">
                    <span class="text-muted" style="font-style:italic;">تابعنا على :&nbsp; &nbsp;</span>
                    <a href="#" class="sbox-facebook"><i class="fa fa-facebook"></i></a>
                    <a href="#" class="sbox-twitter"><i class="fa fa-twitter"></i></a>
                    <a href="#" class="sbox-instagram"><i class="fa fa-instagram"></i></a>
                    <a href="#" class="sbox-google-plus"><i class="fa fa-google-plus"></i></a>
                    <a href="#" class="sbox-github"><i class="fa fa-github"></i></a>
                </div> <!-- /.social_box -->


            </div>

            <div>

            </div>

        </div> <!-- /.col-md-4 -->
    </div> <!-- /.row -->
</div> <!-- /.container -->

<style>
    footer {
        position: absolute;
        bottom: 50px;
    }

    .footer_links a {
        color: rgba(255, 255, 255, 0.5);
        margin-left: 13px;
        font-size: 13px;
        text-decoration: underline;
    }

    .footer_links a:hover {
        text-decoration: none;
    }
</style>



<div class="bg_opacity"></div>


</body>
</html>