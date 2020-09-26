<aside>
<!--    <div class="sideuser"></div>-->
<!--    <div class="avataruser">-->
<!---->
<!--        <img src="--><?php //active_user('avatar'); ?><!--" class="img-repsonsive img-avatar"-->
<!--             style="border-radius: 50%; width: 100px;     border: 1px solid #000000;" alt="">-->
<!--        <span class="user-name1">--><?php //active_user('username'); ?><!--</span>-->
<!--        <span class="user-role1">--><?php //echo get_user_role_text(get_active_user('role')); ?><!--</span>-->
<!---->
<!--    </div>-->
<!--    <div class="sidebar1"></div>-->

    <div class="sidebar">
<!--        <img src="content/themes/default/img/sidebar-1.jpg " alt="">-->
        <h3 class="sidebar-title ff-1">القائمة الرئيسية</h3>

        <ul class="sidebar-menu ff-1">
            <li><a href="<?php site_url(); ?>"><i class="fa fa-home"></i> لوحة التحكم</a></li>
            <li class="active"><a href="#"><i class="fa fa-users"></i> بطاقات المستفيدين <span
                            class="fa fa-caret-down caret-opt"></span></a>
                <ul class="submenu">
                    <li><a href="<?php site_url('admin/account'); ?>"><i class="fa fa-user-o"></i>ادارة المستفيدين</a>
                    </li>
                    <li><a href="<?php site_url('admin/account/add.php'); ?>"><i class="fa fa-user-circle-o"></i>إضافة
                            مستفيد</a></li>
                    <li><a href="<?php site_url('admin/account/list.php'); ?>"><i class="fa fa-address-book-o"></i>قائمة
                            المستفيدين</a></li>
                    <li><a href="<?php site_url('admin/account/delete.php'); ?>"><i class="fa fa-trash-o "></i>سلة
                            المحذوفات</a></li>
                    <?php if (user_access('admin')): ?>
                        <li><a href="<?php site_url('admin/account/tree.php'); ?>"><i class="fa fa-list-ol"></i>شجرة
                            الحسابات</a></li><?php endif; ?>
                </ul>
            </li>
            <li class="active"><a href="#"><i class="fa fa-cubes"></i> المعونة والمساعدة <span
                            class="fa fa-caret-down caret-opt"></span></a>
                <ul class="submenu">
                    <li><a href="<?php site_url('admin/item/'); ?>"><i class="fa fa-cube"></i>ادارة المعونة</a></li>
                    <?php if (user_access('admin')): ?>
                        <li><a href="<?php site_url('admin/item/add.php'); ?>"><i class="fa fa-plus"></i>اضافة معونة</a>
                        </li><?php endif; ?>
                    <li><a href="<?php site_url('admin/item/list.php'); ?>"><i class="fa fa-bars"></i>قائمة المعونة</a>
                    </li>
                </ul>
            </li>
            <li class="admin-form"><a href="#"><i class="fa fa-shopping-cart"></i> التوزيع <span
                            class="fa fa-caret-down caret-opt"></span></a>
                <ul class="submenu">
                    <li><a href="<?php site_url('admin/form/'); ?>"><i class="fa fa-shopping-bag"></i>ادارة توزيع
                            المعونة</a></li>
                    <!--                <li><a href="-->
                    <?php //site_url('admin/form/detail.php?out'); ?><!--"><i class="fa fa-cart-arrow-down" aria-hidden="true"></i> فاتورة مبيعات جديدة</a></li>-->
                    <li><a href="<?php site_url('admin/form/detail.php?in'); ?>"><i class="fa fa-cart-arrow-down"
                                                                                    aria-hidden="true"></i>توزيع معونة
                            جديد</a></li>
                    <li><a href="<?php site_url('admin/form/list.php'); ?>"><i class="fa fa-shopping-cart"></i>جميع
                            المعونات</a></li>

                </ul>
            </li>
            <?php if (user_access('admin')): ?>
            <li class="admin-payment"><a href="#"><i class="fa fa-money"></i> إدارة الأموال<span
                            class="fa fa-caret-down caret-opt"></span></a><?php endif; ?>
                <ul class="submenu">
                    <?php if (user_access('admin')): ?>
                        <li><a href="<?php site_url('admin/payment/'); ?>"><i class="fa fa-bank"></i>الصندوق والبنك</a>
                        </li><?php endif; ?>
                    <?php if (user_access('admin')): ?>
                        <li><a href="<?php site_url('admin/payment/detail.php?out'); ?>"><i
                                    class="fa fa-long-arrow-right" aria-hidden="true"></i> سند صرف جديد</a>
                        </li><?php endif; ?>
                    <?php if (user_access('admin')): ?>
                        <li><a href="<?php site_url('admin/payment/detail.php?in'); ?>"><i class="fa fa-long-arrow-left"
                                                                                           aria-hidden="true"></i> سند
                            قبض جديد</a></li><?php endif; ?>
                    <?php if (user_access('admin')): ?>
                        <li><a href="<?php site_url('admin/payment/list.php'); ?>"><i class="fa fa-briefcase"></i>كشف
                            حساب الصندوق</a></li><?php endif; ?>
                    <?php if (user_access('admin')): ?>
                        <li><a href="<?php site_url('admin/system/case'); ?>"><i class="fa fa-plus"></i> إضافة حساب
                            صندوق / بنك</a></li><?php endif; ?>
                </ul>
            </li>
            <li class="admin-user"><a href="#"><i class="fa fa-user-o"></i> الموظفين <span
                            class="fa fa-caret-down caret-opt"></span></a>
                <ul class="submenu">
                    <?php if (user_access('admin')): ?>
                        <li class="list"><a href="<?php site_url('admin/user/list.php'); ?>"><i
                                    class="fa fa-th-list fa-fw"></i> جميع الموظفين</a></li><?php endif; ?>
                    <?php if (user_access('admin')): ?>
                        <li><a href="<?php site_url('admin/user/add.php'); ?>"><i class="fa fa-plus fa-fw"></i> إضافة
                            موظف جديد</a></li><?php endif; ?>
                    <li class="profile"><a href="<?php site_url('admin/user/profile.php'); ?>"><i
                                    class="fa fa-user-circle-o fa-fw"></i> الملف الشخصي</a></li>
                    <li class="profile"><a href="<?php site_url('admin/user/message/list.php?box=inbox'); ?>"><i
                                    class="fa fa-envelope-o fa-fw"></i> صندوق الرسائل</a></li>
                    <li class="profile"><a href="<?php site_url('admin/user/task/list.php?box=inbox'); ?>"><i
                                    class="fa fa-tasks fa-fw"></i> المهام الصادرة</a></li>
                </ul>
            </li>
            <?php if (user_access('admin')): ?>
            <li class=""><a href="#"><i class="fa fa-gears"></i> الإعدادت <span
                            class="fa fa-caret-down caret-opt"></span></a><?php endif; ?>
                <ul class="submenu">
                    <?php if (user_access('admin')): ?>
                        <li><a href="<?php site_url('admin/system/form_status'); ?>"><i class="fa fa-newspaper-o"></i>إدارة
                            حالة النماذج</a></li><?php endif; ?>
                    <?php if (user_access('admin')): ?>
                        <li><a href="<?php site_url('admin/system/case'); ?>"><i class="fa fa-university"></i> إدارة
                            الصندوق والبنك</a></li><?php endif; ?>
                    <?php if (user_access('admin')): ?>
                        <li><a href="<?php site_url('admin/system/options'); ?>"><i class="fa fa-cog"></i>إعدادت
                            عامة</a></li><?php endif; ?>
                    <?php if (user_access('admin')): ?>
                        <li><a href="<?php site_url('admin/system/info'); ?>"><i class="fa fa-paper-plane"></i>اتصل بنا</a>
                        </li><?php endif; ?>
                    <?php if (user_access('admin')): ?>
                        <li><a href="<?php site_url('admin/system/backup'); ?>"><i class="fa fa-database"></i>قواعد
                            البيانات</a></li><?php endif; ?>
                </ul>
            </li>
                    <?php if(user_access('superadmin')): ?>
                        <li class=""><a href="#"><i class="fa fa-code"></i> الاوامر البرمجية <span class="fa fa-caret-down caret-opt"></span></a>
                            <ul class="submenu">
                                <li><a href="
            <?php site_url('admin/_developer/colors.php'); ?>">قائمة الالوان</a></li>
                                <li><a href="
            <?php site_url('admin/_developer/grid.php'); ?>">نظام الشبكة</a></li>
                                <li><a href="
            <?php site_url('admin/_developer/typography.php'); ?>">طباعة</a></li>
                                <li><a href="
            <?php site_url('admin/_developer/general.php'); ?>">العناصر العامة</a></li>
                                <li><a href="
            <?php site_url('admin/_developer/form.php'); ?>">نماذج الادخال</a></li>
                                <li><a href="
            <?php site_url('admin/_developer/buttons.php'); ?>">الأزرار</a></li>
                                <li><a href="
            <?php site_url('admin/_developer/panels.php'); ?>">اللوحات</a></li>
                                <li><a href="
            <?php site_url('admin/_developer/icons.php'); ?>">الايقونات</a></li>
                                <li><a href="
            <?php site_url('admin/_developer/alerts.php'); ?>">التنبيهات</a></li>
                                <li><a href="
            <?php site_url('admin/_developer/tabs.php'); ?>">علامات التبويب</a></li>
                                <li><a href="
            <?php site_url('admin/_developer/helper.php'); ?>">مساعد CSS</a></li>
                            </ul>
                        </li>
                    <?php endif; ?>
        </ul> <!-- /.sidebar-menu -->

    </div> <!-- /.sidebar -->


