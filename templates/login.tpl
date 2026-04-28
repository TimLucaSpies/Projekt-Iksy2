{extends file="base.tpl"}

{block name="inhalt"}

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

                {if isset($fehler) && $fehler}
                <div class="alert-s04-fehler mb-3">
                    <ul class="mb-0 ps-3">
                        {foreach $fehler as $f}
                        <li>{$f|escape}</li>
                        {/foreach}
                    </ul>
                </div>
                {/if}

                <form method="POST" action="{$PHP_SELF|escape}">
                    <input type="hidden" name="csrfToken" value="{$csrfToken|escape}">

                    <div class="mb-3">
                        <label for="email" class="form-label">E-Mail-Adresse</label>
                        <input
                            type="email"
                            class="form-control"
                            id="email"
                            name="email"
                            value="{$email|default:''|escape}"
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

{/block}
