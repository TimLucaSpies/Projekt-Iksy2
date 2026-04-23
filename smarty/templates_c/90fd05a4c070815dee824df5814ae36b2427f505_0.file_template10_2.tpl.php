<?php
/* Smarty version 5.7.0, created on 2026-01-10 11:47:58
  from 'file:template10_2.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.7.0',
  'unifunc' => 'content_69623c6e87fcb5_83887822',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '90fd05a4c070815dee824df5814ae36b2427f505' => 
    array (
      0 => 'template10_2.tpl',
      1 => 1768045675,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_69623c6e87fcb5_83887822 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = '/var/www/html/smarty/templates';
?><!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Aufgabe 10.2</title>
    <style>
        body { font-family: sans-serif; padding: 20px; }
        .result-box { background: #e9ecef; padding: 15px; margin-top: 20px; border-radius: 5px; }
    </style>
</head>
<body>
    <h1>Finanzierungsrechner</h1>
    
    <form action="<?php echo $_smarty_tpl->getValue('PHP_SELF');?>
" method="post">
        <label>Eigenkapital (€):</label><br>
        <input type="number" name="Eigenkapital" step="any" required><br><br>
        
        <label>Kaufpreis (€):</label><br>
        <input type="number" name="Preis" step="any" required><br><br>
        
        <input type="submit" name="calc_button" value="Im Browser berechnen">
        
        <input type="submit" name="pdf_button" value="Als PDF exportieren">
    </form>

    <?php if ((true && ($_smarty_tpl->hasVariable('Ergebnis') && null !== ($_smarty_tpl->getValue('Ergebnis') ?? null)))) {?>
        <div class="result-box">
            <h2>Ergebnis:</h2>
            <p><?php echo $_smarty_tpl->getValue('Ergebnis');?>
</p>
        </div>
    <?php }?>
</body>
</html><?php }
}
