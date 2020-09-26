<?php include('../../../ultra.php'); ?>
<?php get_header(); ?>
<?php
add_page_info('title', 'المشاركات');
add_page_info('nav', array('name' => 'المشاركات'));
?>

<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <div class="row space-5">
            <div class="col-xs-4 col-sm-4 col-md-3 col-lg-2">
                <div class="box-menu">
                    <a href="<?php site_url('admin/user/message/add.php'); ?>">
                        <span class="icon-box"><i class="fa fa-plus-square-o"></i></span>
                        <h3>رسالة جديدة</h3>
                    </a>
                </div> <!-- /.box-menu -->
            </div> <!-- /.col-* -->
            <div class="col-xs-4 col-sm-4 col-md-3 col-lg-2">
                <div class="box-menu">
                    <a href="<?php site_url('admin/user/message/list.php?box=outbox'); ?>">
    				<span class="icon-box">
              <span class="info-icon"><i class="fa fa-mail-reply fa-fw"></i></span>
              <i class="fa fa-envelope-o fa-fw"></i>
            </span>
                        <h3>رسالة صادرة</h3>
                    </a>
                </div> <!-- /.box-menu -->
            </div> <!-- /.col-* -->
            <div class="col-xs-4 col-sm-4 col-md-3 col-lg-2">
                <div class="box-menu">
                    <a href="<?php site_url('admin/user/message/list.php?box=inbox'); ?>">
    				<span class="icon-box">
              <span class="info-icon"><i class="fa fa-mail-forward fa-fw"></i></span>
              <i class="fa fa-envelope-o fa-fw"></i>
              <span class="badge" id="box_menu_message_badge"
                    js-onload="get_notification_count({elem: '#box_menu_message_badge', box: 'message'})"><?php echo $message_unread = get_calc_message(); ?></span>
            </span>
                        <h3>رسالة واردة</h3>
                    </a>
                </div> <!-- /.box-menu -->
            </div> <!-- /.col-* -->
        </div> <!-- /.row -->
    </div> <!--/ .col-* /-->
</div> <!--/ .row /-->

<?php get_footer(); ?>
