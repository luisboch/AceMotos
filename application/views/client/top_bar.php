<div id="topo">
    <div id="topo_dir">
        <div class="busca">
            <form method="get" action="URL do site">
                <input class="pesquisa"  type="text" value="" name="s"  size="10" placeholdervalue="faça sua busca..." />
                <input type="image" src="<?=$layoutImgPath?>buscar.png" class="button"/>
            </form>
        </div>
    </div>
    <div id="topo_esq">
        <img src="<?=$layoutImgPath?>topo_dir.png" width="355" height="133" border="0" usemap="#Map1" />
        <map name="Map1" id="Map1">
            <area shape="rect" coords="41,16,333,120" href="index.html" />
        </map>
    </div>
</div>
<div id="menu">
    <img src="<?=$layoutImgPath?>menu_index.png" width="1081" height="32" border="0" usemap="#Map2" />
    <map name="Map2" id="Map2">
        <area shape="rect" coords="948,5,1037,47" href="contato.html" />
        <area shape="rect" coords="813,6,926,46" href="destaque.html" />
        <area shape="rect" coords="681,6,789,43" href="promocoes.html" />
        <area shape="rect" coords="523,4,652,30" href="lancamentos.html" />
        <area shape="rect" coords="373,5,499,34" href="quem_somos.html" />
    </map>
</div>
