<?php
/* Smarty version 5.7.0, created on 2026-01-07 14:28:23
  from 'file:template7_1.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.7.0',
  'unifunc' => 'content_695e6d87b69d51_88452892',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'ea7b72a7c50c47a8e68242f233b3111bc640b901' => 
    array (
      0 => 'template7_1.tpl',
      1 => 1767796100,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_695e6d87b69d51_88452892 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = '/var/www/html/smarty/templates';
?><!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<!-- division3.tpl -->
<title>Division</title>
<link rel="stylesheet" href="../css/formular.css" type="text/css">
</head>
<body>
<h2>Division zweier Zahlen</h2>
<?php if (((true && ($_smarty_tpl->hasVariable('PHP_SELF') && null !== ($_smarty_tpl->getValue('PHP_SELF') ?? null))))) {?>
<form name='division' action='<?php echo $_smarty_tpl->getValue('PHP_SELF');?>
' method='post'>
<label for="i_zaehler">Zähler</label>
<input type="number" name="zaehler" id="i_zaehler" size=12><br>
<label for="i_nenner">Nenner</label>
<input type="number" name="nenner" size=12><br>
<input type="submit" name="Button1" value="Abschicken">
</form>
<?php } else {
if (((true && ($_smarty_tpl->hasVariable('teilenDurchNullFehler') && null !== ($_smarty_tpl->getValue('teilenDurchNullFehler') ?? null))))) {?>
Sie haben versucht durch Null zu teilen!
<?php } else { ?>
Der Quotient von <?php echo $_smarty_tpl->getValue('zaehler');?>
 und <?php echo $_smarty_tpl->getValue('nenner');?>
 ist: <?php echo $_smarty_tpl->getValue('quotient');?>

<?php }
}?>
</body>
</html><?php }
}
