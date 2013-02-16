<? foreach ($products as $p) { ?>
    <div id="produto_visual">
        <div id="imagem_produto"> <a href="<?= site_url('Products/view/' . $p->getId()) ?>"><img src="<?= URL_IMAGES . $p->getImages()[0]->getImage(2)->getLink(); ?>" width="120" height="127"/></a>
        </div>
        <div id="conteudo_produto">
            <p><?=$p->getName() ?></p>
        </div>
        <div id="conteudo_valor">
            <p><?= StringUtil::currency($p->getSellValue()) ?></p>
        </div>
    </div>
<? } ?>