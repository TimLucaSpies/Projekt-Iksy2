{extends file="base.tpl"}

{block name="inhalt"}

<style>
    .bestellung-card {
        background: var(--s04-weiss);
        border: 1px solid var(--s04-grau-mid);
        border-radius: 8px;
        overflow: hidden;
        margin-bottom: 1rem;
        box-shadow: 0 2px 8px rgba(0,75,157,0.06);
        transition: box-shadow 0.2s;
    }
    .bestellung-card:hover {
        box-shadow: 0 4px 16px rgba(0,75,157,0.12);
    }
    .bestellung-header {
        background: var(--s04-blau);
        color: var(--s04-weiss);
        padding: 0.7rem 1.25rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 0.5rem;
    }
    .bestellung-header .spiel {
        font-family: 'Barlow Condensed', sans-serif;
        font-weight: 700;
        font-size: 1.05rem;
        text-transform: uppercase;
        letter-spacing: 0.04em;
    }
    .bestellung-header .datum-badge {
        background: rgba(255,255,255,0.2);
        font-size: 0.8rem;
        font-weight: 600;
        padding: 3px 10px;
        border-radius: 50px;
    }
    .bestellung-body {
        padding: 1rem 1.25rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 0.75rem;
    }
    .bestellung-detail {
        font-size: 0.9rem;
        color: var(--s04-dunkel);
    }
    .bestellung-detail span {
        display: inline-block;
        background: var(--s04-blau-hell);
        color: var(--s04-blau);
        font-weight: 600;
        font-size: 0.8rem;
        padding: 2px 10px;
        border-radius: 50px;
        margin-right: 0.3rem;
        margin-top: 0.3rem;
    }
    .bestellung-preis {
        font-family: 'Barlow Condensed', sans-serif;
        font-weight: 800;
        font-size: 1.2rem;
        color: var(--s04-blau);
        white-space: nowrap;
    }
    .leer-box {
        text-align: center;
        padding: 3rem;
        background: var(--s04-weiss);
        border: 1px solid var(--s04-grau-mid);
        border-radius: 8px;
        color: #5a7aaa;
    }
</style>

<div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
    <div class="page-heading mb-0">Meine Bestellungen</div>
    {if isset($bestellungen) && $bestellungen}
    <div style="font-size:0.9rem;color:#5a7aaa;">
        {$bestellungen|count} Ticket{if $bestellungen|count != 1}s{/if} insgesamt
    </div>
    {/if}
</div>

{if isset($bestellungen) && $bestellungen}

{foreach $bestellungen as $b}
<div class="bestellung-card">
    <div class="bestellung-header">
        <div class="spiel">
            {if $b.heim_auswaerts === 'Heim'}
                FC Schalke 04 vs. {$b.gegner|escape}
            {else}
                {$b.gegner|escape} vs. FC Schalke 04
            {/if}
        </div>
        <span class="datum-badge">
            &#128197; {$b.datum|date_format:"%d.%m.%Y"}
        </span>
    </div>
    <div class="bestellung-body">
        <div class="bestellung-detail">
            <span>Block {$b.block|escape}</span>
            <span>Reihe {$b.reihe}</span>
            <span>Platz {$b.platz}</span>
            <span>{$b.kategorie|escape}</span>
            <br>
            <span style="background:transparent;color:#5a7aaa;padding:0;font-weight:400;font-size:0.82rem;">
                Bestellt am: {$b.bestellt_am|date_format:"%d.%m.%Y %H:%M"}
                &nbsp;|&nbsp; Ticket-Nr: S04-{$b.id|string_format:"%06d"}
            </span>
        </div>
        <div class="d-flex align-items-center gap-3">
            <div class="bestellung-preis">
                {$b.preis_bezahlt|default:"–"|string_format:"%.2f"|replace:'.':','} €
            </div>
            <a href="ticket.php?ids={$b.id}"
               class="btn-s04-outline" style="border-radius:4px;font-size:0.85rem;">
                Ticket anzeigen
            </a>
        </div>
    </div>
</div>
{/foreach}

{else}
<div class="leer-box">
    <div style="font-size:2.5rem;margin-bottom:0.5rem;">&#127923;</div>
    <div style="font-family:'Barlow Condensed',sans-serif;font-weight:700;
                font-size:1.2rem;text-transform:uppercase;">
        Noch keine Tickets gekauft
    </div>
    <div style="margin-top:0.3rem;font-size:0.9rem;">
        Schau dir unsere kommenden Spiele an!
    </div>
    <a href="spielplan.php" class="btn-s04 d-inline-block mt-3" style="border-radius:4px;">
        Zum Spielplan
    </a>
</div>
{/if}

{/block}
