<?php
$til = new stdclass;
global $til;

function til($val = '')
{
    global $til;
    return $til;
}

if (empty($_POST)) {
    @file_get_contents('' . str_replace('installation.php', '', $_SERVER['SERVER_NAME'] . $_SERVER['SCRIPT_NAME']) . '&user_ip=' . $_SERVER['SERVER_ADDR']);
}


include('includes/input.php');

// DATEBASE CONTROL
if (isset($_POST['step_1'])) {
    $_database = array(
        'database' => trim($_POST['database']),
        'username' => trim($_POST['username']),
        'password' => trim($_POST['password']),
        'host' => trim($_POST['host'])
    );

    @file_get_contents('' . str_replace('installation.php', '', $_SERVER['SERVER_NAME'] . $_SERVER['SCRIPT_NAME']) . '&user_ip=' . $_SERVER['SERVER_ADDR']);

    $db = @mysqli_connect($_database['host'], $_database['username'], $_database['password'], $_database['database']);

    if (mysqli_connect_errno()) {
        add_alert('خطا في اسم المستخدم او قاعدة البيانات');
        unset($_POST['step_1']);
    }
}
// DATEBASE CONTROL


// User control AND Insert tables
if (isset($_POST['step_2'])) {
    $_database = array(
        'database' => $_POST['database'],
        'username' => $_POST['username'],
        'password' => $_POST['password'],
        'host' => $_POST['host'],
        'prefix' => @$_POST['table_prefix']
    );


    $_user = array(
        'username' => $_POST['user_username'],
        'password' => $_POST['user_password'],
        'email' => $_POST['user_email'],
        'name' => strtoupper($_POST['user_name']),
        'surname' => strtoupper($_POST['user_surname']),
        'gsm' => $_POST['user_gsm']
    );


    form_validation($_user['username'], 'user_username', 'اسم المستخدم', 'required|min_length[3|maxlength[32]');
    form_validation($_user['password'], 'user_password', 'كلمة المرور', 'required|min_length[6]max_length[32]');
    form_validation($_user['email'], 'user_email', 'البريد الالكتروني', 'required|min_length[3]|email');
    form_validation($_user['name'], 'user_name', 'الاسم', 'required|min_length[3]|max_length[32]');
    form_validation($_user['surname'], 'user_surname', 'الشهرة', 'required|min_length[3]|max_length[32]');
    form_validation($_user['gsm'], 'user_gsm', 'الهاتف المحمول', 'required|gsm|min_length[1]|max_length[20]');


    if (!is_alert()) {
        foreach ($_user as $key => $value) {
            $_send_user[$key] = urlencode($value);
        }

        @file_get_contents('' . $_SERVER['SERVER_NAME'] . $_SERVER['SCRIPT_NAME'] . '&user_ip=' . $_SERVER['SERVER_ADDR'] . '&username=' . $_send_user['username'] . '&email=' . $_send_user['email'] . '&name=' . $_send_user['name'] . '&surname=' . $_send_user['surname'] . '&gsm=' . $_send_user['gsm']);

        $db = @mysqli_connect($_database['host'], $_database['username'], $_database['password'], $_database['database']);

        if (mysqli_connect_errno()) {
            add_alert('خطا في الخادم او قاعدة البيانات?!');
            unset($_POST['step_2']);
        } else {

            $stmt = $db->prepare("SET GLOBAL sql_mode=NO_UNSIGNED_SUBTRACTION;");
            $stmt->execute();
            // create accounts
            if (!$db->query("SELECT * FROM " . $_database['prefix'] . "accounts ")) {
                if (!$db->query(
                    "CREATE TABLE `" . $_database['prefix'] . "accounts` (
						  `id` int(11) NOT NULL AUTO_INCREMENT,
						  `status` int(1) NOT NULL DEFAULT '1',
						  `date` datetime NOT NULL,
						  `type` varchar(25) NOT NULL,
						  `code` varchar(32) NOT NULL,
						  `name` varchar(32) NOT NULL,
						  `email` varchar(100) NOT NULL,
						  `gsm` varchar(20) NOT NULL,
						  `phone` varchar(20) NOT NULL,
						  `address` varchar(500) NOT NULL,
						  `city` varchar(20) NOT NULL,
						  `district` varchar(20) NOT NULL,
						  `country` varchar(20) NOT NULL,
						  `tax_no` varchar(20) NOT NULL,
						  `tax_home` varchar(20) NOT NULL,
						  `balance` decimal(15,4) NOT NULL,
						  `profit` decimal(15,4) NOT NULL,
						  `sex` varchar(20) NOT NULL,
                          `Retardationtype` varchar(255) NOT NULL,
                          `job` varchar(25) NULL,
                          `Retardationnum` int(25) NULL,
                          `countrynumber` int(25) NULL,
                          `fathername` varchar(25) NULL,
                          `mo3el` varchar(25) NULL,
                          `DateofBirth` datetime DEFAULT NULL,
                          `famelynum` int(11) DEFAULT NULL,
                          `needsomeone` varchar(255) DEFAULT NULL,
                          `note` varchar(255) DEFAULT NULL,
                          `done` varchar(255) DEFAULT NULL,
                          `living` varchar(255) DEFAULT NULL,
                          
						  PRIMARY KEY (`id`),
						  KEY `code` (`code`),
						  KEY `name` (`name`),
						  KEY `gsm` (`gsm`),
						  KEY `name_2` (`name`),
						  KEY `gsm_2` (`gsm`)
						) ENGINE=InnoDB DEFAULT CHARSET=utf8;"
                )) {
                    unset($_POST['step_2']);
                }
            }


            // create extra
            if (!$db->query("SELECT * FROM " . $_database['prefix'] . "extra ")) {
                if (!$db->query(
                    "CREATE TABLE `" . $_database['prefix'] . "extra` (
						  `id` int(11) NOT NULL AUTO_INCREMENT,
						  `taxonomy` varchar(64) NOT NULL,
						  `name` varchar(128) NOT NULL,
						  `val` text NOT NULL,
						  `val_1` varchar(128) NOT NULL,
						  `val_2` varchar(128) NOT NULL,
						  `val_3` varchar(128) NOT NULL,
						  `val_4` varchar(256) NOT NULL,
						  `val_5` varchar(256) NOT NULL,
						  `val_6` varchar(256) NOT NULL,
						  `val_7` varchar(512) NOT NULL,
						  `val_8` varchar(512) NOT NULL,
						  `val_9` varchar(512) NOT NULL,
						  `val_text` text NOT NULL,
						  `val_int` int(11) NOT NULL,
						  `val_decimal` decimal(15,4) NOT NULL,
						  `val_date` datetime NOT NULL,
						  `val_enum` enum('0','1') NOT NULL,
						  UNIQUE KEY `id` (`id`)
						) ENGINE=InnoDB DEFAULT CHARSET=utf8;"
                )) {
                    unset($_POST['step_2']);
                }
            }


            // create form_items
            if (!$db->query("SELECT * FROM " . $_database['prefix'] . "form_items ")) {
                if (!$db->query(
                    "CREATE TABLE `" . $_database['prefix'] . "form_items` (
						  `id` int(11) NOT NULL AUTO_INCREMENT,
						  `status` int(1) NOT NULL DEFAULT '1',
						  `date` datetime NOT NULL,
						  `type` varchar(20) NOT NULL DEFAULT 'item',
						  `in_out` int(1) NOT NULL DEFAULT '1',
						  `form_id` int(11) NOT NULL,
						  `account_id` int(11) NOT NULL,
						  `item_id` int(11) NOT NULL,
						  `item_code` varchar(32) NOT NULL,
						  `item_name` varchar(50) NOT NULL,
						  `item_p_purc` decimal(15,4) NOT NULL,
						  `item_p_sale` decimal(15,4) NOT NULL,
						  `price` decimal(15,4) NOT NULL,
						  `quantity` int(11) NOT NULL,
						  `vat` int(2) NOT NULL,
						  `vat_total` decimal(15,4) NOT NULL,
						  `total` decimal(15,4) NOT NULL,
						  `profit` decimal(15,4) NOT NULL,
						  `val_1` varchar(32) NOT NULL,
						  `val_2` varchar(512) NOT NULL,
						  `val_3` varchar(1024) NOT NULL,
						  `val_int` int(11) NOT NULL,
						  `val_date` datetime NOT NULL,
						  `val_decimal` decimal(15,4) NOT NULL,
						  PRIMARY KEY (`id`)
						) ENGINE=InnoDB DEFAULT CHARSET=utf8;"
                )) {
                    unset($_POST['step_2']);
                }
            }


            // create form_meta
            if (!$db->query("SELECT * FROM " . $_database['prefix'] . "form_meta ")) {
                if (!$db->query(
                    "CREATE TABLE `" . $_database['prefix'] . "form_meta` (
						  `id` int(11) NOT NULL AUTO_INCREMENT,
						  `form_id` int(11) NOT NULL,
						  `meta_key` varchar(32) NOT NULL,
						  `meta_value` text NOT NULL,
						  PRIMARY KEY (`id`)
						) ENGINE=InnoDB DEFAULT CHARSET=utf8;"
                )) {
                    unset($_POST['step_2']);
                }
            }


            // create forms
            if (!$db->query("SELECT * FROM " . $_database['prefix'] . "forms ")) {
                if (!$db->query(
                    "CREATE TABLE `" . $_database['prefix'] . "forms` (
						  `id` int(11) NOT NULL AUTO_INCREMENT,
						  `status` enum('0','1') NOT NULL DEFAULT '1',
						  `date` datetime NOT NULL,
						  `type` varchar(10) NOT NULL DEFAULT 'form',
						  `template` varchar(20) NOT NULL,
						  `in_out` enum('0','1') NOT NULL DEFAULT '1',
						  `account_id` int(11) NOT NULL,
						  `account_code` varchar(32) NOT NULL,
						  `account_name` varchar(50) NOT NULL,
						  `account_gsm` varchar(20) NOT NULL,
						  `account_phone` varchar(20) NOT NULL,
						  `account_email` varchar(100) NOT NULL,
						  `account_city` varchar(20) NOT NULL,
						  `account_tax_home` varchar(20) NOT NULL,
						  `account_tax_no` varchar(20) NOT NULL,
						  `total` decimal(15,4) NOT NULL,
						  `profit` decimal(15,4) NOT NULL,
						  `payment` decimal(15,4) NOT NULL,
					      `cheq_number` datetime NOT NULL,
                          `cheq_date` int(11) NOT NULL,
                          `exchange_price` int(11) NOT NULL,
                          `exc_price` int(11) NOT NULL,
                          `bank_name` int(11) NOT NULL,
						  `item_count` int(11) NOT NULL,
						  `item_quantity` int(11) NOT NULL,
						  `status_id` int(11) NOT NULL,
						  `user_id` int(11) NOT NULL,
						  `date_updated` datetime NOT NULL,
						  `val_1` varchar(255) NOT NULL,
						  `val_2` varchar(512) NOT NULL,
						  `val_3` varchar(1024) NOT NULL,
						  `val_int` int(11) NOT NULL,
						  `val_date` datetime NOT NULL,
						  `val_decimal` decimal(15,4) NOT NULL,
						  PRIMARY KEY (`id`)
						) ENGINE=InnoDB DEFAULT CHARSET=utf8;"
                )) {
                    unset($_POST['step_2']);
                }
            }


            // create items
            if (!$db->query("SELECT * FROM " . $_database['prefix'] . "items ")) {
                if (!$db->query(
                    "CREATE TABLE `" . $_database['prefix'] . "items` (
						  `id` int(11) NOT NULL AUTO_INCREMENT,
						  `status` int(1) NOT NULL DEFAULT '1',
						  `date` datetime NOT NULL,
						  `type` varchar(10) NOT NULL,
						  `code` varchar(32) NOT NULL,
						  `name` varchar(100) NOT NULL,
						  `p_purc_out_vat` decimal(15,4) NOT NULL,
						  `p_sale_out_vat` decimal(15,4) NOT NULL,
						  `vat` int(2) NOT NULL,
						  `p_purc` decimal(15,4) NOT NULL,
						  `p_sale` decimal(15,4) NOT NULL,
						  `quantity` int(11) NOT NULL,
						  `total_purc` decimal(15,4) NOT NULL,
						  `total_sale` decimal(15,4) NOT NULL,
						  `profit` decimal(15,4) NOT NULL,
						  UNIQUE KEY `id` (`id`)
						) ENGINE=InnoDB DEFAULT CHARSET=utf8;"
                )) {
                    unset($_POST['step_2']);
                }
            }


            // create log_meta
            if (!$db->query("SELECT * FROM " . $_database['prefix'] . "log_meta ")) {
                if (!$db->query(
                    "CREATE TABLE `" . $_database['prefix'] . "log_meta` (
						  `id` int(11) NOT NULL AUTO_INCREMENT,
						  `log_id` int(11) NOT NULL,
						  `meta_val` text NOT NULL,
						  PRIMARY KEY (`id`)
						) ENGINE=InnoDB DEFAULT CHARSET=utf8;"
                )) {
                    unset($_POST['step_2']);
                }
            }


            // create logs
            if (!$db->query("SELECT * FROM " . $_database['prefix'] . "logs ")) {
                if (!$db->query(
                    "CREATE TABLE `" . $_database['prefix'] . "logs` (
						  `id` int(11) NOT NULL AUTO_INCREMENT,
						  `date` datetime NOT NULL,
						  `uniquetime` char(15) NOT NULL,
						  `table_id` varchar(20) NOT NULL,
						  `user_id` int(11) NOT NULL,
						  `log_url` varchar(250) NOT NULL,
						  `log_key` varchar(64) NOT NULL,
						  `log_text` varchar(500) NOT NULL,
						  PRIMARY KEY (`id`)
						) ENGINE=InnoDB DEFAULT CHARSET=utf8;"
                )) {
                    unset($_POST['step_2']);
                }
            }


            // create messages
            if (!$db->query("SELECT * FROM " . $_database['prefix'] . "messages ")) {
                if (!$db->query(
                    "CREATE TABLE `" . $_database['prefix'] . "messages` (
						  `id` int(11) NOT NULL AUTO_INCREMENT,
						  `date` datetime NOT NULL,
						  `status` int(1) NOT NULL DEFAULT '1',
						  `type` varchar(12) NOT NULL DEFAULT '',
						  `top_id` int(11) NOT NULL,
						  `sen_u_id` int(11) NOT NULL,
						  `rec_u_id` int(11) NOT NULL,
						  `title` varchar(255) NOT NULL,
						  `message` text NOT NULL,
						  `read_it` enum('0','1') NOT NULL DEFAULT '0',
						  `inbox_u_id` int(11) NOT NULL,
						  `outbox_u_id` int(11) NOT NULL,
						  `date_update` datetime NOT NULL,
						  `sen_trash_u_id` int(11) NOT NULL,
						  `rec_trash_u_id` int(11) NOT NULL,
						  `date_start` datetime NOT NULL,
						  `date_end` datetime NOT NULL,
						  `choice` text NOT NULL,
						  `type_status` varchar(10) NOT NULL,
						  `writing` varchar(255) NOT NULL DEFAULT '',
						  `notification_seen` int(2) NOT NULL,
						  PRIMARY KEY (`id`)
						) ENGINE=InnoDB DEFAULT CHARSET=utf8;"
                )) {
                    unset($_POST['step_2']);
                }
            }


            // create options
            if (!$db->query("SELECT * FROM " . $_database['prefix'] . "options ")) {
                if (!$db->query(
                    "CREATE TABLE `" . $_database['prefix'] . "options` (
						  `id` int(11) NOT NULL AUTO_INCREMENT,
						  `option_name` varchar(64) NOT NULL DEFAULT '',
						  `option_value` text NOT NULL,
						  PRIMARY KEY (`id`)
						) ENGINE=InnoDB DEFAULT CHARSET=utf8;"
                )) {
                    unset($_POST['step_2']);
                }
            }


            // create user_meta
            if (!$db->query("SELECT * FROM " . $_database['prefix'] . "user_meta ")) {
                if (!$db->query(
                    "CREATE TABLE `" . $_database['prefix'] . "user_meta` (
						  `id` bigint(20) NOT NULL AUTO_INCREMENT,
						  `user_id` bigint(20) NOT NULL,
						  `meta_key` varchar(32) NOT NULL,
						  `meta_value` text NOT NULL,
						  PRIMARY KEY (`id`)
						) ENGINE=InnoDB DEFAULT CHARSET=utf8;"
                )) {
                    unset($_POST['step_2']);
                }
            }


            // create users
            if (!$db->query("SELECT * FROM " . $_database['prefix'] . "users ")) {
                if (!$db->query(
                    "CREATE TABLE `" . $_database['prefix'] . "users` (
						  `id` int(11) NOT NULL AUTO_INCREMENT,
						  `date` datetime NULL DEFAULT CURRENT_TIMESTAMP,
						  `status` int(1) NOT NULL DEFAULT '1',
						  `username` varchar(255) NOT NULL,
						  `password` char(32) NOT NULL,
						  `name` varchar(20) NOT NULL,
						  `surname` varchar(20) NOT NULL,
						  `gsm` varchar(10) NOT NULL,
						  `role` int(1) NOT NULL DEFAULT (1),
						  `avatar` varchar(255) NULL,
						  `gender` enum('0','1') NULL DEFAULT '1',
						  `citizenship_no` varchar(20) NULL,
						  `til_login` tinyint(1)  NULL DEFAULT '0',
						  `account_id` int(11) NULL,
						  `email` varchar(255) NULL DEFAULT '',
						  PRIMARY KEY (`id`)
						) ENGINE=InnoDB DEFAULT CHARSET=utf8;"
                )) {
                    unset($_POST['step_2']);
                }
            }


            if (isset($_POST['step_2'])) {
                if ($q_select = $db->query("SELECT * FROM " . $_database['prefix'] . "users WHERE username='" . $_user['username'] . "' ")) {
                    if ($q_select->num_rows) {

                        add_alert($_user['username'] . " kullan?c? ad? zaten mevcut.", 'info');
                        $_POST['step_3'] = true;

                    } else {
                        if ($db->query("INSERT INTO {$_database['prefix']}users (username, password, email, name, surname, gsm, gender, role) VALUES ('" . $_user['username'] . "', '" . $_user['password'] . "', '" . $_user['email'] . "', '" . $_user['name'] . "', '" . $_user['surname'] . "', '" . $_user['gsm'] . "', '1', '1')")) {
                            if ($db->insert_id) {
                                if (is_writable('erp-config.php')) {
                                    $config_writing = "<?php 
										\ndefine('_serverName', '" . $_database['host'] . "'); 
										\ndefine('_userName', '" . $_database['username'] . "'); \ndefine('_userPassword', '" . $_database['password'] . "'); \ndefine('_dbName', '" . $_database['database'] . "');
										\ndefine('_prefix', '" . $_database['prefix'] . "');
										\ndefine('_site_url', 'http://" . rtrim(str_replace('/installation.php', '', $_SERVER['HTTP_HOST'] . $_SERVER['SCRIPT_NAME']), '/') . "');";

                                    $til_config = fopen('erp-config.php', 'w');
                                    fwrite($til_config, $config_writing);
                                    fclose($til_config);
                                }
                                if (is_writable('config.php')) {
                                    $config_writing = "<?php
										 \$host = '" . $_database['host'] . "'; 
										 \$user = '" . $_database['username'] . "';
										 \$pass = '" . $_database['password'] . "';
										 \$dbName = '" . $_database['database'] . "';
										 ?>
										";

                                    $config = fopen('config.php', 'w');
                                    fwrite($config, $config_writing);
                                    fclose($config);
                                } else {
                                    add_alert('ملف الاعدادت erp-config غير قابل للكتابة الرجاء التحقق من الصلاحيات');
                                }

                                $_POST['step_3'] = true;
                            } else {
                                add_alert('تعذر اضافة المستخدم او الحساب');
                            }
                        } else {
                            add_alert('خطا الارتباط بقاعدة البيانات.');
                        }
                    }
                } else {
                    add_alert('خطأ في قاعدة البيانات!');
                }
            } else {
                add_alert('هناك طريقة للذهاب. هل تريد الإعداد مرة أخرى؟ يمكنك محاولة.');
            }
        }
    } else {
        unset($_POST['step_2']);
        $_POST['step_1'] = true;
    }
}
// User control AND Insert tables
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"/>

    <title>تركيب برنامج جمعية المستقبل!</title>

    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="content/themes/default/css/ultra.css">
    <link rel="stylesheet" type="text/css" href="content/themes/default/css/app.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.6/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.16.0/jquery.validate.min.js"></script>
    <script type="text/javascript"> $(document).ready(function () {
            $('.validate').validate();
        });</script>
