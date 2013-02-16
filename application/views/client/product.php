<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <? include 'client_header.php'; ?>
        <script type="text/javascript" src="<?= $url_home ?>resources/js/jquery.lightbox-0.5.min.js"></script>
        <link rel="stylesheet" type="text/css" href="<?= $url_home ?>resources/css/jquery.lightbox-0.5.css" media="screen" />    
        <!-- Ativando o jQuery lightBox plugin -->
        <script type="text/javascript">
            $(function() {
                $('#gallery a').lightBox();
            });
        </script>
        <style type="text/css">
            /* jQuery lightBox plugin - Gallery style */
            #gallery {
                padding: 10px;
                width: 250px;
                height: 200px;
            }
            #gallery ul { list-style: none; }
            #gallery ul li { display: inline; }
            #gallery ul img {

            }
            #gallery ul a:hover img {
                color: #fff;
            }
            #gallery ul a:hover { color: #fff; }
            a:link {
                text-decoration: none;
            }
            a:visited {
                text-decoration: none;
            }
            a:hover {
                text-decoration: none;
            }
            a:active {
                text-decoration: none;
            }
        </style>
    </head>
    <body>
        <center>
            <div id="container">
                <? include 'top_bar.php'; ?>
                <div id="conteudo">
                    <? include 'left_bar.php'; ?>
                    <div id="conteudo_dir">
                        <div id="produto_maior">
<!--                            <div id="titulo_produto"><?=$product->getName();?></div>-->
                            <div id="produto_amostra">
                                <div id="produto_ampli">
                                    <div id="gallery">
                                        <ul>
                                            <li><a href="<?=URL_IMAGES.$product->getImages()[0]->getImage(5)->getLink(); ?>" title=""><img src="<?=URL_IMAGES.$product->getImages()[0]->getImage(3)->getLink(); ?>" alt="" width="200" height="210" border="0" align="middle" /></a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div id="descricao_produto">
                                        <p><?=$product->getName();?></p>
                                        <p>&nbsp;</p>
                                        <p><?=StringUtil::currency($product->getSellValue());?></p>
                                    </div>
                                    <div id="descricao_tecnica">
                                        <p>Descrição:</p>
                                        <p><?=$product->getDescription();?></p>
                                    </div>                       
                                </div>
                            </div>

                            
                        </div>

                    </div>     
                </div>
                <? include 'footer.php'; ?>

            </div>
        </center>
    </body>
</html>


