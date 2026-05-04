{extends file="base.tpl"} {block name="inhalt"}

<style>
.spielplan-grid {
	display: grid;
	grid-template-columns: repeat(auto-fill, minmax(410px, 1fr));
	gap: 1.25rem;
}

/* Teamlogos */
.team-logo {
    width: 60px;           /* Breite */
    height: 60px;          /* Höhe */
    object-fit: contain;    /* Proportional skalieren */
    display: block;         /* zentrieren */
    margin: 0 auto 0.3rem auto; /* Abstand unter dem Logo */
}

/* Spiel-Metadaten (Datum & Stadion) */
.spiel-meta {
    display: flex;
    flex-direction: column;  /* Datum und Stadion untereinander */
    gap: 0.3rem;             /* Abstand zwischen den Zeilen */
    font-size: 0.88rem;
    color: #5a7aaa;
    padding-top: 0.5rem;
    border-top: 1px solid var(--s04-grau-mid);
}
.spiel-meta span {
    display: flex;
    align-items: center;
    gap: 0.3rem;  /* Abstand zwischen Icon und Text */
}

/* VS Trennung */
.spiel-vs {
    font-family: 'Barlow Condensed', sans-serif;
    font-weight: 800;
    font-size: 1rem;
    color: var(--s04-grau-mid);
    padding: 0 0.5rem;
}

.wettbewerb-logo {
	height: 35px; /* Höhe des Logos anpassen */
	object-fit: contain; /* Proportional skalieren */
}

.spiel-card {
	background: var(--s04-weiss);
	border: 1px solid var(--s04-grau-mid);
	border-radius: 10px;
	overflow: hidden;
	box-shadow: 0 2px 10px rgba(0, 75, 157, 0.07);
	transition: box-shadow 0.2s, transform 0.15s;
	display: flex;
	flex-direction: column;
}

.spiel-card:hover {
	box-shadow: 0 6px 20px rgba(0, 75, 157, 0.15);
	transform: translateY(-3px);
}

.spiel-card-header {
	background: var(--s04-blau);
	color: var(--s04-weiss);
	padding: 0.75rem 1.25rem;
	display: flex;
	align-items: center;
	justify-content: space-between;
}

.spiel-card-header .wettbewerb {
	font-family: 'Barlow Condensed', sans-serif;
	font-weight: 700;
	font-size: 0.85rem;
	letter-spacing: 0.08em;
	text-transform: uppercase;
	opacity: 0.9;
}

.spiel-card-header .heim-badge {
	font-size: 0.75rem;
	font-weight: 600;
	padding: 3px 10px;
	border-radius: 50px;
	background: rgba(255, 255, 255, 0.2);
	letter-spacing: 0.05em;
}

.spiel-card-body {
	padding: 1.25rem 1.5rem;
	flex-grow: 1;
	display: flex;
	flex-direction: column;
	gap: 0.75rem;
}

.spiel-matchup {
	display: flex;
	align-items: center;
	justify-content: space-between;
	gap: 0.5rem;
}

.spiel-team {
    font-family: 'Barlow Condensed', sans-serif;
    font-weight: 700;
    font-size: 1.1rem;
    color: var(--s04-dunkel);
    text-align: center;
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: center;
    min-height: 110px;  /* gleiche Höhe für alle Teams */
}

.spiel-team.s04 {
	color: var(--s04-blau);
}

.spiel-vs {
	font-family: 'Barlow Condensed', sans-serif;
	font-weight: 800;
	font-size: 1rem;
	color: var(--s04-grau-mid);
	padding: 0 0.5rem;
}

.spiel-meta {
	display: flex;
	flex-direction: column;
	gap: 0.3rem;
	font-size: 0.88rem;
	color: #5a7aaa;
	padding-top: 0.5rem;
	border-top: 1px solid var(--s04-grau-mid);
}

.spiel-meta span {
	display: flex;
	align-items: center;
	gap: 0.3rem;
}

.spiel-card-footer {
	padding: 1rem 1.5rem;
	border-top: 1px solid var(--s04-grau-mid);
	background: var(--s04-grau);
}

/* Filter-Leiste */
.filter-bar {
	display: flex;
	gap: 0.6rem;
	flex-wrap: wrap;
	margin-bottom: 1.5rem;
}

.filter-btn {
	background: var(--s04-weiss);
	border: 1.5px solid var(--s04-grau-mid);
	color: var(--s04-dunkel);
	font-family: 'Barlow Condensed', sans-serif;
	font-weight: 600;
	font-size: 0.9rem;
	letter-spacing: 0.05em;
	text-transform: uppercase;
	padding: 0.35rem 1rem;
	border-radius: 50px;
	cursor: pointer;
	transition: all 0.2s;
}

