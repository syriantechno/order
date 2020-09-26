<?php include('../../ultra.php'); ?>

<?php if (!$item = get_item($_GET['id'])) {
    get_header();
    add_page_info('title', 'لم يتم العثور على بطافة المادة');
    add_page_info('nav', array('name' => 'مواد', 'url' => get_site_url('admin/item/')));
    add_page_info('nav', array('name' => 'قائمة', 'url' => get_site_url('admin/item/list.php')));
    add_page_info('nav', array('name' => 'لم يتم العثور على بطافة المادة'));
    print_alert();
    get_footer();
    exit;
}
include_content_page('detail', $item->type, 'item', array('item' => $item));
?>
<?php get_header(); ?>
<?php
if (isset($_POST['update'])) {
    if (update_item($item->id, $_POST)) {
        $item = get_item($item->id);
    }
}

if (isset($_GET['status'])) {
    if ($_GET['status'] == '0' OR $_GET['status'] == '1') {
        if (update_item($item->id, array('update' => array('status' => $_GET['status']), 'add_alert' => false))) {
            $item = get_item($item->id);
        }
    }
}
?>


<?php
add_page_info('title', $item->name);
add_page_info('nav', array('name' => 'المواد', 'url' => get_site_url('admin/item/')));
add_page_info('nav', array('name' => 'قائمة', 'url' => get_site_url('admin/item/list.php')));
add_page_info('nav', array('name' => $item->name));
?>


<?php if ($item->status == '0'): ?>
    <?php echo get_alert('<i class="fa fa-trash-o"></i> <b>الحذر!</b> بطاقة المادة غير نشطة.', 'warning', false); ?>
    <div class="h-20 visible-xs"></div>
<?php else: ?>
    <?php create_modal(array('id' => 'status_item',
        'title' => 'بطاقة المنتج <u>تحذير</u>',
        'content' => _b($item->name) . ' الغاء تنشيط بطاقة المادة؟ <br /> <small>من قاعدة بيانات بطاقة المنتج <u>متعذر محوه</u>. ولكن لا يمكن العثور عليها في عمليات البحث وقوائم البيانات. <br /> إذا كان هناك شكل حركة مثل أي، يظهر البيان الحالي في التفاصيل وتشكيل الحركات.</small>',
        'btn' => '<a href="?id=' . $item->id . '&status=0" class="btn btn-danger">نعم، أوافق</a>')); ?>
