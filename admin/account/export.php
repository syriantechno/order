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

<?php if ($export_type == 'print') {
    get_header_print(array('title' => 'قائمة بطاقات المستفيدين'));
} ?>

<?php if ($accounts): ?>
    <?php if ($export_type == 'print'): ?>
        <div class="h-20"></div>
        <table class="table table-hover table-bordered table-condensed">
            <tr>
                <th width="15%"><?php echo('كود المستفيد'); ?></th>
                <th><?php echo('اسم المستفيد'); ?></th>
                <th><?php echo('الموبايل'); ?></th>
                <th><?php echo('نوع الاعاقة'); ?></th>
                <th><?php echo('العنوان'); ?></th>

            </tr>
            <?php foreach ($accounts->list as $account): ?>
                <tr>
                    <td><?php echo $account->code; ?></td>
                    <td><?php echo $account->name; ?></td>
                    <td><?php echo $account->gsm; ?></td>
                    <td><?php echo $account->Retardationtype; ?></td>
                    <td><?php echo $account->address; ?></td>

                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <table>
            <tr>
                <th><?php echo('كود المستفيد'); ?></th>
                <th><?php echo('اسم المستفيد'); ?></th>
                <th><?php echo('الموبايل'); ?></th>
                <th><?php echo('نوع الاعاقة'); ?></th>
                <th><?php echo('العنوان'); ?></th>

            </tr>
            <?php foreach ($accounts->list as $account): ?>
                <tr>
                    <td><?php echo $account->code; ?></td>
                    <td><?php echo $account->name; ?></td>
                    <td><?php echo $account->gsm; ?></td>
                    <td><?php echo $account->Retardationtype; ?></td>
                    <td><?php echo $account->address; ?></td>

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
}

?>
</body>
</html>

