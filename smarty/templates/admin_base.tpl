<!DOCTYPE html> 
  <html lang="de">                                                                                                     
  <head>          
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{$seitentitel|default:"Admin"} – FC Schalke 04</title>                                                        
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">               
  <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@400;600;800&family=Barlow:wght@400;500&dis
  play=swap" rel="stylesheet">                                                                                         
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>                                                        
                                                                                                                       
  <style>         
  :root {                                                                                                              
      --a-bg:       #0f1923;
      --a-card:     #1a2a3a;                                                                                           
      --a-border:   #1e3a5a;
      --a-blau:     #004B9D;                                                                                           
      --a-nav:      #0a1219;
      --a-text:     #c8d8ea;                                                                                           
      --a-weiss:    #ffffff;                                                                                           
      --a-akzent:   #3a8eff;
  }                                                                                                                    
                  
  body {                                                                                                               
      font-family: 'Barlow', sans-serif;
      background-color: var(--a-bg);
      color: var(--a-text);                                                                                            
      min-height: 100vh;
      display: flex;                                                                                                   
      flex-direction: column;
  }
                                                                                                                       
  /* Navbar */
  .navbar-admin {                                                                                                      
      background: var(--a-nav);
      border-bottom: 3px solid var(--a-blau);
      padding: 0.65rem 1.5rem;                                                                                         
  }
  .navbar-admin .navbar-brand {                                                                                        
      font-family: 'Barlow Condensed', sans-serif;
      font-weight: 800;                                                                                                
      font-size: 1.4rem;
      color: var(--a-weiss) !important;                                                                                
      letter-spacing: 0.08em;
      text-transform: uppercase;                                                                                       
  }
  .navbar-admin .nav-link {                                                                                            
      color: rgba(255,255,255,0.6) !important;
      font-weight: 500;                                                                                                
      transition: color 0.2s;
  }                                                                                                                    
  .navbar-admin .nav-link:hover {
      color: var(--a-weiss) !important;                                                                                
  }
                                                                                                                       
  /* Cards */     
  .card-admin {
      background: var(--a-card);
      border: 1px solid var(--a-border);
      border-radius: 8px;                                                                                              
      overflow: hidden;
      margin-bottom: 1.5rem;                                                                                           
  }               
  .card-admin .card-header {
      background: var(--a-blau);                                                                                       
      color: var(--a-weiss);
      font-family: 'Barlow Condensed', sans-serif;                                                                     
      font-weight: 700;                                                                                                
      font-size: 1rem;
      text-transform: uppercase;                                                                                       
      letter-spacing: 0.06em;
      padding: 0.75rem 1.25rem;                                                                                        
  }
                                                                                                                       
  /* Tabellen */  
  .table {
      color: var(--a-text);                                                                                            
      margin-bottom: 0;
  }                                                                                                                    
  .table thead th {
      background: var(--a-bg);
      color: var(--a-akzent);                                                                                          
      border-color: var(--a-border);
      font-size: 0.8rem;                                                                                               
      text-transform: uppercase;
      letter-spacing: 0.05em;                                                                                          
  }
  .table td {                                                                                                          
      border-color: var(--a-border);
      vertical-align: middle;
      font-size: 0.88rem;
  }                                                                                                                    
  .table-hover tbody tr:hover {
      background: rgba(58,142,255,0.07);                                                                               
  }                                                                                                                    
   
  /* Stat-Karten */                                                                                                    
  .stat-card {    
      background: var(--a-card);
      border: 1px solid var(--a-border);                                                                               
      border-left: 4px solid var(--a-blau);
      border-radius: 8px;                                                                                              
      padding: 1.2rem 1.5rem;
      margin-bottom: 1rem;                                                                                             
  }
  .stat-card .stat-zahl {                                                                                              
      font-family: 'Barlow Condensed', sans-serif;
      font-weight: 800;                                                                                                
      font-size: 2.2rem;
      color: var(--a-weiss);                                                                                           
      line-height: 1;                                                                                                  
  }
  .stat-card .stat-label {                                                                                             
      font-size: 0.8rem;
      color: var(--a-text);
      text-transform: uppercase;
      letter-spacing: 0.05em;                                                                                          
      margin-top: 0.3rem;
  }                                                                                                                    
                  
  /* Form */
  .form-control, .form-select {
      background: var(--a-bg);                                                                                         
      border: 1px solid var(--a-border);
      color: var(--a-weiss);                                                                                           
  }               
  .form-control:focus, .form-select:focus {                                                                            
      background: var(--a-bg);
      border-color: var(--a-akzent);                                                                                   
      color: var(--a-weiss);
      box-shadow: 0 0 0 0.2rem rgba(58,142,255,0.2);                                                                   
  }
  .form-control::placeholder { color: rgba(255,255,255,0.3); }                                                         
  .form-select option { background: var(--a-card); }                                                                   
  .form-label { color: var(--a-text); font-size: 0.85rem; }                                                            
                                                                                                                       
  /* Alerts */                                                                                                         
  .alert-admin-fehler {
      background: rgba(200,50,50,0.15);                                                                                
      border-left: 4px solid #e05555;
      border-radius: 4px;                                                                                              
      color: #f08080;
      padding: 0.85rem 1rem;                                                                                           
      margin-bottom: 1rem;
  }                                                                                                                    
  .alert-admin-erfolg {
      background: rgba(50,180,100,0.15);
      border-left: 4px solid #32b464;                                                                                  
      border-radius: 4px;
      color: #5de098;                                                                                                  
      padding: 0.85rem 1rem;
      margin-bottom: 1rem;                                                                                             
  }               

  /* Heading */                                                                                                        
  .page-heading {
      font-family: 'Barlow Condensed', sans-serif;                                                                     
      font-weight: 800;
      font-size: 2rem;
      color: var(--a-weiss);                                                                                           
      text-transform: uppercase;
      letter-spacing: 0.04em;                                                                                          
      border-left: 5px solid var(--a-blau);
      padding-left: 0.75rem;                                                                                           
      margin-bottom: 1.25rem;
  }                                                                                                                    
                  
  /* Button */                                                                                                         
  .btn-admin {    
      background: var(--a-blau);
      color: var(--a-weiss);
      font-family: 'Barlow Condensed', sans-serif;
      font-weight: 600;                                                                                                
      font-size: 1rem;
      letter-spacing: 0.06em;                                                                                          
      text-transform: uppercase;
      border: none;                                                                                                    
      border-radius: 4px;
      padding: 0.5rem 1.4rem;                                                                                          
      cursor: pointer;
      transition: background 0.2s;
  }
  .btn-admin:hover { background: #003578; }
                                                                                                                       
  footer {
      background: var(--a-nav);                                                                                        
      border-top: 1px solid var(--a-border);
      color: rgba(255,255,255,0.3);
      font-size: 0.8rem;                                                                                               
      padding: 1rem 0;
      text-align: center;                                                                                              
      margin-top: auto;                                                                                                
  }
  </style>                                                                                                             
  </head>         
  <body>

  <nav class="navbar navbar-admin navbar-expand-lg">                                                                   
      <div class="container-fluid px-4">
          <a class="navbar-brand" href="admin.php">                                                                    
              &#9881; Chef-Bereich
          </a>                                                                                                         
          <ul class="navbar-nav ms-auto">
              <li class="nav-item">                                                                                    
                  <span class="nav-link" style="color:rgba(255,255,255,0.4)!important;">
                      {$SESSION_vorname|escape} {$SESSION_nachname|escape}                                             
                  </span>                                                                                              
              </li>                                                                                                    
              <li class="nav-item">                                                                                    
                  <a class="nav-link" href="landingpage.php">&#8592; Zur Website</a>
              </li>                                                                                                    
              <li class="nav-item">
                  <a class="nav-link" href="logout.php">Abmelden</a>                                                   
              </li>                                                                                                    
          </ul>
      </div>                                                                                                           
  </nav>          

  <main class="container-fluid px-4 py-4 flex-grow-1">                                                                 
      {block name="inhalt"}{/block}
  </main>                                                                                                              
                  
  <footer>FC Schalke 04 &mdash; Admin-Bereich</footer>                                                                 
                  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>                 
  </body>         
  </html>