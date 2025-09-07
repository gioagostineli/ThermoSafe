<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') exit;

require __DIR__ . '/config.php';

$raw = file_get_contents('php://input');
$in  = $raw ? json_decode($raw, true) : [];
$in  = array_merge($_GET, $in);

$pagina = isset($in['page']) ? substr($in['page'], 0, 255) : '/';
$ua     = $_SERVER['HTTP_USER_AGENT'] ?? '';
$refer  = $_SERVER['HTTP_REFERER'] ?? null;
$ip     = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';

$ua_l = strtolower($ua);
$device = (strpos($ua_l, 'mobile') !== false) ? 'mobile' :
          ((strpos($ua_l, 'tablet') !== false) ? 'tablet' : 'desktop');

$origem = $refer ? parse_url($refer, PHP_URL_HOST) : 'direto';

$cx  = db();
$stm = $cx->prepare("INSERT INTO t_visitas (ip_usuario, pagina, navegador, dispositivo, origem) VALUES (?, ?, ?, ?, ?)");
$stm->bind_param('sssss', $ip, $pagina, $ua, $device, $origem);
$ok = $stm->execute();

echo json_encode(['ok' => (bool)$ok, 'id' => $ok ? $stm->insert_id : null]);
