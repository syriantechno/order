<?php include('../../ultra.php'); ?>
<?php get_header(); ?>
<?php

add_page_info('title', 'كشف حساب الصندوق');
add_page_info('nav', array('name' => 'الصندوق / البنك', 'url' => get_site_url('admin/payment/')));

if (!isset($_GET['orderby_name'])) {
    $_GET['orderby_name'] = 'date';
    $_GET['orderby_type'] = 'ASC';
}

if (isset($_GET['from_date']) && isset($_GET['to_date'])) {
    if (!empty($_GET['from_date']) && !empty($_GET['to_date'])) {
        $forms = get_payments(array('_GET' => true, 'where' => [
            "query" => "`date` BETWEEN '{$_GET['from_date']}' AND '{$_GET['to_date']}' AND `type` = 'payment'"
        ]));
    } else {
        $forms = get_payments(array('_GET' => true));
    }

} else {
    $forms = get_payments(array('_GET' => true));
}

?>


<?php
if (til_is_mobile()) :

    $arr_s = array();
    $arr_s['s_name'] = 'forms';
    $arr_s['db-s-where'][] = array('name' => 'اسم المنتج', 'val' => 'name');
    $arr_s['db-s-where'][] = array('name' => 'رمز المنتج', 'val' => 'code');
    search_form_for_panel($arr_s);