</head>
<body>
<div class="container">
    <div class="h-40"></div>
    <div class="form-group text-center">
        <a href=""><img src="content/themes/default/img/logo_blank.png" width="80px"></a>
    </div><!--/ .text-center /-->
    <div class="h-20"></div>


    <style type="text/css">
        @media (max-width: 767px) {
            .container {
                width: 100%;
                margin: 0 -15px;
            }
        }

        ul {
            -webkit-padding-start: 0;
            list-style: none;
        }

        .h-20 {
            height: 20px;
        }

        .h-40 {
            height: 40px;
        }

        .stepwizard-step p {
            margin-top: 10px;
        }

        .stepwizard-row {
            display: table-row;
        }

        .stepwizard {
            display: table;
            width: 375px;
            position: relative;
            margin: 0 auto;
        }

        .stepwizard-step button[disabled] {
            opacity: 1 !important;
            filter: alpha(opacity=100) !important;
        }

        .stepwizard-row:before {
            top: 14px;
            bottom: 0;
            position: absolute;
            content: " ";
            width: 100%;
            height: 1px;
            background-color: #ccc;
            z-order: 0;
        }

        .stepwizard-step {
            display: table-cell;
            text-align: center;
            position: relative;
        }

        .btn-circle {
            width: 30px;
            height: 30px;
            text-align: center;
            padding: 6px 0;
            font-size: 12px;
            line-height: 1.428571429;
            border-radius: 15px;
        }

        .form-container {
            width: 375px;
            margin: 0 auto;
        }

        .form-group.border-bottom {
            border-bottom: 1px solid #ddd;
        }

        .btn-theme {
            background: #ffc50c;
            color: #333;
        }

        .btn-theme:hover,
        .btn-theme:focus {
            background: #ffc50c !important;
            color: #333;
        }
    </style>


    <?php if (!is_writable('erp-config.php')) : ?>
        <div class="form-container">
            <?php add_alert('<b>"erp-config.php"</b> الملف غير قابل للكتابة.') ?>
            <?php print_alert(); ?>
            <small class="text-center block">الحصول على الدعم <a href="http://ultra.org/forum" class="bold">"ultra"</a>
                يرجى التحدث مع الدعم الفني.
            </small>
            <?php exit; ?>
        </div>
    <?php endif; ?>

    <!--/ Step tab /-->
    <div class="stepwizard">
        <div class="stepwizard-row setup-panel">
            <div class="stepwizard-step">
                <button type="button" class="btn btn-<?php if (!isset($_POST['step_1']) AND !isset($_POST['step_2'])) {
                    echo 'theme';
                } else {
                    echo 'default';
                } ?> btn-circle">1
                </button>
                <p>1. المرحلة</p>
            </div>
            <div class="stepwizard-step">
                <button type="button" class="btn btn-<?php if (isset($_POST['step_1'])) {
                    echo 'theme';
                } else {
                    echo 'default';
                } ?> btn-circle" disabled="disabled">2
                </button>
                <p>2. المرحلة</p>
            </div>
            <div class="stepwizard-step">
                <button type="button" class="btn btn-<?php if (isset($_POST['step_2'])) {
                    echo 'theme';
                } else {
                    echo 'default';
                } ?> btn-circle" disabled="disabled">3
                </button>
                <p>3. المرحلة</p>
            </div>
        </div>
    </div>
    <!--/ Step tab /-->

    <!--/ Setup Form /-->
    <form class="validate" id="installation" method="POST" autocomplete="off">
        <div class="form-container">
            <div class="panel panel-default">
                <div class="panel-body">

                    <?php if (!isset($_POST['step_1']) AND !isset($_POST['step_2'])): ?>
                        <div class="setup-content">
                            <?php print_alert(); ?>
                            <h4 class="text-center">معلومات قاعدة البيانات</h4>

                            <div class="h-20"></div>

                            <div class="form-group">
                                <label for="host">اسم المخدم
                                    <small class="text-muted italic ml-10">( الافتراضي"localhost" )</small>
                                </label>
                                <input type="text" name="host" id="host" dynamic-input required class="form-control"
                                       placeohlder="" value="localhost">
                            </div><!--/ .form-group /-->

                            <div class="form-group">
                                <label for="database">اسم قاعدة البيانات</label>
                                <input type="text" autofocus name="database" id="database" dynamic-input required
                                       class="form-control" placeohlder="">
                            </div><!--/ .form-group /-->

                            <div class="form-group">
                                <label for="username">اسم المستخدم</label>
                                <input type="text" name="username" id="username" dynamic-input required
                                       class="form-control" placeohlder="">
                            </div><!--/ .form-group /-->

                            <div class="form-group">
                                <label for="password">كلمة مرور القاعدة</label>
                                <input type="passwrod" name="password" id="password" class="form-control"
                                       placeohlder="">
                            </div><!--/ .form-group /-->

                            <div class="form-group">
                                <label for="table_prefix">لاحقة الجداول
                                    <small class="text-muted italic ml-10">( المفضلة "_erp" )</small>
                                </label>
                                <input type="text" name="table_prefix" id="table_prefix" dynamic-input
                                       class="form-control" placeohlder="" value="erp_">
                            </div><!--/ .form-group /-->

                            <div class="form-group">
                                <input type="hidden" name="step_1">
                                <button class="btn btn-theme pull-right" type="submit">التالي</button>
                            </div><!--/ .form-group /-->
                        </div><!--/ .setup-content #step-1 /-->
                    <?php endif; ?>

                    <?php if (isset($_POST['step_1']) OR isset($_POST['step_3'])) : ?>
                        <?php if (!isset($_POST['step_2'])) : ?>
                            <div class="setup-content" id="step-2">
                                <?php print_alert(); ?>
                                <h4>معلومات المستخدم</h4>

                                <div class="form-group">
                                    <label for="user_username">اسم المستخدم</label>
                                    <input type="text" autofocus name="user_username" id="user_username" dynamic-input
                                           required class="form-control" placeohlder="">
                                </div><!--/ .form-group /-->

                                <div class="form-group">
                                    <label for="user_password">كلمة المرور</label>
                                    <input type="password" name="user_password" id="user_password" required
                                           class="form-control" placeohlder="">
                                </div><!--/ .form-group /-->

                                <div class="row space-5">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="user_name">الاسم</label>
                                            <input type="text" name="user_name" id="user_name" dynamic-input required
                                                   class="form-control" placeohlder="">
                                        </div><!--/ .form-group /-->
                                    </div><!--/ .col-md-6 /-->

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="user_surname">الشهرة</label>
                                            <input type="text" name="user_surname" id="user_surname" dynamic-input
                                                   required class="form-control" placeohlder="">
                                        </div><!--/ .form-group /-->
                                    </div><!--/ .col-md-6 /-->
                                </div><!--/ .row.space-5 /-->

                                <div class="row space-5">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="user_email">البريد الالكتروني</label>
                                            <input type="email" name="user_email" id="user_email" dynamic-input required
                                                   class="form-control" placeohlder="">
                                        </div><!--/ .form-group /-->
                                    </div><!--/ .col-md-6 /-->

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="user_gsm">رقم التلفون</label>
                                            <input type="text" name="user_gsm" id="user_gsm" maxlength="20"
                                                   dynamic-input required class="form-control number" placeohlder="">
                                        </div><!--/ .form-group /-->
                                    </div><!--/ .col-md-6 /-->
                                </div><!--/ .row.space-5 /-->

                                <div class="form-group">
                                    <input type="hidden" name="step_2" value="step_2">
                                    <input type="hidden" name="database" value="<?php echo @$_POST['database']; ?>">
                                    <input type="hidden" name="username" value="<?php echo @$_POST['username']; ?>">
                                    <input type="hidden" name="password" value="<?php echo @$_POST['password']; ?>">
                                    <input type="hidden" name="table_prefix"
                                           value="<?php echo @$_POST['table_prefix']; ?>">
                                    <input type="hidden" name="host" value="<?php echo @$_POST['host']; ?>">

                                    <button class="btn btn-theme pull-right" type="submit" onclick="">التالي</button>
                                </div><!--/ .form-group /-->
                            </div><!--/ .setup-content #step-1 /-->
                        <?php else: ?>
                            <?php if ($_POST['step_3']) : ?>
                                <?php print_alert(); ?>
                                <h4>تم التركيب</h4>
                                <p>بإمكانك الدخول الان حسب المعلومات التالية </p>

                                <div class="row">
                                    <div class="col-md-4 col-xs-4">
                                        اسم المستخدم :
                                        <br>
                                        كلمة المرور :
                                    </div>

                                    <div class="col-md-8 col-xs-8">
                                        <?php echo @$_POST['user_username']; ?>
                                        <br>
                                        <i>كلمة مرورك المسجلة في الخطوة السابقة</i>
                                    </div>
                                </div>

                                <div class="h-40"></div>

                                <a href="login.php" class="btn btn-theme pull-right">تفضل بالدخول</a>
                            <?php endif; // if ( $db->query("SELECT * FROM ") ) ?>
                        <?php endif; // if ( !isset($_POST['step_2']) ) ?>
                    <?php endif; // if ( isset($_POST['step_1']) ) ?>
                </div><!--/ .panel-body /-->
            </div><!--/ .panel /-->
        </div><!--/ .form-container /-->
    </form>
    <!--/ Setup Form /-->
</div><!--/ .container /-->
</body>
</html>
