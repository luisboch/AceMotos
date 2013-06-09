<div id="topo">
    <div id="topo_dir">
        <div class="busca">
            <form method="get" action="<?=site_url('Products/Search');?>">
                <input class="pesquisa"  type="text" value="" name="q"  size="10" placeholdervalue="faça sua busca..." />
                <input type="image" value="Ok" class="button"/>
            </form>
        </div>
    </div>
    <div id="topo_esq">
        <img src="<?=$url_home?><?=$layoutImgPath?>topo_dir.png" width="355" height="133" border="0" usemap="#Map1" />
        <map name="Map1" id="Map1">
            <area shape="rect" coords="41,16,333,120" href="index.html" />
        </map>
    </div>
</div>
<div id="menu">
    <div id="menu-items" style="width: 1081px; height: 32px; background-image: <?=$url_home?><?=$layoutImgPath?>menu_index_bg.png">
        <a href="<?=site_url('/');?>">Home</a>|<a href="<?=site_url('Pages/who');?>">Quem somos</a>|<a href="<?=site_url('Pages/contactUs');?>">Contato</a>
    </div>
    <!--<img src="<?=$url_home?><?=$layoutImgPath?>menu_index_bg.png" width="1081" height="32" border="0" usemap="#Map2" />-->
<!--    <map name="Map2" id="Map2">
        <area shape="rect" coords="948,5,1037,47" href="<?=site_url('Pages/contactUs');?>" />
        <area shape="rect" coords="813,6,926,46" href="destaque.html" />
        <area shape="rect" coords="681,6,789,43" href="promocoes.html" />
        <area shape="rect" coords="523,4,652,30" href="lancamentos.html" />
        <area shape="rect" coords="373,5,499,34" href="<?=site_url('Pages/who');?>" />
    </map>-->
</div>
