<div class="panel panel-default panel-sidebar">
    <div class="panel-body">
        <div class="text-left">
            <a href="add.php" class="btn btn-default btn-block"><i class="fa fa-pencil-square-o"></i> مهمة جديدة</a>
        </div>
        <div class="clearfix"></div>
        <div class="h-20"></div>
        <?php $box = 'inbox';
        $type_status = '0'; ?>
        <div class="list-group list-group-messagebox">

            <a href="list.php?box=inbox" class="list-group-item <?php echo $box == 'inbox' ? 'active' : ''; ?>"><i
                        class="fa fa-mail-forward fa-fw"></i> المهام الواردة</a>
            <a href="list.php?box=inbox&type_status=0"
               class="list-group-item list-group-item-sub <?php echo $type_status == '0' && $box == 'inbox' ? 'active' : ''; ?>"><i
                        class="fa fa-angle-double-right"></i> المهام المفتوحة <span
                        class="badge"><?php echo get_calc_task(array('query' => _get_query_task('inbox-open'))); ?></span></a>
            <a href="list.php?box=inbox&type_status=1"
               class="list-group-item list-group-item-sub <?php echo $type_status == '1' && $box == 'inbox' ? 'active' : ''; ?>"><i
                        class="fa fa-angle-double-right"></i> المهام المكتملة <span
                        class="badge"><?php echo get_calc_task(array('query' => _get_query_task('inbox-close'))); ?></span></a>

            <a href="list.php?box=outbox" class="list-group-item <?php echo $box == 'outbox' ? 'active' : ''; ?>"><i
                        class="fa fa-mail-reply fa-fw"></i> المهام الصادرة</a>
            <a href="list.php?box=outbox&type_status=0"
               class="list-group-item list-group-item-sub <?php echo $type_status == '0' && $box == 'outbox' ? 'active' : ''; ?>"><i
                        class="fa fa-angle-double-right"></i> المهام المكتملة <span
                        class="badge"><?php echo get_calc_task(array('query' => _get_query_task('outbox-open'))); ?></span></a>
            <a href="list.php?box=outbox&type_status=1"
               class="list-group-item list-group-item-sub <?php echo $type_status == '1' && $box == 'outbox' ? 'active' : ''; ?>"><i
                        class="fa fa-angle-double-right"></i> المهام المكتملة <span
                        class="badge"><?php echo get_calc_task(array('query' => _get_query_task('outbox-close'))); ?></span></a>
            <?php
            $args = array();
            $args['outbox_u_id'] = get_active_user('id');
            $args['unset']['read_it'] = true;
            ?>
            <a href="list.php?box=trash" class="list-group-item <?php echo $box == 'trash' ? 'active' : ''; ?>"><i
                        class="fa fa-trash-o"></i> سلة المهملات <span
                        class="badge"><?php echo get_calc_task(array('query' => _get_query_task('trash'))); ?></span></a>
        </div>
    </div> <!-- /.panel-body -->
</div> <!-- /.panel -->