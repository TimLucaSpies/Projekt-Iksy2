<!DOCTYPE HTML>

<html>
<head>
<title>{$ueberschrift}</title>						
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="{CSS_BASE}Forms.css">
<link rel="stylesheet" type="text/css" href="{CSS_BASE}Tables.css">

<style>
.error {
	color: red;
}
</style>
</head>
<body>
	<h2>{$ueberschrift}</h2>

	{if isset($PHP_SELF)}
<form action="{$PHP_SELF}" method="post">
    <input type="hidden" name="csrfToken" value="{$csrfToken}">

    <label>SelectBoxArray</label>
    <select name="SelectBoxArray">
        {foreach key=id item=inhalt from=$SelectBoxArray}
            <option value="{$id}">{$inhalt}</option> 
        {/foreach}
    </select><br> 
    
    <label>Variable1</label> 
    <input type="number" name="variable1" min="1" max="100" step="1" required><br>

    <label>Variable2</label> 
    <input type="text" 
           name="variable2" 
           pattern="grün|blau|gelb" 
           placeholder="grün, blau oder gelb" 
           title="Bitte nur 'grün', 'blau' oder 'gelb' eingeben."     
           required><br> 
    
    <label>Als PDF ausgeben?</label> 
    <input type="checkbox" name="pdf"><br>  
    
    <input type="submit" value="Berechnen">
</form>
	{else} 
        {if isset($fehler)}
            <p class="error">Bitte prüfen Sie Ihre Eingaben</p> 
        {else}

            <img src="{$PATH_AND_FILENAME}" alt="Umsatzgrafik">
            <br>

            <!--    
            {* QR-Code im HTML anzeigen *}        
            <img src="{$QR_PATH_AND_FILENAME}" alt="QR Code">
            <br> -->


            {$ausgabe1} 
            <br> {$ausgabe2}
            <br> {$ausgabe3}

	    {/if} 
	{/if}
	
</body>
</html>




{* --- START BLUEPRINTS (AUSKOMMENTIERT) --- *}
{*<strong><i>SelectBox</i></strong> für Kursiv und fett*}
	{* <label>Textfeld</label> 
	<input type="text" name="name" placeholder="Eingabe hier..." value="{$value|escape}"><br>
	*}

	{* <label>Passwort</label> 
	<input type="password" name="password" autocomplete="off"><br>
	*}

	{* <label>Nachricht</label> 
	<textarea name="message" rows="5">{$messageText|escape}</textarea><br>
	*}

	{* <label>Anzahl</label> 
	<input type="number" name="quantity" min="1" max="10" step="1" value="1"><br>
	*}

	{* <label>Datum</label> 
	<input type="date" name="date" value="{$smarty.now|date_format:'%Y-%m-%d'}"><br>
	*}

	{* <label>Auswahl</label>
	<select name="dropdown">
		<option value="" selected disabled>Bitte auswählen</option>
		{foreach key=id item=inhalt from=$MeinArray}
			<option value="{$id}">{$inhalt}</option> 
		{/foreach}
	</select><br>
	*}

	{* <label>Option A</label> <input type="radio" name="radioGroup" value="A">
	<label>Option B</label> <input type="radio" name="radioGroup" value="B"><br>
	*}

	{* <label>Einzel-Checkbox</label> 
	<input type="checkbox" name="confirm" value="1"><br>
	*}

	{* <input type="hidden" name="hidden_id" value="{$id}">
	*}

	{* --- ENDE BLUEPRINTS --- *}
