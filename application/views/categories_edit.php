<form action="<?=site_url('Categories/save')?>" method="post">
    <input type="hidden" name="id" value="<?=$cat->getId()?>"/>
    <table class="formTable">
        <? include 'thead-register.html'; ?>
        <tbody>
        <tr class="ui-widget-content ui-datatable-even">
            <td style="width: 30%">Nome:</td>
            <td style="width: 70%">
                <?=inputtext($cat->getDescription(), 'description', array('class' => 'inputM'));?>
                <?=$error['description'] != '' ? '<span class="error-helper">' . $error['description'] . '</span>' : '';?>
            </td>
        </tr>
        <tr class="ui-widget-content ui-datatable-even">
            <td>Categoria Pai:</td>
            <td>
                <?=select($categories, 'parent_id', $cat->getCategory() == null ? null : $cat->getCategory()->getId(), array('style' => 'width:140px'), 'parent_id', true);?>
                <?=$error['category'] != '' ? '<span class="error-helper">' . $error['category'] . '</span>' : '';?>
            </td>
        </tr>

        <tr class="ui-widget-content ui-datatable-even">
            <td></td>
            <td>
                <?=button('Salvar'); ?>
            </td>
        </tr>


        </tbody>
    </table>
</form>