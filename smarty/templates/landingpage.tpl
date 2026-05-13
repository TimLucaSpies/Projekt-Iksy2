{extends file="base.tpl"}

{block name="inhalt"}

<style>
    .hero {
        background: linear-gradient(135deg, var(--s04-blau) 60%, var(--s04-blau-d) 100%);
        color: var(--s04-weiss);
        border-radius: 10px;
        padding: 3rem 2.5rem;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
    }
    .hero::after {
        content: 'S04';
        position: absolute;
        right: -1rem;
        top: 50%;
        transform: translateY(-50%);
        font-family: 'Barlow Condensed', sans-serif;
        font-weight: 800;
        font-size: 10rem;
        color: rgba(255,255,255,0.05);
        pointer-events: none;
        line-height: 1;
    }
    .hero h1 {
        font-family: 'Barlow Condensed', sans-serif;
        font-weight: 800;
        font-size: 2.4rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 0.5rem;
    }
    .hero p {
        font-size: 1.05rem;
        opacity: 0.85;
        margin-bottom: 1.5rem;
    }

    /* Spielkarten */
    .spiel-card {
        background: var(--s04-weiss);
        border: 1px solid var(--s04-grau-mid);
        border-radius: 8px;
        padding: 1.25rem 1.5rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        transition: box-shadow 0.2s, transform 0.15s;
        margin-bottom: 0.85rem;
    }
    .spiel-card:hover {
        box-shadow: 0 4px 16px rgba(0,75,157,0.13);
        transform: translateY(-2px);
    }
    .spiel-badge {
        background: var(--s04-blau-hell);
        color: var(--s04-blau);
        font-family: 'Barlow Condensed', sans-serif;
        font-weight: 700;
        font-size: 0.8rem;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        padding: 3px 10px;
        border-radius: 50px;
        white-space: nowrap;
    }
    .spiel-gegner {
        font-family: 'Barlow Condensed', sans-serif;
        font-weight: 700;
        font-size: 1.2rem;
        color: var(--s04-dunkel);
    }
    .spiel-datum {
        font-size: 0.88rem;
        color: #5a7aaa;
        margin-top: 2px;
    }

    /* Extras */
    .extra-card {
        background: var(--s04-weiss);
        border: 1px solid var(--s04-grau-mid);
        border-radius: 8px;
        padding: 1.5rem;
        text-align: center;
        text-decoration: none;
        color: var(--s04-dunkel);
        display: block;
        transition: box-shadow 0.2s, transform 0.15s;
        height: 100%;
    }
    .extra-card:hover {
        box-shadow: 0 4px 16px rgba(0,75,157,0.13);
        transform: translateY(-2px);
        color: var(--s04-blau);
    }
    .extra-icon {
        font-size: 2.2rem;
        margin-bottom: 0.6rem;
        display: block;
    }
    .extra-title {
        font-family: 'Barlow Condensed', sans-serif;
        font-weight: 700;
        font-size: 1.1rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 0.3rem;
    }
    .extra-sub {
        font-size: 0.85rem;
        color: #5a7aaa;
    }

    /* Profil-Dropdown Überschreibung für Navbar */
    .profil-link {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .profil-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: rgba(255,255,255,0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.85rem;
        color: white;
        flex-shrink: 0;
    }

    .section-title {
        font-family: 'Barlow Condensed', sans-serif;
        font-weight: 800;
        font-size: 1.4rem;
        color: var(--s04-blau);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        border-left: 4px solid var(--s04-blau);
        padding-left: 0.7rem;
        margin-bottom: 1.1rem;
    }
</style>

<!-- Hero Banner -->
<div class="hero">
    <h1>Glück Auf, {$SESSION_vorname|escape}!</h1>
    <p>Sichere dir jetzt deine Tickets für die nächsten Heimspiele des FC Schalke 04.</p>
    <a href="#spiele" class="btn-s04" style="font-size:0.95rem;">
        Tickets kaufen &darr;
    </a>
</div>

<div class="row g-4">

    <!-- Linke Spalte: Spielplan -->
    <div class="col-12 col-lg-8">
        <div class="section-title" id="spiele">Nächste Spiele</div>

        {if isset($spiele) && $spiele}
            {foreach $spiele as $spiel}
            <div class="spiel-card">
                <div>
                    <div class="spiel-gegner">
                        {if $spiel.heim_auswaerts === 'Heim'}
                            FC Schalke 04 vs. {$spiel.gegner|escape}
                        {else}
                            {$spiel.gegner|escape} vs. FC Schalke 04
                        {/if}
                    </div>
                    <div class="spiel-datum">
                        {$spiel.datum|date_format:"%d.%m.%Y"}
                        &nbsp;|&nbsp;
                        <span class="spiel-badge">{$spiel.heim_auswaerts|escape}</span>
                    </div>
                </div>
                <a href="kauf.php?spiel_id={$spiel.id}"" class="btn-s04" style="white-space:nowrap;font-size:0.9rem;">
                    Ticket kaufen
                </a>
            </div>
            {/foreach}
        {else}
            <div class="card-s04">
                <div class="card-body p-4 text-center" style="color:#5a7aaa;">
                    Aktuell sind keine Spiele verfügbar.
                </div>
            </div>
        {/if}
    </div>

    <!-- Rechte Spalte: Extras + Profil -->
    <div class="col-12 col-lg-4">

        <!-- Profil-Box -->
        <div class="card-s04 mb-4">
            <div class="card-header">Mein Konto</div>
            <div class="card-body p-3">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div style="
                        width: 48px; height: 48px; border-radius: 50%;
                        background: var(--s04-blau);
                        color: white;
                        display: flex; align-items: center; justify-content: center;
                        font-family: 'Barlow Condensed', sans-serif;
                        font-weight: 800; font-size: 1.2rem;
                    ">
                        {$SESSION_vorname|truncate:1:''|upper}{$SESSION_nachname|truncate:1:''|upper}
                    </div>
                    <div>
                        <div style="font-weight:600;">{$SESSION_vorname|escape} {$SESSION_nachname|escape}</div>
                        <div style="font-size:0.85rem; color:#5a7aaa;">{$SESSION_email|escape}</div>
                    </div>
                </div>
                <a href="mein_profil.php" class="btn-s04-outline w-100 text-center d-block" style="font-size:0.9rem;">
                    Profil anzeigen
                </a>
                <a href="meine_bestellungen.php" class="btn-s04-outline w-100 text-center d-block mt-2" style="font-size:0.9rem;">
                    Meine Bestellungen
                </a>
            </div>
        </div>

        <!-- Extras -->
        <div class="section-title">Mehr von S04</div>
        <div class="row g-3">
            <div class="col-6">
                <a href="https://www.schalke04.de" target="_blank" rel="noopener" class="extra-card">
                    <span class="extra-icon">&#127760;</span>
                    <div class="extra-title">Website</div>
                    <div class="extra-sub">schalke04.de</div>
                </a>
            </div>
            <div class="col-6">
                <a href="https://shop.schalke04.de" target="_blank" rel="noopener" class="extra-card">
                    <span class="extra-icon">&#128722;</span>
                    <div class="extra-title">Fanshop</div>
                    <div class="extra-sub">Trikots & Merchandise</div>
                </a>
            </div>
            <div class="col-6">
                <a href="https://www.instagram.com/s04" target="_blank" rel="noopener" class="extra-card">
                    <span class="extra-icon">&#128247;</span>
                    <div class="extra-title">Instagram</div>
                    <div class="extra-sub">@s04</div>
                </a>
            </div>
            <div class="col-6">
                <a href="https://www.youtube.com/@S04" target="_blank" rel="noopener" class="extra-card">
                    <span class="extra-icon">&#127897;</span>
                    <div class="extra-title">YouTube</div>
                    <div class="extra-sub">S04 TV</div>
                </a>
            </div>
        </div>

    </div>
</div>

{/block}
