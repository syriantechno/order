<?php require_once('../../ultra.php'); ?>
<?php
if (!$account = get_account($_GET['id'])) {
    add_console_log('لم يتم العثور على بطاقة حساب.', 'print-statement.php');
}
?>
<?php include_content_page('print', 'statement', 'account', array('account' => @$account)); ?>


    <title> بحث مفصل | <?php echo $account->name; ?></title>

<?php
$print['title'] = 'كشف حساب المستفيد';
$print['date'] = til_get_date(date('Y-m-d H:i'), 'd F Y H:i');
$print['barcode'] = $account->code;
?>

<?php get_header_print($print); ?>


    <div class="row">
        <div class="col-xs-6">

            <div class="p-22 br-3">
                <div class="fs-14 bold"><?php echo til()->company->name; ?></div>

                <div class="fs-11"><?php echo til()->company->city; ?><?php echo til()->company->country ? ' - ' : ''; ?><?php echo til()->company->country; ?></div>
                <div class="fs-11"><?php echo til()->company->address; ?></div>
                <div class="fs-11"><?php echo get_set_show_phone(til()->company->phone); ?></div>
                <div class="fs-11"><?php echo til()->company->email; ?></div>
            </div>

        </div> <!-- /.col -->
        <div class="col-xs-6">

            <div class="bg-gray p-10 br-3">
                <div class="fs-14 bold"><?php echo $account->name; ?></div>
                <div class="fs-11"><?php echo $account->address; ?></div>
                <div class="fs-11"><?php echo $account->district; ?><?php echo ($account->city && $account->district) ? '/' : ''; ?><?php echo $account->city; ?><?php echo $account->country ? ' - ' : ''; ?><?php echo $account->country; ?></div>
                <div class="fs-11"><?php echo get_set_show_phone($account->gsm); ?><?php echo $account->phone ? ' - ' : ''; ?><?php echo get_set_show_phone($account->phone); ?></div>
                <div class="fs-11"><?php echo $account->tax_home ? 'المكتب الضريبي: ' . $account->tax_home : ''; ?><?php echo ($account->tax_home and $account->tax_no) ? ' - ' : ''; ?><?php echo $account->tax_no ? 'الرقم الضريبي: ' . $account->tax_no : ''; ?></div>
                <?php if ($account->email): ?>
                    <div class="fs-11"><?php echo $account->email; ?></div><?php endif; ?>
            </div>

        </div> <!-- /.col -->
    </div> <!-- /.row -->


<?php
$args_form['where']['status'] = '1';
$args_form['where']['account_id'] = $account->id;
$args_form['where']['order_by'] = array('id' => 'ASC', 'date' => 'ASC');
if ($forms = get_forms($args_form)): ?>
    <div class="h-20"></div>
    <table class="table table-hover table-bordered table-condensed table-striped">
        <thead>
        <tr>
            <th width="40">ID</th>
            <th width="60">التاريخ</th>
            <th width="40">الحالة</th>
            <th>البيان</th>


        </tr>
        </thead>
        <tbody>
        <?php $balance = 0;
        foreach ($forms->list as $form): ?>
            <?php $form_status = get_form_status($form->status_id); ?>
            <tr>
                <td>#<?php echo $form->id; ?></td>
                <td>
                    <small><?php echo substr($form->date, 0, 10); ?></small>
                </td>

                <td>
                    <?php
                    if ($form->type == 'form') {
                        $item = get_form_items($form->id);
                        $item = $item->list[0];
                        $in_out = ($form->in_out == '0') ? 'معونة' : 'معونة';
                        echo "نموذج {$in_out} : "
                            . " عدد {$form->item_quantity}"
                            . " : {$item->item_name}";
                    } elseif ($form->type == 'payment') {
                        if ($form->in_out == '0') {
                            echo 'دفعة منه';
                        } else {
                            echo 'دفعة له';
                        }
                    }
                    ?>
                </td>
                <td>
                    <?php
                    $meta = get_form_meta($form->id, 'note');
                    echo $meta->meta_value;
                    ?>
                </td>

            </tr>
        <?php endforeach; ?>
        </tbody>

    </table>

<?php endif; ?>

<?php if (isset($_GET['print'])): ?>
    <script>
        setTimeout(function () {
            window.print();
        }, 500);
        setTimeout(function () {
            window.close();
        }, 500);
    </script>
<?php endif; ?>