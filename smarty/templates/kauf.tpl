{extends file="base.tpl"}

{block name="inhalt"}

<style>
    .booking-container {
        display: flex;
        align-items: flex-start;
        gap: 30px;
        margin-top: 1.5rem;
    }
    .form-section {
        flex: 1;
        max-width: 450px;
    }
    .map-section {
        flex: 1.2;
        background: var(--s04-weiss);
        border: 1px solid var(--s04-grau-mid);
        border-radius: 8px;
        padding: 20px;
        text-align: center;
        box-shadow: 0 2px 10px rgba(0,75,157,0.07);
    }
    .stadion-bild {
        max-width: 100%;
        height: auto;
        border-radius: 4px;
        transition: transform 0.3s ease;
    }
    .price-display {
        margin-top: 15px;
        padding: 15px;
        background: var(--s04-blau);
        color: white;
        border-radius: 4px;
        text-align: center;
    }
    .price-value {
        display: block;
        font-size: 2rem;
        font-weight: bold;
    }
    .form-select-s04 {
        display: block;
        width: 100%;
        padding: 0.6rem;
        border-radius: 4px;
        border: 1px solid #ced4da;
        font-family: 'Barlow', sans-serif;
    }
    .form-select-s04:focus {
        border-color: var(--s04-blau);
        outline: none;
        box-shadow: 0 0 0 0.2rem rgba(0,75,157,0.15);
    }

    /* Spiel-Info Banner */
    .spiel-info-banner {
        background: var(--s04-blau);
        color: var(--s04-weiss);
        border-radius: 8px;
        padding: 1.25rem 1.5rem;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 0.75rem;
    }
    .spiel-info-banner .matchup {
        font-family: 'Barlow Condensed', sans-serif;
        font-weight: 800;
        font-size: 1.4rem;
        text-transform: uppercase;
        letter-spacing: 0.04em;
    }
    .spiel-info-banner .meta {
        font-size: 0.9rem;
        opacity: 0.85;
        margin-top: 0.2rem;
    }
    .spiel-info-banner .heim-badge {
        background: rgba(255,255,255,0.2);
        font-size: 0.8rem;
        font-weight: 600;
        padding: 4px 12px;
        border-radius: 50px;
        letter-spacing: 0.05em;
        white-space: nowrap;
    }

    /* Block-Overlay unter Stadionbild */
    #block-overlay {
        color: var(--s04-blau);
        margin-top: 12px;
        font-family: 'Barlow Condensed', sans-serif;
        font-weight: 700;
        font-size: 1.1rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        min-height: 1.5rem;
    }

    @media (max-width: 768px) {
        .booking-container {
            flex-direction: column;
        }
        .form-section {
            max-width: 100%;
            width: 100%;
        }
        .map-section {
            width: 100%;
        }
    }
</style>

<!-- Spiel-Info Banner -->
<div class="spiel-info-banner">
    <div>
        <div class="matchup">
            {if $spiel.heim_auswaerts === 'Heim'}
                FC Schalke 04 vs. {$spiel.gegner|escape}
            {else}
                {$spiel.gegner|escape} vs. FC Schalke 04
            {/if}
        </div>
        <div class="meta">
            &#128197; {$spiel.datum|date_format:"%d.%m.%Y"}
            &nbsp;|&nbsp; &#127968; Veltins-Arena
        </div>
    </div>
    <span class="heim-badge">{$spiel.heim_auswaerts|escape}</span>
</div>

