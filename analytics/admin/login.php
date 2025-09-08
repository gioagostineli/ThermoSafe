<?php
// /analytics/admin/login.php
session_start();
require __DIR__ . '/config.admin.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $u = $_POST['user'] ?? '';
  $p = $_POST['pass'] ?? '';
  if ($u === $ADMIN_USER && password_verify($p, $ADMIN_PASS_HASH)) {
    $_SESSION['admin'] = true;
    header('Location: dashboard.php');
    exit;
  }
  $error = 'Usuário ou senha inválidos.';
}
?>
<!doctype html><html lang="pt-br"><head>
<meta charset="utf-8">
<title>ThermoSafe • Acesso ao Painel</title>
<meta name="robots" content="noindex,nofollow">
<link rel="icon" href="/assets/images/favicon/favicon.png" type="image/png">
<style>
  body{font:16px/1.5 system-ui,Segoe UI,Roboto,Arial,sans-serif;background:#f4f7fa;color:#0A3D62;display:grid;place-items:center;height:100dvh;margin:0}
  .card{background:#fff; padding:32px; border-radius:16px; box-shadow:0 8px 24px rgba(0,0,0,.12); width:min(420px,90vw)}
  .row{margin:12px 0}
  input{width:100%; padding:12px 14px; border:2px solid #0A3D62; border-radius:10px}
  button{display:inline-block;padding:.8rem 1.2rem;border-radius:999px;border:2px solid #0A3D62;background:#0A3D62;color:#fff;cursor:pointer}
  .err{color:#b00020; margin:8px 0 0}
</style>
</head><body>
  <div class="card">
    <h1 style="margin:0 0 12px">Painel ThermoSafe</h1>
    <p>Acesso restrito</p>
    <?php if($error): ?><div class="err"><?=htmlspecialchars($error)?></div><?php endif; ?>
    <form method="post" autocomplete="off">
      <div class="row"><label>Usuário<br><input name="user" required></label></div>
      <div class="row"><label>Senha<br><input type="password" name="pass" required></label></div>
      <div class="row"><button type="submit">Entrar</button></div>
    </form>
  </div>
</body></html>