endif;
?>

    <div class="panel panel-default panel-table">
        <div class="panel-heading hidden-xs">
            <div class="row">
                <div class="col-md-6" style="display: flex;">
                    <h3 class="panel-title">كشف حساب الصندوق</h3>
                    <form action="<?= $_SERVER['PHP_SELF']; ?>" method="get" class="form-inline">
                        <div class="form-group">
                            <input type="text" name="from_date" class="form-control input-sm date" placeholder="من"
                                   value="" style="width: 20%;">
                            <input type="text" name="to_date" class="form-control input-sm date" placeholder="إلى"
                                   value="" style="width: 20%;">
                            <button class="btn" type="submit">
                                <i class="fa fa-search text-black"></i>
                            </button>
                        </div>
                    </form>
                </div> <!-- /.col-md-6 -->
                <div class="col-md-6">
                    <div class="pull-right">

                        <?php
                        if (!til_is_mobile()) :

                            $arr_s = array();
                            $arr_s['s_name'] = 'forms';
                            $arr_s['db-s-where'][] = array('name' => 'اسم المادة', 'val' => 'name');
                            $arr_s['db-s-where'][] = array('name' => 'كود المادة', 'val' => 'code');
                            search_form_for_panel($arr_s);
                        endif;
                        ?>


                        <!-- Single button -->
                        <div class="btn-group btn-icon" data-toggle="tooltip" data-placement="top" title="Pdf">
                            <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-file-pdf-o"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li class="dropdown-header"><i class="fa fa-download"></i> PDF تصدير</li>
                                <li>
                                    <a href="<?php echo str_replace('list.php', 'export.php', set_url_parameters(array('add' => array('export' => 'pdf')))); ?>">تصدير
                                        قائمة نشطة</a></li>
                                <li>
                                    <a href="<?php echo str_replace('list.php', 'export.php', set_url_parameters(array('add' => array('export' => 'pdf', 'limit' => 'false')))); ?>">تصدير
                                        الكل <sup class="text-muted">(<?php echo $forms->num_rows; ?>)</sup></a></li>
                            </ul>
                        </div>


                        <!-- Single button -->
                        <div class="btn-group btn-icon" data-toggle="tooltip" data-placement="top" title="Excel">
                            <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-file-excel-o"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li class="dropdown-header"><i class="fa fa-download"></i> EXCEL تصدير</li>
                                <li>
                                    <a href="<?php echo str_replace('list.php', 'export.php', set_url_parameters(array('add' => array('export' => 'excel')))); ?>">تصدير
                                        قائمة نشطة</a></li>
                                <li>
                                    <a href="<?php echo str_replace('list.php', 'export.php', set_url_parameters(array('add' => array('export' => 'excel', 'limit' => 'false')))); ?>">تصدير
                                        الكل <sup class="text-muted">(<?php echo $forms->num_rows; ?>)</sup></a></li>
                            </ul>
                        </div>


                        <!-- Single button -->
                        <div class="btn-group btn-icon" data-toggle="tooltip" data-placement="top" title="طباعة">
                            <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-print"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li class="dropdown-header"><i class="fa fa-file-o"></i> طباعة</li>
                                <li>
                                    <a href="<?php echo str_replace('list.php', 'export.php', set_url_parameters(array('add' => array('export' => 'print')))); ?>"
                                       target="_blank">طباعة قائمة نشطة</a></li>
                                <li>
                                    <a href="<?php echo str_replace('list.php', 'export.php', set_url_parameters(array('add' => array('export' => 'print', 'limit' => 'false')))); ?>"
                                       target="_blank">طباعة الكل <sup
                                                class="text-muted">(<?php echo $forms->num_rows; ?>)</sup></a></li>
                            </ul>
                        </div>

                    </div>
                </div> <!-- /.col-md-6 -->
            </div> <!-- /.row -->
        </div> <!-- /.panel-heading -->

        <?php if ($forms): ?>
            <table class="table table-hover table-bordered table-condensed table-striped">
                <thead>
                <tr>
                    <th width="100">ID <?php echo get_table_order_by('id'); ?></th>
                    <th width="100">د/خ</th>
                    <th width="100">التاريخ <?php echo get_table_order_by('date', 'ASC'); ?></th>
                    <th>بطاقة الحساب <?php echo get_table_order_by('account_name', 'ASC'); ?></th>
                    <th>البيان <?php echo get_table_order_by('account_name', 'ASC'); ?></th>
                    <th width="100" class="hidden-xs">
                        مقبوضات<?php echo get_table_order_by('account_gsm', 'ASC'); ?></th>
                    <th width="100" class="hidden-xs">
                        مدفوعات<?php echo get_table_order_by('account_city', 'ASC'); ?></th>
                    <th width="100">الرصيد <?php echo get_table_order_by('total', 'ASC'); ?></th>
                </tr>
                </thead>
                <tbody>
                <?php $balance = 0;
                foreach ($forms->list as $form): ?>
                    <tr>
                        <td><a href="detail.php?id=<?php echo $form->id; ?>">#<?php echo $form->id; ?></a></td>
                        <td><?php echo get_in_out_label($form->in_out); ?></td>
                        <td>
                            <small class="text-muted"><?php echo substr($form->date, 0, 16); ?></small>
                        </td>
                        <td><?php if ($form->account_id): ?><a
                                href="../account/detail.php?id=<?php echo $form->account_id; ?>#forms" target="_blank">
                                <i class="fa fa-external-link"
                                   aria-hidden="true"></i> <?php echo $form->account_name; ?>
                                </a> <?php else: ?><?php echo $form->account_name; ?><?php endif; ?></td>
                        <td class="hidden-xs">
                            <?php
                            $meta = get_form_meta($form->id, 'note');
                            echo $meta->meta_value;
                            ?>
                        </td>
                        <td class="text-right"><?php if ($form->in_out == 0) {
                                echo get_set_money($form->total, true);
                                $balance = $balance + $form->total;
                            } else {
                                echo '';
                            } ?></td>
                        <td class="text-right"><?php if ($form->in_out == 1) {
                                echo get_set_money($form->total, true);
                                $balance = $balance - $form->total;
                            } else {
                                echo '';
                            } ?></td>

                        <td class="text-right"><?php echo get_set_money($balance, true); ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
                <tfoot style="font-size: 14px;">
                <tr>
                    <?php $D_C = ($balance < 0) ? 'دائن' : 'مدين'; ?>

                    <td colspan="10" class="text-right"><b>الرصيد : </b>
                        <span class="ff-2 fs-17 bold <?php echo $balance < 0 ? 'text-danger' : 'text-success'; ?>">
                               <?php echo get_set_money($balance); ?>
                               <?php echo $D_C; ?>
                 </span>
                        <h> فقط :</h> <?php echo til_get_money_convert_string(get_set_money($balance)); ?>
                    </td>
                </tr>
                </tfoot>
            </table>

            <?php pagination($forms->num_rows); ?>

        <?php else: ?>
            <div class="not-found">
                <?php print_alert(); ?>
            </div> <!-- /.not-found -->
        <?php endif; ?>

    </div> <!-- /.panel -->


<?php get_footer(); ?>