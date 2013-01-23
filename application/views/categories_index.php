<form id="filters" name="filters" class="" method="get" action="<?= site_url('Categories/search/'); ?>"
      enctype="application/x-www-form-urlencoded">
    <table style="text-align: right;width: 100%">
        <tbody>
        <tr>
            <td class="labelForm">Search:</td>
            <td class="itemForm"><?= inputtext("", 'search') ?></td>
        </tr>
        <tr>
            <td class="labelForm"></td>
            <td class="itemForm"><?= button("Pesquisar"); ?></td>
        </tr>
        </tbody>
    </table>
    <div style="text-align: right;"></div>
</form>