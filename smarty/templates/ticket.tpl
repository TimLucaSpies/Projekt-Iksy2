{extends file="base.tpl"}

{block name="inhalt"}

<style>
    .ticket-wrapper {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .ticket-card {
        display: flex;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0,75,157,0.15);
        border: 1px solid var(--s04-grau-mid);
        max-width: 750px;
    }

    /* Linker blauer Streifen */
    .ticket-left {
        background: var(--s04-blau);
        color: var(--s04-weiss);
        padding: 1.5rem 1.25rem;
        min-width: 180px;
        max-width: 180px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
    }
    .ticket-left .club {
        font-family: 'Barlow Condensed', sans-serif;
        font-weight: 800;
        font-size: 1.1rem;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        border-bottom: 1px solid rgba(255,255,255,0.3);
        padding-bottom: 0.5rem;
        margin-bottom: 0.5rem;
        width: 100%;
    }
    .ticket-left .matchup {
        font-family: 'Barlow Condensed', sans-serif;
        font-weight: 700;
        font-size: 0.95rem;
        line-height: 1.3;
        margin-bottom: 0.5rem;
    }
    .ticket-left .datum {
        font-size: 0.82rem;
        opacity: 0.85;
    }
    .ticket-left .preis {
        margin-top: 0.75rem;
        font-family: 'Barlow Condensed', sans-serif;
        font-weight: 800;
        font-size: 1.4rem;
        border-top: 1px solid rgba(255,255,255,0.3);
        padding-top: 0.5rem;
        width: 100%;
    }

    /* Gestrichelter Trennstrich */
    .ticket-sep {
        width: 2px;
        background: repeating-linear-gradient(
            to bottom,
            var(--s04-grau-mid) 0px,
            var(--s04-grau-mid) 6px,
            transparent 6px,
            transparent 12px
        );
        flex-shrink: 0;
    }

    /* Rechter Bereich */
    .ticket-right {
        background: var(--s04-weiss);
        padding: 1.5rem 1.5rem 1.5rem 1.25rem;
        flex: 1;
        display: flex;
        gap: 1.25rem;
        align-items: center;
    }
    .ticket-details { flex: 1; }
    .ticket-nr {
        font-size: 0.78rem;
        color: #aaa;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        margin-bottom: 0.5rem;
    }
    .ticket-spiel {
        font-family: 'Barlow Condensed', sans-serif;
        font-weight: 800;
        font-size: 1.15rem;
        color: var(--s04-blau);
        text-transform: uppercase;
        margin-bottom: 0.5rem;
    }
    .ticket-info-row {
        display: flex;
        gap: 0.4rem;
        flex-wrap: wrap;
        margin-bottom: 0.25rem;
    }
    .ticket-badge {
        background: var(--s04-blau-hell);
        color: var(--s04-blau);
        font-size: 0.8rem;
        font-weight: 600;
        padding: 2px 10px;
        border-radius: 50px;
    }
    .ticket-kat {
        font-size: 0.85rem;
        color: #5a7aaa;
        margin-top: 0.3rem;
    }
    .ticket-hint {
        font-size: 0.75rem;
        color: #aaa;
        margin-top: 0.75rem;
        font-style: italic;
    }

    /* QR-Code Box */
    .ticket-qr {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.4rem;
        flex-shrink: 0;
    }
    .ticket-qr img {
        width: 90px;
        height: 90px;
        border: 2px solid var(--s04-grau-mid);
        border-radius: 4px;
    }
    .ticket-qr span {
        font-size: 0.72rem;
        color: #aaa;
        text-transform: uppercase;
        letter-spacing: 0.06em;
    }

    @media (max-width: 600px) {
        .ticket-card { flex-direction: column; }
        .ticket-left { max-width: 100%; min-width: 0; }
        .ticket-sep  { width: 100%; height: 2px;
            background: repeating-linear-gradient(to right,
                var(--s04-grau-mid) 0px, var(--s04-grau-mid) 6px,
                transparent 6px, transparent 12px);
        }
    }
</style>

<!-- Erfolgsmeldung -->
<div class="alert-s04-erfolg mb-4" style="display:flex;align-items:center;gap:0.75rem;">
    <span style="font-size:1.5rem;">&#10003;</span>
    <div>
        <strong>Kauf erfolgreich!</strong>
        Deine Tickets wurden reserviert. Bitte zeige den QR-Code beim Einlass vor.
    </div>
</div>

<div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
    <div class="page-heading mb-0">Deine Tickets</div>
    <a href="ticket.php?ids={$ids}&pdf=1" class="btn-s04" style="border-radius:4px;font-size:0.92rem;">
        &#128196; Als PDF herunterladen
    </a>
</div>

<div class="ticket-wrapper">
{foreach $tickets as $ticket}
<div class="ticket-card">

    <!-- Linker Bereich -->
    <div class="ticket-left">
        <div class="club">FC Schalke 04</div>
        <div class="matchup">
            {if $ticket.heim_auswaerts === 'Heim'}
                FC Schalke 04<br>vs.<br>{$ticket.gegner|escape}
            {else}
                {$ticket.gegner|escape}<br>vs.<br>FC Schalke 04
            {/if}
        </div>
        <div class="datum">&#128197; {$ticket.datum|date_format:"%d.%m.%Y"}</div>
        <div class="preis">
            {$ticket.preis_bezahlt|default:$ticket.preis|string_format:"%.2f"|replace:'.':','} €
        </div>
    </div>

    <!-- Trennstrich -->
    <div class="ticket-sep"></div>

    <!-- Rechter Bereich -->
    <div class="ticket-right">
        <div class="ticket-details">
            <div class="ticket-nr">
                Ticket-Nr: S04-{$ticket.bestellungID|string_format:"%06d"}
            </div>
            <div class="ticket-spiel">
                {if $ticket.heim_auswaerts === 'Heim'}
                    FC Schalke 04 vs. {$ticket.gegner|escape}
                {else}
                    {$ticket.gegner|escape} vs. FC Schalke 04
                {/if}
            </div>
            <div class="ticket-info-row">
                <span class="ticket-badge">Block {$ticket.block|escape}</span>
                <span class="ticket-badge">Reihe {$ticket.reihe}</span>
                <span class="ticket-badge">Platz {$ticket.platz}</span>
            </div>
            <div class="ticket-kat">{$ticket.kategorie|escape} &nbsp;|&nbsp; Veltins-Arena</div>
            <div class="ticket-hint">
                Personengebunden · Nicht übertragbar · QR-Code beim Einlass vorzeigen
            </div>
        </div>

        <!-- QR-Code -->
        <div class="ticket-qr">
            <img src="https://api.qrserver.com/v1/create-qr-code/?size=90x90&data={$ticket.qr_inhalt|escape:'url'}"
                 alt="QR-Code Ticket {$ticket.bestellungID}">
            <span>Scan Einlass</span>
        </div>
    </div>

</div>
{/foreach}
</div>

<div class="d-flex gap-2 flex-wrap">
    <a href="spielplan.php" class="btn-s04-outline" style="border-radius:4px;">
        Weitere Tickets kaufen
    </a>
    <a href="meine_bestellungen.php" class="btn-s04-outline" style="border-radius:4px;">
        Alle Bestellungen anzeigen
    </a>
</div>

{/block}
