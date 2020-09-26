<?php include('../../ultra.php'); ?>
<?php include_content_page('list', false, 'form'); ?>
<?php get_header(); ?>
<?php
add_page_info('title', 'قائمة التوزيع');
add_page_info('nav', array('name' => 'إدارة التوزيع', 'url' => get_site_url('admin/form/')));

if (isset($_GET['status_id'])) {
    if ($form_status = get_form_status($_GET['status_id'])) {

        add_page_info('title', 'قائمة التوزيع - ' . $form_status->name);
        add_page_info('nav', array('name' => 'جميع عمليات التوزيع', 'url' => get_site_url('admin/form/list.php')));
        add_page_info('nav', array('name' => $form_status->name));
    }
} else {
    add_page_info('nav', array('name' => 'قائمة التوزيع'));
}

?>



<?php

if (!isset($_GET['orderby_name'])) {
    $_GET['orderby_name'] = 'id';
    $_GET['orderby_type'] = 'DESC';
}

$forms = get_forms(array('_GET' => true)); ?>

<?php if (til_is_mobile()): ?>

    <?php

    $arr_s = array();
    $arr_s['s_name'] = 'forms';
    $arr_s['db-s-where'][] = array('name' => 'اسم المادة', 'val' => 'name');
    $arr_s['db-s-where'][] = array('name' => 'كود المادة', 'val' => 'code');
    search_form_for_panel($arr_s);
    ?>

    <div class="panel panel-default panel-table">
        <?php if ($forms): ?>
            <table class="table table-hover table-bordered table-condensed table-striped">
                <thead>
                <tr>
                    <th>ID <?php echo get_table_order_by('date', 'ASC'); ?></th>
                    <th class="hidden-xs-portrait" width="40"></th>
                    <th>التاريخ <?php echo get_table_order_by('date', 'ASC'); ?></th>
                    <th>بطاقة الحساب <?php echo get_table_order_by('account_name', 'ASC'); ?></th>
                    <th class="hidden-xs-portrait">المواد <?php echo get_table_order_by('item_quantity', 'ASC'); ?></th>
                    <th width="80">مجموع <?php echo get_table_order_by('total', 'ASC'); ?></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($forms->list as $form): ?>
                    <?php $form_status = get_form_status($form->status_id); ?>
                    <tr>
                        <td><a href="detail.php?id=<?php echo $form->id; ?>">#<?php echo $form->id; ?></a></td>
                        <td class="hidden-xs-portrait">
                            <span class="label label-primary" data-toggle="tooltip"
                                  title="<?php echo $form_status->name; ?>"
                                  style="background-color:<?php echo $form_status->bg_color; ?>; color:<?php echo $form_status->color; ?>;"><?php echo til_get_abbreviation($form_status->name); ?></span>
                        </td>
                        <td class="fs-11 text-muted"><?php echo til_get_date($form->date, 'd M H:i'); ?></td>
                        <td class="fs-10"><?php if ($form->account_id): ?><a
                                href="../account/detail.php?id=<?php echo $form->account_id; ?>#forms" target="_blank">
                                <i class="fa fa-external-link"
                                   aria-hidden="true"></i> <?php echo $form->account_name; ?>
                                </a> <?php else: ?><?php echo $form->account_name; ?><?php endif; ?></td>
                        <td class="text-center hidden-xs-portrait"><span class="text-muted" data-toggle="tooltip"
                                                                         data-placement="top" title=""
                                                                         data-original-title="<?php echo $form->item_count; ?> منتج مختلف"><?php echo $form->item_quantity; ?> العدد</span>
                        </td>
                        <td class="text-right"><?php echo get_set_money($form->item_count, true); ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>

            <?php pagination($forms->num_rows); ?>

        <?php else: ?>
            <div class="not-found">
                <?php print_alert(); ?>
            </div> <!-- /.not-found -->
        <?php endif; ?>

    </div> <!-- /.panel -->
