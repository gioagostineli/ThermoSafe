# ThermoSafe — Monitoramento Inteligente de Temperatura e Umidade (24×7)

![ANVISA RDC 430 Alinhado](https://img.shields.io/badge/ANVISA-RDC%20430%2F2020%20(alinhado)-0057A3?style=for-the-badge)
![LGPD Ready](https://img.shields.io/badge/LGPD-Ready-2E7D32?style=for-the-badge)
![ESG](https://img.shields.io/badge/ESG-Efici%C3%AAncia%20Energ%C3%A9tica-00897B?style=for-the-badge)
![ODS](https://img.shields.io/badge/ODS-3%E2%80%A2%209%E2%80%A2%2012%E2%80%A2%2013-6A1B9A?style=for-the-badge)
![Python 3.13](https://img.shields.io/badge/Python-3.13-3776AB?style=for-the-badge&logo=python)
![Streamlit](https://img.shields.io/badge/Streamlit-1.25.1-FF4B4B?style=for-the-badge&logo=streamlit)
![Flask](https://img.shields.io/badge/Flask-API%20Gateway-000000?style=for-the-badge&logo=flask)
![MariaDB](https://img.shields.io/badge/MariaDB-RDS-003545?style=for-the-badge&logo=mariadb)
![AWS](https://img.shields.io/badge/AWS-EC2%20%7C%20RDS%20%7C%20S3-232F3E?style=for-the-badge&logo=amazonaws)
![Made in Brazil](https://img.shields.io/badge/Made%20in-Brazil-009739?style=for-the-badge)

> **Aviso**: As badges **ANVISA/RDC 430** e **LGPD** indicam **alinhamento e boas práticas**. Não constituem atestado oficial ou certificação por parte das autoridades competentes.

---

## 🔎 Visão Geral
**ThermoSafe** é uma plataforma de **monitoramento contínuo (24×7)** de temperatura e umidade para cadeias frias (farmácias, hospitais, laboratórios e supermercados), com **alertas em tempo real**, **dashboards** e **histórico auditável** — tudo com foco em **confiabilidade**, **segurança** e **conformidade regulatória**.

- **Front-end Web (site institucional)**: páginas *Home*, *Soluções*, *Setores*, *Clientes*, *Contato* e **Política de Privacidade** (`Politica.html`).
- **Aplicação**: painéis (Streamlit), API (Flask), IoT (ESP32) e banco **MariaDB** (RDS/Aurora).
- **Destaques**: tema escuro, navegação responsiva, logs de ações, gráficos e importação CSV.
- **Formatação VS Code**: foi disponibilizado no diretorio raiz, 2 arquivos para garantir a padronização de tabs e padrão para HTML, CSS, JS. Os arqivos .editorconfig e .prettierrc devem ser colocados na mesma pasta do index.html.

> **Slogan**: *Confiabilidade em cada número.*

---

## 🚀 Principais Recursos
- **Leituras em tempo real** (ESP32) com *buffer offline* e reenvio confiável.
- **Alertas multicanal** (WhatsApp/e-mail) quando a temperatura sai do *range*.
- **Dashboards** com séries temporais, estatísticas e comparativos.
- **Auditoria completa** (tabelas de *logs* e *triggers* de sistema).
- **Segurança**: TLS 1.2/1.3, LGPD, segregação de acessos e registros de auditoria.
- **Integração** com bancos **MariaDB/Aurora** (AWS RDS) e armazenamento em **S3**.
- **Escalabilidade**: arquitetura pronta para centenas/milhares de módulos (ESP32).

---

## 🧭 Páginas do Site
- `index.html` — Página inicial (visão geral e diferenciais)
- `solucoes.html` — Produtos e serviços oferecidos
- `setores.html` — Setores atendidos (saúde, varejo, etc.)
- `clientes.html` — (opcional) Vitrine de clientes
- `contato.html` — Formulário de contato (WhatsApp/telefone)
- `Politica.html` — **Política de Privacidade** (LGPD)
- `assets/documents` — Documentos auxiliares
- `assets/font` — Font externa para Font-Face
- `assets/images/cliente` — Logo dos clientes do Grupo Union
- `assets/images/evolucao` — Quadro sintético da história da Union, com 3 tamanhos
- `assets/images/favicon` — Icon para utilização como FAVICON
- `assets/images/fundo` — Imagem de fundo do site
- `assets/images/logo` — Logo em 3 tamanhos para responsividade
- `assets/styles/style-*.css` — Estilos do tema institucional

# Padrão de Formatação — Projeto ThermoSafe
Este projeto utiliza arquivos de configuração para manter **padronização de código** entre todos os desenvolvedores.

## 📌 Arquivos incluídos
- `.editorconfig` → garante indentação consistente (tab = 4 espaços).
- `.prettierrc` → configura o Prettier/VSCode para formatar HTML, CSS e JS de forma padronizada.

## ⚙️ Como usar no VSCode
1. Instale a extensão **EditorConfig for VS Code**, a partir do ícone extensão do VS Code.
2. Instale a extensão **Prettier - Code formatter**, a partir do ícone extensão do VS Code.
3. Certifique-se de que o Prettier é o formatador padrão:
   - Pressione `Ctrl + Shift + P` → "Format Document With..."
   - Selecione **Prettier** e clique em **Set as Default**.
4. Para formatar um arquivo manualmente: `Shift + Alt + F`.

## ✅ Resultado
- Sempre que salvar, o código será reformatado automaticamente:
  - **Indentação:** Tab equivalente a 4 espaços.
  - **HTML/CSS/JS:** mesmo estilo para toda a equipe.
  - **Quebra de linha:** padrão Unix (LF).

---
# Plataforma ThermoSafe
A seguir, uma pequena descrição de como foi feito a Plataforma ThermoSafe para os usuários e operação do sistema.

## Segurança
- **Criptografia ponta a ponta** (TLS 1.2/1.3; opção mTLS por dispositivo).
- **Pseudonimização** e perfis de acesso mínimos (LGPD).
- **Logs** e trilhas de auditoria (tabelas de log e *status flags*).

---

## 🗄️ Banco de Dados (convenções)
- Prefixo de tabelas: `t_` (ex.: `t_leituras`, `t_logs`, `t_realtime`, `t_configuracao`).
- Convenção de variáveis no código: prefixo `m_` (ex.: `m_arquivo_selecionado`).
- Exemplos de campos:
  - `t_leituras.f_status`: **1=ok**, **2=falta cadastro do monitor**, **3=falta cadastro na farmácia**, **4=faltou canal1**, **5=faltou canal2**.
  - `t_monitores.status_operacional`: derivado de `data_ultima_leitura` vs. parâmetro em `t_configuracao`.

> Consulte a modelagem/ERD para entidades complementares (monitores, incidentes, triggers, integrações).

---

## ⚙️ Setup Rápido (Apenas para o Desenvolvimento!!!)
### Pré-requisitos
- **Python 3.13+**
- **pip** e **virtualenv**
- **MariaDB** local (ou conexão RDS/Aurora)

### 1) Clonar e criar venv
```bash
git clone <URL_DO_REPOSITORIO>
cd ThermoSafe
python -m venv venv
# Windows PowerShell
.\venv\Scripts\Activate.ps1
```

### 2) Dependências
Crie/edite `requirements.txt` (exemplo mínimo):
```txt
mysql-connector-python>=9.0.0
python-dotenv>=1.0.1
flask>=3.0.0
streamlit>=1.25.1
plotly>=5.24.0
pandas>=2.2.2
```

Instale:
```bash
pip install -r requirements.txt
```

### 3) Variáveis de ambiente
Crie um `.env` (NÃO COMMITAR) com algo como:
```ini
# Banco
DB_HOST=localhost
DB_USER=root
DB_PASS=senha_aqui
DB_NAME=thermo_dados

# Flask
FLASK_SECRET=troque_isto
FLASK_PORT=5003

# Streamlit
STREAMLIT_PORT=8507
```

### 4) Rodar
API Flask:
```bash
python app.py
# ou
flask --app app run --port %FLASK_PORT% --host 0.0.0.0
```

Dashboards Streamlit:
```bash
streamlit run dashboard.py --server.port %STREAMLIT_PORT%
```

---

## 🧪 Qualidade e Observabilidade
- **Logs de aplicação** + `t_logs` e `t_log_trigger` no banco.
- **Alertas** para incidentes e quedas (watchdog, *health checks*).
- **Backups** diários; restauração testada; **multi-AZ** (RDS).

---
# Comunicação do Sistema ThermoSafe
A seguir, uma pequena descrição de como foi projeto o ThermoSafe para os usuários e operação do sistema.


## 📄 Licença
Distribuído sob licença **MIT** (para o site da ThermoSafe).

Para aquisição dos Serviços da ThermoSafe, faça um contato com a área comercial
---

## 📬 Contato
**ThermoSafe** — *Confiabilidade em cada número.*  
- E-mail: `thermosafe2030@gmail.com`
- Telefone: `55.11.98077.1968`
