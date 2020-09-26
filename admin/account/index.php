<?php include('../../ultra.php'); ?>
<?php get_header(); ?>
<?php
add_page_info('title', 'بطاقات المستفيد');
add_page_info('nav', array('name' => 'بطاقات المستفيد'));
?>


    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">

            <div class="row space-5">
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    <div class="box-menu">
                        <a href="<?php site_url('admin/account/add.php'); ?>">
						<span class="icon-box1">
                            <div class="stats-title">إضافة مستفيد</div>
                            <i class="faw fa-plus-square-o" style="color: rgba(255, 255, 255, 0.4117647058823529);"></i>
                            <hr>
                            <div class="stats-desc">إضافة مستفيد جديد</div>
                           
                        </span>

                        </a>
                    </div>
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    <div class="box-menu">
                        <a href="<?php site_url('admin/account/list.php'); ?>">
						<span class="icon-box1">
                            <div class="stats-title">كل المستفيدين</div>
                            <i class="faw fa-list" style="color: rgba(255, 255, 255, 0.4117647058823529);"></i>
                            <hr>
                            <div class="stats-desc">تعديل وحذف وكشف مستفيد</div>
                        </span>

                        </a>
                    </div>
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    <div class="box-menu">
                        <a href="<?php site_url('admin/account/add.php?accoutcode=Officer'); ?>">
						<span class="icon-box1">
                            <div class="stats-title">اضافة حساب عام</div>
                            <i class="faw fa-plus-square-o" style="color: rgba(255, 255, 255, 0.4117647058823529);"></i>
                            <hr>
                            <div class="stats-desc">موظفين - مصاريف نثرية - الخ</div>
                        </span>

                        </a>
                    </div>
                </div>
                <!--<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                <div class="box-menu">
                    <a href="<?php site_url('admin/account/tree.php'); ?>">
						<span class="icon-box1">
                            <div class="stats-title">شجرة المستفيدين</div>
                            <i class="faw fa-list" style="color: rgba(255, 255, 255, 0.4117647058823529);"></i>
                            <hr>
                            <div class="stats-desc">عرض شجرة مستفيدين النظام</div>
                        </span>

                    </a>
                </div>
            </div>-->
            </div>

            <div class="h-20 visible-xs"></div>

        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">

            <small class="text-muted"><i class="fa fa-line-chart"></i> الوضع العام للسوق</small>
            <div class="h-10"></div>

            <?php
            $total = array();

            $q = db()->query("SELECT sum(balance) as balance FROM " . dbname('accounts') . " WHERE status='1' AND balance > 0 ");
            $total['in_balance'] = $q->fetch_object()->balance;

            $q = db()->query("SELECT sum(balance) as balance FROM " . dbname('accounts') . " WHERE status='1' AND balance < 0 ");
            $total['out_balance'] = $q->fetch_object()->balance;

            $total['status'] = $total['in_balance'] - abs($total['out_balance']);


            ?>

            <?php
            $chart = array();
            $chart['type'] = 'line';
            $chart['data']['datasets'][0]['label'] = 'الحركات';
            $chart['data']['datasets'][0]['fill'] = true;
            $chart['data']['datasets'][0]['lineTension'] = '0';
            $chart['data']['datasets'][0]['borderWidth'] = 0.1;
            $chart['data']['datasets'][0]['pointBorderWidth'] = 0.5;
            $chart['data']['datasets'][0]['pointRadius'] = 1;
            $chart['data']['datasets'][0]['backgroundColor'] = 'rgba(253, 196, 48, 0.2)';
            $chart['data']['datasets'][0]['borderColor'] = 'rgba(253, 196, 48, 1)';


            $_start_date = date('Y-m-d', strtotime('-4 week', strtotime(date('Y-m-d'))));
            $_end_date = date('Y-m-d');
            while (strtotime($_start_date) <= strtotime($_end_date)) {
                $chart['data']['labels'][] = $_start_date = date('Y-m-d', strtotime('+1 day', strtotime($_start_date)));

                $_total = 0;
                $chart_balance = $total['status'];
                $q_forms = db()->query("SELECT sum(total) as total FROM " . dbname('forms') . " WHERE status='1' AND in_out='0' AND date >= '" . $_start_date . " 00:00:00' ORDER BY id DESC, date DESC");
                if (($_total = $q_forms->fetch_object()->total) > 0) {
                    // $chartt['data']['datasets'][0]['data'][] = $_total;
                } else {
                    // $chartt['data']['datasets'][0]['data'][] = '0.00';
                }
                $chart_balance = $chart_balance + $_total;

                $_total = 0;
                $q_forms = db()->query("SELECT sum(total) as total FROM " . dbname('forms') . " WHERE status='1' AND in_out='1' AND date >= '" . $_start_date . " 00:00:00' ORDER BY id DESC, date DESC");
                if (($_total = $q_forms->fetch_object()->total) > 0) {
                    // $chartt['data']['datasets'][1]['data'][] = $_total;
                } else {
                    // $chartt['data']['datasets'][1]['data'][] = '0.00';
                }
                $chart_balance = $chart_balance - $_total;
                $chart['data']['datasets'][0]['data'][] = $chart_balance;
            }

            $chart['options']['legend']['display'] = false;
            $chart['options']['scales']['yAxes'][0]['display'] = false;
            $chart['options']['scales']['xAxes'][0]['display'] = false;
            $chart['options']['scales']['xAxes'][0]['ticks']['beginAtZero'] = true;
            $chart['options']['maintainAspectRatio'] = false;
            $chart['options']['tooltips']['enabled'] = true;
            $chart['options']['tooltips']['callbacks']['title'] = "=TIL= function(tooltipItems, data) {  return ''; } =TIL=";
            $chart['options']['tooltips']['callbacks']['label'] = "=TIL= function(tooltipItems, data) {  return  tooltipItems.yLabel.formatMoney(2, '.', ',') + ' ل٫س'; } =TIL=";


            $args['height'] = '60';
            $args['chart'] = $chart;
            ?>
            <div class="row space-none">
                <div class="col-md-4">

                    <div class="well">
                        <span class="ff-2 fs-18 bold <?php echo $total['status'] < 0 ? 'text-danger' : 'text-success'; ?>"><?php echo get_set_money($total['status']); ?></span>
                        <small class="text-muted"><?php echo til()->company->currency; ?></small>
                        <br/>
                        <small class="text-muted">النتيجة النهائية</small>
                    </div>

                </div>
                <div class="col-md-8 hidden-xs">

                    <?php chartjs($args); ?>

                </div>
            </div>

            <div class="h-20"></div>

            <div class="row space-none">
                <div class="col-xs-6 col-md-3">

                    <div class="">

                        <br/>

                    </div>

                </div>
                <div class="col-xs-6 col-md-3">

                    <div class="">

                        <br/>

                    </div>

                </div>
                <div class="col-xs-12 col-md-6">
                    <?php
                    $chart = array();
                    $chart['type'] = 'bar';
                    $chart['data']['datasets'][0]['label'] = 'ائتمان';
                    $chart['data']['datasets'][0]['type'] = 'bar';
                    $chart['data']['datasets'][0]['fill'] = true;
                    $chart['data']['datasets'][0]['lineTension'] = 0.5;
                    $chart['data']['datasets'][0]['borderWidth'] = 1;
                    $chart['data']['datasets'][0]['pointBorderWidth'] = 3;
                    $chart['data']['datasets'][0]['pointRadius'] = 1;

                    $chart['data']['datasets'][1]['label'] = 'الربح / الخسارة';
                    $chart['data']['datasets'][1]['type'] = 'line';
                    $chart['data']['datasets'][1]['fill'] = true;
                    $chart['data']['datasets'][1]['lineTension'] = 0.5;
                    $chart['data']['datasets'][1]['borderWidth'] = 1;
                    $chart['data']['datasets'][1]['pointBorderWidth'] = 3;
                    $chart['data']['datasets'][1]['pointRadius'] = 1;

                    $other[0] = 0;
                    $other[1] = 0;
                    $query = db()->query("SELECT * FROM " . dbname('accounts') . " WHERE status='1' AND type='account' AND balance > 0 ORDER BY balance DESC");
                    if ($query->num_rows) {
                        $i = 0;
                        while ($list = $query->fetch_object()) {
                            if ($i < 20) {
                                $chart['data']['labels'][] = $list->name;
                                $chart['data']['datasets'][0]['data'][] = $list->balance;
                                $chart['data']['datasets'][1]['data'][] = $list->profit;
                            } else {
                                $other[0] = $other[0] + $list->balance;
                                $other[1] = $other[1] + $list->profit;
                            }
                            $i++;
                        }
                    }

                    $chart['data']['labels'][] = 'اخرى';
                    $chart['data']['datasets'][0]['data'][] = $other[0];
                    $chart['data']['datasets'][1]['data'][] = $other[0];

                    $chart['options']['legend']['display'] = false;
                    $chart['options']['scales']['yAxes'][0]['display'] = false;
                    $chart['options']['scales']['yAxes'][0]['ticks']['userCallback'] = "=TIL= function(value, index, values) { return value.formatMoney(2, '.', ',') + ' ل٫س';  } =TIL=";
                    $chart['options']['scales']['xAxes'][0]['display'] = false;
                    $chart['options']['scales']['xAxes'][0]['ticks']['beginAtZero'] = false;
                    $chart['options']['maintainAspectRatio'] = false;
                    // $chart['options']['tooltips']['callbacks']['title'] = "=TIL= function(tooltipItems, data) { return data.labels[tooltipItems[0].index] + ''; } =TIL=";
                    $chart['options']['tooltips']['callbacks']['label'] = "=TIL= function(tooltipItems, data) { return data.datasets[tooltipItems.datasetIndex].label +' : '+ tooltipItems.yLabel.formatMoney(2, '.', ',') + ' ل٫س'; } =TIL=";

                    $args = array();
                    $args['height'] = '60';
                    $args['chart'] = $chart;
                    ?>

                    <div class="relative"><?php chartjs($args); ?></div>

                </div>
            </div>


        </div>
    </div>

    <div class="h-20"></div>


    <div class="row">
        <div class="col-md-4">

            <small class="text-muted module-title-small"><i class="fa fa-trophy"></i> اخر 50 مستفيد ذكر</small>
            <div class="h-10"></div>
            <div class="panel panel-info panel-table panel-heading-0 panel-border-right panel-dashboard-list">
                <div class="panel-body">
                    <div class="panel-list">
                        <?php $query = db()->query(
                            "SELECT * FROM " . dbname('accounts') .
                            " WHERE status='1' AND type='Retardation' AND sex ='ذكر' ORDER BY sex DESC LIMIT 50 "); ?>
                        <?php if ($query->num_rows): ?>
                            <table class="table table-hover table-condensed table-stripe">
                                <thead>
                                <tr>
                                    <th>بطاقة المستفيد</th>
                                    <th class="text-right">الاعاقة</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php while ($list = $query->fetch_object()): ?>
                                    <tr onclick="location.href='<?php site_url('account', $list->id); ?>#forms';"
                                        class="pointer">
                                        <td><a href="<?php site_url('account', $list->id); ?>#forms"
                                               title="<?php echo $list->name; ?>"><?php echo til_get_substr($list->name, 0, 30); ?></a>
                                        </td>
                                        <td class="text-right"><?php echo $list->Retardationtype; ?> </td>
                                    </tr>
                                <?php endwhile; ?>
                                </tbody>
                            </table>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-md-4">

            <small class="text-muted module-title-small"><i class="fa fa-th-list"></i> اخر 50 مستفيدة انثى</small>
            <div class="h-10"></div>

            <div class="panel panel-warning panel-table panel-heading-0 panel-border-right panel-dashboard-list">
                <div class="panel-body">
                    <div class="panel-list">
                        <?php $query = db()->query(
                            "SELECT * FROM " . dbname('accounts') .
                            " WHERE status='1' AND type='Retardation' AND sex ='انثى' ORDER BY sex DESC LIMIT 50 "); ?>
                        <?php if ($query->num_rows): ?>
                            <table class="table table-hover table-condensed table-stripe">
                                <thead>
                                <tr>
                                    <th>بطاقة المستفيد</th>
                                    <th class="text-right">الاعاقة</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php while ($list = $query->fetch_object()): ?>
                                    <tr onclick="location.href='<?php site_url('account', $list->id); ?>#forms';"
                                        class="pointer">
                                        <td><a href="<?php site_url('account', $list->id); ?>#forms"
                                               title="<?php echo $list->name; ?>"><?php echo til_get_substr($list->name, 0, 30); ?></a>
                                        </td>
                                        <td class="text-right"><?php echo $list->Retardationtype; ?> </td>
                                    </tr>
                                <?php endwhile; ?>
                                </tbody>
                            </table>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-md-4">

            <?php
            $chart = array();
            $chart['type'] = 'pie';
            // $chart['data']['datasets'][0]['label'] 	= 'دخول';
            $chart['data']['datasets'][0]['fill'] = true;
            $chart['data']['datasets'][0]['lineTension'] = 0.3;
            $chart['data']['datasets'][0]['borderWidth'] = 1;
            $chart['data']['datasets'][0]['pointBorderWidth'] = 1;
            $chart['data']['datasets'][0]['pointRadius'] = 1;

            $other = 0;
            $query = db()->query("SELECT * FROM " . dbname('accounts') . " WHERE status='1' AND type='account' AND profit > 0 ORDER BY profit DESC");
            if ($query->num_rows) {
                $i = 0;
                while ($list = $query->fetch_object()) {
                    if ($i < 7) {
                        $chart['data']['labels'][] = til_get_substr($list->name, 0, 10);
                        $chart['data']['datasets'][0]['data'][] = $list->profit;
                    } else {
                        $other = $other + $list->profit;
                    }
                    $i++;
                }
            }

            $chart['data']['labels'][] = 'أخرى';
            $chart['data']['datasets'][0]['data'][] = $other;

            $chart['options']['legend']['display'] = true;
            $chart['options']['scales']['yAxes'][0]['display'] = true;
            $chart['options']['scales']['xAxes'][0]['display'] = false;
            $chart['options']['scales']['xAxes'][0]['ticks']['beginAtZero'] = false;
            $chart['options']['maintainAspectRatio'] = false;
            $chart['options']['tooltips']['callbacks']['title'] = "=TIL= function(tooltipItems, data) { return data.labels[tooltipItems[0].index] + ''; } =TIL=";
            $chart['options']['tooltips']['callbacks']['label'] = "=TIL= function(tooltipItems, data) { return parseFloat(data.datasets[0].data[tooltipItems.index]).formatMoney(2, '.', ',') + ' ل٫س'; } =TIL=";

            $args = array();
            $args['height'] = '280';
            $args['chart'] = $chart;
            ?>

            <div class="h-20 visible-xs"></div>
            <small class="text-muted module-title-small"><i class="fa fa-pie-chart"></i> توزيع الارباح</small>
            <div class="h-10"></div>

            <div class="relative"><?php chartjs($args); ?></div>


        </div> <!-- /.col-* -->

    </div> <!-- /.row -->

    <div class="h-20"></div>

    <div class="row">
        <div class="col-md-8 hidden-xs">

            <small class="text-muted module-title-small"><i class="fa fa-th-list"></i> الحسابات الختامية</small>
            <div class="h-10"></div>
            <div class="panel panel-warning panel-table panel-heading-0 panel-border-right panel-dashboard-list">
                <div class="panel-body">
                    <div class="panel-list">
                        <?php $query = db()->query("SELECT * FROM " . dbname('forms') . " WHERE status='1' AND type IN ('form', 'payment') AND account_id > 0 ORDER BY date DESC LIMIT 50 "); ?>
                        <?php if ($query->num_rows): ?>
                            <table class="table table-hover table-condensed table-stripe">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th width="80">التاريخ</th>
                                    <th width="60">د/خ</th>
                                    <th>الحركة</th>
                                    <th>بطاقة المستفيد</th>

                                </tr>
                                </thead>
                                <tbody>
                                <?php while ($list = $query->fetch_object()): ?>
                                    <td>
                                        <?php if ($list->type === 'payment') { ?>
                                            <a href="../payment/detail.php?id=<?php echo $list->id; ?>" target="_blank">#<?php echo $list->id; ?></a>
                                        <?php } else { ?>
                                            <a href="../form/detail.php?id=<?php echo $list->id; ?>"
                                               target="_blank">#<?php echo $list->id; ?></a>
                                        <?php } ?>
                                    </td>

                                    <td class="text-muted"><?php echo til_get_date($list->date, 'd F'); ?></td>
                                    <td class="text-muted"><?php echo get_in_out_label($list->in_out); ?></td>

                                    <td>
                                        <?php
                                        if ($list->type == 'form') {
                                            $item = get_form_items($list->id);
                                            $item = $item->list[0];
                                            $in_out = ($list->in_out == '0') ? 'معونة' : 'معونة';
                                            echo " {$in_out} : "
                                                . " عدد {$list->item_quantity} "
                                                . " : {$item->item_name}";
                                        } elseif ($list->type == 'payment') {
                                            if ($list->in_out == '0') {
                                                echo 'دفعة منه';
                                            } else {
                                                echo 'دفعة له';
                                            }
                                        }
                                        ?>
                                    </td>
                                    <td><a href="<?php site_url('account', $list->account_id); ?>#forms"
                                           title="<?php echo $list->account_name; ?>"><?php echo til_get_substr($list->account_name, 0, 30); ?></a>
                                    </td>
                                    <tr>
                                    </tr>
                                <?php endwhile; ?>
                                </tbody>
                            </table>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-md-4">

            <?php
            $chart = array();
            $chart['type'] = 'doughnut';
            // $chart['data']['datasets'][0]['label'] 	= 'دخول';
            $chart['data']['datasets'][0]['fill'] = true;
            $chart['data']['datasets'][0]['lineTension'] = 0.3;
            $chart['data']['datasets'][0]['borderWidth'] = 1;
            $chart['data']['datasets'][0]['pointBorderWidth'] = 1;
            $chart['data']['datasets'][0]['pointRadius'] = 1;

            $other = 0;
            $query = db()->query("SELECT * FROM " . dbname('accounts') . " WHERE status='1' AND type='account' AND balance < 0 ORDER BY balance ASC");
            if ($query->num_rows) {
                $i = 0;
                while ($list = $query->fetch_object()) {
                    if ($i < 7) {
                        $chart['data']['labels'][] = til_get_substr($list->name, 0, 10);
                        $chart['data']['datasets'][0]['data'][] = abs($list->balance);
                    } else {
                        $other = $other + abs($list->balance);
                    }
                    $i++;
                }
            }

            $chart['data']['labels'][] = 'أخرى';
            $chart['data']['datasets'][0]['data'][] = $other;

            $chart['options']['legend']['display'] = true;
            $chart['options']['scales']['yAxes'][0]['display'] = true;
            $chart['options']['scales']['xAxes'][0]['display'] = false;
            $chart['options']['scales']['xAxes'][0]['ticks']['beginAtZero'] = false;
            $chart['options']['maintainAspectRatio'] = false;
            $chart['options']['scales']['yAxes'][0]['ticks']['userCallback'] = "=TIL= function(value, index, values) { return value.formatMoney(2, '.', ',') + ' ل٫س';  } =TIL=";
            $chart['options']['tooltips']['callbacks']['label'] = "=TIL= function(tooltipItems, data) { return parseFloat(data.datasets[0].data[tooltipItems.index]).formatMoney(2, '.', ',') + ' ل٫س'; } =TIL=";

            $args = array();
            $args['height'] = '280';
            $args['chart'] = $chart;
            ?>

            <div class="h-20 visible-xs"></div>
            <small class="text-muted module-title-small"><i class="fa fa-pie-chart"></i> الرسم البياني للموردين</small>
            <div class="h-10"></div>

            <div class="relative"><?php chartjs($args); ?></div>


        </div>

    </div>


<?php get_footer(); ?>