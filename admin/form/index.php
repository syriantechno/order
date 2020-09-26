<?php include('../../ultra.php'); ?>
<?php get_header(); ?>
<?php
add_page_info('title', 'ادارة التوزيع');
add_page_info('nav', array('name' => 'ادارة التوزيع'));
?>


    <div class="row">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">

        <div class="row space-5">

            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                <div class="box-menu">
                    <a href="<?php site_url('admin/form/detail.php?in'); ?>">
						<span class="icon-box3">
                            <div class="stats-title">توزيع معونة</div>
                            <i class="faw fa-cart-arrow-down"
                               style="color: rgba(255, 255, 255, 0.4117647058823529);"></i>
                        <hr>
                            <div class="stats-desc">إضافة توزيع معونة جديد</div>
                        </span>

                    </a>
                </div> <!-- /.box-menu -->
            </div> <!-- /.col-* -->
            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                <div class="box-menu">
                    <a href="<?php site_url('admin/form/list.php'); ?>">
						<span class="icon-box3">
                            <div class="stats-title">عمليات التوزيع</div>
                            <i class="faw fa-list" style="color: rgba(255, 255, 255, 0.4117647058823529);"></i>
                        <hr>
                            <div class="stats-desc">استعراض جميع عمليات التوزيع</div>
                        </span>

                    </a>
                </div> <!-- /.box-menu -->
            </div> <!-- /.col-* -->
            <div class="col-md-12">

                <div class="h-20 visible-xs"></div>
                <small class="text-muted module-title-small"><i class="fa fa-cart-arrow-down"></i> احدث عمليات التوزيع
                </small>
                <div class="h-10"></div>

                <div class="panel panel-warning panel-table panel-heading-0 panel-border-right panel-dashboard-list">
                    <div class="panel-body">
                        <div class="panel-list">
                            <?php $query = db()->query("SELECT * FROM " . dbname('forms') . " WHERE status='1' AND type='form' AND in_out='0' ORDER BY date DESC LIMIT 50 "); ?>
                            <?php if ($query->num_rows): ?>
                                <table class="table table-hover table-condensed table-stripe">
                                    <thead>
                                    <tr>
                                        <th width="80">التاريخ</th>
                                        <th>ID</th>
                                        <th>بطاقة الحساب</th>
                                        <th class="text-right">البيان</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php while ($list = $query->fetch_object()): ?>
                                        <?php $form_status = get_form_status($list->status_id); ?>
                                        <tr onclick="location.href='<?php site_url('form', $list->id); ?>';"
                                            class="pointer">
                                            <td class="text-muted"><?php echo til_get_date($list->date, 'd F'); ?></td>
                                            <td><a href="<?php site_url('form', $list->id); ?>"
                                                   title="">#<?php echo $list->id; ?></a></td>
                                            <td><a href="<?php site_url('account', $list->account_id); ?>"
                                                   title="<?php echo $list->account_name; ?>"><?php echo til_get_substr($list->account_name, 0, 30); ?></a>
                                            </td>
                                            <td class="text-muted"><i class="fa fa-square"
                                                                      style=" color:<?php echo $form_status->bg_color; ?>;"></i> <?php echo til_get_strtoupper($form_status->name); ?>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                    </tbody>
                                </table>
                            <?php endif; ?>
                        </div> <!-- /.panel-list -->
                    </div> <!-- /.panel-body -->
                </div> <!-- /.panel -->

            </div> <!-- /.col -->
        </div> <!-- /.row -->

        <div class="h-20 visible-xs"></div>

    </div> <!-- /.col-md-6 -->
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">

        <div class="row space-6">


            <small class="text-muted"><i class="fa fa-long-arrow-up text-black"></i> قائمة تصنيف التوزيع</small>
            <div class="h-10"></div>
            <?php if ($form_status_all = get_form_status_all('0')): ?>
                <div class="list-group mobile-full list-group-dashboard">
                    <?php foreach ($form_status_all as $status): ?>
                        <a href="<?php site_url(); ?>/admin/form/list.php?status_id=<?php echo $status->id; ?>"
                           class="list-group-item-column"
                           style="border-left:25px solid <?php echo $status->bg_color; ?>; width: 33.33333%">
                            <?php echo $status->name; ?>
                            <span class="pull-right"><?php echo $status->count = calc_form_status($status->id); ?></span>
                        </a>
                    <?php endforeach; ?>
                </div>

            <?php endif; ?>


        </div> <!-- /.col -->
    </div> <!-- /.row -->


    <div class="h-20"></div>

    <div class="row">


    </div> <!-- /.row -->


    <script>
        // Get the elements with class="column"
        var elements = document.getElementsByClassName("list-group-item-column");

        // Declare a loop variable
        var i;

        // List View
        function gridView() {
            for (i = 0; i < elements.length; i++) {
                elements[i].style.width = "33.3333333%";
            }
        }

        // Grid View
        function listView() {
            for (i = 0; i < elements.length; i++) {
                elements[i].style.width = "50%";
            }
        }

        /* Optional: Add active class to the current button (highlight it) */
        var container = document.getElementById("btnContainer");
        var btns = container.getElementsByClassName("btn");
        for (var i = 0; i < btns.length; i++) {
            btns[i].addEventListener("click", function () {
                var current = document.getElementsByClassName("active");
                current[0].className = current[0].className.replace(" active", "");
                this.className += " active";
            });
        }
    </script>



<?php get_footer(); ?>