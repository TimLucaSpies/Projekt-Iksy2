<?php
/* Smarty version 5.7.0, created on 2026-01-10 12:26:02
  from 'file:template11_1.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.7.0',
  'unifunc' => 'content_6962455aa0bcc1_75507543',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '97cc894877a3eaf3d43c41f3f04c3b76152d2630' => 
    array (
      0 => 'template11_1.tpl',
      1 => 1768047959,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_6962455aa0bcc1_75507543 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = '/var/www/html/smarty/templates';
?><!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Kundensuche</title>
    <style>
        body { font-family: sans-serif; padding: 20px; line-height: 1.6; }
        .result { margin-top: 20px; font-weight: bold; color: #2c3e50; padding: 10px; background: #ecf0f1; border-left: 5px solid #3498db; }
        select { padding: 5px; width: 200px; }
        input[type="submit"] { padding: 5px 15px; cursor: pointer; }
    </style>
</head>
<body>
    <h1>Kundensuche</h1>

    <form action="<?php echo $_smarty_tpl->getValue('PHP_SELF');?>
" method="post">
        <label for="kunde_id">Wählen Sie einen Kunden aus:</label><br><br>
        
        <select name="kunde_id" id="kunde_id">
            <option value="">-- Bitte wählen --</option>
            <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('kundeArray'), 'name', false, 'knr');
$foreach0DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('knr')->value => $_smarty_tpl->getVariable('name')->value) {
$foreach0DoElse = false;
?>
                <option value="<?php echo $_smarty_tpl->getValue('knr');?>
"><?php echo $_smarty_tpl->getValue('name');?>
</option>
            <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
        </select>

        <input type="submit" value="Stadt anzeigen">
    </form>

    <?php if ($_smarty_tpl->getValue('ausgabeText') != '') {?>
        <div class="result">
            <?php echo $_smarty_tpl->getValue('ausgabeText');?>

        </div>
    <?php }?>

</body>
</html><?php }
}