<div class="booking-container">

    <!-- Linke Seite: Formular -->
    <div class="form-section">
        <div class="card card-s04">
            <div class="card-header">Sitzplatz wählen</div>
            <div class="card-body p-4">

                {if isset($fehler) && $fehler|@count > 0}
                <div class="alert-s04-fehler mb-3">
                    <ul class="mb-0 ps-3">
                        {foreach from=$fehler item=f}
                        <li>{$f|escape}</li>
                        {/foreach}
                    </ul>
                </div>
                {/if}

                {if isset($plaetze) && $plaetze}
                <form method="POST" action="{$PHP_SELF|escape}?spiel_id={$spielID}" id="ticketForm">
                    <input type="hidden" name="csrfToken" value="{$csrfToken|escape}">
                    <input type="hidden" name="spiel_id" value="{$spielID}">

                    <div class="mb-3">
                        <label class="form-label">Block / Sitzplatz</label>
                        <select name="arena_id" id="arena_select" class="form-select-s04"
                                required onchange="updateView()">
                            <option value="" data-preis="0.00" data-block="none">
                                -- Platz wählen --
                            </option>
                            {foreach from=$plaetze item=platz}
                            <option value="{$platz.id}"
                                    data-preis="{$platz.preis}"
                                    data-block="{$platz.block}"
                                    data-kat="{$platz.beschreibung|escape}">
                                Block {$platz.block|escape},
                                Reihe {$platz.reihe},
                                Platz {$platz.platz}
                                – {$platz.beschreibung|escape}
                                ({$platz.preis|string_format:"%.2f"} €)
                            </option>
                            {/foreach}
                        </select>
                    </div>

                    <!-- Preisanzeige -->
                    <div class="price-display">
                        <span style="font-size:0.85rem; text-transform:uppercase; opacity:0.85;">
                            Gesamtpreis
                        </span>
                        <span class="price-value" id="dynamic-price">0,00 €</span>
                    </div>

                    <button type="submit" name="kaufen"
                            class="btn-s04 w-100 mt-4 mb-2"
                            style="border-radius:4px;">
                        Verbindlich kaufen
                    </button>

                    <div class="text-center mt-2">
                        <a href="spielplan.php"
                           style="color:var(--s04-blau); text-decoration:none; font-size:0.85rem;">
                            Vorgang abbrechen
                        </a>
                    </div>
                </form>

                {else}
                <div class="text-center" style="padding:1.5rem 0; color:#5a7aaa;">
                    <div style="font-size:2rem; margin-bottom:0.5rem;">&#127923;</div>
                    <div style="font-family:'Barlow Condensed',sans-serif; font-weight:700;
                                font-size:1.1rem; text-transform:uppercase; color:var(--s04-blau);">
                        Keine Plätze verfügbar
                    </div>
                    <div style="margin-top:0.3rem; font-size:0.9rem;">
                        Für dieses Spiel sind leider keine Plätze mehr frei.
                    </div>
                    <a href="spielplan.php" class="btn-s04 d-inline-block mt-3"
                       style="border-radius:4px; font-size:0.9rem;">
                        Zurück zum Spielplan
                    </a>
                </div>
                {/if}

            </div>
        </div>
    </div>

    <!-- Rechte Seite: Stadionplan -->
    <div class="map-section">
        <div style="font-family:'Barlow Condensed',sans-serif; font-weight:700;
                    font-size:1rem; text-transform:uppercase; letter-spacing:0.06em;
                    color:var(--s04-blau); margin-bottom:12px;">
            Veltins-Arena – Blockplan
        </div>
        <img src="images/Stadion_Plan.webp" alt="Stadionplan"
             class="stadion-bild" id="stadionImage">
        <div id="block-overlay">Wähle einen Block für Details</div>
    </div>

</div>

<script>
function updateView() {
    const select  = document.getElementById('arena_select');
    const opt     = select.options[select.selectedIndex];

    const preis = opt.getAttribute('data-preis') || '0';
    document.getElementById('dynamic-price').innerText =
        parseFloat(preis).toFixed(2).replace('.', ',') + ' €';

    const block = opt.getAttribute('data-block');
    const kat   = opt.getAttribute('data-kat') || '';
    const info  = document.getElementById('block-overlay');
    const img   = document.getElementById('stadionImage');

    if (block && block !== 'none') {
        info.innerText = 'Block ' + block + (kat ? ' – ' + kat : '');
        img.style.transform = 'scale(1.02)';
        img.style.filter    = 'brightness(1.08) saturate(1.15)';
    } else {
        info.innerText      = 'Wähle einen Block für Details';
        img.style.transform = 'scale(1)';
        img.style.filter    = 'none';
    }
}
</script>

{/block}
