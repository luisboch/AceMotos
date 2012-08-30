<form action="<?= $targetsave ?>" method="post" enctype="multipart/form-data"> 
    <?=$error?>
    <input type="hidden" name="id" value="<?= $product->getId() ?>" /> 
    <?= multipleUpload($product->getImages(), 'product', $targetremove, $product->getId() ) ?>
    <div style="padding-left: 45%;">
    <a href="<?=$targetback?>"  class="ui-button">Voltar</a>
    <a href="<?=$targetedit?>"  class="ui-button">Editar</a>
    <input type="submit" class="ui-button" value="Salvar">
    </div>
</form>
