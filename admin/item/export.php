<?php include('../../ultra.php'); ?>
    <meta charset="UTF-8">
    <title>قائمة بطاقات المنتجات | المستقبل</title>
<?php
ini_set('max_execution_time', 300);
ini_set('memory_limit', '-1');

$export_type = '';
if (isset($_GET['export'])) {
    $export_type = $_GET['export'];
}

$items = get_items(array('_GET' => true));
?>

<?php if ($export_type == 'print') {
    get_header_print(array('title' => 'قائمة بطاقات المنتجات'));
} ?>

<?php if ($items): ?>
    <?php if ($export_type == 'print'): ?>
        <div class="h-20"></div>
        <table class="table table-hover table-bordered table-condensed">
            <tr>
                <?php if (isset($_GET['addBarcode'])): ?>
                    <th width="200">كود المادة</th><?php else: ?>
                    <th width="140">كود المادة</th> <?php endif; ?>
                <th>اسم المادة</th>
                <th width="100">سعر التكلفة</th>
                <th width="100">سعر البيع</th>
                <th width="60" class="text-center">عدد</th>
            </tr>
            <?php foreach ($items->list as $item): ?>
                <tr>
                    <td>
                        <?php if (isset($_GET['addBarcode'])): ?> <img
                                src="<?php get_barcode_url($item->code, array('position' => 'left')); ?>"/>
                            <br/> <?php endif; ?>
                        <?php echo $item->code; ?>
                    </td>
                    <td><?php echo $item->name; ?></td>
                    <td class="text-right"><?php echo get_set_money($item->p_purc, true); ?></td>
                    <td class="text-right"><?php echo get_set_money($item->p_sale, true); ?></td>
                    <td class="text-center"><?php echo $item->quantity; ?></td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <td colspan="6"
                    style="color:#ccc; font-size:10px;"><?php echo get_convert_str_export('  تم إنشاؤها باستخدام المستقبل'); ?></td>
            </tr>
        </table>

    <?php else: ?>
        <table>
            <tr>
                <th><?php echo get_convert_str_export('اسم المنتج'); ?></th>
                <th><?php echo get_convert_str_export('كود المنتج'); ?></th>
                <th><?php echo get_convert_str_export('سعر الكلفة'); ?></th>
                <th><?php echo get_convert_str_export('سعر البيع'); ?></th>
                <th><?php echo get_convert_str_export('عدد'); ?></th>
            </tr>
            <?php foreach ($items->list as $item): ?>
                <tr>
                    <td><?php echo get_convert_str_export($item->name); ?></td>
                    <td><?php echo get_convert_str_export($item->code); ?></td>
                    <td><?php echo $item->p_purc; ?></td>
                    <td><?php echo $item->p_sale; ?></td>
                    <td><?php echo $item->quantity; ?></td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <td colspan="6"
                    style="color:#ccc; font-size:10px;"><?php echo get_convert_str_export('تم إنشاؤها باستخدام المستقبل'); ?></td>
            </tr>
        </table>
    <?php endif; ?>

<?php endif; ?>


<?php
if ($export_type == 'excel') {
    export_excel('قائمة بطاقات المنتج');
} elseif ($export_type == 'pdf') {
    ?>
    <style>
        table tr td {
            border-bottom: 1px solid #ccc;
        }
    </style>
    <?php
    export_pdf('قائمة بطاقات المنتج');
} elseif ($export_type == 'print') {
    get_footer_print();
}
?>