<div style="padding: 10px">
    <? /* @var $statistic StatisticResult */ ?>
    <table style="width: 100%;border-collapse: collapse;">
        <thead>
            <tr>
                <th class="ui-state-default" colspan="2" style="font-size: 15px;padding: 5px 10px;">Estatísticas de visualizações</th>
            </tr>
            <tr>
                <th class="ui-state-default" colspan="2" style="">Visualizações de produtos por período</th>
            </tr>
            <tr>
                <th class="ui-state-default">Período</th>
                <th class="ui-state-default">Quantidade de visualizações</th>
            </tr>
        </thead>
        <tbody>
            <tr >
                <td style="padding: 4px;border-bottom: 1px solid #AED0EA;border-left: 1px solid #AED0EA;">Semana passada</td>
                <td style="text-align: center;border-bottom: 1px solid #AED0EA;border-right: 1px solid #AED0EA;"><?= $statistic->getQtdLastWeek(); ?></td>
            </tr>
            <tr>
                <td style="padding: 4px;border-bottom: 1px solid #AED0EA;border-left: 1px solid #AED0EA;">Esta semana</td>
                <td style="text-align: center;border-bottom: 1px solid #AED0EA;border-right: 1px solid #AED0EA;"><?= $statistic->getQtdThisWeek(); ?></td>
            </tr>
            <tr>
                <td style="padding: 4px;border-bottom: 1px solid #AED0EA;border-left: 1px solid #AED0EA;">Ontem</td>
                <td style="text-align: center;border-bottom: 1px solid #AED0EA;border-right: 1px solid #AED0EA;"><?= $statistic->getQtdYesterday(); ?></td>
            </tr>
            <tr>
                <td style="padding: 4px;border-bottom: 1px solid #AED0EA;border-left: 1px solid #AED0EA;">Hoje</td>
                <td style="text-align: center;border-bottom: 1px solid #AED0EA;border-right: 1px solid #AED0EA;"><?= $statistic->getQtdToday(); ?></td>
            </tr>
        </tbody>
    </table>

    <table style="width: 100%;border-collapse: collapse;margin-top: 10px;">
        <thead>
            <tr>
                <th colspan="4" class="ui-state-default"> Top 10 Visualizações (últimos 2 mêses)</th>
            </tr>
            <tr>
                <th class="ui-state-default" style="width: 35%">Produtos</th>
                <th class="ui-state-default" style="width: 15%">Qtd</th>
                <th class="ui-state-default" style="width: 35%">Categorias</th>
                <th class="ui-state-default" style="width: 15%">Qtd</th>
            </tr>
        </thead>
        <tbody>
            <?
            $prdTen = $statistic->getPrdTen();
            $catTen = $statistic->getCatTen();

            for ($i = 0; $i < 10; $i++) {
                ?>
                <tr>
                    <? if ($prdTen[$i] != '') { ?>
                    <td style="padding: 4px;border-bottom: 1px solid #AED0EA;border-left: 1px solid #AED0EA;">
                            <a target="_blank" 
                               href="<?= site_url('Products/view/' . $prdTen[$i]->getProductId()) ?>">
                                   <?= $prdTen[$i]->getProductName() ?>
                            </a>
                        </td>
                        <td  style="padding: 4px;text-align: center; border-bottom: 1px solid #AED0EA;">
                            <?= $prdTen[$i]->getQtd(); ?>
                        </td>
                    <? } else { ?>
                        <td colspan="2" style="border-bottom: 1px solid #AED0EA;border-left: 1px solid #AED0EA;"></td>
                    <? } ?>
                    <? if ($catTen[$i] != '') { ?>
                        <td style="padding: 4px;border-bottom: 1px solid #AED0EA;">
                            <a target="_blank" 
                               href="<?= site_url('Products/viewCategory/' . $catTen[$i]->getCatId()) ?>">
                                   <?= $catTen[$i]->getCatName() ?>
                            </a>
                        </td>
                        <td style="padding: 4px;text-align: center;border-bottom: 1px solid #AED0EA;border-right: 1px solid #AED0EA;">
                            <?= $catTen[$i]->getQtd(); ?>
                        </td>
                    <? } else { ?>
                        <td colspan="2"  style="padding: 4px;border-bottom: 1px solid #AED0EA;border-right: 1px solid #AED0EA;">
                            &zwj;
                        </td>
                    <? } ?>
                </tr>
            <? } ?>
        </tbody>
    </table>


</div>