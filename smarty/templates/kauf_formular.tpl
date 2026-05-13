<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>S04 Tickets – Kaufvorgang</title>
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@400;600;700;800&family=Barlow:wght@400;500&display=swap" rel="stylesheet">
    <style>
        {literal}
        :root {
            --blau:      #004B9D;
            --blau-d:    #003578;
            --blau-hell: #E8F0FA;
            --weiss:     #FFFFFF;
            --grau:      #F4F6F9;
            --grau-mid:  #D0D8E4;
            --dunkel:    #0D1B2A;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Barlow', sans-serif;
            background: url('{/literal}{$seitenbild}{literal}') no-repeat center center fixed;
            background-size: cover;
            color: var(--dunkel);
            min-height: 100vh;
        }

        /* Overlay für bessere Lesbarkeit über dem Stadionbild */
        body::before {
            content: "";
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(13, 27, 42, 0.7);
            z-index: -1;
        }

        header {
            background: var(--blau);
            padding: 0.75rem 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 2px 10px rgba(0,0,0,0.3);
        }
        header span {
            color: white;
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 1.4rem;
            font-weight: 800;
            text-transform: uppercase;
        }

        .seite { max-width: 1100px; margin: 2rem auto; padding: 0 1rem; }

        h1 {
            font-family: 'Barlow Condensed', sans-serif;
            font-weight: 800;
            font-size: 2.2rem;
            color: white;
            text-transform: uppercase;
            border-left: 6px solid var(--blau);
            padding-left: 1rem;
            margin-bottom: 1.5rem;
        }

        .layout { display: grid; grid-template-columns: 1fr 360px; gap: 1.5rem; }

        .karte {
            background: white;
            border-radius: 8px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            overflow: hidden;
        }
        .karte-header {
            background: var(--blau);
            color: white;
            font-family: 'Barlow Condensed', sans-serif;
            font-weight: 700;
            padding: 0.75rem 1.25rem;
            text-transform: uppercase;
        }
        .karte-body { padding: 1.5rem; }

        #stadion-svg { width: 100%; height: auto; }
        .sektor { transition: all 0.2s; cursor: pointer; opacity: 0.8; }
        .sektor:hover { opacity: 1; filter: brightness(1.2); }
        .sektor.aktiv { opacity: 1; filter: brightness(1.3); stroke: #fff; stroke-width: 2; }
        .sektor.ausverkauft { cursor: not-allowed; fill: #555 !important; opacity: 0.5; }

        .preis-wert { font-family: 'Barlow Condensed', sans-serif; font-size: 2.4rem; font-weight: 800; color: var(--blau); }
        
        .f-select { width: 100%; padding: 0.8rem; border-radius: 4px; border: 1px solid var(--grau-mid); font-size: 1rem; margin-top: 0.5rem; }
        
        .btn-haupt { 
            width: 100%; padding: 1rem; background: var(--blau); color: white; border: none; 
            border-radius: 4px; font-weight: 700; cursor: pointer; text-transform: uppercase;
            font-size: 1.1rem; transition: background 0.2s;
        }
        .btn-haupt:hover { background: var(--blau-d); }
        .btn-haupt:disabled { background: var(--grau-mid); cursor: not-allowed; }
        
        .error-box { background: #fee2e2; color: #b91c1c; padding: 15px; border-radius: 6px; margin-bottom: 15px; border: 1px solid #f87171; }
        .success-box { background: #dcfce7; color: #15803d; padding: 15px; border-radius: 6px; margin-bottom: 15px; border: 1px solid #4ade80; text-align: center; }
        {/literal}
    </style>
</head>
<body>

<header>
    <div style="display: flex; align-items: center; gap: 15px;">
        <img src="{$wappen}" alt="S04" style="height: 40px;">
        <span>S04 TICKETING</span>
    </div>
    <span>Glückauf, {$vorname}!</span>
</header>

<div class="seite">
    <h1>Heimspiel vs. Borussia Dortmund</h1>

    <div class="layout">
        <div class="karte">
            <div class="karte-header">Wähle deinen Sektor in der Arena</div>
            <div class="karte-body">
                <svg id="stadion-svg" viewBox="0 0 700 500">
                    <defs>
                        <linearGradient id="rasen" x1="0" y1="0" x2="1" y2="1"><stop offset="0%" stop-color="#2e8b2e"/><stop offset="100%" stop-color="#2e8b2e"/></linearGradient>
                        <linearGradient id="grad-nord" x1="0" y1="0" x2="0" y2="1"><stop offset="0%" stop-color="#1a5fb4"/><stop offset="100%" stop-color="#004B9D"/></linearGradient>
                        <linearGradient id="grad-sued" x1="0" y1="1" x2="0" y2="0"><stop offset="0%" stop-color="#1a5fb4"/><stop offset="100%" stop-color="#004B9D"/></linearGradient>
                    </defs>

                    <ellipse cx="350" cy="250" rx="340" ry="238" fill="#1a2a3a"/>
                    
                    <path class="sektor" id="sek-nordkurve" d="M 55,28 C 150,10 550,10 645,28 L 560,118 C 480,108 220,108 140,118 Z" fill="url(#grad-nord)" data-id="1" data-name="Nordkurve" data-preis="17.50" />
                    <path class="sektor" id="sek-suedkurve" d="M 140,382 C 220,392 480,392 560,382 L 645,472 C 550,490 150,490 55,472 Z" fill="url(#grad-sued)" data-id="2" data-name="Südkurve" data-preis="17.50" />
                    <path class="sektor" id="sek-haupt" d="M 18,75 C 35,50 70,35 100,28 L 140,118 L 140,382 L 100,472 C 70,465 35,450 18,425 Z" fill="#003578" data-id="3" data-name="Haupttribüne" data-preis="58.00" />
                    <path class="sektor" id="sek-gegen" d="M 600,28 C 630,35 665,50 682,75 L 682,425 C 665,450 630,465 600,472 L 560,382 L 560,118 Z" fill="#1558a8" data-id="4" data-name="Gegentribüne" data-preis="35.00" />
                    
                    <rect x="140" y="118" width="420" height="264" rx="14" fill="url(#rasen)"/>
                    <text x="350" y="255" text-anchor="middle" font-family="'Barlow Condensed',sans-serif" font-size="22" font-weight="800" fill="rgba(255,255,255,0.15)">VELTINS-ARENA</text>
                </svg>
            </div>
        </div>

        <div class="karte">
            <div class="karte-header">Deine Auswahl</div>
            <div class="karte-body">
                {if $fehler}<div class="error-box">{foreach from=$fehler item=f}<p>{$f}</p>{/foreach}</div>{/if}
                {if $erfolg}
                    <div class="success-box">
                        <h3>Glückauf!</h3>
                        <p>Deine Tickets wurden erfolgreich gebucht.</p>
                        <br>
                        <a href="index.php" class="btn-haupt" style="text-decoration:none; display:block;">Zurück</a>
                    </div>
                {else}
                    <div id="panel-leer" style="text-align:center; padding: 20px; color: #666;">
                        <p>Klicke auf einen Sektor im Plan, um Plätze zu wählen.</p>
                    </div>

                    <form action="kauf.php" method="post" id="panel-inhalt" style="display:none;">
                        <input type="hidden" name="csrfToken" value="{$csrfToken}">
                        <input type="hidden" id="input-sektor-id" name="sektor_id">
                        
                        <h2 id="p-name" style="color:var(--blau); margin-bottom: 15px;"></h2>
                        
                        <div style="background: var(--blau-hell); padding: 1rem; border-radius: 6px; margin-bottom: 1.5rem;">
                            <div style="font-size: 0.85rem; color: #5a7aaa;">Einzelpreis</div>
                            <div class="preis-wert" id="p-preis">0,00 €</div>
                        </div>

                        <label style="font-weight: 600;">Anzahl Tickets:</label>
                        <select class="f-select" id="anzahl-select" name="anzahl">
                            <option value="">-- wählen --</option>
                            {for $i=1 to 5}<option value="{$i}">{$i}</option>{/for}
                        </select>

                        <div style="margin: 1.5rem 0; border-top: 1px solid #eee; padding-top: 1rem;">
                            <div style="font-size: 0.85rem; color: #5a7aaa;">Gesamtbetrag:</div>
                            <div id="p-gesamt" style="font-size: 1.8rem; font-weight: 800; color: var(--blau);">0,00 €</div>
                        </div>

                        <button type="submit" class="btn-haupt" id="btn-kaufen" disabled>JETZT ZAHLUNGSPFLICHTIG BUCHEN</button>
                    </form>
                {/if}
            </div>
        </div>
    </div>
</div>

{literal}
<script>
    let aktivPreis = 0;
    const sektoren = document.querySelectorAll('.sektor');
    const panelLeer = document.getElementById('panel-leer');
    const panelInhalt = document.getElementById('panel-inhalt');
    const inputSektor = document.getElementById('input-sektor-id');
    const anzahlSelect = document.getElementById('anzahl-select');
    const btnKaufen = document.getElementById('btn-kaufen');

    sektoren.forEach(s => {
        s.addEventListener('click', function() {
            sektoren.forEach(el => el.classList.remove('aktiv'));
            this.classList.add('aktiv');

            aktivPreis = parseFloat(this.dataset.preis);
            inputSektor.value = this.dataset.id;
            document.getElementById('p-name').textContent = this.dataset.name;
            document.getElementById('p-preis').textContent = aktivPreis.toFixed(2).replace('.', ',') + ' €';

            panelLeer.style.display = 'none';
            panelInhalt.style.display = 'block';
            updateGesamt();
        });
    });

    anzahlSelect.addEventListener('change', updateGesamt);

    function updateGesamt() {
        const anzahl = parseInt(anzahlSelect.value) || 0;
        if (anzahl > 0) {
            const gesamt = aktivPreis * anzahl;
            document.getElementById('p-gesamt').textContent = gesamt.toFixed(2).replace('.', ',') + ' €';
            btnKaufen.disabled = false;
        } else {
            document.getElementById('p-gesamt').textContent = '0,00 €';
            btnKaufen.disabled = true;
        }
    }
</script>
{/literal}
</body>
</html>