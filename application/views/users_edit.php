<form action="<?=site_url('_Users/save')?>" method="post">
    <input type="hidden" name="id" value="<?=$user->getId()?>" />
    <table class="formTable">
        <? include 'thead-register.html'; ?>
        <tbody>
            <tr class="ui-widget-content ui-datatable-even">
                <td style="width: 30%">Nome:</td>
                <td style="width: 70%">
                    <?=inputtext($user->getName(), 'name',array('class' =>'inputM'));?>
                    <?=$error['name']!=''?'<span class="error-helper">'.$error['name'].'</span>':'';?>
                </td>
            </tr>
            <tr class="ui-widget-content ui-datatable-even">
                <td>Email:</td>
                <td>
                    <?=inputtext($user->getEmail(), 'email',array('class'=>'inputM'));?>
                    <?=$error['email']!=''?'<span class="error-helper">'.$error['email'].'</span>':'';?>
                </td>
            </tr>
            <tr class="ui-widget-content ui-datatable-even">
                <td>Grupo:</td>
                <td>
                    <?=select(array(1 => 'Admin',2 => 'Empresário'),'group', $user->getGroup(),array('style' => 'width:140px'));?>
                    <?=$error['group']!=''?'<span class="error-helper">'.$error['group'].'</span>':'';?>
                </td>
            </tr>
            
            <tr class="ui-widget-content ui-datatable-even">
                <td>Senha:</td>
                <td>
                    <?=inputpass('password');?>
                    <?=$error['password']!=''?'<span class="error-helper">'.$error['password'].'</span>':'';?>
                </td>
            </tr>
            <tr class="ui-widget-content ui-datatable-even">
                <td>Confirme a senha:</td>
                <td>
                    <?=inputpass('passwordConfirm');?>
                    <?=$error['passwordConfirm']!==NULL?'<span class="error-helper">'.$error['passwordConfirm'].'</span>':'';?>
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