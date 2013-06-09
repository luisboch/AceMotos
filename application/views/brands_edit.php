<? /* @var $brand Brand */  ?>
<form action="<?= site_url('BrandsController/save') ?>" method="post">
    <input type="hidden" name="id" value="<?= $brand->getId() ?>"/>
    <table class="formTable">
        <? include 'thead-register.html'; ?>
        <tbody>
        <tr class="ui-widget-content ui-datatable-even">
            <td style="width: 30%">Nome:</td>
            <td style="width: 70%">
                <?= inputtext($brand->getName(), 'name', array('class' => 'inputM')); ?>
                <?= $error['name'] != '' ? '<span class="error-helper">' . $error['name'] . '</span>' : ''; ?>
            </td>
        </tr>
        <tr class="ui-widget-content ui-datatable-even">
            <td></td>
            <td>
                <?= button('Salvar'); ?>
            </td>
        </tr>
        </tbody>
    </table>
</form>