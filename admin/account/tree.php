<?php include('../../ultra.php'); ?>
<?php include_content_page('list', '', 'account'); ?>
<?php get_header(); ?>
<?php
add_page_info('title', 'شجرة المستفيدين');
add_page_info('nav', array('name' => 'المستفيدين', 'url' => get_site_url('admin/account/')));
add_page_info('nav', array('name' => 'شجرة  المستفيدين'));


if (!isset($_GET['orderby_code'])) {
    $_GET['orderby_code'] = 'code';
    $_GET['orderby_type'] = 'ASC';
}
$accounts = get_accounts(array('_GET' => true)); ?>
    <div class="row">
        <div class="col-xs-6 col-md-6">
            <?php
            if (!til_is_mobile()) :

                $arr_s = array();
                $arr_s['s_name'] = 'accounts';
                $arr_s['db-s-where'][] = array('name' => 'اسم المستفيد', 'val' => 'name');
                $arr_s['db-s-where'][] = array('name' => 'كود المستفيد', 'val' => 'code');
                $arr_s['db-s-where'][] = array('name' => ' نوع الاعاقة', 'val' => 'Retardationtype');
                $arr_s['db-s-where'][] = array('name' => 'رقم الاعاقة', 'val' => 'Retardationnum');
                $arr_s['db-s-where'][] = array('name' => 'المعيل', 'val' => 'mo3el');
                $arr_s['db-s-where'][] = array('name' => 'تاريخ الميلاد', 'val' => 'DateofBirth');
                search_form_for_panel($arr_s);
            endif;
            ?>
            <div class="panel panel-default panel-table">
                <div class="pull-right">
                    <div class="btn-group btn-icon hidden-xs" data-toggle="tooltip" data-placement="top" title="Pdf">
                        <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-file-pdf-o"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li class="dropdown-header"><i class="fa fa-download"></i> تصدير PDF</li>
                            <li>
                                <a href="<?php echo str_replace('list.php', 'export.php', get_set_url_parameters(array('add' => array('export' => 'pdf')))); ?>">تصدير
                                    قائمة نشطة</a></li>
                            <li>
                                <a href="<?php echo str_replace('list.php', 'export.php', get_set_url_parameters(array('add' => array('export' => 'pdf', 'limit' => 'false')))); ?>">تصدير
                                    الكل <sup class="text-muted">(<?php echo $accounts->num_rows; ?>)</sup></a></li>
                        </ul>
                    </div>
                    <!-- Single button -->
                    <div class="btn-group btn-icon hidden-xs" data-toggle="tooltip" data-placement="top" title="Excel">
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
                                    الكل <sup class="text-muted">(<?php echo $accounts->num_rows; ?>)</sup></a></li>
                        </ul>
                    </div>
                    <!-- Single button -->
                    <div class="btn-group btn-icon hidden-xs" data-toggle="tooltip" data-placement="top" title="طباعة">
                        <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-print"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li class="dropdown-header"><i class="fa fa-file-o"></i> طباعة</li>
                            <li>
                                <a href="<?php echo str_replace('list.php', 'export.php', get_set_url_parameters(array('add' => array('export' => 'print')))); ?>"
                                   target="_blank">طباعة القائمة النشطة</a></li>
                            <li>
                                <a href="<?php echo str_replace('list.php', 'export.php', get_set_url_parameters(array('add' => array('export' => 'print', 'limit' => 'false')))); ?>"
                                   target="_blank">طباعة الكل <sup
                                            class="text-muted">(<?php echo $accounts->num_rows; ?>)</sup></a></li>
                            <li class="divider"></li>
                            <li>
                                <a href="<?php echo str_replace('list.php', 'export.php', get_set_url_parameters(array('add' => array('export' => 'print', 'addBarcode' => true)))); ?>"
                                   target="_blank">طباعة قائمة الركود النشطة</a></li>
                            <li>
                                <a href="<?php echo str_replace('list.php', 'export.php', get_set_url_parameters(array('add' => array('export' => 'print', 'limit' => 'false', 'addBarcode' => true)))); ?>"
                                   target="_blank">طباعة كافة البراكودات <sup
                                            class="text-muted">(<?php echo $accounts->num_rows; ?>)</sup></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>


