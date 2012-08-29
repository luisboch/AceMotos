<form action="<?= $targetsave ?>" method="post" enctype="multipart/form-data"> 
    <?=$error?>
    <input type="hidden" name="id" value="<?= $product->getId() ?>" /> 
    <?= multipleUpload($product->getImages(), 'product', $targetremove, $product->getId() ) ?>
    <input type="submit" class="button" style="float: right;" value="Salvar">
</form>
