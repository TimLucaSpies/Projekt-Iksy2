<?php
/* Smarty version 5.7.0, created on 2026-01-10 15:55:27
  from 'file:loesung.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.7.0',
  'unifunc' => 'content_6962766f0ffc09_92892041',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '46c56c4594fb3b907e4f36b6876c480cb7098a74' => 
    array (
      0 => 'loesung.tpl',
      1 => 1768060425,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_6962766f0ffc09_92892041 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = '/var/www/html/Probeklausur2/smarty/templates';
?><!DOCTYPE HTML>
<html>
<head>
    <title>Lieferservice</title>
    <meta charset="utf-8">
    <style>
        body { font-family: Arial; margin: 20px; }
        label { display: inline-block; width: 200px; margin-bottom: 5px; }
        .error { color: red; }
    </style>
</head>
<body>
    <h2><?php echo $_smarty_tpl->getValue('ueberschrift');?>
</h2>

    <?php if ((true && ($_smarty_tpl->hasVariable('ausgabeText') && null !== ($_smarty_tpl->getValue('ausgabeText') ?? null)))) {?>
        <p><?php echo $_smarty_tpl->getValue('ausgabeText');?>
</p>
        <a href="<?php echo $_smarty_tpl->getValue('PHP_SELF');?>
">Zurück</a>
    <?php } else { ?>
        <?php if ((true && ($_smarty_tpl->hasVariable('fehler') && null !== ($_smarty_tpl->getValue('fehler') ?? null)))) {?><p class="error">Bitte prüfen Sie Ihre Eingaben (Zahlen > 0)!</p><?php }?>
        
        <form action="<?php echo $_smarty_tpl->getValue('PHP_SELF');?>
" method="post">
            <input type="hidden" name="csrfToken" value="<?php echo $_smarty_tpl->getValue('csrfToken');?>
">
            
            <label>Pizza auswählen:</label>
            <select name="bestellnummer">
                <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('angebote'), 'name', false, 'id');
$foreach0DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('id')->value => $_smarty_tpl->getVariable('name')->value) {
$foreach0DoElse = false;
?>
                    <option value="<?php echo $_smarty_tpl->getValue('id');?>
"><?php echo $_smarty_tpl->getValue('name');?>
</option>
                <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
            </select><br>

            <label>Anzahl:</label>
            <input type="number" name="anzahl" min="1" required><br>

            <label>Entfernung (km):</label>
            <input type="number" name="entfernung" min="1" required><br>

            <label>Selbstabholung?</label>
            <input type="checkbox" name="abholung"><br>

            <label>Als PDF ausgeben?</label>
            <input type="checkbox" name="pdf"><br>

            <input type="submit" value="Berechnen">
        </form>
    <?php }?>
</body>
</html><?php }
}
