<!DOCTYPE html>
<html lang="de">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{$seitentitel|default:"FC Schalke 04 – Tickets"}</title>

<link
	href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
	rel="stylesheet">
<link
	href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@400;600;800&family=Barlow:wght@400;500&display=swap"
	rel="stylesheet">



<style>
:root {
	--s04-blau: #004B9D;
	--s04-blau-d: #003578;
	--s04-blau-hell: #E8F0FA;
	--s04-weiss: #FFFFFF;
	--s04-grau: #F4F6F9;
	--s04-grau-mid: #D0D8E4;
	--s04-dunkel: #0D1B2A;
}

body {
	font-family: 'Barlow', sans-serif;
	background-color: var(--s04-grau);
	color: var(--s04-dunkel);
	min-height: 100vh;
	display: flex;
	flex-direction: column;
}

/* ---- Navbar ---- */
.navbar-s04 {
	background: var(--s04-blau);
	border-bottom: 3px solid var(--s04-blau-d);
	padding: 0.65rem 1.5rem;
}

.navbar-s04 .navbar-brand {
	font-family: 'Barlow Condensed', sans-serif;
	font-weight: 800;
	font-size: 1.5rem;
	color: var(--s04-weiss) !important;
	letter-spacing: 0.05em;
	text-transform: uppercase;
}

.navbar-s04 .nav-link {
	color: rgba(255, 255, 255, 0.8) !important;
	font-weight: 500;
	transition: color 0.2s;
}

.navbar-s04 .nav-link:hover, .navbar-s04 .nav-link.active {
	color: var(--s04-weiss) !important;
	text-decoration: underline;
	text-underline-offset: 4px;
}

.navbar-toggler {
	border-color: rgba(255, 255, 255, 0.4);
}

.navbar-toggler-icon {
	filter: invert(1);
}

.badge-s04 {
	background: var(--s04-weiss);
	color: var(--s04-blau);
	font-weight: 700;
	font-size: 0.7rem;
	border-radius: 50px;
	padding: 2px 7px;
}

/* ---- Buttons ---- */
.btn-s04 {
	background: var(--s04-blau);
	color: var(--s04-weiss);
	font-family: 'Barlow Condensed', sans-serif;
	font-weight: 600;
	font-size: 1rem;
	letter-spacing: 0.06em;
	text-transform: uppercase;
	border: 2px solid var(--s04-blau);
	border-radius: 4px;
	padding: 0.5rem 1.4rem;
	transition: background 0.2s, color 0.2s, transform 0.1s;
	text-decoration: none;
	display: inline-block;
}

.btn-s04:hover {
	background: var(--s04-blau-d);
	border-color: var(--s04-blau-d);
	color: var(--s04-weiss);
	transform: translateY(-1px);
}

.btn-s04-outline {
	background: transparent;
	border: 2px solid var(--s04-blau);
	color: var(--s04-blau);
	font-family: 'Barlow Condensed', sans-serif;
	font-weight: 600;
	font-size: 1rem;
	letter-spacing: 0.06em;
	text-transform: uppercase;
	border-radius: 4px;
	padding: 0.48rem 1.4rem;
	transition: all 0.2s;
	text-decoration: none;
	display: inline-block;
}

.btn-s04-outline:hover {
	background: var(--s04-blau);
	color: var(--s04-weiss);
}

/* ---- Cards ---- */
.card-s04 {
	border: 1px solid var(--s04-grau-mid);
	border-radius: 8px;
	box-shadow: 0 2px 10px rgba(0, 75, 157, 0.07);
	overflow: hidden;
	background: var(--s04-weiss);
}

.card-s04 .card-header {
	background: var(--s04-blau);
	color: var(--s04-weiss);
	font-family: 'Barlow Condensed', sans-serif;
	font-weight: 700;
	font-size: 1.1rem;
	letter-spacing: 0.06em;
	text-transform: uppercase;
	border-bottom: none;
	padding: 0.85rem 1.4rem;
}

