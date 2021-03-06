<?
import("services/CategoryService.php");
/**
 * Load all categories.
 */
$service = new CategoryService();
$categories = $service->getRootCategories();
?>
<div id="conteudo_esq">
    <div id="categoria">
        <div class="bloco_categorias">
            <?
            $i = 0;
            foreach ($categories as $cat) {
                ?>
                <div id="conteudo_categoria">
                    <p><a href="<?= site_url("Products/viewCategory/" . $cat->getId()); ?>">&gt; <strong><?= $cat->getDescription(); ?></strong></a></p>
                    <?
                    if ($cat->getChildren() !== null) {
                        foreach ($cat->getChildren() as $child) {
                            ?>
                            <a style="margin-left: 10px;display:block" href="<?= site_url("Products/viewCategory/" . $child->getId()); ?>">&gt; <strong><?= $child->getDescription(); ?></strong></a>
                        <?
                        }
                    }
                    ?>
                </div>
                <?
                $i++;
            }
            ?>
            <div style="clear:both"></div>
        </div>
    </div>
    <div id="letter" style="padding-top: 20px">
        <div id="conteudo_formulario_contato">
            <div class="contactform">
                <form id="formulario" action="<?= site_url("Clients/register") ?>" method="post">
                    <div><label for="name"><strong>Nome</strong></label><strong>*</strong></div>
                    <div>
                        <input id="name" name="name" size="25" style="width: 160px;" maxlength="50" type="text" />
                    </div>
                    <div><strong><label for="email">E-mail</label>*</strong></div>
                    <div>
                        <input id="email" name="email" size="25" style="width: 160px;" maxlength="50" value="" type="text"  />
                    </div>
                    
                    <div style="text-align: right;margin: 10px;">
                        <input name="contactsubmit" type="submit" class="button" value="Enviar" />
                    </div>
                    <div id="status_02"></div>                
                </form>
            </div>
        </div>
    </div>
</div>  