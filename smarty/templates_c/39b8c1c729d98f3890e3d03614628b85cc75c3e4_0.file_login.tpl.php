<?php
/* Smarty version 5.7.0, created on 2026-04-28 12:48:52
  from 'file:login.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.7.0',
  'unifunc' => 'content_69f0acb41ce4a9_98254071',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '39b8c1c729d98f3890e3d03614628b85cc75c3e4' => 
    array (
      0 => 'login.tpl',
      1 => 1777380526,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_69f0acb41ce4a9_98254071 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = '/home/iksy/iksy05/ProjektGruppe1/smarty/templates';
$_smarty_tpl->getInheritance()->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_197534163069f0acb41c99d2_35408597', "inhalt");
?>

<?php $_smarty_tpl->getInheritance()->endChild($_smarty_tpl, "base.tpl", $_smarty_current_dir);
}
/* {block "inhalt"} */
class Block_197534163069f0acb41c99d2_35408597 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = '/home/iksy/iksy05/ProjektGruppe1/smarty/templates';
?>


<div class="row justify-content-center">
<div style="width: 120%; max-width: 900px;">	
        <!-- S04 Logo-Block -->
        <div class="text-center mb-4">
		<img src="images/Schalke_04.png" alt="FC Schalke 04" style="height: 100px;margin-top: 20px; margin-bottom: 10px;">
        
    <style>
    body {
        background-image: url('images/Stadion.jpg');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
    }
    main.container {
        min-height: 80vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
}
</style>
        

        <div class="card card-s04">
            <div class="card-header">Anmelden</div>
            <div class="card-body p-4">

                <?php if ((true && ($_smarty_tpl->hasVariable('fehler') && null !== ($_smarty_tpl->getValue('fehler') ?? null))) && $_smarty_tpl->getValue('fehler')) {?>
                <div class="alert-s04-fehler mb-3">
                    <ul class="mb-0 ps-3">
                        <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('fehler'), 'f');
$foreach0DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('f')->value) {
$foreach0DoElse = false;
?>
                        <li><?php echo htmlspecialchars((string)$_smarty_tpl->getValue('f'), ENT_QUOTES, 'UTF-8', true);?>
</li>
                        <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
                    </ul>
                </div>
                <?php }?>

                <form method="POST" action="<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('PHP_SELF'), ENT_QUOTES, 'UTF-8', true);?>
">
                    <input type="hidden" name="csrfToken" value="<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('csrfToken'), ENT_QUOTES, 'UTF-8', true);?>
">

                    <div class="mb-3">
                        <label for="email" class="form-label">E-Mail-Adresse</label>
                        <input
                            type="email"
                            class="form-control"
                            id="email"
                            name="email"
                            value="<?php echo htmlspecialchars((string)(($tmp = $_smarty_tpl->getValue('email') ?? null)===null||$tmp==='' ? '' ?? null : $tmp), ENT_QUOTES, 'UTF-8', true);?>
"
                            required
                            autocomplete="email"
                            placeholder="deine@email.de"
                        >
                    </div>

                    <div class="mb-4">
                        <label for="passwort" class="form-label">Passwort</label>
                        <input
                            type="password"
                            class="form-control"
                            id="passwort"
                            name="passwort"
                            required
                            autocomplete="current-password"
                            placeholder="••••••••"
                        >
                    </div>

                    <button type="submit" class="btn-s04 w-100" style="border-radius:4px;">
                        Anmelden
                    </button>
                </form>

            </div>
        </div>

        <p class="text-center mt-3" style="color:white; font-size:0.93rem;">
            Noch kein Konto?
            <a href="registrierung.php" style="color:white; font-weight:600; text-decoration:none;">
                <u>Jetzt registrieren</u>
            </a>
        </p>

    </div>
</div>

<?php
}
}
/* {/block "inhalt"} */
}
