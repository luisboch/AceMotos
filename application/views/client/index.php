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
<!--                        <div id="banner">
                            <div id="banner_imagem"></div>
                        </div>-->
                        <div class="disposicao-produtos">
                            <div id="titulo_produto">Produtos</div>
                            <? include 'products_each.php'; ?>
                        </div>
                    </div>
                </div>
                <? include 'footer.php'; ?>
            </div>
        </center>
    </body>
</html>


