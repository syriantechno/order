<?php require_once('../../ultra.php'); ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>قائمة بطاقات المستفيدين |!المستقبل</title>
</head>
<body>

<?php
ini_set('max_execution_time', 300);
ini_set('memory_limit', '-1');

$export_type = '';
if (isset($_GET['export'])) {
    $export_type = $_GET['export'];
}
$accounts = get_accounts(array('_GET' => true));
?>

<h4 class="text-right"><?php if ($export_type == 'printexl') {
        get_header_print(array('title' => 'جمعية المستقبل'));
    } ?></h4>
<div class="h-10"></div>

<h4 class="text-right">أسماء المستفيدين من الإعانة لعام </h4>


<?php if ($accounts): ?>
    <?php if ($export_type == 'printexl'): ?>
        <div class="h-20"></div>
        <table class="table table-hover table-bordered table-condensed">
            <tr>

                <th style="font-size: 16px; width: 35%;"><?php echo('اسم المستفيد'); ?></th>
                <th style="font-size: 16px; width: 15%;"><?php echo('الموبايل'); ?></th>
                <th style="font-size: 16px; width: 20%;"><?php echo('التاريخ'); ?></th>
                <th style="font-size: 16px; width: 35%;"><?php echo('التوقيع'); ?></th>


            </tr>
            <?php foreach ($accounts->list as $account): ?>
                <tr>

                    <td style="font-size: 20px"><?php echo $account->name; ?></td>
                    <td style="font-size: 20px"><?php echo $account->gsm; ?></td>
                    <td></td>
                    <td></td>


                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <table>
            <tr>
                <th width="25%"><?php echo('اسم المستفيد'); ?></th>
                <th width="15%"><?php echo('الموبايل'); ?></th>
                <th width="25%"><?php echo('التاريخ'); ?></th>
                <th><?php echo('التوقيع'); ?></th>

            </tr>
            <?php foreach ($accounts->list as $account): ?>
                <tr>
                    <td style="font-size: 20px"><?php echo $account->name; ?></td>
                    <td><?php echo $account->gsm; ?></td>
                    <td></td>
                    <td></td>


                </tr>
            <?php endforeach; ?>
            <tr>
                <td colspan="6" style="color:#ccc; font-size:10px;"><?php echo('تم انشاءها باستخدام المستقبل'); ?></td>
            </tr>
        </table>
    <?php endif; ?>

<?php endif; ?>


<?php
if ($export_type == 'excel') {
    export_excel('قائمة بطاقات الحساب');
} elseif ($export_type == 'pdf') {
    ?>
    <style>
        table tr td {
            border-bottom: 1px solid #ccc;
        }
    </style>
    <?php
    export_pdf('قائمة بطاقات الحساب');
} elseif ($export_type == 'print') {
    get_footer_print();
} elseif ($export_type == 'printexl') {
    get_footer_print();
    ?>
    <style>
        fon {
            border-bottom: 1px solid #ccc;
        }
    </style>
    <?php
}

?>
</body>
</html>

