<body>
<div id="loginBox">
    <form id="loginForm" name="loginForm" method="post" action="<?= site_url("LoginService/login") ?>"
          enctype="application/x-www-form-urlencoded">
        <input type="hidden" value="<?=$target?>" name="target"/>
        <table>
            <tbody class="formTable">
            <tr>
                <td>Email:</td>
                <td>
                    <?=inputtext($_POST['email'], 'email')?>
                </td>
            </tr>
            <tr>
                <td>Password:</td>
                <td>
                    <?=inputpass('passwd')?>
                </td>
            </tr>
            <tr>
                <td></td>
                <td style="text-align: right">
                    <?=button('Login');?>
                </td>
            </tr>
            <? if ($error) { ?>
            <tr>
                <td/>
                <td style="text-align: center;color: #F44">Email/Senha inválidos</td>
            </tr>
                <? } ?>
            </tbody>
        </table>
        <input type="hidden" name="javax.faces.ViewState" id="javax.faces.ViewState"
               value="-3419631855049974606:8348462350574818991" autocomplete="off"/>
    </form>
</div>
</body>
</html>