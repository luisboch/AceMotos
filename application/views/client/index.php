<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <? include 'client_header.php'; ?>
    </head>
    <body>
        <center>
            <div id="container">
                <? include 'top_bar.php'; ?>
                <div id="conteudo">
                    <? include 'left_bar.php'; ?>
                    <div id="conteudo_dir">
                        <div id="banner">
                            <div id="banner_imagem"></div>
                        </div>
                        <div id="produto">
                            <? foreach ($products as $p) { ?>
                                <div id="produto_visual">
                                    <div id="imagem_produto"> <a href="<?=site_url('Products/' . $p->getId()) ?>"><img src="<?= URL_IMAGES.$p->getImages()[0]->getImage(0)->getLink(); ?>" width="120" height="127"/></a>
                                    </div>
                                    <div id="conteudo_produto">
                                        <p><? $p->getName() ?></p>
                                    </div>
                                    <div id="conteudo_valor">
                                        <p><?= StringUtil::currency($p->getSellValue()) ?></p>
                                    </div>
                                </div>
                            <? } ?>
                        </div>
                    </div>
                </div>
                <? include 'footer.php'; ?>
            </div>
        </center>
    </body>
</html>


