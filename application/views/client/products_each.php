<? /* @var $products Product[] */ ?>
<div class="bloco_produtos">
    <?
    if (!is_array($products) || count($products) === 0) {
        ?><span>Nenhum produto disponível.</span><?
    } else {
        foreach ($products as $p) {
            ?>
            <div id="produto_visual">
                <?
                $imgs = $p->getImages();
                ?>
                <div id="imagem_produto"> <a href="<?= site_url('Products/view/' . $p->getId()) ?>"><img src="<?= URL_IMAGES . $imgs[0]->getImage(2)->getLink(); ?>" width="120" height="127"/></a>
                </div>
                <div id="conteudo_produto">
                    <p><?= $p->getName() ?></p>
                </div>
                <div id="conteudo_valor">
                    <? if ($p->getSellValue() < 1) { ?>
                        <p>Consultar</p>
                    <? } else { ?>
                        <p><?= StringUtil::currency($p->getSellValue()) ?></p>
                    <? } ?>
                </div>
            </div>
            <?
        }
    }
    ?>
    <div style="clear: both;"></div>
</div>