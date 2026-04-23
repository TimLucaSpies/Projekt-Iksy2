<?php
/* Smarty version 5.7.0, created on 2026-01-07 14:53:30
  from 'file:template8_1.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.7.0',
  'unifunc' => 'content_695e736ac67c26_82053565',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '63ab0f83a55aa8f5c382839a69c60bb66febd31e' => 
    array (
      0 => 'template8_1.tpl',
      1 => 1767797608,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_695e736ac67c26_82053565 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = '/var/www/html/smarty/templates';
?><!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Euro-Dollar Umrechnung Teil 2</title>
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