<?php else: ?>
    <div class="panel panel-default panel-table">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-6" style="display: flex">
                    <h3 class="panel-title">قائمة التوزيع</h3>
                    <form action="<?= $_SERVER['PHP_SELF']; ?>" method="get" class="form-inline">
                        <div class="form-group">
                            <?php
                            $from_date = isset($_GET['from_date']) ? $_GET['from_date'] : null;
                            $to_date = isset($_GET['to_date']) ? $_GET['to_date'] : null;
                            ?>
                            <input type="text" name="from_date" class="form-control input-sm date" placeholder="من"
                                   value="<?= $from_date; ?>" style="width: 30%;">
                            <input type="text" name="to_date" class="form-control input-sm date" placeholder="إلى"
                                   value="<?= $to_date; ?>" style="width: 30%;">
                            <button class="btn" type="submit">
                                <i class="fa fa-search text-black"></i>
                            </button>
                        </div>
                    </form>
                </div> <!-- /.col-md-6 -->
                <div class="col-md-6">
                    <div class="pull-right">

                        <?php

                        $arr_s = array();
                        $arr_s['s_name'] = 'forms';
                        $arr_s['db-s-where'][] = array('name' => 'اسم المادة', 'val' => 'name');
                        $arr_s['db-s-where'][] = array('name' => 'كود المادة', 'val' => 'code');
                        search_form_for_panel($arr_s);
                        ?>


                        <!-- Single button -->
                        <!--						<div class="btn-group btn-icon " data-toggle="tooltip" data-placement="top" title="Pdf" style="background-color: #EEEEEE">-->
                        <!--						  <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">-->
                        <!--						    <i class="fa fa-file-pdf-o"></i>-->
                        <!--						  </button>-->
                        <!--						  <ul class="dropdown-menu dropdown-menu-right">-->
                        <!--						  	<li class="dropdown-header"><i class="fa fa-download"></i> تصدير PDF</li>-->
                        <!--						    <li><a href="-->
                        <?php //echo str_replace('list.php', 'export.php', get_set_url_parameters(array('add'=> array('export'=>'pdf')))); ?><!--">تصدير قائمة نشطة</a></li>-->
                        <!--						    <li><a href="-->
                        <?php //echo str_replace('list.php', 'export.php', get_set_url_parameters(array('add'=> array('export'=>'pdf', 'limit'=>'false')))); ?><!--">تصدير الكل <sup class="text-muted">(-->
                        <?php //echo $forms->num_rows; ?><!--)</sup></a></li>-->
                        <!--						  </ul>-->
                        <!--						</div>-->


                        <!-- Single button -->
                        <div class="btn-group btn-icon" data-toggle="tooltip" data-placement="top" title="Excel">
                            <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-file-excel-o"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li class="dropdown-header"><i class="fa fa-download"></i> EXCEL تصدير</li>
                                <li>
                                    <a href="<?php echo str_replace('list.php', 'export.php', get_set_url_parameters(array('add' => array('export' => 'excel')))); ?>">تصدير
                                        قائمة نشطة</a></li>
                                <li>
                                    <a href="<?php echo str_replace('list.php', 'export.php', get_set_url_parameters(array('add' => array('export' => 'excel', 'limit' => 'false')))); ?>">تصدير
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
                                    <a href="<?php echo str_replace('list.php', 'export.php', get_set_url_parameters(array('add' => array('export' => 'print')))); ?>"
                                       target="_blank">طباعة قائمة نشطة</a></li>
                                <li>
                                    <a href="<?php echo str_replace('list.php', 'export.php', get_set_url_parameters(array('add' => array('export' => 'print', 'limit' => 'false')))); ?>"
                                       target="_blank">طباعة الكل <sup
                                                class="text-muted">(<?php echo $forms->num_rows; ?>)</sup></a></li>
                                <li class="divider"></li>
                                <li>
                                    <a href="<?php echo str_replace('list.php', 'export.php', get_set_url_parameters(array('add' => array('export' => 'print', 'addBarcode' => true)))); ?>"
                                       target="_blank">طباعة قائمة الباركود النشطة</a></li>
                                <li>
                                    <a href="<?php echo str_replace('list.php', 'export.php', get_set_url_parameters(array('add' => array('export' => 'print', 'limit' => 'false', 'addBarcode' => true)))); ?>"
                                       target="_blank">طباعة باركود <sup
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
                    <th width="60">ID</th>
                    <th width="100">الحالة</th>
                    <th width="120">التاريخ<?php echo get_table_order_by('date', 'ASC'); ?></th>
                    <th>بطاقة المستفيد <?php echo get_table_order_by('account_name', 'ASC'); ?></th>
                    <th width="100">الهاتف <?php echo get_table_order_by('account_gsm', 'ASC'); ?></th>

                    <th width="200">الحركة <?php echo get_table_order_by('item_quantity', 'ASC'); ?></th>
                    <th width="150">المجموع <?php echo get_table_order_by('total', 'ASC'); ?></th>
                </tr>
                </thead>
                <tbody>
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
                        <td><a href="detail.php?id=<?php echo $form->id; ?>">#<?php echo $form->id; ?></a></td>
                        <td><span class="label label-primary"
                                  style="background-color:<?php echo $form_status->bg_color; ?>; color:<?php echo $form_status->color; ?>;"><?php echo $form_status->name; ?></span>
                        </td>
                        <td><?php echo substr($form->date, 0, 16); ?></td>
                        <td><?php if ($form->account_id): ?><a
                                href="../account/detail.php?id=<?php echo $form->account_id; ?>#forms" target="_blank">
                                <i class="fa fa-external-link"
                                   aria-hidden="true"></i> <?php echo $form->account_name; ?>
                                </a> <?php else: ?><?php echo $form->account_name; ?><?php endif; ?></td>
                        <td><?php echo $form->account_gsm; ?></td>
                        <td class="text-center">
						<span class="text-muted" data-toggle="tooltip" data-placement="top" title=""
                              data-original-title=
                              " فاتورة بحركة منتج <?php echo $form->item_count; ?> ">
						
						 <?php
                         if ($form->type == 'form') {
                             $item = get_form_items($form->id);
                             $item = $item->list[0];
                             $in_out = ($form->in_out == '0') ? 'معونة' : 'معونة';
                             echo " {$in_out} : "
                                 . " عدد {$form->item_quantity} "
                                 . " : {$item->item_name}";
                         } elseif ($form->type == 'payment') {
                             if ($form->in_out == '0') {
                                 echo 'دفعة منه';
                             } else {
                                 echo 'دفعة له';
                             }
                         }
                         ?>
						  </span></td>
                        <td class="text-right"><?php echo get_set_money($form->item_count, true); ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>

            <?php pagination($forms->num_rows); ?>

        <?php else: ?>
            <div class="not-found">
                <?php print_alert(); ?>
            </div> <!-- /.not-found -->
        <?php endif; ?>

    </div> <!-- /.panel -->

<?php endif; ?>

<?php get_footer(); ?>
