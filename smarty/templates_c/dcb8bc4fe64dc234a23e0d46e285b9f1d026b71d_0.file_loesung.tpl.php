<?php
/* Smarty version 5.7.0, created on 2026-04-27 10:50:03
  from 'file:loesung.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.7.0',
  'unifunc' => 'content_69ef3f5b05ccb2_39606498',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'dcb8bc4fe64dc234a23e0d46e285b9f1d026b71d' => 
    array (
      0 => 'loesung.tpl',
      1 => 1769274572,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_69ef3f5b05ccb2_39606498 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = '/home/iksy/iksy05/ProjektGruppe1/smarty/templates';
?><!DOCTYPE HTML>

<html>
<head>
<title><?php echo $_smarty_tpl->getValue('ueberschrift');?>
</title>						
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="<?php echo CSS_BASE;?>
Forms.css">
<link rel="stylesheet" type="text/css" href="<?php echo CSS_BASE;?>
Tables.css">

<style>
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
">

    <label>SelectBoxArray</label>
    <select name="SelectBoxArray">
        <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('SelectBoxArray'), 'inhalt', false, 'id');
$foreach0DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('id')->value => $_smarty_tpl->getVariable('inhalt')->value) {
$foreach0DoElse = false;
?>
            <option value="<?php echo $_smarty_tpl->getValue('id');?>
"><?php echo $_smarty_tpl->getValue('inhalt');?>
</option> 
        <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
    </select><br> 
    
    <label>Variable1</label> 
    <input type="number" name="variable1" min="1" max="100" step="1" required><br>

    <label>Variable2</label> 
    <input type="text" 
           name="variable2" 
           pattern="grün|blau|gelb" 
           placeholder="grün, blau oder gelb" 
           title="Bitte nur 'grün', 'blau' oder 'gelb' eingeben."     
           required><br> 
    
    <label>Als PDF ausgeben?</label> 
    <input type="checkbox" name="pdf"><br>  
    
    <input type="submit" value="Berechnen">
</form>
	<?php } else { ?> 
        <?php if ((true && ($_smarty_tpl->hasVariable('fehler') && null !== ($_smarty_tpl->getValue('fehler') ?? null)))) {?>
            <p class="error">Bitte prüfen Sie Ihre Eingaben</p> 
        <?php } else { ?>

            <img src="<?php echo $_smarty_tpl->getValue('PATH_AND_FILENAME');?>
" alt="Umsatzgrafik">
            <br>

            <!--    
                    
            <img src="<?php echo $_smarty_tpl->getValue('QR_PATH_AND_FILENAME');?>
" alt="QR Code">
            <br> -->


            <?php echo $_smarty_tpl->getValue('ausgabe1');?>
 
            <br> <?php echo $_smarty_tpl->getValue('ausgabe2');?>

            <br> <?php echo $_smarty_tpl->getValue('ausgabe3');?>


	    <?php }?> 
	<?php }?>
	
</body>
</html>




	
	
	
	
	
	
	
	
	
	<?php }
}