<?php endif; ?>


    <ul class="nav nav-pills mb-3" role="tablist">
        <li role="presentation" class="active"><a href="#home" id="home-tab" role="tab" data-toggle="tab"
                                                  aria-controls="home" aria-expanded="true"><i
                        class="fa fa-id-card-o"></i><span class="hidden-xs"> بطاقة المعونة</span></a></li>
        <li role="presentation" class=""><a href="#forms" role="tab" id="forms-tab" data-toggle="tab"
                                            aria-controls="forms" aria-expanded="false"><i class="fa fa-list"></i><span
                        class="hidden-xs"> كشف حركات المعونة</span></a></li>
        <li role="presentation" class=""><a href="#logs" role="tab" id="logs-tab" data-toggle="tab" aria-controls="logs"
                                            aria-expanded="false"><i class="fa fa-database"></i><span class="hidden-xs"> سجل العمليات</span></a>
        </li>

        <li role="presentation" class="dropdown pull-right til-menu-right"><a href="#" class="dropdown-toggle"
                                                                              id="myTabDrop1" data-toggle="dropdown"
                                                                              aria-controls="myTabDrop1-contents"
                                                                              aria-expanded="false"><i
                        class="fa fa-cogs"></i><span class="hidden-xs"> خيارات </span><span class="caret"></span></a>
            <ul class="dropdown-menu" aria-labelledby="myTabDrop1" id="myTabDrop1-contents">
                <li><a href="<?php site_url('admin/user/task/add.php?attachment&item_id=' . $item->id); ?>"
                       target="_blank"><i class="fa fa-tasks fa-fw"></i> إلحاق المهمة</a></li>
                <li><a href="<?php site_url('admin/user/message/add.php?attachment&item_id=' . $item->id); ?>"
                       target="_blank"><i class="fa fa-envelope-o fa-fw"></i> إضافة مرفق الرسالة</a></li>
                <li role="separator" class="divider"></li>
                <?php if ($item->status == '1'): ?>
                    <li><a href="#" data-toggle="modal" data-target="#status_item"><i
                                    class="fa fa-trash-o fa-fw text-danger"></i> حذف</a></li>
                <?php else: ?>
                    <li><a href="?id=<?php echo $item->id; ?>&status=1"><i class="fa fa-undo fa-fw text-success"></i>
                            نشط</a></li>
                <?php endif; ?>
            </ul>
        </li>

        <li role="presentation" class="dropdown pull-right til-menu-right"><a href="#" class="dropdown-toggle"
                                                                              id="myTabDrop1" data-toggle="dropdown"
                                                                              aria-controls="myTabDrop1-contents"
                                                                              aria-expanded="false"><i
                        class="fa fa-print"></i><span class="hidden-xs"> طباعة </span><span class="caret"></span></a>
            <ul class="dropdown-menu" aria-labelledby="myTabDrop1" id="myTabDrop1-contents">
                <li><a href="print-statement.php?id=<?php echo $item->id; ?>&print" target="_blank"><i
                                class="fa fa-fw fa-file-text-o"></i> طباعة البيان</a></li>
                <li class="divider"></li>
                <li><a href="print-barcode.php?id=<?php echo $item->id; ?>&print" target="_blank"><i
                                class="fa fa-fw fa-barcode"></i> طباعة الباركود</a></li>
                <li><a href="print-barcode_price.php?id=<?php echo $item->id; ?>&print" target="_blank"><i
                                class="fa fa-fw fa-barcode"></i> طباعة باركود الاسعار</a></li>
            </ul>
        </li>
    </ul>


    <div class="tab-content">

        <!-- tab:home -->
        <div class="tab-pane fade active in" role="tabpanel" id="home" aria-labelledby="home-tab">

            <div class="row">
                <div class="col-md-6">
                    <?php print_alert('update_item'); ?>

                    <form name="form_add_accout" id="form_add_account" action="" method="POST" class="validate">
                        <div class="form-group">
                            <label for="code">رمز المعونة <sup><i class="fa fa-barcode"></i> كود الباركود</sup> </label>
                            <input type="text" name="code" id="code" value="<?php echo $item->code; ?>"
                                   class="form-control" minlength="3" maxlength="32">
                        </div> <!-- /.form-group -->

                        <div class="form-group">
                            <label for="name">اسم المعونة <sup class="text-muted">اسم المعونة</sup></label>
                            <input type="text" name="name" id="name" value="<?php echo $item->name; ?>"
                                   class="form-control required focus" minlength="3" maxlength="50">
                        </div> <!-- /.form-group -->


                        <div class="row">
                            <div class="col-md-2">

                            </div> <!-- /.col-md-2 -->
                            <div class="col-xs-6 col-md-5">
                                <div class="form-group">
                                    <label for="p_purc_out_vat">سعر التكلفة <sup class="text-muted"><u>بإستثناء
                                                الضريبة</u></sup></label>
                                    <input type="text" pattern="[0-9]+([\.,][0-9]+)?" name="p_purc_out_vat"
                                           id="p_purc_out_vat"
                                           value="<?php echo get_set_money($item->p_purc_out_vat); ?>"
                                           class="form-control money" maxlength="15" disabled>
                                </div> <!-- /.form-group -->
                            </div> <!-- /.col -->
                            <div class="col-xs-6 col-md-5">
                                <div class="form-group">
                                    <label for="p_sale_out_vat">سعر البيع <sup class="text-muted"><u>بإستثناء
                                                الضريبة</u></sup></label>
                                    <input type="text" pattern="[0-9]+([\.,][0-9]+)?" name="p_sale_out_vat"
                                           id="p_sale_out_vat"
                                           value="<?php echo get_set_money($item->p_sale_out_vat); ?>"
                                           class="form-control money" maxlength="11" disabled>
                                </div> <!-- /.form-group -->
                            </div> <!-- /.col-md-5 -->
                        </div> <!-- /.row -->


                        <div class="row">
                            <div class="col-xs-6 col-md-2">
                                <div class="form-group">
                                    <label for="vat">VAT <sup class="text-muted">(%)</sup></label>
                                    <input type="tel" name="vat" id="vat" value="<?php echo $item->vat; ?>"
                                           class="form-control digits" maxlength="2" onkeyup="calc_vat();"
                                           onfocusout="calc_vat();">
                                </div> <!-- /.form-group -->
                            </div> <!-- /.col -->
                            <div class="clearfix visible-xs"></div>
                            <div class="col-xs-6 col-md-5">
                                <div class="form-group">
                                    <label for="p_purc">سعر التكلفة</label>
                                    <input type="number" name="p_purc" id="p_purc"
                                           value="<?php echo get_set_money($item->p_purc); ?>"
                                           class="form-control money" maxlength="15" onkeyup="calc_vat();"
                                           onfocusout="calc_vat();">
                                </div> <!-- /.form-group -->
                            </div> <!-- /.col -->
                            <div class="col-xs-6 col-md-5">
                                <div class="form-group">
                                    <label for="p_sale">سعر البيع</label>
                                    <input type="number" name="p_sale" id="p_sale"
                                           value="<?php echo get_set_money($item->p_sale); ?>"
                                           class="form-control money" maxlength="15" onkeyup="calc_vat();"
                                           onfocusout="calc_vat();">
                                </div> <!-- /.form-group -->
                            </div> <!-- /.col -->
                        </div> <!-- /.row -->


                        <div class="text-right">
                            <input type="hidden" name="update">
                            <input type="hidden" name="uniquetime" value="<?php uniquetime(); ?>">

                            <button class="btn btn-success btn-xs-block btn-insert"><i class="fa fa-floppy-o"></i> حفظ
                            </button>
                        </div>
                    </form>
                </div> <!-- /.col-* -->
                <div class="col-md-6">

                    <small class="text-muted"><i class="fa fa-calendar-o"></i> حالة الأسهم الحالية</small>
                    <div class="h-10"></div>

                    <div class="row space-none">
                        <div class="col-md-4">

                            <div class="well text-center">
                                <small class="text-muted block">كمية التوزيع:</small>
                                تم توزيعها
                                <span class="ff-2 fs-18 bold <?php echo $item->quantity > 0 ? 'text-success' : 'text-danger'; ?>"><?php echo $item->quantity; ?></span>
                                مرات

                            </div>

                        </div> <!-- /.col- -->
                        <div class="col-xs-6 col-md-4">
                            <div class="">
                                <span class="ff-2 fs-17 bold"><?php echo get_set_money($item->quantity * $item->p_purc); ?></span>
                                <small class="text-muted"><?php echo til()->company->currency; ?></small>
                                <br>
                                <small class="text-muted">سعر التكلفة</small>
                            </div>
                        </div> <!-- /.col-* -->
                        <div class="col-xs-6 col-md-4">
                            <div class="">
                                <span class="ff-2 fs-15 bold"><?php echo get_set_money($item->quantity * $item->p_sale); ?></span>
                                <small class="text-muted"><?php echo til()->company->currency; ?></small>
                                <br>
                                <small class="text-muted">سعر البيع</small>
                            </div>
                        </div> <!-- /.col-* -->
                    </div> <!-- /.row -->

                    <div class="h-10 visible-xs"></div>

                    <div class="row">
                        <div class="col-md-12">
                            <?php
                            $chart = array();
                            $chart['type'] = 'bar';
                            $chart['data']['datasets'][0]['label'] = 'الحركات';
                            $chart['data']['datasets'][0]['fill'] = true;
                            $chart['data']['datasets'][0]['lineTension'] = 0.1;
                            $chart['data']['datasets'][0]['borderWidth'] = 1;
                            $chart['data']['datasets'][0]['pointBorderWidth'] = 3;
                            $chart['data']['datasets'][0]['pointRadius'] = 1;
                            $chart['data']['datasets'][0]['backgroundColor'] = 'rgba(253, 196, 48, 0.2)';
                            $chart['data']['datasets'][0]['borderColor'] = 'rgba(253, 196, 48, 1)';


                            $_start_date = date('Y-m-d', strtotime('-4 week', strtotime(date('Y-m-d'))));
                            $_end_date = date('Y-m-d');
                            while (strtotime($_start_date) <= strtotime($_end_date)) {
                                $chart['data']['labels'][] = $_start_date = date('Y-m-d', strtotime('+1 day', strtotime($_start_date)));

                                $quantity = 0;
                                $item_quantity = $item->quantity;
                                $q_forms = db()->query("SELECT sum(quantity) as quantity FROM " . dbname('form_items') . " WHERE status='1' AND  in_out='0' AND item_id='" . $item->id . "' AND date >= '" . $_start_date . " 00:00:00' ORDER BY date DESC");
                                if (($quantity = $q_forms->fetch_object()->quantity) > 0) {
                                    // $chartt['data']['datasets'][0]['data'][] = $total;
                                } else {
                                    // $chartt['data']['datasets'][0]['data'][] = '0.00';
                                }
                                $item_quantity = $item_quantity + $quantity;


                                $quantity = 0;
                                $q_forms = db()->query("SELECT sum(quantity) as quantity FROM " . dbname('form_items') . " WHERE status='1' AND in_out='1' AND item_id='" . $item->id . "' AND date >= '" . $_start_date . " 00:00:00' ORDER BY date DESC");
                                if (($quantity = $q_forms->fetch_object()->quantity) > 0) {
                                    // $chartt['data']['datasets'][1]['data'][] = $total;
                                } else {
                                    // $chartt['data']['datasets'][1]['data'][] = '0.00';
                                }
                                $item_quantity = $item_quantity + $quantity;
                                $chart['data']['datasets'][0]['data'][] = $item_quantity;


                            }


                            $chart['options']['legend']['display'] = false;
                            $chart['options']['scales']['yAxes'][0]['display'] = false;
                            $chart['options']['scales']['xAxes'][0]['display'] = false;
                            $chart['options']['scales']['xAxes'][0]['ticks']['beginAtZero'] = true;
                            $chart['options']['maintainAspectRatio'] = false;
                            $chart['options']['tooltips']['enabled'] = true;
                            $chart['options']['tooltips']['titleFontSize'] = 9;
                            $chart['options']['tooltips']['callbacks']['title'] = "=TIL= function(tooltipItems, data) { return ''; } =TIL=";
                            $chart['options']['tooltips']['callbacks']['label'] = "=TIL= function(tooltipItems, data) {  return  data.labels[tooltipItems.index]+':      '+ tooltipItems.yLabel; } =TIL=";


                            $args['height'] = '50';
                            $args['chart'] = $chart;
                            ?>

                            <?php chartjs($args); ?>
                        </div> <!-- /.col-md-12 -->
                    </div> <!-- /.row -->

                    <div class="h-20"></div>

                    <small class="text-muted"><i class="fa fa-calendar-o"></i> حتى الآن</small>
                    <div class="h-10"></div>

                    <div class="row">
                        <div class="col-xs-4 col-md-4">
                            <div class="">
                                <span class="ff-2 fs-15 bold"><?php echo get_set_money($item->total_purc); ?></span>
                                <small class="text-muted"><?php echo til()->company->currency; ?></small>
                                <br>
                                <small class="text-muted">إجمالي المنتجات الواردة</small>
                            </div>
                        </div> <!-- /.col-* -->
                        <div class="col-xs-4 col-md-4">
                            <div class="">
                                <span class="ff-2 fs-15 bold"><?php echo get_set_money($item->total_sale); ?></span>
                                <small class="text-muted"><?php echo til()->company->currency; ?></small>
                                <br>
                                <small class="text-muted">إجمالي المنتجات المباعة</small>
                            </div>
                        </div> <!-- /.col-* -->
                        <div class="col-xs-4 col-md-4">
                            <div class="">
                                <span class="ff-2 fs-15 bold <?php echo $item->profit > 0 ? 'text-success' : 'text-danger'; ?>"><?php echo get_set_money($item->profit); ?></span>
                                <small class="text-muted"><?php echo til()->company->currency; ?></small>
                                <br>
                                <small class="text-muted">ارباح المادة</small>
                            </div>
                        </div> <!-- /.col-* -->
                    </div> <!-- /.row -->

                </div> <!-- /.col-* -->
            </div> <!-- /.row -->

            <div class="h-20"></div>

            <div class="row">
                <div class="col-md-4">

                    <?php
                    $whichAccount = array();
                    $query = db()->query("SELECT * FROM " . dbname('form_items') . " WHERE status='1' AND in_out='1' AND item_id='" . $item->id . "' ");
                    if ($query->num_rows) {
                        while ($list = $query->fetch_object()) {

                            if (!isset($whichAccount[$list->account_id])) {
                                $whichAccount[$list->account_id] = array('quantity' => 0, 'profit' => 0, 'total' => 0);
                            }

                            $whichAccount[$list->account_id]['quantity'] = $whichAccount[$list->account_id]['quantity'] + $list->quantity;
                            $whichAccount[$list->account_id]['profit'] = $whichAccount[$list->account_id]['profit'] + $list->profit;
                            $whichAccount[$list->account_id]['total'] = $whichAccount[$list->account_id]['total'] + $list->total;
                        }
                    }
                    ?>

                    <div class="h-20 visible-xs"></div>
                    <small class="text-muted module-title-small"><i class="fa fa-users"></i> الزبائن الأكثر تفضيلا
                    </small>
                    <div class="h-10"></div>

                    <div class="panel panel-info panel-heading-0 panel-border-right panel-table panel-dashboard-list">
                        <div class="panel-body">
                            <div class="panel-list">
                                <?php if (count($whichAccount)): ?>

                                    <table class="table table-hover table-condensed">
                                        <thead>
                                        <tr>
                                            <th>بطاقة الحساب</th>
                                            <th class="text-center">عدد</th>
                                            <th class="text-right">المجموع</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach ($whichAccount as $key => $value): ?>
                                            <?php $account = get_account($key); ?>
                                            <tr onclick="location.href='<?php site_url('account', $account->id); ?>';"
                                                class="pointer">
                                                <td>
                                                    <?php if ($key): ?>
                                                        <a href="<?php site_url('account', $account->id); ?>"
                                                           title="<?php echo $account->name; ?>"><?php echo til_get_substr($account->name, 0, 20); ?>
                                                            <i class="fa fa-external-link"></i></a>
                                                    <?php else: ?>
                                                        اخرى

                                                    <?php endif; ?>
                                                </td>
                                                <td class="text-center"><?php echo $value['quantity']; ?></td>
                                                <td class="text-right" width="100" data-toggle="tooltip"
                                                    title="الربح والخسارة: <?php echo get_set_money($value['profit'], true); ?>"><?php echo get_set_money($value['total']); ?>
                                                    <small class="text-muted"><?php echo til()->company->currency; ?></small>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                        </tbody>
                                    </table>

                                <?php endif; ?>
                            </div> <!-- /.panel-list -->
                        </div> <!-- /.panel-body -->
                    </div> <!-- /.panel -->

                </div> <!-- /.col-* -->
                <div class="col-md-8">

                    <div class="h-20 visible-xs"></div>
                    <small class="text-muted module-title-small"><i class="fa fa-th-list"></i> آخر التحركات من هذا
                        المنتج
                    </small>
                    <div class="h-10"></div>

                    <div class="panel panel-warning panel-heading-0 panel-border-right panel-table panel-dashboard-list">
                        <div class="panel-body">
                            <?php $query = db()->query("SELECT * FROM " . dbname('form_items') . " WHERE status='1' AND type='item' AND item_id ='" . $item->id . "' ORDER BY date DESC LIMIT 50"); ?>
                            <?php if ($query->num_rows): ?>

                                <table class="table table-hover table-condensed table-stripedd">
                                    <thead>
                                    <tr>
                                        <th>المعرف</th>
                                        <th>بطاقة الحساب</th>
                                        <th>د/خ</th>
                                        <th class="text-center">عدد</th>
                                        <th class="text-right">السعر الافرادي</th>
                                        <th class="text-right">المجموع</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php while ($list = $query->fetch_object()): ?>
                                        <?php $item = get_item($list->item_id); ?>
                                        <tr onclick="location.href='<?php site_url('form', $list->form_id); ?>';"
                                            class="pointer">
                                            <td width="80"><a href="<?php site_url('form', $list->form_id); ?>"
                                                              class="text-muted">#<?php echo $list->form_id; ?></a></td>
                                            <td>
                                                <?php if ($list->account_id): ?>
                                                    <a href="<?php site_url('account', $list->account_id); ?>"
                                                       title="<?php echo get_form($list->form_id)->account_name; ?>"><?php echo til_get_substr(get_form($list->form_id)->account_name, 0, 40); ?>
                                                        <i class="fa fa-external-link"></i></a>
                                                <?php else: ?>
                                                    <?php echo til_get_substr(get_form($list->form_id)->account_name, 0, 40); ?>
                                                <?php endif; ?>
                                            </td>
                                            <?php if ($list->in_out == '1'): ?>
                                                <td class="text-muted">تبرع</td>
                                            <?php else: ?>
                                                <td class="text-muted">معونة</td>
                                            <?php endif; ?>
                                            <td class="text-center"><?php echo $list->quantity; ?></td>
                                            <td class="text-right"
                                                width="100"><?php echo get_set_money($list->price); ?>
                                                <small class="text-muted"><?php echo til()->company->currency; ?></small>
                                            </td>
                                            <td class="text-right"
                                                width="100"><?php echo get_set_money($list->total); ?>
                                                <small class="text-muted"><?php echo til()->company->currency; ?></small>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                    </tbody>
                                </table>

                            <?php endif; ?>
                        </div> <!-- /.panel-body -->
                    </div> <!-- /.panel -->

                </div> <!-- /.col-* -->
            </div> <!-- /.row -->


        </div>
        <!-- /tab:home -->


        <!-- tab:forms -->
        <div class="tab-pane fade" role="tabpanel" id="forms" aria-labelledby="forms-tab">

            <?php $q_form_items = db()->query("SELECT * FROM " . dbname('form_items') . " WHERE status='1' AND item_id='" . $item->id . "' ORDER BY date DESC"); ?>
            <?php if ($q_form_items->num_rows): ?>
                <table class="table table-striped table-hover table-condensed table-bordered dataTable">
                    <thead>
                    <?php if (til_is_mobile()): ?>
                        <tr>
                            <th>ID</th>
                            <th width="" class="hidden-xs-portrait">التاريخ</th>
                            <th class="hidden-xs-portrait">بطاقة الحساب</th>
                            <th width="" class="text-center">عدد</th>
                            <th width="" class="text-center hidden-xs-portrait">السعر</th>
                            <th width="" class="text-center">دخول</th>
                            <th width="" class="text-center">خروج</th>
                        </tr>
                    <?php else: ?>
                        <tr>
                            <th width="60">ID</th>
                            <th width="150" class="no-sort">التاريخ</th>
                            <th width="50">د/خ</th>
                            <th>بطاقة الحساب</th>
                            <th width="50" class="text-center">س.افرادي</th>
                            <th width="150" class="text-center">داخل</th>
                            <th width="150" class="text-center">خارج</th>

                            <!--							<th width="150" class="text-center">دخول</th>-->
                            <!--							<th width="150" class="text-center">خروج</th>-->
                            <th width="150" class="text-center">الرصيد</th>
                        </tr>

                    <?php endif; ?>
                    </thead>
                    <tbody>

                    <?php while ($list = $q_form_items->fetch_object()): ?>

                        <?php if (til_is_mobile()): ?>
                            <tr id="<?php echo $list->id; ?>">
                                <td><a href="<?php site_url('form', $list->form_id); ?>"
                                       target="_blank">#<?php echo $list->form_id; ?></a></td>
                                <td class="hidden-xs-portrait fs-11 text-muted"><?php echo til_get_date($list->date, 'Y-m-d'); ?></td>
                                <td class="hidden-xs-portrait nowrap fs-11 text-muted">
                                    <?php if ($list->account_id): ?>
                                        <?php echo get_account($list->account_id)->name; ?> <a
                                                href="<?php site_url('account', $list->account_id); ?>" target="_blank"
                                                class="fs-12"><i class="fa fa-external-link"></i></a>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center"><?php echo $list->quantity; ?></td>
                                <td class="text-right hidden-xs-portrait"><?php echo get_set_money($list->price, true); ?></td>
                                <td class="text-right"><?php echo $list->in_out == '0' ? get_set_money($list->total, true) : ''; ?></td>
                                <td class="text-right"><?php echo $list->in_out == '1' ? get_set_money($list->total, true) : ''; ?></td>
                            </tr>
                        <?php else: ?>

                            <tr id="<?php echo $list->id; ?>">
                                <td><a href="<?php site_url('form', $list->form_id); ?>"
                                       target="_blank">#<?php echo $list->form_id; ?></a></td>
                                <td class="text-muted fs-11"><?php echo til_get_date($list->date, 'Y-m-d H:i'); ?></td>
                                <td><?php echo get_in_out_label($list->in_out); ?></td>
                                <td>
                                    <?php if ($list->account_id): ?>
                                        <?php echo get_account($list->account_id)->name; ?> <a
                                                href="<?php site_url('account', $list->account_id); ?>#formws"
                                                target="_blank" class="fs-12"><i class="fa fa-external-link"></i></a>
                                    <?php endif; ?>
                                <td class="text-right"><?php echo get_set_money($list->price, true); ?></td>
                                </td>
                                <td class="text-right"><?php if ($list->in_out == 0) {
                                        echo get_set_money($list->quantity, true);
                                        $balance = $balance + $list->quantity;
                                    } else {
                                        echo '';
                                    } ?></td>
                                <td class="text-right"><?php if ($list->in_out == 1) {
                                        echo get_set_money($list->quantity, true);
                                        $balance = $balance - $list->quantity;
                                    } else {
                                        echo '';
                                    } ?></td>
                                <td class="text-right"><?php echo get_set_money($balance, true); ?></td>
                            </tr>

                        <?php endif; ?>
                    <?php endwhile; ?>
                    </tbody>
                </table>

            <?php else: ?>

                <?php echo get_alert(array('title' => 'لا حركة النموذج', 'description' => 'لم تتم إضافة أي إجراءات نموذج لبطاقة المنتج هذه حتى الآن.'), 'warning', false); ?>
            <?php endif; ?>

        </div>
        <!-- /tab:forms -->


        <!-- tab:logs -->
        <div class="tab-pane fade" role="tabpanel" id="logs" aria-labelledby="logs-tab">
            <?php theme_get_logs(" table_id='items:" . $item->id . "' "); ?>
        </div>
        <!-- /tab:logs -->

    </div> <!-- /.tab-content -->


    <script>

        function calc_vat() {
            var p_purc = get_set_decimal($('#p_purc').val());
            var p_sale = get_set_decimal($('#p_sale').val());
            var p_vat = math_vat_rate($('#vat').val());


            if (!$.isNumeric(p_purc)) {
                p_purc = 0.00;
            }
            if (!$.isNumeric(p_sale)) {
                p_sale = 0.00;
            }
            if (!$.isNumeric(p_vat)) {
                p_vat = 0;
            }

            var p_purc_out_vat = p_purc / p_vat;
            var p_sale_out_vat = p_sale / p_vat;
            $('#p_purc_out_vat').val(p_purc_out_vat);
            $('#p_sale_out_vat').val(p_sale_out_vat);
        }
    </script>


<?php get_footer(); ?>