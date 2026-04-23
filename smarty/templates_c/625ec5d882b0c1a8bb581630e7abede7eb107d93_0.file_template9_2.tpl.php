<?php
/* Smarty version 5.7.0, created on 2026-01-09 15:41:30
  from 'file:template9_2.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.7.0',
  'unifunc' => 'content_696121aa75c6a4_02306870',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '625ec5d882b0c1a8bb581630e7abede7eb107d93' => 
    array (
      0 => 'template9_2.tpl',
      1 => 1767973048,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_696121aa75c6a4_02306870 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = '/var/www/html/smarty/templates';
?><!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Aufgabe 9.2</title>
<link rel="stylesheet" href="../css/formular.css" type="text/css">
</head>
<body>
	<?php if (((true && ($_smarty_tpl->hasVariable('PHP_SELF') && null !== ($_smarty_tpl->getValue('PHP_SELF') ?? null))))) {?>
	<form name='euro' action='<?php echo $_smarty_tpl->getValue('PHP_SELF');?>
' method='post'>
	
		<label for="i_eigenkapital">Eigenkapital</label> 
		<input type="number" name="Eigenkapital" id="i_eigenkapital" size=12 step="any"><br> 
		
		<label for="i_preis">Preis</label> 
		<input type="text" name="Preis" id="i_preis" lsize=12><br> 
		
		<input type="submit" name="Button1" value="Abschicken">
	</form>
	<?php } else { ?> 
	<h1><?php echo $_smarty_tpl->getValue('Ergebnis');?>
</h1>
	<?php }?>
</body>
</html><?php }
}
