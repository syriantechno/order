<?php include('../../ultra.php'); ?>
<?php include_content_page('list', false, 'item'); ?>
<?php get_header(); ?>
<?php
add_page_info('title', 'قائمة بطاقات المواد');
add_page_info('nav', array('name' => 'إدارة المواد', 'url' => get_site_url('admin/item/')));
add_page_info('nav', array('name' => 'قائمة بطاقات المواد'));


if (!isset($_GET['orderby_name'])) {
    $_GET['orderby_name'] = 'name';
    $_GET['orderby_type'] = 'ASC';
}

$items = get_items(array('_GET' => true)); ?>


<?php
if (til_is_mobile()) {

    $arr_s = array();
    $arr_s['s_name'] = 'items';
    $arr_s['db-s-where'][] = array('name' => 'اسم المادة', 'val' => 'name');
    $arr_s['db-s-where'][] = array('name' => 'كود المادة', 'val' => 'code');
    search_form_for_panel($arr_s);
}
?>


    <div class="panel panel-default panel-table">
        <?php if (!til_is_mobile()): ?>
            <div class="panel-heading">
                <div class="row">
                    <div class="col-md-6">
                        <h3 class="panel-title">بطاقة المادة</h3>
                    </div> <!-- /.col-md-6 -->
                    <div class="col-md-6">
                        <div class="pull-right">

                            <?php

                            $arr_s = array();
                            $arr_s['s_name'] = 'items';
                            $arr_s['db-s-where'][] = array('name' => 'اسم المادة', 'val' => 'name');
                            $arr_s['db-s-where'][] = array('name' => 'كود المادة', 'val' => 'code');
                            search_form_for_panel($arr_s);
                            ?>


                            <!-- Single button -->
                            <div class="btn-group btn-icon" data-toggle="tooltip" data-placement="top" title="Pdf">
                                <button type="button" class="btn btn-default btn-xs dropdown-toggle"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-file-pdf-o"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li class="dropdown-header"><i class="fa fa-download"></i> PDF تصدير</li>
                                    <li>
                                        <a href="<?php echo str_replace('list.php', 'export.php', get_set_url_parameters(array('add' => array('export' => 'pdf')))); ?>">تصدير
                                            قائمة نشطة</a></li>
                                    <li>
                                        <a href="<?php echo str_replace('list.php', 'export.php', get_set_url_parameters(array('add' => array('export' => 'pdf', 'limit' => 'false')))); ?>">تصدير
                                            الكل <sup class="text-muted">(<?php echo $items->num_rows; ?>)</sup></a>
                                    </li>
                                </ul>
                            </div>


                            <!-- Single button -->
                            <div class="btn-group btn-icon" data-toggle="tooltip" data-placement="top" title="Excel">
                                <button type="button" class="btn btn-default btn-xs dropdown-toggle"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-file-excel-o"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li class="dropdown-header"><i class="fa fa-download"></i> EXCEL تصدير</li>
                                    <li>
                                        <a href="<?php echo str_replace('list.php', 'export.php', get_set_url_parameters(array('add' => array('export' => 'excel')))); ?>">تصدير
                                            قائمة نشطة</a></li>
                                    <li>
                                        <a href="<?php echo str_replace('list.php', 'export.php', get_set_url_parameters(array('add' => array('export' => 'excel', 'limit' => 'false')))); ?>">تصدير
                                            الكل <sup class="text-muted">(<?php echo $items->num_rows; ?>)</sup></a>
                                    </li>
                                </ul>
                            </div>


                            <!-- Single button -->
                            <div class="btn-group btn-icon" data-toggle="tooltip" data-placement="top" title="طباعة">
                                <button type="button" class="btn btn-default btn-xs dropdown-toggle"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-print"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li class="dropdown-header"><i class="fa fa-file-o"></i> طباعة</li>
                                    <li>
                                        <a href="<?php echo str_replace('list.php', 'export.php', get_set_url_parameters(array('add' => array('export' => 'print')))); ?>"
                                           target="_blank">طباعة قائمة نشطة</a></li>
                                    <li>
                                        <a href="<?php echo str_replace('list.php', 'export.php', get_set_url_parameters(array('add' => array('export' => 'print', 'limit' => 'false')))); ?>"
                                           target="_blank">طباعة الكل <sup
                                                    class="text-muted">(<?php echo $items->num_rows; ?>)</sup></a></li>
                                    <li class="divider"></li>
                                    <li>
                                        <a href="<?php echo str_replace('list.php', 'export.php', get_set_url_parameters(array('add' => array('export' => 'print', 'addBarcode' => true)))); ?>"
                                           target="_blank">طباعة قائمة الباركود النشطة</a></li>
                                    <li>
                                        <a href="<?php echo str_replace('list.php', 'export.php', get_set_url_parameters(array('add' => array('export' => 'print', 'limit' => 'false', 'addBarcode' => true)))); ?>"
                                           target="_blank">طباعة قائمة الباركود<sup
                                                    class="text-muted">(<?php echo $items->num_rows; ?>)</sup></a></li>
                                </ul>
                            </div>

                        </div>
                    </div> <!-- /.col-md-6 -->
                </div> <!-- /.row -->
            </div> <!-- /.panel-heading -->
        <?php endif; ?>

        <?php if ($items): ?>
            <table class="table table-hover table-bordered table-condensed table-striped">
                <thead>
                <?php if (til_is_mobile()): ?>
                    <tr>
                        <th>اسم المادة <?php echo get_table_order_by('name', 'ASC'); ?></th>
                        <th>سعر التكلفة <?php echo get_table_order_by('p_purc', 'ASC'); ?></th>
                        <th>سعر البيع <?php echo get_table_order_by('p_sale', 'ASC'); ?></th>
                        <th>&nbsp;الكمية <?php echo get_table_order_by('quantity', 'ASC'); ?></th>
                    </tr>
                <?php else : ?>
                    <tr>
                        <th width="200">كود المادة <?php echo get_table_order_by('code', 'ASC'); ?></th>
                        <th>اسم المادة <?php echo get_table_order_by('name', 'ASC'); ?></th>
                        <th width="100">سعر التكلفة <?php echo get_table_order_by('p_purc', 'ASC'); ?></th>
                        <th width="100">سعر البيع <?php echo get_table_order_by('p_sale', 'ASC'); ?></th>
                        <th width="100">الكمية <?php echo get_table_order_by('quantity', 'ASC'); ?></th>
                    </tr>
                <?php endif; ?>
                </thead>
                <tbody>
                <?php foreach ($items->list as $item): ?>
                    <?php if (til_is_mobile()): ?>
                        <tr>
                            <td><a href="detail.php?id=<?php echo $item->id; ?>"
                                   class="fs-11"><?php echo til_get_substr($item->name, 0, 20); ?></a></td>
                            <td class="text-right"><?php set_money($item->p_purc, true); ?></td>
                            <td class="text-right"><?php set_money($item->p_sale, true); ?></td>
                            <td class="text-center"><?php echo $item->quantity; ?></td>
                        </tr>
                    <?php else : ?>
                        <tr>
                            <td><a href="detail.php?id=<?php echo $item->id; ?>"><?php echo $item->code; ?></a></td>
                            <td><a href="detail.php?id=<?php echo $item->id; ?>"><?php echo $item->name; ?></a></td>
                            <td class="text-right"><?php set_money($item->p_purc, true); ?></td>
                            <td class="text-right"><?php set_money($item->p_sale, true); ?></td>
                            <td class="text-center"><?php echo $item->quantity; ?></td>
                        </tr>
                    <?php endif; ?>
                <?php endforeach; ?>
                </tbody>
            </table>

            <?php pagination($items->num_rows); ?>

        <?php else: ?>
            <div class="not-found">
                <?php print_alert(); ?>
            </div> <!-- /.not-found -->
        <?php endif; ?>

    </div> <!-- /.panel -->


<?php get_footer(); ?>