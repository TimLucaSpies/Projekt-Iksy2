<?php
/* Smarty version 5.7.0, created on 2026-01-10 11:41:04
  from 'file:aufgabe10_2.Ausgabe.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.7.0',
  'unifunc' => 'content_69623ad0c1c9a3_03108513',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '2048e0955ff53ae32b113029b12677b8746c04c7' => 
    array (
      0 => 'aufgabe10_2.Ausgabe.tpl',
      1 => 1768045262,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_69623ad0c1c9a3_03108513 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = '/var/www/html/smarty/templates';
?><style>
    h1 { color: #0044cc; }
    .box { border: 1px solid #ccc; padding: 10px; }
</style>
<div class="box">
    <h1>Ihre Berechnung</h1>
    <p>Kaufpreis: <?php echo $_smarty_tpl->getValue('Preis');?>
 €</p>
    <p>Eigenkapital: <?php echo $_smarty_tpl->getValue('EK');?>
 €</p>
    <hr>
    <h2><?php echo $_smarty_tpl->getValue('Ergebnis');?>
123</h2>
</div><?php }
}
