{extends file="admin_base.tpl"}
                                                                                                                       
  {block name="inhalt"}
                                                                                                                       
  <div class="page-heading">Dashboard</div>

  {* Fehlermeldungen *}                                                                                                
  {if isset($fehler) && $fehler}
      <div class="alert-admin-fehler">                                                                                 
          {foreach $fehler as $f}<div>&#9888; {$f|escape}</div>{/foreach}
      </div>                                                                                                           
  {/if}
  {if isset($erfolg) && $erfolg}                                                                                       
      <div class="alert-admin-erfolg">&#10003; {$erfolg|escape}</div>
  {/if}                                                                                                                
   
  {* ── Stat-Karten ── *}                                                                                              
  <div class="row mb-4">
      <div class="col-md-4">                                                                                           
          <div class="stat-card">
              <div class="stat-zahl">{$gesamtTickets}</div>                                                            
              <div class="stat-label">Tickets verkauft</div>                                                           
          </div>
      </div>                                                                                                           
      <div class="col-md-4">
          <div class="stat-card" style="border-left-color:#3a8eff;">
              <div class="stat-zahl">{$gesamtEinnahmen} €</div>                                                        
              <div class="stat-label">Gesamteinnahmen</div>                                                            
          </div>                                                                                                       
      </div>                                                                                                           
      <div class="col-md-4">
          <div class="stat-card" style="border-left-color:#32b464;">                                                   
              <div class="stat-zahl">{$gesamtKunden}</div>
              <div class="stat-label">Registrierte Kunden</div>                                                        
          </div>
      </div>                                                                                                           
  </div>          

  {* ── Diagramme ── *}                                                                                                
  <div class="row mb-4">
      <div class="col-md-6">                                                                                           
          <div class="card-admin">
              <div class="card-header">Tickets pro Spiel</div>                                                         
              <div class="p-3">
                  <canvas id="chartTickets" height="200"></canvas>                                                     
              </div>                                                                                                   
          </div>
      </div>                                                                                                           
      <div class="col-md-6">
          <div class="card-admin">
              <div class="card-header">Einnahmen pro Spiel (€)</div>
              <div class="p-3">                                                                                        
                  <canvas id="chartEinnahmen" height="200"></canvas>
              </div>                                                                                                   
          </div>  
      </div>
  </div>                                                                                                               
  <div class="row mb-4">
      <div class="col-md-5">                                                                                           
          <div class="card-admin">
              <div class="card-header">Tickets nach Kategorie</div>
              <div class="p-3">                                                                                        
                  <canvas id="chartKategorien" height="220"></canvas>
              </div>                                                                                                   
          </div>  
      </div>
      <div class="col-md-7">
                                                                                                                       
          {* ── Neues Spiel ── *}
          <div class="card-admin">                                                                                     
              <div class="card-header">Neues Spiel hinzufügen</div>                                                    
              <div class="p-3">
                  <form method="post" action="admin.php">                                                              
                      <input type="hidden" name="csrfToken" value="{$csrfToken}">                                      
                      <div class="row g-3">
                          <div class="col-12">                                                                         
                              <label class="form-label">Gegner</label>
                              <input type="text" name="gegner" class="form-control"                                    
                                     placeholder="z.B. Bayern München" required>                                       
                          </div>
                          <div class="col-6">                                                                          
                              <label class="form-label">Datum</label>
                              <input type="date" name="datum" class="form-control" required>                           
                          </div>
                          <div class="col-6">                                                                          
                              <label class="form-label">Heim / Auswärts</label>
                              <select name="heim_auswaerts" class="form-select">                                       
                                  <option value="Heim">Heim</option>                                                   
                                  <option value="Auswärts">Auswärts</option>                                           
                              </select>                                                                                
                          </div>
                      </div>                                                                                           
                      <button type="submit" class="btn-admin mt-3">Spiel speichern</button>
                  </form>                                                                                              
              </div>
          </div>                                                                                                       
      </div>      
  </div>

  {* ── Aktive Spiele ── *}                                                                                            
  <div class="card-admin">
      <div class="card-header">Kommende Spiele ({$spiele|count})</div>                                                 
      <div class="table-responsive">                                                                                   
          <table class="table table-hover">
              <thead>                                                                                                  
                  <tr>
                      <th>ID</th><th>Gegner</th><th>Datum</th><th>Typ</th>                                             
                  </tr>
              </thead>                                                                                                 
              <tbody>                                                                                                  
              {if $spiele}
                  {foreach $spiele as $s}                                                                              
                  <tr>
                      <td>{$s.id}</td>
                      <td>{$s.gegner|escape}</td>                                                                      
                      <td>{$s.datum|date_format:"%d.%m.%Y"}</td>
                      <td>{$s.heim_auswaerts|escape}</td>                                                              
                  </tr>                                                                                                
                  {/foreach}
              {else}                                                                                                   
                  <tr><td colspan="4" class="text-center py-3" style="color:rgba(255,255,255,0.3);">Keine
  Spiele</td></tr>                                                                                                     
              {/if}
              </tbody>                                                                                                 
          </table>
      </div>
  </div>

  {* ── Alle Bestellungen ── *}                                                                                        
  <div class="card-admin">
      <div class="card-header">Alle Bestellungen ({$bestellungen|count})</div>                                         
      <div class="table-responsive">
          <table class="table table-hover">
              <thead>                                                                                                  
                  <tr>
                      <th>ID</th><th>Kunde</th><th>Spiel</th><th>Datum</th>                                            
                      <th>Block</th><th>Reihe</th><th>Platz</th><th>Kategorie</th>
                      <th>Preis</th><th>Bestellt am</th>                                                               
                  </tr>                                                                                                
              </thead>                                                                                                 
              <tbody>                                                                                                  
              {if $bestellungen}
                  {foreach $bestellungen as $b}                                                                        
                  <tr>
                      <td>S04-{$b.id|string_format:"%06d"}</td>                                                        
                      <td>{$b.vorname|escape} {$b.nachname|escape}</td>                                                
                      <td>{$b.gegner|escape}</td>
                      <td>{$b.datum|date_format:"%d.%m.%Y"}</td>                                                       
                      <td>{$b.block|escape}</td>
                      <td>{$b.reihe}</td>                                                                              
                      <td>{$b.platz}</td>
                      <td>{$b.kategorie|escape}</td>                                                                   
                      <td>{$b.preis_bezahlt|string_format:"%.2f"|replace:'.':','} €</td>
                      <td>{$b.bestellt_am|date_format:"%d.%m.%Y %H:%M"}</td>                                           
                  </tr>
                  {/foreach}                                                                                           
              {else}
                  <tr><td colspan="10" class="text-center py-3" style="color:rgba(255,255,255,0.3);">Keine
  Bestellungen</td></tr>                                                                                               
              {/if}
              </tbody>                                                                                                 
          </table>                                                                                                     
      </div>
  </div>                                                                                                               
                  
  {* ── Chart.js ── *}
  <script>
  const chartDefaults = {
      color: 'rgba(200,216,234,0.8)',                                                                                  
      grid: 'rgba(255,255,255,0.07)'                                                                                   
  };                                                                                                                   
                                                                                                                       
  // Tickets pro Spiel                                                                                                 
  const dataSpiele = {$chartSpiele};
  new Chart(document.getElementById('chartTickets'), {                                                                 
      type: 'bar',                                                                                                     
      data: {
          labels: dataSpiele.map(d => d.gegner),                                                                       
          datasets: [{
              label: 'Tickets',
              data: dataSpiele.map(d => d.anzahl),                                                                     
              backgroundColor: 'rgba(0,75,157,0.8)',
              borderColor: '#3a8eff',                                                                                  
              borderWidth: 1,                                                                                          
              borderRadius: 4
          }]                                                                                                           
      },          
      options: {
          plugins: { legend: { labels: { color: chartDefaults.color } } },
          scales: {                                                                                                    
              x: { ticks: { color: chartDefaults.color }, grid: { color: chartDefaults.grid } },
              y: { ticks: { color: chartDefaults.color }, grid: { color: chartDefaults.grid }, beginAtZero: true }     
          }       
      }                                                                                                                
  });             

  // Einnahmen pro Spiel                                                                                               
  const dataEinnahmen = {$chartEinnahmen};
  new Chart(document.getElementById('chartEinnahmen'), {                                                               
      type: 'bar',
      data: {
          labels: dataEinnahmen.map(d => d.gegner),
          datasets: [{                                                                                                 
              label: 'Einnahmen (€)',
              data: dataEinnahmen.map(d => parseFloat(d.einnahmen)),                                                   
              backgroundColor: 'rgba(58,142,255,0.7)',                                                                 
              borderColor: '#3a8eff',
              borderWidth: 1,                                                                                          
              borderRadius: 4                                                                                          
          }]
      },                                                                                                               
      options: {  
          plugins: { legend: { labels: { color: chartDefaults.color } } },
          scales: {
              x: { ticks: { color: chartDefaults.color }, grid: { color: chartDefaults.grid } },
              y: { ticks: { color: chartDefaults.color }, grid: { color: chartDefaults.grid }, beginAtZero: true }     
          }
      }                                                                                                                
  });             
                                                                                                                       
  // Tickets nach Kategorie
  const dataKat = {$chartKategorien};
  new Chart(document.getElementById('chartKategorien'), {
      type: 'doughnut',
      data: {                                                                                                          
          labels: dataKat.map(d => d.beschreibung),
          datasets: [{                                                                                                 
              data: dataKat.map(d => d.anzahl),
              backgroundColor: ['#004B9D','#3a8eff','#32b464','#e0a020'],
              borderColor: '#1a2a3a',                                                                                  
              borderWidth: 2                                                                                           
          }]                                                                                                           
      },                                                                                                               
      options: {  
          plugins: {
              legend: { labels: { color: chartDefaults.color } }                                                       
          }
      }                                                                                                                
  });             
  </script>

  {/block}     