<?php include('../../ultra.php'); ?>
<?php get_header(); ?>
<?php
add_page_info('title', 'المستخدم');
add_page_info('nav', array('name' => 'المستخدم'));
?>


<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="row space-5">
            <?php if (user_access('admin')) : ?>
                <div class="col-xs-4 col-sm-4 col-md-3 col-lg-2">
                    <div class="box-menu">
                        <a href="<?php site_url('admin/user/add.php'); ?>">
        				<span class="icon-box5">
                            <div class="stats-title">إضافة</div>
                            <i class="faw fa-plus-square-o" style="color: rgba(255, 255, 255, 0.4117647058823529);"></i>
                            <hr>
                            <div class="stats-desc">إضافة موظف جديد</div>
                        </span>

                        </a>
                    </div> <!-- /.box-menu -->
                </div> <!-- /.col-* -->
            <?php endif; ?>
            <?php if (user_access('admin')): ?>
                <div class="col-xs-4 col-sm-4 col-md-3 col-lg-2">
                <div class="box-menu">
                    <a href="<?php site_url('admin/user/list.php'); ?>">
                    <span class="icon-box5">
                        <div class="stats-title">الموظفين</div>
                        <i class="faw fa-users" style="color: rgba(255, 255, 255, 0.4117647058823529);"></i>
                        <hr>
                            <div class="stats-desc">عرض و تعديل موظف</div>
                    </span>

                    </a>
                </div> <!-- /.box-menu -->
                </div><?php endif; ?> <!-- /.col-* -->
            <div class="col-xs-4 col-sm-4 col-md-3 col-lg-2">
                <div class="box-menu">
                    <a href="<?php site_url('admin/user/task/'); ?>">
    				<span class="icon-box5">
                        <div class="stats-title">المهام</div>
                        <i class="faw fa-tasks" style="color: rgba(255, 255, 255, 0.4117647058823529);"></i>
                        <hr>
                            <div class="stats-desc">اداة المهام الخاصة بك</div>
                    </span>

                    </a>
                </div> <!-- /.box-menu -->
            </div> <!-- /.col-* -->
            <div class="col-xs-4 col-sm-4 col-md-3 col-lg-2">
                <div class="box-menu">
                    <a href="<?php site_url('admin/user/message/'); ?>">
    				<span class="icon-box5">
                        <div class="stats-title">الرسائل</div>
                        <i class="faw fa-envelope-o" style="color: rgba(255, 255, 255, 0.4117647058823529);"></i>
                        <hr>
                            <div class="stats-desc">ادارة الرسائل الخاصة بك</div>
                    </span>

                    </a>
                </div> <!-- /.box-menu -->
            </div> <!-- /.col-* -->
        </div> <!-- /.row -->
    </div> <!--/ .col-* /-->
</div> <!--/ .row /-->

<div class="h-20 visible-xs"></div>


<?php get_footer(); ?>
