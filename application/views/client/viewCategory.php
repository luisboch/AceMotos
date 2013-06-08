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
                        <div id="produto_maior1">
                            <div id="titulo_produto"><?=$category->getDescription();?></div>
                            <div id="amostra_total">
                                <? include 'products_each.php';?>
                            </div>
                        </div>
                    </div>
                </div>
                <? include 'footer.php'; ?>
            </div>
        </center>
    </body>
</html>


