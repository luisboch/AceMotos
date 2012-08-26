<form action="<?= $targetsave ?>" method="post" enctype="multipart/form-data"> 
    <input type="hidden" name="id" value="<?= $product->getId() ?>" /> 
    <table class="formTable">

        <thead>
            <tr>
                <th colspan="3" class="ui-state-default ui-widget-header">Alterar imagens</th>
            </tr>
            <tr>
                <th class="ui-state-default ui-widget-header">Imagem Atual</th>
                <th class="ui-state-default ui-widget-header">Nova Imagem</th>
                <th class="ui-state-default ui-widget-header"></th>
            </tr>
        </thead>
        <tbody>
            <?
            $images = $product->getImages();
            for ($i = 0; $i < 10; $i++) {
                $image = $images[$i];
                ?>
                <tr class="ui-widget-content ui-datatable-even">
                    <td>
                        <?= adminimage($image, 1) ?>
                    </td>
                    <? if ($webImage != null) { ?>
                        <td><?= adminimage($webImage, 2) ?>
                            <input type="hidden" name="n_image[<?= $i ?>][0]" value="<?= $webImage->getImage(0)->getLink() ?>" />
                            <input type="hidden" name="n_image[<?= $i ?>][1]" value="<?= $webImage->getImage(1)->getLink() ?>" />
                            <input type="hidden" name="n_image[<?= $i ?>][2]" value="<?= $webImage->getImage(2)->getLink() ?>" />
                            <input type="hidden" name="n_image[<?= $i ?>][3]" value="<?= $webImage->getImage(3)->getLink() ?>" />
                            <input type="hidden" name="n_image[<?= $i ?>][4]" value="<?= $webImage->getImage(4)->getLink() ?>" />
                            <input type="hidden" name="n_image[<?= $i ?>][5]" value="<?= $webImage->getImage(5)->getLink() ?>" />

                        <? } else { ?>
                        <td>
                        <? } ?>
                        <?= simpleUpload($targetupload, 'img[' . $i . ']', 'img_' . 
                                $i . '', array('onclick' => '$(this).closest(\'form\').attr(\'action\', $(this).attr(\'rel\'))')) ?>
                        <?= $error != '' ? '<a><span class="error-helper">' . $error . '</span>' : '' ?>
                    </td>
                    <td>
                        <?= button("Enviar"); ?>
                    </td>
                </tr>
            <? } ?>
        </tbody>
    </table>
</form>
<script type="text/javascript">
</script>
