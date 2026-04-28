{extends file="base.tpl"}

{block name="inhalt"}

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

                {if isset($fehler) && $fehler}
                <div class="alert-s04-fehler mb-3">
                    <ul class="mb-0 ps-3">
                        {foreach $fehler as $f}
                        <li>{$f|escape}</li>
                        {/foreach}
                    </ul>
                </div>
                {/if}

                <form method="POST" action="{$PHP_SELF|escape}" enctype="multipart/form-data">
                    <input type="hidden" name="csrfToken" value="{$csrfToken|escape}">

                    <div class="row g-3 mb-3">
                        <div class="col-6">
                            <label for="vorname" class="form-label">Vorname</label>
                            <input type="text" class="form-control" id="vorname" name="vorname"
                                value="{$vorname|default:''|escape}" required maxlength="80" placeholder="Max">
                        </div>
                        <div class="col-6">
                            <label for="nachname" class="form-label">Nachname</label>
                            <input type="text" class="form-control" id="nachname" name="nachname"
                                value="{$nachname|default:''|escape}" required maxlength="80" placeholder="Mustermann">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">E-Mail-Adresse</label>
                        <input type="email" class="form-control" id="email" name="email"
                            value="{$email|default:''|escape}" required maxlength="150" placeholder="deine@email.de">
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

{/block}
