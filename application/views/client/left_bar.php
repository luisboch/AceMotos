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
        <?
        $i = 0;
        foreach ($categories as $cat) {
            ?>
            <div id="conteudo_categoria<?= $i === 0 ? '' : '1'; ?>">
                <p><a href="<?= site_url("Products/viewCategory/" . $cat->getId()); ?>">&gt; <strong><?= $cat->getDescription(); ?></strong></a></p>
                <? if ($cat->getChildren() !== null) {
                    foreach ($cat->getChildren() as $child) {
                        ?>
                        <a style="margin-left: 10px;display:block" href="<?= site_url("Products/viewCategory/" . $child->getId()); ?>">&gt; <strong><?= $child->getDescription(); ?></strong></a>
                    <? }
                }
                ?>
            </div>
            <?
            $i++;
        }
        ?>
    </div>
    <div id="letter">
        <div id="conteudo_formulario_contato">
            <div class="contactform">
                <form id="formulario" action="javascript:func(fale);" method="post">
                    <div><label for="nome"><strong>Nome</strong></label><strong>*</strong></div>
                    <div>
                        <input id="nome" name="nome" size="25" maxlength="50" type="text" />
                    </div><br /><br /><strong><br/></strong>
                    <div><strong><label for="email">E-mail</label>*</strong></div>
                    <div><input id="email" name="email" size="25" maxlength="50" value=""type="text"  /></div><br /><br />
                    <div></div>
                    <p><strong>
                            <input name="contactsubmit" type="submit" class="hack-btn" id="contactsubmit" value="" />
                        </strong></p>
                    <p><br />
                    </p>

                    <div></div>
                    <br />
                    <div id="status_02"></div>                
                </form>
            </div>
        </div>
    </div>
</div>  