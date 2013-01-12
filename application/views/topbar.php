<div id="top-bar" class="ui-state-default">
    <form action="<?= site_url("LoginService/logout"); ?>" method="post">
        <?= button('Logout', NULL, NULL, NULL, array('style' => 'float: right;')) ?>
    </form>
    <span style="clear: both;display: block"></span>
</div>
