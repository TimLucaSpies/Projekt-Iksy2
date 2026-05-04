{extends file="base.tpl"}

{block name="inhalt"}

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
    .logout-card .card-s04 {
        background: rgba(255, 255, 255, 0.93);
        backdrop-filter: blur(4px);
    }
</style>

<div class="row justify-content-center w-100">
    <div class="logout-card" style="width:100%; max-width:480px;">
        <div class="card-s04">
            <div class="card-header text-center">
                Auf Wiedersehen!
            </div>
            <div class="card-body p-4 text-center">

                <!-- Wappen -->
                <img src="images/Schalke_04.png" alt="FC Schalke 04"
                     style="height:80px; margin-bottom:1.25rem;">

                <!-- Abschiedstext -->
                <h2 style="
                    font-family: 'Barlow Condensed', sans-serif;
                    font-weight: 700;
                    font-size: 1.4rem;
                    color: var(--s04-blau);
                    margin-bottom: 0.5rem;
                ">Tschüss, {$vorname}!</h2>

                <p style="color:#5a7aaa; font-size:0.97rem; margin-bottom:1.75rem;">
                    Du wurdest erfolgreich abgemeldet.<br>
                    Wir freuen uns, dich bald wieder auf dem Schalke-Ticket-Portal begrüßen zu dürfen.<br><br>
                    <strong style="color:var(--s04-blau);">Glück Auf!</strong>
                </p>

                <!-- Login-Button -->
                <a href="login.php" class="btn-s04 w-100 text-center d-block"
                   style="border-radius:4px; font-size:1rem;">
                    Erneut anmelden
                </a>

            </div>
        </div>
    </div>
</div>

{/block}
