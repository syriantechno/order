<?php include('../../ultra.php'); ?>
<?php get_header(); ?>
<?php
add_page_info('title', 'الصندوق والبنك');
add_page_info('nav', array('name' => 'الصندوق والبنك'));
?>


<?php
$total['money'] = 0;

if ($cases = get_case_all(array('is_bank' => 0))) {
    foreach ($cases as $case) {
        $total['money'] = $total['money'] + calc_case($case->id);
    }
}

if ($cases = get_case_all(array('is_bank' => 1))) {
    foreach ($cases as $case) {
        $total['money'] = $total['money'] + calc_case($case->id);
    }
}


?>


    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">

            <div class="row space-5">
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    <div class="box-menu">
                        <a href="<?php site_url('admin/payment/detail.php?in'); ?>">
						<span class="icon-box4">
                            <div class="stats-title">سند قبض</div>
                            <i class="faw fa-plus-square-o" style="color: rgba(255, 255, 255, 0.4117647058823529);"></i>
                            <hr>
                            <div class="stats-desc">إضافة سند قبض جديد</div>
                        </span>

                        </a>
                    </div> <!-- /.box-menu -->
                </div> <!-- /.col-* -->
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    <div class="box-menu">
                        <a href="<?php site_url('admin/payment/detail.php?out'); ?>">
						<span class="icon-box4">
                            <div class="stats-title">سند صرف</div>
                            <i class="faw fa-minus-square-o"
                               style="color: rgba(255, 255, 255, 0.4117647058823529);"></i>
                            <hr>
                            <div class="stats-desc">إضافة سند صرف جديد</div>
                        </span>

                        </a>
                    </div> <!-- /.box-menu -->
                </div> <!-- /.col-* -->
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    <div class="box-menu">
                        <a href="<?php site_url('admin/payment/list.php'); ?>">
						<span class="icon-box4">
                            <div class="stats-title">قائمة السندات</div>
                            <i class="faw fa-list" style="color: rgba(255, 255, 255, 0.4117647058823529);"></i>
                            <hr>
                            <div class="stats-desc">اظهار كافة المعاملات النقدية</div>
                        </span>

                        </a>
                    </div> <!-- /.box-menu -->
                </div> <!-- /.col-* -->
            </div> <!-- /.row -->

            <div class="h-20 visible-xs"></div>

        </div> <!-- /.col-md-6 -->
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">

            <small class="text-muted"><i class="fa fa-line-chart"></i> المجموع</small>
            <div class="h-10"></div>

            <div class="row">
                <div class="col-md-4">
                    <div class="well">
                        <span class="ff-2 fs-18 bold <?php echo $total['money'] < 0 ? 'text-danger' : 'text-success'; ?>"><?php echo get_set_money($total['money']); ?></span>
                        <small class="text-muted"><?php echo til()->company->currency; ?></small>
                        <br/>
                        <small class="text-muted">الوضع الأخير</small>
                    </div>
                </div> <!-- /.col -->
            </div> <!-- /.row -->

            <div class="h-20"></div>
            <div class="row space-5">
                <div class="col-md-6">
                    <small class="text-muted"><i class="fa fa-paypal"></i> الصندوق</small>
                    <div class="h-10"></div>
                    <?php if ($cases = get_case_all(array('is_bank' => 0))): ?>
                        <div class="list-group mobile-full list-group-dashboard">
                            <?php foreach ($cases as $case): ?>
                                <a href="<?php site_url(); ?>/admin/payment/list.php?status_id=<?php echo $case->id; ?>"
                                   class="list-group-item">
                                    <?php echo $case->name; ?>
                                    <span class="pull-right"><?php echo get_set_money($case->total); ?></span>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <div class="h-20 visible-xs"></div>
                    <small class="text-muted"><i class="faw fa-bank"></i> البنك</small>
                    <div class="h-10"></div>
                    <?php if ($banks = get_case_all(array('is_bank' => 1))): ?>
                        <div class="list-group mobile-full list-group-dashboard">
                            <?php foreach ($banks as $bank): ?>
                                <a href="<?php site_url(); ?>/admin/payment/list.php?status_id=<?php echo $bank->id; ?>"
                                   class="list-group-item">
                                    <?php echo $bank->name; ?>
                                    <span class="pull-right"><?php echo get_set_money($bank->count); ?></span>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div> <!-- /.col-* -->
            </div> <!-- /.row -->

        </div> <!-- /.col -->
    </div> <!-- /.row -->


<?php get_footer(); ?>