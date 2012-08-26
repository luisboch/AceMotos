<form action="<?=site_url('ProductsController/save')?>" method="post"> 
   <input type="hidden" name="id" value="<?=$product->getId()?>" /> 
    <table class="formTable">
        <? include 'thead-register.html'; ?>
        <tbody>
            <tr class="ui-widget-content ui-datatable-even">
                <td style="width: 30%">Nome:</td>
                <td style="width: 70%">
                    <?=inputtext($product->getName(), 'name',array('class' =>'inputM'));?>
                    <?=$error['name']!=''?'<span class="error-helper">'.$error['name'].'</span>':'';?>
                </td>
            </tr>
            <tr class="ui-widget-content ui-datatable-even">
                <td>Descrição:</td>
                <td>
                    <textarea name="description" class="formG"><?=$product->getDescription();?></textarea>
                    <?=$error['description']!=''?'<span class="error-helper">'.$error['description'].'</span>':'';?>
                </td>
            </tr>
            <tr class="ui-widget-content ui-datatable-even">
                <td style="width: 30%">Valor Venda:</td>
                <td style="width: 70%">
                    <?=inputtext(StringUtil::currency($product->getSellValue()), 'sellValue',array('class' =>'inputM'));?>
                    <?=$error['sellValue']!=''?'<span class="error-helper">'.$error['sellValue'].'</span>':'';?>
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