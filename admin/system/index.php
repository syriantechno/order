<?php include('../../ultra.php'); ?>
<?php get_header(); ?>
<?php
add_page_info('title', 'الاعدادت الرئيسية');
add_page_info('nav', array('name' => 'الاعدادت الرئيسية'));
?>
    <div class="row">
        <?php if (user_access('admin')): ?>
    <div class="col-xs-4 col-sm-4 col-md-3 col-lg-2">
        <div class="box-menu">
            <a href="<?php site_url('admin/system/options'); ?>">
						<span class="icon-box6">
                            <div class="stats-title">الاعدادات</div>
                            <i class="faw fa-cogs" style="color: rgba(255, 255, 255, 0.4117647058823529);"></i>
                             <hr>
			    <div class="stats-desc">تعديل اعدادت البرنامج</div>
                        </span>

            </a>
        </div>
    </div><?php endif; ?><!-- /.box-menu -->
        <?php if (user_access('admin')): ?>
    <div class="col-xs-4 col-sm-4 col-md-3 col-lg-2">
        <div class="box-menu">
            <a href="<?php site_url('admin/system/form_status'); ?>">
						<span class="icon-box6">
                            <div class="stats-title">النماذج</div>
                            <i class="faw fa-cogs" style="color: rgba(255, 255, 255, 0.4117647058823529);"></i>
                             <hr>
			    <div class="stats-desc">تعديل نماذج المبيعات والمشتريات</div>
                        </span>

            </a>
        </div>
    </div><?php endif; ?><!-- /.box-menu -->
        <?php if (user_access('admin')): ?>
        <div class="col-xs-4 col-sm-4 col-md-3 col-lg-2">
            <div class="box-menu">
                <a href="<?php site_url('admin/system/case'); ?>">
						<span class="icon-box6">
                            <div class="stats-title">اعدادت الاموال</div>
                            <i class="faw fa-cogs" style="color: rgba(255, 255, 255, 0.4117647058823529);"></i>
                             <hr>
			    <div class="stats-desc">اضافة واستعراض الصندوق والبنك</div>
                        </span>

                </a>
            </div>
        </div><?php endif; ?><!-- /.box-menu -->
        <div class="col-xs-4 col-sm-4 col-md-3 col-lg-2">
            <div class="box-menu">
                <a href="<?php site_url('admin/system/info'); ?>">
						<span class="icon-box6">
                            <div class="stats-title">من نحن</div>
                            <i class="faw fa-cogs" style="color: rgba(255, 255, 255, 0.4117647058823529);"></i>
                             <hr>
			    <div class="stats-desc">!!!!تعرف علينا اكثر</div>
                        </span>

                </a>
            </div> <!-- /.box-menu -->


            <div class="h-20 visible-xs"></div>

        </div> <!-- /.col-md-6 -->
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">

        </div>
    </div> <!-- /.row -->


<?php get_footer(); ?>