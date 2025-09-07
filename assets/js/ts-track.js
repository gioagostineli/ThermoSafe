/* assets/js/ts-track.js
    Explica que este script fica em assets/js/ts-track.js.
    Serve para registrar visualizações de páginas (“pageviews”) no backend PHP (/analytics/track.php).
    Só envia o caminho da página (ex.: /clientes.html, /index.html), não a URL completa.
    Usa keepalive para não perder o envio se o usuário fechar a aba rapidamente.
    É “fail-safe”: se o servidor não responder ou a pessoa estiver offline, não mostra erro nenhum ao usuário.   
*/

(function () {
// Função autoexecutável
// Aqui abrimos uma função anônima que se executa automaticamente.
// Isso evita que as variáveis internas (payload, etc.) vazem para o escopo global do navegador.
  try {
    // Colocado para capturar possíveis erros de execução.
    // Exemplo: se o navegador for muito antigo e não suportar fetch, o erro não vai travar o site.    
    var payload = { page: location.pathname || location.href };
    // Criação do objeto payload
    // location.pathname → pega apenas o caminho da URL (ex.: /clientes.html).
    // Se por algum motivo pathname não existir, cai no location.href (URL inteira).
    // O objeto payload terá o formato:
    // { "page": "/clientes.html" }
    fetch('/analytics/track.php', {
    // Início da chamada fetch
    // Dispara uma requisição para o backend PHP (/analytics/track.php).
    // O caminho /analytics/track.php é relativo à raiz do site (por isso começa com /).
      method: 'POST', 
      // Isso é mais seguro que GET porque evita expor a URL inteira com parâmetros no histórico ou em logs do servidor.
      headers: { 'Content-Type': 'application/json' },
      // Cabeçalho HTTP
      // Define que o corpo da requisição será em formato JSON.
      // O PHP (track.php) conseguirá ler o JSON corretamente com file_get_contents('php://input').


      body: JSON.stringify(payload),
      // Corpo da requisição
      // Converte o objeto payload em JSON antes de enviar.
      // Exemplo real enviado para o servidor:
      keepalive: true
      // Flag keepalive
      // Garante que o navegador continue enviando a requisição mesmo que o usuário feche a aba rapidamente.
      // Muito usado para analytics, pois garante que a visita seja registrada mesmo em navegação rápida.  
    });
    // Fecha a chamada do fetch
    // Aqui o envio é disparado.
    // O retorno da chamada é ignorado, porque não precisamos da resposta para nada.
  } catch (e) { /* noop */ }
  // Tratamento de erro silencioso
  // Se algo falhar (navegador antigo, usuário offline, bloqueio por firewall), o erro é engolido.
  // noop significa “no operation”, ou seja, literalmente não faz nada.    
  // Isso evita que o site quebre por causa do tracker.
})();
// Fechamento da função autoexecutável
// Executa a função imediatamente após ser definida.
// Assim, o tracking roda automaticamente ao carregar qualquer página que tenha <script src="assets/js/ts-track.js"></script>.

// 📌📌📌📌📌📌 Resumo final 📌📌📌📌📌📌
// Cria um objeto com a página atual (payload).
// Envia esse objeto em JSON para /analytics/track.php.
// Usa POST + keepalive para garantir entrega confiável.
// Se falhar, não mostra erro ao usuário.
// Está isolado numa função anônima autoexecutável para não interferir no resto do site.