/* ---- Seitenüberschrift ---- */
.page-heading {
	font-family: 'Barlow Condensed', sans-serif;
	font-weight: 800;
	font-size: 2rem;
	color: var(--s04-blau);
	text-transform: uppercase;
	letter-spacing: 0.04em;
	border-left: 5px solid var(--s04-blau);
	padding-left: 0.75rem;
	margin-bottom: 1.25rem;
}

/* ---- Seitenbild-Banner ---- */
/*.page-banner-wrap {
            position: relative;
            margin-bottom: 1.75rem;
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid var(--s04-grau-mid);
        }
        .page-banner-wrap img {
            width: 100%;
            max-height: 300px;
            object-fit: cover;
            display: block;
            
        }
        .page-banner-wrap .banner-label {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(transparent, rgba(0,53,120,0.88));
            color: white;
            font-family: 'Barlow Condensed', sans-serif;
            font-weight: 700;
            font-size: 1.5rem;
            letter-spacing: 0.05em;
            padding: 2rem 1.25rem 0.9rem;
        }

        /* ---- Bild-Upload-Zone ---- */
.upload-zone {
	border: 2px dashed var(--s04-grau-mid);
	border-radius: 8px;
	padding: 1.5rem;
	text-align: center;
	background: var(--s04-blau-hell);
	cursor: pointer;
	transition: border-color 0.2s, background 0.2s;
}

.upload-zone:hover {
	border-color: var(--s04-blau);
	background: #dce8f8;
}

.upload-zone input[type="file"] {
	display: none;
}

.upload-icon {
	font-size: 2rem;
	margin-bottom: 0.4rem;
	color: var(--s04-blau);
}

.upload-hint {
	font-size: 0.85rem;
	color: #5a7aaa;
	margin-top: 0.3rem;
}

#preview-img {
	max-width: 100%;
	max-height: 200px;
	object-fit: cover;
	border-radius: 6px;
	border: 1px solid var(--s04-grau-mid);
	margin-top: 0.75rem;
	display: none;
}

/* ---- Alerts ---- */
.alert-s04-fehler {
	background: #dce8f8;
	border-left: 4px solid var(--s04-blau);
	border-radius: 4px;
	color: var(--s04-blau-d);
	padding: 0.85rem 1rem;
}

.alert-s04-erfolg {
	background: var(--s04-blau-hell);
	border-left: 4px solid var(--s04-blau);
	border-radius: 4px;
	color: var(--s04-blau-d);
	padding: 0.85rem 1rem;
}

/* ---- Forms ---- */
.form-control:focus, .form-select:focus {
	border-color: var(--s04-blau);
	box-shadow: 0 0 0 0.2rem rgba(0, 75, 157, 0.15);
}

.form-label {
	font-weight: 500;
	font-size: 0.9rem;
	margin-bottom: 0.3rem;
}

/* ---- Footer ---- */
footer {
	background: var(--s04-dunkel);
	color: rgba(255, 255, 255, 0.5);
	font-size: 0.85rem;
	padding: 1.2rem 0;
	margin-top: auto;
}

footer a {
	color: rgba(255, 255, 255, 0.75);
	text-decoration: none;
}

footer a:hover {
	color: var(--s04-weiss);
}

