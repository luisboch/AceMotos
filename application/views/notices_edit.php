<form action="<?=site_url('Notices/save')?>" method="post">
    <input type="hidden" name="id" value="<?=$notice->getId()?>"/>
    <table class="formTable">
        <? include 'thead-register.html'; ?>
        <tbody>
        <tr class="ui-widget-content ui-datatable-even">
            <td style="width: 30%">Titulo:</td>
            <td style="width: 70%">
                <?=inputtext($notice->getTitle(), 'title', array('class' => 'inputM'));?>
                <?=$error['title'] != '' ? '<span class="error-helper">' . $error['title'] . '</span>' : '';?>
            </td>
        </tr>
        <tr class="ui-widget-content ui-datatable-even">
            <td>Resumo:</td>
            <td>
                <?=inputtext($notice->getResume(), 'resume', array('class' => 'inputM'));?>
                <?=$error['resume'] != '' ? '<span class="error-helper">' . $error['resume'] . '</span>' : '';?>
            </td>
        </tr>
        <tr class="ui-widget-content ui-datatable-even">
            <td>Noticia:</td>
            <td>
                <textarea name="notice" class="formG"><?=$notice->getNotice();?></textarea>
                <?=$error['notice'] != '' ? '<span class="error-helper">' . $error['notice'] . '</span>' : '';?>
            </td>
        </tr>
        <tr class="ui-widget-content ui-datatable-even">
            <td></td>
            <td>
                <?=button('Salvar'); ?>
            </td>
        </tr>
        </tbody>
    </table>
</form>