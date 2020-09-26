<div class="panel panel-default panel-sidebar">
    <div class="panel-body">
        <div class="text-left">
            <a href="add.php" class="btn btn-default btn-block"><i class="fa fa-pencil-square-o"></i> رسالة جديدة</a>
        </div>
        <div class="clearfix"></div>
        <div class="h-20"></div>
        <div class="list-group list-group-messagebox">
            <!-- inbox -->
            <?php $box = 'inbox'; ?>
            <a href="list.php?box=inbox" class="list-group-item <?php echo $box == 'inbox' ? 'active' : ''; ?>"><i
                        class="fa fa-mail-forward fa-fw"></i>البريد الوارد</a>
            <a href="list.php?box=inbox&read_it=0"
               class="list-group-item list-group-item-sub <?php echo @$read_it == '0' ? 'active' : ''; ?>"><i
                        class="fa fa-angle-double-right"></i> غير مقروء <span
                        class="badge"><?php echo get_calc_message(array('query' => _get_query_message('inbox-unread'))); ?></span></a>
            <a href="list.php?box=inbox&read_it=1"
               class="list-group-item list-group-item-sub <?php echo @$read_it == '1' ? 'active' : ''; ?>"><i
                        class="fa fa-angle-double-right"></i> مقروء<span
                        class="badge"><?php echo get_calc_message(array('query' => _get_query_message('inbox-read'))); ?></span></a>
            <!-- outbox -->
            <a href="list.php?box=outbox" class="list-group-item <?php echo $box == 'outbox' ? 'active' : ''; ?>"><i
                        class="fa fa-mail-reply fa-fw"></i> صندوق الحفظ <span
                        class="badge"><?php echo get_calc_message(array('query' => _get_query_message('outbox'))); ?></span></a>
            <!-- trash -->
            <a href="list.php?box=trash" class="list-group-item <?php echo $box == 'trash' ? 'active' : ''; ?>"><i
                        class="fa fa-trash-o fa-fw"></i> سلة المهملات <span
                        class="badge"><?php echo get_calc_message(array('query' => _get_query_message('trash'))); ?></span></a>
        </div>
    </div> <!-- /.panel-body -->
</div> <!-- /.panel -->