{extends file="base.tpl"}

{block name="inhalt"}

<style>
    .warenkorb-item {
        background: var(--s04-weiss);
        border: 1px solid var(--s04-grau-mid);
        border-radius: 8px;
        padding: 1.1rem 1.4rem;
        margin-bottom: 0.85rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        flex-wrap: wrap;
    }
    .warenkorb-item:hover {
        box-shadow: 0 3px 12px rgba(0,75,157,0.1);
    }
    .item-info {
        flex: 1;
        min-width: 200px;
    }
    .item-spiel {
        font-family: 'Barlow Condensed', sans-serif;
        font-weight: 700;
        font-size: 1.1rem;
        color: var(--s04-blau);
        text-transform: uppercase;
    }
    .item-meta {
        font-size: 0.88rem;
        color: #5a7aaa;
        margin-top: 3px;
    }
    .item-preis {
        font-family: 'Barlow Condensed', sans-serif;
        font-weight: 800;
        font-size: 1.3rem;
        color: var(--s04-blau);
        white-space: nowrap;
    }
    .btn-entfernen {
        background: none;
        border: 1.5px solid var(--s04-grau-mid);
        color: #888;
        border-radius: 4px;
        padding: 0.3rem 0.75rem;
        font-size: 0.85rem;
        cursor: pointer;
        transition: all 0.2s;
    }
    .btn-entfernen:hover {
        border-color: #dc3545;
        color: #dc3545;
    }
    .summen-box {
        background: var(--s04-weiss);
        border: 1px solid var(--s04-grau-mid);
        border-radius: 8px;
        padding: 1.4rem;
    }
    .summen-zeile {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.4rem 0;
        font-size: 0.95rem;
    }
    .summen-zeile.gesamt {
        border-top: 2px solid var(--s04-blau);
        margin-top: 0.5rem;
        padding-top: 0.75rem;
        font-family: 'Barlow Condensed', sans-serif;
        font-weight: 800;
        font-size: 1.3rem;
        color: var(--s04-blau);
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

<div class="page-heading">Warenkorb</div>

{if isset($fehler) && $fehler}
<div class="alert-s04-fehler mb-3">
    <ul class="mb-0 ps-3">
        {foreach $fehler as $f}
        <li>{$f|escape}</li>
        {/foreach}
    </ul>
</div>
{/if}

{if isset($warenkorb) && $warenkorb}

<div class="row g-4">
    <div class="col-12 col-lg-8">

        {foreach $warenkorb as $index => $item}
        <div class="warenkorb-item">
            <div class="item-info">
                <div class="item-spiel">
                    {if $item.heim_auswaerts === 'Heim'}
                        FC Schalke 04 vs. {$item.gegner|escape}
                    {else}
                        {$item.gegner|escape} vs. FC Schalke 04
                    {/if}
                </div>
                <div class="item-meta">
                    &#128197; {$item.datum|date_format:"%d.%m.%Y"}
                    &nbsp;|&nbsp; Block {$item.block|escape},
                    Reihe {$item.reihe}, Platz {$item.platz}
                    &nbsp;|&nbsp; {$item.kategorie|escape}
                </div>
            </div>
            <div class="item-preis">
                {$item.preis|string_format:"%.2f"|replace:'.':','} €
            </div>
            <a href="warenkorb.php?aktion=entfernen&index={$index}"
               class="btn-entfernen">
                ✕ Entfernen
            </a>
        </div>
        {/foreach}

    </div>

    <div class="col-12 col-lg-4">
        <div class="summen-box">
            <div style="font-family:'Barlow Condensed',sans-serif; font-weight:700;
                        font-size:1rem; text-transform:uppercase; letter-spacing:0.05em;
                        color:var(--s04-blau); margin-bottom:0.75rem;">
                Zusammenfassung
            </div>

            {foreach $warenkorb as $item}
            <div class="summen-zeile">
                <span>Block {$item.block|escape}, Reihe {$item.reihe}, Platz {$item.platz}</span>
                <span>{$item.preis|string_format:"%.2f"|replace:'.':','} €</span>
            </div>
            {/foreach}

            <div class="summen-zeile gesamt">
                <span>Gesamt</span>
                <span>{$gesamtpreis} €</span>
            </div>

            <form method="POST" action="warenkorb.php" class="mt-3">
                <input type="hidden" name="aktion" value="kaufen">
                <input type="hidden" name="csrfToken" value="{$csrfToken|escape}">
                <button type="submit" class="btn-s04 w-100" style="border-radius:4px;">
                    Jetzt kaufen & Tickets erhalten
                </button>
            </form>

            <a href="spielplan.php" class="btn-s04-outline w-100 text-center d-block mt-2"
               style="border-radius:4px; font-size:0.9rem;">
                Weitere Tickets hinzufügen
            </a>
        </div>
    </div>
</div>

{else}
<div class="leer-box">
    <div style="font-size:2.5rem; margin-bottom:0.5rem;">&#128722;</div>
    <div style="font-family:'Barlow Condensed',sans-serif; font-weight:700;
                font-size:1.2rem; text-transform:uppercase;">
        Dein Warenkorb ist leer
    </div>
    <div style="margin-top:0.3rem; font-size:0.9rem;">
        Füge Tickets über den Spielplan hinzu.
    </div>
    <a href="spielplan.php" class="btn-s04 d-inline-block mt-3"
       style="border-radius:4px;">
        Zum Spielplan
    </a>
</div>
{/if}

{/block}
