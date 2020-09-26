<?php include('../../../ultra.php'); ?>


<?php get_header(); ?>
<?php
add_page_info('title', 'ادارة قواعد البيانات');
add_page_info('nav', array('name' => 'خيارات', 'url' => get_site_url('admin/system/')));
add_page_info('nav', array('name' => 'ادارة قواعد البيانات'));
?>
<?php
error_reporting(E_ALL ^ E_DEPRECATED);
//  require_once('BackUp.php');
?>
<?php


//$backup=require_once('BackUp.php');
$backup_name = 'database_' . _dbName . '.sql';
if (isset($_GET['process'])) {
    $process = $_GET['process'];
    if ($process == 'backup') {
        require_once('BackUp.php');
    } else if ($process == require_once('restor.php')) {
        require_once('restor.php');
        @unlink('backup/database_' . $db . '.sql');

    }
}


?>


    <br>
    <br>
    <h3 class="text-center">النسخ الاحتياطي والاستعادة</h3>


<?php if (isset($_GET['process'])): ?>
    <?php

    $msg = $_GET['process'];
    $class = 'text-center';
    switch ($msg) {
        case 'backup':
            $msg = 'نجحت النسخة الاحتياطية!<br />قم بحفظها على جهازك <a href=' . $backup_name . ' target=_blank >SQL FILE </a>  لاسترجاعها باي وقت';
            break;
        case 'restore':
            $msg = 'تم استعادة قاعدة البيانات بنجاح الرجاء التاكد من البيانات';
            break;
        case 'upload':
            $msg = 'تم رفع قاعدة البيانات الى السيرفر بنجاح';
            break;
        default:
            $class = 'hide';
    }

    ?>

    <strong class="text-center" style="width: auto;display: block;"><?php echo $msg; ?></strong><br>
<?php endif; ?>
<?php
if (isset($_POST['submit'])) {
    $db = 'database_' . _dbName . '.sql';
    $target_path = 'backup';
    move_uploaded_file($_FILES["file"]["tmp_name"], $db);
    $msge = 'تم رفع قاعدة البيانات الى السيرفر بنجاح <a href=index.php?process=restore>اضغط هنا للاستعادة</a> !';
    echo "<strong class='col-md-12 text-center' > $msge </strong><br>";
}
?>
    <div class="col-md-12 text-center">
        <br>
        <a href="index.php?process=backup">
            <button type="button" class="btn btn-success btn-lg span4"><i class="fa fa-database"></i> نسخ احتياطي لقاعدة
                البيانات
            </button>
        </a>

        <a href="index.php?process=restore">
            <button type="button" class="btn btn-info btn-lg span4"><i class="fa fa-database"></i> استعادة النسخة
                الاحتياطية
            </button>
        </a>
        <br/>
        <br/>
        <div class="col-md-12 text-center">
            <form method="POST" enctype="multipart/form-data"
                  style="display: inline-block; border:1px solid #000; width:600px; padding:20px;">
                <label>رفع نسخة احتياطية من الكومبيوتر :</label>
                <input type="file" name="file" class="form-control">

                <a href="index.php?process=upload">
                    <input type="submit" name="submit" class="btn btn-success " value="رفع الى السيرفر"
                           style="margin-top: 20px;"/ >
                </a>


            </form>

            <br>
            <table border="1" cellspacing="0" cellpadding="12">

            </table>
        </div>
    </div>


<?php get_footer(); ?>