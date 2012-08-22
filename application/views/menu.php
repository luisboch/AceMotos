<div style="width: 16%;float: left">
    <ul id="menu">
        <li>Administração
            <ul>
                <li>
                    <a href="<?= site_url('_Users'); ?>">Usuários</a>
                </li>
            </ul>
        </li>
        <li>Produtos
            <ul>
                <li>
                    <a href="<?= site_url('ProductsController'); ?>">Produtos</a>
                </li>
                <li>
                    <a href="<?= site_url('Categories'); ?>">Categorias</a>
                </li>
            </ul>
        </li>
        <li>Conteúdo
            <ul>
                <li>
                    <a href="<?= site_url('Notices'); ?>">Noticias</a>
                </li>
            </ul>
        </li>
    </ul>
</div>
<div id="nav-bar" class="ui-state-default"><?=$way?></div>
<div id="rootDocument" class="ui-panel ui-widget ui-widget-content ui-corner-all" style ="width: 82%;float:right">