</aside>

<script>
    $(document).ready(function () {
        $('ul.sidebar-menu li a').click(function () {
            if ($(this).parent('li').hasClass('active')) {
                $(this).parent('li').removeClass('active');
                $(this).find('span.fa').removeClass('fa-caret-up');
                $(this).find('span.fa').addClass('fa-caret-down');
            } else {
                $(this).parent('li').addClass('active');
                $(this).find('span.fa').removeClass('fa-caret-down');
                $(this).find('span.fa').addClass('fa-caret-up');
            }
        });
    });
</script>

<style>
    main {
        margin-right: 250px;


    }

    aside::-webkit-scrollbar {
        display: none;
    }

    aside {
        width: 251px;
        bottom: 0;
        top: 71px;
        right: 0;
        direction: rtl;
        /*overflow-y: scroll;*/
        position: fixed;
        /*overflow-x: hidden;*/
        padding-top: 71px;
    }

    .sideuser {
        top: 0 !important;
    }


</style>


<?php

if ($explode = explode('/admin/', $_SERVER['SCRIPT_NAME'])) {
    if ($exp = explode('/', @$explode[1])) {

        if (isset($exp[1])) {
            $exp[1] = str_replace('.php', '', @$exp[1]);
            ?>
            <script>
                $(document).ready(function () {
                    $('ul.sidebar-menu li.admin-<?php echo $exp[0]; ?>').addClass('active');
                    $('ul.sidebar-menu li.admin-<?php echo $exp[0]; ?> ul li.<?php echo $exp[1]; ?>').addClass('active');
                });
            </script>
            <?php
        }
    }
}

?>
