<?php if (!isset($print['footer'])) {
    $print['footer'] = true;
} ?>
<?php if ($print['footer']): ?>
    <div class="print-footer print-footer-left">
        <small class="text-muted"><img src="<?php site_url('content/themes/default/img/logo_header.png'); ?>"
                                       class="img-responsive pull-left" width="64">معتمدة من برنامج المستقبل!
        </small>
    </div>
<?php endif; ?>

    <!-- page-print -->


<?php if (isset($_GET['print'])): ?>
    <script>
        setTimeout(function () {
            window.print();
        }, 500);
        setTimeout(function () {
            window.close();
        }, 500);
    </script>
<?php endif; ?>