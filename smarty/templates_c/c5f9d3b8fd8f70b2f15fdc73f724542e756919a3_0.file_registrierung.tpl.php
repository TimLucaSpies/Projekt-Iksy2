<?php
/* Smarty version 5.7.0, created on 2026-04-28 12:50:04
  from 'file:registrierung.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.7.0',
  'unifunc' => 'content_69f0acfc6d15a4_95729585',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'c5f9d3b8fd8f70b2f15fdc73f724542e756919a3' => 
    array (
      0 => 'registrierung.tpl',
      1 => 1777380602,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_69f0acfc6d15a4_95729585 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = '/home/iksy/iksy05/ProjektGruppe1/smarty/templates';
$_smarty_tpl->getInheritance()->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_20635532669f0acfc6ccd98_82877115', "inhalt");
?>

<?php $_smarty_tpl->getInheritance()->endChild($_smarty_tpl, "base.tpl", $_smarty_current_dir);
}
/* {block "inhalt"} */
class Block_20635532669f0acfc6ccd98_82877115 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = '/home/iksy/iksy05/ProjektGruppe1/smarty/templates';
?>


<div class="row justify-content-center">
<div style="width: 100%; max-width: 600px;">
       <img src="images/Schalke_04.png" alt="FC Schalke 04" style="height: 100px; margin-top: 20px; margin-bottom: 10px; margin-left: 200px">
        
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
</style>

        <div class="card card-s04">
            <div class="card-header">Registrierung</div>
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
" enctype="multipart/form-data">
                    <input type="hidden" name="csrfToken" value="<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('csrfToken'), ENT_QUOTES, 'UTF-8', true);?>
">

                    <div class="row g-3 mb-3">
                        <div class="col-6">
                            <label for="vorname" class="form-label">Vorname</label>
                            <input type="text" class="form-control" id="vorname" name="vorname"
                                value="<?php echo htmlspecialchars((string)(($tmp = $_smarty_tpl->getValue('vorname') ?? null)===null||$tmp==='' ? '' ?? null : $tmp), ENT_QUOTES, 'UTF-8', true);?>
" required maxlength="80" placeholder="Max">
                        </div>
                        <div class="col-6">
                            <label for="nachname" class="form-label">Nachname</label>
                            <input type="text" class="form-control" id="nachname" name="nachname"
                                value="<?php echo htmlspecialchars((string)(($tmp = $_smarty_tpl->getValue('nachname') ?? null)===null||$tmp==='' ? '' ?? null : $tmp), ENT_QUOTES, 'UTF-8', true);?>
" required maxlength="80" placeholder="Mustermann">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">E-Mail-Adresse</label>
                        <input type="email" class="form-control" id="email" name="email"
                            value="<?php echo htmlspecialchars((string)(($tmp = $_smarty_tpl->getValue('email') ?? null)===null||$tmp==='' ? '' ?? null : $tmp), ENT_QUOTES, 'UTF-8', true);?>
" required maxlength="150" placeholder="deine@email.de">
                    </div>

                    <div class="mb-3">
                        <label for="passwort" class="form-label">Passwort</label>
                        <input type="password" class="form-control" id="passwort" name="passwort"
                            required minlength="8" placeholder="••••••••">
                        <div class="form-text" style="color:#5a7aaa;">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="passwortWdh" class="form-label">Passwort wiederholen</label>
                        <input type="password" class="form-control" id="passwortWdh" name="passwortWdh"
                            required placeholder="••••••••">
                    </div>

                    <!-- Profilbild Upload (optional) -->
                    <div class="mb-4">
                        <label class="form-label">Profilbild <span style="color:#5a7aaa;font-weight:400;">(optional)</span></label>
                        <label for="profilbild" class="upload-zone d-block">
                            <div class="upload-icon">&#128247;</div>
                            <div style="font-weight:500; color:var(--s04-blau);">Bild auswählen</div>
                            <div class="upload-hint">JPG, PNG oder WebP · max. 2 MB</div>
                            <input type="file" id="profilbild" name="
                                accept="image/jpeg,image/png,image/webp"
                                onchange="s04PreviewImage('profilbild','preview-img')">
                        </label>
                        <img id="preview-img" src="" alt="Vorschau">
                    </div>

                    <button type="submit" class="btn-s04 w-100" style="border-radius:4px;">
                        Konto erstellen
                    </button>
                </form>

            </div>
        </div>

        <p class="text-center mt-3" style="color:white; font-size:0.93rem;">
            Bereits registriert?
            <a href="login.php" style="color:white; font-weight:600; text-decoration:none;">
                <u>Jetzt anmelden</u>
            </a>
        </p>

    </div>
</div>

<?php
}
}
/* {/block "inhalt"} */
}
