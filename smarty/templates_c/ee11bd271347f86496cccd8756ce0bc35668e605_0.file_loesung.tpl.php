<?php
/* Smarty version 5.7.0, created on 2026-01-12 12:16:28
  from 'file:loesung.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.7.0',
  'unifunc' => 'content_6964e61ca07484_60833356',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'ee11bd271347f86496cccd8756ce0bc35668e605' => 
    array (
      0 => 'loesung.tpl',
      1 => 1768220186,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_6964e61ca07484_60833356 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = '/var/www/html/Probeklausur4/smarty/templates';
?><!DOCTYPE HTML>
<html>
<head>
<title>Bonus</title>
<meta charset="utf-8">
<style>
body {
	font-family: Arial;
	margin: 20px;
}

label {
	display: inline-block;
	width: 200px;
	margin-bottom: 5px;
}

.error {
	color: red;
}
</style>
</head>
<body>
	<h2><?php echo $_smarty_tpl->getValue('ueberschrift');?>
</h2>

	<?php if ((true && ($_smarty_tpl->hasVariable('PHP_SELF') && null !== ($_smarty_tpl->getValue('PHP_SELF') ?? null)))) {?>
	<form action="<?php echo $_smarty_tpl->getValue('PHP_SELF');?>
" method="post">
		<input type="hidden" name="csrfToken" value="<?php echo $_smarty_tpl->getValue('csrfToken');?>
"> <label>Name</label>
		<select name="mitarbeiterNr"> <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('nachname'), 'name', false, 'id');
$foreach0DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('id')->value => $_smarty_tpl->getVariable('name')->value) {
$foreach0DoElse = false;
?>
			<option value="<?php echo $_smarty_tpl->getValue('id');?>
"><?php echo $_smarty_tpl->getValue('name');?>
</option> <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
		</select><br> <label>Höhe Teambonus</label> <input type="number"
			name="hoeheTeambonus" min="10" max="80" step="0.1" required><br>

		<label>Farbe Grußkarte</label> <input type="text"
			name="farbeGrußkarte" required><br> <label>Als
			PDF ausgeben?</label> <input type="checkbox" name="pdf"><br> <input
			type="submit" value="Berechnen">
	</form>
	<?php } else { ?> <?php if ((true && ($_smarty_tpl->hasVariable('fehler') && null !== ($_smarty_tpl->getValue('fehler') ?? null)))) {?> Falsche Eingaben. <?php } else { ?>
	<img src="<?php echo $_smarty_tpl->getValue('PATH_AND_FILENAME');?>
" alt="Umsatzgrafik">
	<br> <?php echo $_smarty_tpl->getValue('ausgabe1');?>
 
	<br> <?php echo $_smarty_tpl->getValue('ausgabe2');?>

	<br> <?php echo $_smarty_tpl->getValue('ausgabe3');?>


	<?php }?> 
	<?php }?>
	
</body>
</html><?php }
}
