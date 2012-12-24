<form action="<?= $targetsave ?>" method="post" enctype="multipart/form-data"> 
    <input type="hidden" name="id" value="<?= $notice->getId() ?>" /> 
    <table class="formTable">

        <thead>
            <tr>
                <th colspan="2" class="ui-state-default ui-widget-header">Alterar imagem</th>
            </tr>
        </thead>
        <tbody>
            <tr class="ui-widget-content ui-datatable-even">
                <td>Imagem Atual:</td>
                <td>
                    <?= adminimage(el('webImage', $notice), 2) ?>
                </td>
            </tr>
            <? if ($webImage != null) { ?>
                <tr class="ui-widget-content ui-datatable-even">
                    <td>Nova Imagem:</td>
                    <td><?= adminimage($webImage, 2) ?>
                        <input type="hidden" name="n_image[0]" value="<?= $webImage->getImage(0)->getLink() ?>" />
                        <input type="hidden" name="n_image[1]" value="<?= $webImage->getImage(1)->getLink() ?>" />
                        <input type="hidden" name="n_image[2]" value="<?= $webImage->getImage(2)->getLink() ?>" />
                        <input type="hidden" name="n_image[3]" value="<?= $webImage->getImage(3)->getLink() ?>" />
                        <input type="hidden" name="n_image[4]" value="<?= $webImage->getImage(4)->getLink() ?>" />
                        <input type="hidden" name="n_image[5]" value="<?= $webImage->getImage(5)->getLink() ?>" />
                    </td>
                </tr>
            <? } ?>
            <tr class="ui-widget-content ui-datatable-even">
                <td>Alterar imagem:</td>
                <td>
                    <?= simpleUpload($targetupload, $librarie, 'output', array('onclick' => '$(this).closest(\'form\').attr(\'action\', $(this).attr(\'rel\'))')) ?>
                    <?=$error!=''?'<a><span class="error-helper">'.$error.'</span>':''?>
                </td>
            </tr>
            <tr class="ui-widget-content ui-datatable-even">
                <td></td>
                <td>
                    <?= button("salvar"); ?>
                </td>
            </tr>
        </tbody>
    </table>
</form>
<script type="text/javascript">
</script>