.stripe-top {
	height: 4px;
	background: var(--s04-blau-d);
}
</style>
</head>
<body>

	<div class="stripe-top"></div>

	<!-- Navbar -->
	<nav class="navbar navbar-s04 navbar-expand-lg">
		<div class="container">
			<a class="navbar-brand d-flex align-items-center gap-2"
				href="landingpage.php"> <img src="images/Schalke_04.png" alt="S04"
				style="height: 38px;"> Tickets
			</a>
			<button class="navbar-toggler" type="button"
				data-bs-toggle="collapse" data-bs-target="#navMenu"
				aria-controls="navMenu" aria-expanded="false"
				aria-label="Navigation öffnen">
				<span class="navbar-toggler-icon"></span>
			</button>

			<div class="collapse navbar-collapse" id="navMenu">
				<ul class="navbar-nav me-auto mb-2 mb-lg-0">
					<li class="nav-item"><a class="nav-link" href="spielplan.php">Spielplan</a>
					</li> {if isset($SESSION_eingeloggt) && $SESSION_eingeloggt}
					<li class="nav-item"><a class="nav-link" href="warenkorb.php">
							Warenkorb {if isset($SESSION_warenkorbAnzahl) &&
							$SESSION_warenkorbAnzahl > 0} <span class="badge-s04">{$SESSION_warenkorbAnzahl}</span>
							{/if}
					</a></li>
					<li class="nav-item"><a class="nav-link"
						href="meine_bestellungen.php">Meine Bestellungen</a></li> {if
					isset($SESSION_rolle) && $SESSION_rolle === 'admin'}
					<li class="nav-item"><a class="nav-link" href="admin.php">Admin</a>
					</li> {/if} {/if}
				</ul>

				<ul class="navbar-nav ms-auto">
					{if isset($SESSION_eingeloggt) && $SESSION_eingeloggt}
					<li class="nav-item dropdown"><a
						class="nav-link dropdown-toggle d-flex align-items-center gap-2"
						href="#" role="button" data-bs-toggle="dropdown"> {if
							isset($SESSION_profilbild) && $SESSION_profilbild} <img
							src="uploads/profilbilder/{$SESSION_profilbild|escape}"
							style="width: 30px; height: 30px; border-radius: 50%; object-fit: cover; border: 2px solid rgba(255, 255, 255, 0.4);">
							{else}
							<div
								style="width: 30px; height: 30px; border-radius: 50%; background: rgba(255, 255, 255, 0.2); display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.8rem; color: white; border: 2px solid rgba(255, 255, 255, 0.4); flex-shrink: 0;">
								{$SESSION_vorname|truncate:1:''|upper}{$SESSION_nachname|truncate:1:''|upper}
							</div> {/if} {$SESSION_vorname|escape}
					</a>
						<ul class="dropdown-menu dropdown-menu-end">
							<li><a class="dropdown-item" href="mein_profil.php">Mein Profil</a></li>
							<li><hr class="dropdown-divider"></li>
							<li><a class="dropdown-item" href="logout.php">Abmelden</a></li>
						</ul></li> {else}
					<li class="nav-item"><a class="nav-link" href="login.php">Anmelden</a>
					</li>
					<li class="nav-item ms-2"><a class="btn-s04"
						href="registrierung.php"
						style="font-size: 0.88rem; padding: 0.4rem 1rem;">Registrieren</a>
					</li> {/if}
				</ul>
			</div>
		</div>
	</nav>

	<!-- Hauptinhalt -->
	<main class="container my-4 flex-grow-1">

		</div>

		{block name="inhalt"}{/block}
	</main>

	<!-- Footer -->
	<footer class="text-center">
		<div class="container">
			&copy; {$smarty.now|date_format:"%Y"} FC Schalke 04 &nbsp;|&nbsp; <a
				href="impressum.php">Impressum</a> &nbsp;|&nbsp; <a href="#">Datenschutz</a>
		</div>
	</footer>

	<script
		src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

	<script>
/**
 * Bild-Vorschau für Upload-Formulare.
 * Aufruf im Template: s04PreviewImage('datei-input-id', 'preview-img-id')
 */
function s04PreviewImage(inputId, previewId) {
    const input   = document.getElementById(inputId);
    const preview = document.getElementById(previewId);
    if (!input || !preview) return;
    input.addEventListener('change', function () {
        const file = this.files[0];
        if (!file) { preview.style.display = 'none'; return; }
        const reader = new FileReader();
        reader.onload = e => {
            preview.src = e.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(file);
    });
}
</script>
</body>
</html>