<?php

if (til_is_mobile()) :

    $arr_s = array();
    $arr_s['s_name'] = 'accounts';
    $arr_s['db-s-where'][] = array('name' => 'اسم المستفيد', 'val' => 'name');
    $arr_s['db-s-where'][] = array('name' => 'كود المستفيد', 'val' => 'code');
    $arr_s['db-s-where'][] = array('name' => ' نوع الاعاقة', 'val' => 'Retardationtype');
    $arr_s['db-s-where'][] = array('name' => 'رقم الاعاقة', 'val' => 'Retardationnum');
    $arr_s['db-s-where'][] = array('name' => 'المعيل', 'val' => 'mo3el');
    $arr_s['db-s-where'][] = array('name' => 'تاريخ الميلاد', 'val' => 'DateofBirth');
    search_form_for_panel($arr_s);
endif;
?>
<? foreach (get_types_array() as $name => $code): ?>
    <div class="panel panel-default panel-table">
        <div class="panel-heading hidden-xs">
            <div class="row">
                <div class="col-xs-6 col-md-6">
                    <h3 class="panel-title"><?= $name ?></h3>
                </div> <!-- /.col-md-6 -->

            </div> <!-- /.row -->
        </div> <!-- /.panel-heading -->

        <?php if ($accounts): ?>

            <table class="table table-hover table-bordered table-condensed table-striped">
                <thead>
                <tr>
                    <th class="hidden-xs" width="200">كود المستفيد<?php echo get_table_order_by('code', 'ASC'); ?></th>
                    <th>اسم المستفيد <?php echo get_table_order_by('name', 'ASC'); ?></th>
                    <th>اسم الاب <?php echo get_table_order_by('fathername', 'ASC'); ?></th>
                    <th>الجنس <?php echo get_table_order_by('sex', 'ASC'); ?></th>
                    <th>تاريخ الميلاد <?php echo get_table_order_by('DateofBirth', 'ASC'); ?></th>
                    <th>الرقم الوطني <?php echo get_table_order_by('countrynumber', 'ASC'); ?></th>
                    <th>رقم بطاقة الاعاقة <?php echo get_table_order_by('Retardationnum', 'ASC'); ?></th>
                    <th>نوع الاعاقة <?php echo get_table_order_by('Retardationtype', 'ASC'); ?></th>
                    <th>المعيل <?php echo get_table_order_by('mo3el', 'ASC'); ?></th>
                    <th>رقم الموبايل <?php echo get_table_order_by('gsm', 'ASC'); ?></th>
                    <th>العنوان <?php echo get_table_order_by('address', 'ASC'); ?></th>
                </tr>
                </thead>

                <tbody>
                <?php foreach ($accounts->list as $account): ?>
                    <?php
                    if (strpos($account->code, $code) === false) continue;
                    ?>
                    <tr>
                        <td class="hidden-xs"><a
                                    href="detail.php?id=<?php echo $account->id; ?>"><?php echo $account->code; ?></a>
                        </td>
                        <td>
                            <a href="detail.php?id=<?php echo $account->id; ?>"><?php echo $account->name; ?></a>
                        </td>
                        <td><?php echo $account->fathername; ?></td>
                        <td><?php echo $account->sex; ?></td>
                        <td><?php echo $account->DateofBirth; ?></td>
                        <td><?php echo $account->countrynumber; ?></td>
                        <td><?php echo $account->Retardationnum; ?></td>
                        <td><?php echo $account->Retardationtype; ?></td>
                        <td><?php echo $account->mo3el; ?></td>

                        <td class="hidden-xs"><?php echo $account->gsm; ?></td>
                        <td class="hidden-xs"><?php echo $account->address; ?></td>

                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>

            <!--        --><?php //pagination($accounts->num_rows); ?>

        <?php else: ?>
            <div class="not-found">
                <?php print_alert(); ?>
            </div> <!-- /.not-found -->
        <?php endif; ?>


    </div> <!-- /.panel -->
<?php endforeach; ?>


<?php get_footer(); ?>