.filter-btn:hover, .filter-btn.aktiv {
	background: var(--s04-blau);
	border-color: var(--s04-blau);
	color: var(--s04-weiss);
}

.keine-spiele {
	text-align: center;
	padding: 3rem;
	color: #5a7aaa;
	background: var(--s04-weiss);
	border-radius: 10px;
	border: 1px solid var(--s04-grau-mid);
}

@media ( max-width : 576px) {
	.spielplan-grid {
		grid-template-columns: 1fr;
	}
	.spiel-team {
		font-size: 0.95rem;
	}
}
</style>

<!-- Seitenüberschrift -->
<div
	class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
	<div class="page-heading mb-0">Spielplan</div>
	<div style="font-size: 0.9rem; color: #5a7aaa;">{if isset($spiele) &&
		$spiele} {$spiele|count} Spiel{if $spiele|count != 1}e{/if} gefunden
		{/if}</div>
</div>

<!-- Filter -->
<div class="filter-bar">
	<button class="filter-btn aktiv" onclick="filterSpiele('alle', this)">Alle</button>
	<button class="filter-btn" onclick="filterSpiele('Heim', this)">Heimspiele</button>
	<button class="filter-btn" onclick="filterSpiele('Auswärts', this)">Auswärtsspiele</button>
</div>

<!-- Spielkarten -->
{if isset($spiele) && $spiele}
<div class="spielplan-grid" id="spielplan-grid">
	{foreach $spiele as $spiel}
	<div class="spiel-card" data-typ="{$spiel.heim_auswaerts|escape}">

		<div class="spiel-card-header">
			<span class="wettbewerb"> <img src="images/bulilogo.png"
				alt="Bundesliga" class="wettbewerb-logo">
			</span><span class="heim-badge">{$spiel.heim_auswaerts|escape}</span>
		</div>

		<div class="spiel-card-body">
			<!-- Team-Aufstellung mit Logos -->
			<div class="spiel-matchup">
				{if $spiel.heim_auswaerts === 'Heim'}
				<div class="spiel-team s04">
					<img src="{$spiel.heim_logo}" alt="FC Schalke 04" class="team-logo">
					<div>FC Schalke 04</div>
				</div>
				<div class="spiel-vs">VS</div>
				<div class="spiel-team">
					<img src="{$spiel.gegner_logo}" alt="{$spiel.gegner|escape}"
						class="team-logo">
					<div>{$spiel.gegner|escape}</div>
				</div>
				{else}
				<div class="spiel-team">
					<img src="{$spiel.gegner_logo}" alt="{$spiel.gegner|escape}"
						class="team-logo">
					<div>{$spiel.gegner|escape}</div>
				</div>
				<div class="spiel-vs">VS</div>
				<div class="spiel-team s04">
					<img src="{$spiel.heim_logo}" alt="FC Schalke 04" class="team-logo">
					<div>FC Schalke 04</div>
				</div>
				{/if}
			</div>

			<!-- Datum & Stadion -->
			<div class="spiel-meta">
				<span>&#128197; {$spiel.datum|date_format:"%d.%m.%Y"}</span> {if
				$spiel.heim_auswaerts === 'Heim'} <span>&#127968; Veltins-Arena</span>
				{/if}
			</div>
		</div>

		<div class="spiel-card-footer">
			{if $spiel.heim_auswaerts === 'Heim'} <a
				href="kauf.php?spiel_id={$spiel.id}"
				class="btn-s04 w-100 text-center d-block"
				style="font-size: 0.92rem;"> Ticket kaufen </a> {else}
			<div class="text-center"
				style="font-size: 0.88rem; color: #5a7aaa; padding: 0.3rem 0;">
				Auswärtsspiel – keine Tickets verfügbar</div>
			{/if}
		</div>

	</div>
	{/foreach}
</div>

{else}
<div class="keine-spiele">
	<div style="font-size: 2.5rem; margin-bottom: 0.5rem;">&#128197;</div>
	<div
		style="font-family: 'Barlow Condensed', sans-serif; font-weight: 700; font-size: 1.2rem; text-transform: uppercase;">
		Keine Spiele gefunden</div>
	<div style="margin-top: 0.3rem;">Schau später wieder vorbei.</div>
</div>
{/if}

<script>
function filterSpiele(typ, btn) {
    // Aktiv-Klasse umsetzen
    document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('aktiv'));
    btn.classList.add('aktiv');

    // Karten ein-/ausblenden
    document.querySelectorAll('.spiel-card').forEach(card => {
        const cardTyp = card.dataset.typ;
        if (typ === 'alle' || cardTyp === typ) {
            card.style.display = '';
        } else {
            card.style.display = 'none';
        }
    });
}
</script>

{/block}
