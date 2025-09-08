<?php
// /analytics/admin/dashboard.php
require __DIR__ . '/guard.php';
require __DIR__ . '/../config.php'; // usa sua função db()

$cx = db();

/* Totais */
$qTotais = [
  'hoje'  => "SELECT COUNT(*) c FROM t_visitas WHERE DATE(data_visita)=CURDATE()",
  'w7'    => "SELECT COUNT(*) c FROM t_visitas WHERE data_visita >= NOW() - INTERVAL 7 DAY",
  'w30'   => "SELECT COUNT(*) c FROM t_visitas WHERE data_visita >= NOW() - INTERVAL 30 DAY",
];
$totais = [];
foreach($qTotais as $k=>$sql){
  $totais[$k] = (int)$cx->query($sql)->fetch_assoc()['c'];
}

/* Série últimos 14 dias */
$sql14 = "
  SELECT DATE(data_visita) d, COUNT(*) c
  FROM t_visitas
  WHERE data_visita >= CURDATE() - INTERVAL 13 DAY
  GROUP BY DATE(data_visita)
  ORDER BY DATE(data_visita)
";
$res14 = $cx->query($sql14);
$labels14=[]; $data14=[];
for($i=13;$i>=0;$i--){
  $dia = date('Y-m-d', strtotime("-$i day"));
  $labels14[] = date('d/m', strtotime($dia));
  $data14[$dia] = 0;
}
while($r=$res14->fetch_assoc()){ $data14[$r['d']] = (int)$r['c']; }
$serie14 = array_values($data14);

/* Top 10 páginas */
$sqlTop = "
  SELECT pagina, COUNT(*) c
  FROM t_visitas
  GROUP BY pagina
  ORDER BY c DESC
  LIMIT 10
";
$topPag = $cx->query($sqlTop)->fetch_all(MYSQLI_ASSOC);

/* Por dispositivo */
$sqlDev = "SELECT dispositivo, COUNT(*) c FROM t_visitas GROUP BY dispositivo";
$porDev  = $cx->query($sqlDev)->fetch_all(MYSQLI_ASSOC);

/* Por origem (host do referer) */
$sqlOrg = "SELECT origem, COUNT(*) c FROM t_visitas GROUP BY origem";
$porOrg = $cx->query($sqlOrg)->fetch_all(MYSQLI_ASSOC);
?>
<!doctype html><html lang="pt-br"><head>
<meta charset="utf-8">
<title>ThermoSafe • Métricas</title>
<meta name="robots" content="noindex,nofollow">
<link rel="icon" href="/assets/images/favicon/favicon.png" type="image/png">
<link rel="stylesheet" href="/assets/styles/tokens.css">
<link rel="stylesheet" href="/assets/styles/style-index.css">
<style>
  .dash{ margin-top: var(--ts-space-7); }
  .cards{ display:grid; grid-template-columns: repeat(3,1fr); gap:var(--ts-space-6); }
  .card{ background:#fff; padding:16px 20px; border-radius:16px; box-shadow: var(--ts-shadow-200); }
  .mt{ margin-top: var(--ts-space-6); }
  canvas{ background:#fff; border-radius:16px; box-shadow: var(--ts-shadow-200); padding:12px }
  table{ width:100%; border-collapse:collapse; background:#fff; border-radius:16px; box-shadow:var(--ts-shadow-200); overflow:hidden }
  th,td{ padding:10px 12px; border-bottom:1px solid #eef2f6 }
  th{ text-align:left; background:#f7fafc }
  .logout{ float:right; font-size:14px }
</style>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1"></script>
</head><body>
<header class="ts-header">
  <div class="page ts-container-banner">
    <a href="/"><img class="ts-logo" src="/assets/images/logo/logo-p.png" alt="ThermoSafe"></a>
    <nav id="ts-nav"><a class="ts-btn" href="/analytics/admin/logout.php">Sair</a></nav>
  </div>
</header>

<main class="page dash">
  <h1>Métricas ThermoSafe</h1>

  <div class="cards">
    <div class="card"><strong>Hoje</strong><div style="font-size:32px"><?=$totais['hoje']?></div></div>
    <div class="card"><strong>Últimos 7 dias</strong><div style="font-size:32px"><?=$totais['w7']?></div></div>
    <div class="card"><strong>Últimos 30 dias</strong><div style="font-size:32px"><?=$totais['w30']?></div></div>
  </div>

  <div class="mt">
    <canvas id="chart14" height="110"></canvas>
  </div>

  <div class="mt" style="display:grid;grid-template-columns:1.1fr .9fr; gap:var(--ts-space-6)">
    <div>
      <h2>Top páginas</h2>
      <table>
        <thead><tr><th>Página</th><th>Visitas</th></tr></thead>
        <tbody>
          <?php foreach($topPag as $r): ?>
          <tr><td><?=htmlspecialchars($r['pagina']?:'/')?></td><td><?=$r['c']?></td></tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

    <div>
      <h2>Distribuições</h2>
      <div class="mt"><canvas id="chartDev" height="140"></canvas></div>
      <div class="mt"><canvas id="chartOrg" height="140"></canvas></div>
    </div>
  </div>
</main>

<script>
const labels14 = <?=json_encode($labels14)?>;
const data14   = <?=json_encode(array_values($serie14))?>;

new Chart(document.getElementById('chart14'),{
  type:'line',
  data:{ labels: labels14, datasets:[{
    label:'Visitas (14 dias)',
    data: data14,
    tension:.25,
    borderWidth:2
  }]},
  options:{ plugins:{ legend:{display:false} }, scales:{ y:{ beginAtZero:true } } }
});

const dev = <?=json_encode($porDev)?>;
new Chart(document.getElementById('chartDev'),{
  type:'doughnut',
  data:{ labels: dev.map(x=>x.dispositivo||'—'),
         datasets:[{ data: dev.map(x=>+x.c) }]},
  options:{ plugins:{ title:{ display:true, text:'Por dispositivo' } } }
});

const org = <?=json_encode($porOrg)?>;
new Chart(document.getElementById('chartOrg'),{
  type:'doughnut',
  data:{ labels: org.map(x=>x.origem||'—'),
         datasets:[{ data: org.map(x=>+x.c) }]},
  options:{ plugins:{ title:{ display:true, text:'Por origem' } } }
});
</script>
</body></html>
