{* templates/mein_profil.tpl *}
{extends file="base.tpl"}

{block name="inhalt"}

<h1 class="page-heading">Mein Profil</h1>

{* ── Erfolgsmeldung ───────────────────────────────────────────────────────── *}
{if $erfolg}
  <div class="alert-s04-erfolg mb-4">
    ✅ <strong>Gespeichert!</strong> Deine Änderungen wurden erfolgreich übernommen.
  </div>
{/if}

{* ── Fehlerliste ──────────────────────────────────────────────────────────── *}
{if $fehler}
  <div class="alert-s04-fehler mb-4">
    <strong>⚠️ Bitte korrigiere folgende Fehler:</strong>
    <ul class="mb-0 mt-1">
      {foreach $fehler as $f}
        <li>{$f|escape}</li>
      {/foreach}
    </ul>
  </div>
{/if}

<div class="row g-4">

  {* ── Linke Spalte: Profilbild ─────────────────────────────────────────── *}
  <div class="col-12 col-md-4">
    <div class="card-s04">
      <div class="card-header">Profilbild</div>
      <div class="card-body p-3">
        <form method="post" action="mein_profil.php" enctype="multipart/form-data">
          <input type="hidden" name="aktion" value="profilbild" />

          {* Aktuelles Bild oder Initiale *}
          <div class="text-center mb-3">
            {if $benutzer.profilbild}
              <img
                src="uploads/profilbilder/{$benutzer.profilbild|escape:'url'}"
                alt="Dein Profilbild"
                class="rounded-circle border"
                style="width:100px;height:100px;object-fit:cover;border-color:var(--s04-grau-mid)!important;"
              />
            {else}
              <div class="rounded-circle d-inline-flex align-items-center justify-content-center"
                   style="width:100px;height:100px;background:var(--s04-blau);color:#fff;font-family:'Barlow Condensed',sans-serif;font-size:2.5rem;font-weight:800;">
                {$benutzer.vorname|truncate:1:'':true|upper}
              </div>
            {/if}
          </div>

          {* Upload-Zone (nutzt die fertige upload-zone Klasse aus base.tpl) *}
          <label for="profilbild-input" class="upload-zone w-100">
            <div class="upload-icon">📁</div>
            <div>Bild auswählen oder hierher ziehen</div>
            <div class="upload-hint">JPEG, PNG oder WebP · max. 2 MB</div>
            <input
              type="file"
              id="profilbild-input"
              name="profilbild"
              accept="image/jpeg,image/png,image/webp"
              onchange="s04PreviewImage('profilbild-input','profil-vorschau')"
            />
          </label>

          {* Vorschau-Bild (wird per JS aus base.tpl befüllt) *}
          <img id="profil-vorschau" src="" alt="Vorschau" />

          <button type="submit" class="btn-s04 w-100 mt-3">
            💾 Bild speichern
          </button>
        </form>
      </div>
    </div>
  </div>

  {* ── Rechte Spalte: alle Formulare ───────────────────────────────────── *}
  <div class="col-12 col-md-8 d-flex flex-column gap-4">

    {* ── 1) Name & Alter ──────────────────────────────────────────────── *}
    <div class="card-s04">
      <div class="card-header">Name &amp; Alter</div>
      <div class="card-body p-3">
        <form method="post">
          <input type="hidden" name="aktion" value="stammdaten" />
          <div class="row g-3">

            <div class="col-12 col-sm-6">
              <label class="form-label" for="vorname">Vorname *</label>
              <input
                type="text" id="vorname" name="vorname"
                class="form-control"
                value="{$benutzer.vorname|default:''|escape}"
                required
              />
            </div>

            <div class="col-12 col-sm-6">
              <label class="form-label" for="nachname">Nachname *</label>
              <input
                type="text" id="nachname" name="nachname"
                class="form-control"
                value="{$benutzer.nachname|default:''|escape}"
                required
              />
            </div>

            <div class="col-12 col-sm-4">
              <label class="form-label" for="alter">Alter *</label>
              <input
                type="number" id="alter" name="alter"
                class="form-control"
                min="1" max="120"
                value="{$benutzer.alter|default:''|escape}"
                required
              />
            </div>

            <div class="col-12 col-sm-8">
              <label class="form-label" for="email">E-Mail (nicht änderbar)</label>
              <input
                type="email" id="email"
                class="form-control"
                value="{$benutzer.email|default:''|escape}"
                disabled
              />
            </div>

          </div>
          <button type="submit" class="btn-s04 mt-3">💾 Speichern</button>
        </form>
      </div>
    </div>

    {* ── 2) Adresse ───────────────────────────────────────────────────── *}
    <div class="card-s04">
      <div class="card-header">Adresse</div>
      <div class="card-body p-3">
        <form method="post">
          <input type="hidden" name="aktion" value="adresse" />
          <div class="row g-3">

            <div class="col-12 col-sm-8">
              <label class="form-label" for="strasse">Straße *</label>
              <input
                type="text" id="strasse" name="strasse"
                class="form-control"
                value="{$benutzer.strasse|default:''|escape}"
                required
              />
            </div>

            <div class="col-12 col-sm-4">
              <label class="form-label" for="hausnummer">Hausnr. *</label>
              <input
                type="text" id="hausnummer" name="hausnummer"
                class="form-control"
                value="{$benutzer.hausnummer|default:''|escape}"
                required
              />
            </div>

            <div class="col-12 col-sm-4">
              <label class="form-label" for="plz">PLZ *</label>
              <input
                type="text" id="plz" name="plz"
                class="form-control"
                maxlength="10"
                value="{$benutzer.plz|default:''|escape}"
                required
              />
            </div>

            <div class="col-12 col-sm-8">
              <label class="form-label" for="ort">Ort *</label>
              <input
                type="text" id="ort" name="ort"
                class="form-control"
                value="{$benutzer.ort|default:''|escape}"
                required
              />
            </div>

          </div>
          <button type="submit" class="btn-s04 mt-3">💾 Speichern</button>
        </form>
      </div>
    </div>

    {* ── 3) Zahlungsmethode ───────────────────────────────────────────── *}
    <div class="card-s04">
      <div class="card-header">Zahlungsmethode</div>
      <div class="card-body p-3">
        <form method="post">
          <input type="hidden" name="aktion" value="zahlung" />
          <div class="row g-3">

            {* Jede Option als klickbare Bootstrap-Karte *}
            {foreach [
              ['wert'=>'paypal',            'icon'=>'🅿️',  'label'=>'PayPal'],
              ['wert'=>'kreditkarte',        'icon'=>'💳',  'label'=>'Kreditkarte'],
              ['wert'=>'rechnung',           'icon'=>'🧾',  'label'=>'Rechnung'],
              ['wert'=>'sofortueberweisung', 'icon'=>'⚡',  'label'=>'Sofortüberweisung']
            ] as $option}

              <div class="col-12 col-sm-6">
                <input
                  type="radio"
                  class="btn-check"
                  name="zahlungsmethode"
                  id="z-{$option.wert}"
                  value="{$option.wert}"
                  {if $benutzer.zahlungsmethode == $option.wert}checked{/if}
                />
                <label
                  class="btn btn-outline-primary w-100 d-flex align-items-center gap-2 py-3"
                  for="z-{$option.wert}"
                  style="border-color:var(--s04-grau-mid);color:var(--s04-dunkel);"
                >
                  <span style="font-size:1.4rem;">{$option.icon}</span>
                  <span style="font-family:'Barlow Condensed',sans-serif;font-weight:600;font-size:1rem;letter-spacing:.04em;text-transform:uppercase;">
                    {$option.label}
                  </span>
                </label>
              </div>

            {/foreach}

          </div>
          <button type="submit" class="btn-s04 mt-3">💾 Speichern</button>
        </form>
      </div>
    </div>

  </div>{* /rechte Spalte *}
</div>{* /row *}

{/block}
