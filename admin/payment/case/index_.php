<?php include('../../../ultra.php'); ?>
<?php get_header(); ?>
<?php
add_page_info('title', 'إدارة حالة النموذج');
add_page_info('nav', array('name' => 'خيارات', 'url' => get_site_url('admin/system/')));
add_page_info('nav', array('name' => 'إدارة حالة النموذج'));
?>


<?php if (isset(til()->form_status)): ?>


    <div class="list-group">
        <?php foreach (til()->form_status as $status): ?>
            <a href="form_status.php?taxonomy=<?php echo $status['taxonomy']; ?>" class="list-group-item">
                <h4 class="list-group-item-heading"><?php echo $status['name']; ?></h4>
                <p class="list-group-item-text"><?php echo $status['description']; ?></p>
            </a>
        <?php endforeach; ?>
    </div> <!-- /.list-group -->


<?php endif; ?>


<?php get_footer(); ?>