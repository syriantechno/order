<?php include('../../ultra.php'); ?>
    <meta charset="UTF-8">
    <title>قائمة النماذج | !المستقبل </title>
<?php
ini_set('max_execution_time', 300);
ini_set('memory_limit', '-1');

$export_type = '';
if (isset($_GET['export'])) {
    $export_type = $_GET['export'];
}


if (!isset($_GET['orderby_name'])) {
    $_GET['orderby_name'] = 'id';
    $_GET['orderby_type'] = 'DESC';
}

$forms = get_forms(array('_GET' => true))
?>

<?php if ($export_type == 'print') {
    get_header_print(array('title' => 'قائمة النماذج'));
} ?>

<?php if ($forms): ?>
    <?php if ($export_type == 'print'): ?>
        <div class="h-20"></div>
        <table class="table table-hover table-bordered table-condensed">
            <thead>
            <tr>
                <th width="100">المعرف</th>
                <th width="200">حالة النموذج</th>
                <th width="120">التاريخ</th>
                <th>بطاقة المستفيد</th>
                <th width="100">الهاتف</th>
                <th width="80">التوزيع</th>
                <th width="100">المجموع</th>
            </tr>
            </thead>
            <?php foreach ($forms->list as $form): ?>
                <?php $form_status = get_form_status($form->status_id); ?>

                <?php
                $form->date = date_format(date_create($form->date), 'Y-m-d');

                if (isset($_GET['from_date']) && isset($_GET['to_date'])) {
                    $from_date = date_format(date_create($_GET['from_date']), 'Y-m-d');

                    $to_date = date_format(date_create($_GET['to_date']), 'Y-m-d');

                    if (($form->date >= $from_date) && ($form->date <= $to_date)) {
                        // is betwen
                    } else {
                        continue;
                    }
                }
                ?>
                <tr>
                    <td>
                        <?php if (isset($_GET['addBarcode'])): ?> <img
                                src="<?php get_barcode_url($form->id, array('position' => 'left')); ?>"/>
                            <br/> <?php endif; ?>
                        #<?php echo $form->id; ?>
                    </td>
                    <td class="fs-11 text-muted"><?php echo $form_status->name; ?></td>
                    <td class="fs-11 text-muted"><?php echo substr($form->date, 0, 16); ?></td>
                    <td><?php echo $form->account_name; ?></td>
                    <td><?php echo $form->account_gsm; ?></td>
                    <td class="text-center"><span class="text-muted" data-toggle="tooltip" data-placement="top" title=""
                                                  data-original-title="<?php echo $form->item_count; ?> منتج مختلف"><?php echo $form->item_quantity; ?> العدد</span>
                    </td>
                    <td class="text-right"><?php echo get_set_money($form->total, true); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>

    <?php else: ?>
        <table>
            <tr>
            <tr>
                <th><?php echo('المعرف'); ?></th>
                <th><?php echo('حالة النموذج'); ?></th>
                <th><?php echo('التاريخ'); ?></th>
                <th><?php echo('بطاقة المستفيد'); ?></th>
                <th><?php echo('التلفون'); ?></th>
                <th><?php echo('التوزيع'); ?></th>
                <th><?php echo('المجموع'); ?></th>
            </tr>

            <?php foreach ($forms->list as $form): ?>
                <?php $form_status = get_form_status($form->status_id); ?>

                <?php
                $form->date = date_format(date_create($form->date), 'Y-m-d');

                if (isset($_GET['from_date']) && isset($_GET['to_date'])) {
                    $from_date = date_format(date_create($_GET['from_date']), 'Y-m-d');

                    $to_date = date_format(date_create($_GET['to_date']), 'Y-m-d');

                    if (($form->date >= $from_date) && ($form->date <= $to_date)) {
                        // is betwen
                    } else {
                        continue;
                    }
                }
                ?>
                <tr>
                    <td>#<?php echo $form->id; ?></td>
                    <td class="fs-11 text-muted"><?php echo($form_status->name); ?></td>
                    <td class="fs-11 text-muted"><?php echo $form->date ?></td>
                    <td><?php echo($form->account_name); ?></td>
                    <td><?php echo $form->account_gsm; ?></td>
                    <td class="text-center"><span class="text-muted" data-toggle="tooltip" data-placement="top" title=""
                                                  data-original-title="<?php echo $form->item_count; ?> منتج مختلف"><?php echo $form->item_quantity; ?> العدد</span>
                    </td>
                    <td class="text-right"><?php echo get_set_money($form->total, true); ?></td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <td colspan="7" style="color:#ccc; font-size:10px;"><?php echo('www.ERPultra.com'); ?></td>
            </tr>
        </table>
    <?php endif; ?>

<?php endif; ?>


<?php
if ($export_type == 'excel') {
    export_excel('قائمة بطاقات المواد');
} elseif ($export_type == 'pdf') {
    ?>

    <style>
        table tr td {
            border-bottom: 1px solid #ccc;
        }
    </style>
    <?php
    export_pdf('قائمة بطاقات المواد');
} elseif ($export_type == 'print') {
    get_footer_print();
}
?>