<?php

/**
 * Shared admin UI helpers (header/footer, actor, catalog gate).
 */

/**
 * @return array{user_id:int, username:string}
 */
function admin_actor(): array
{
    return [
        'user_id' => (int) ($_SESSION['user_id'] ?? 0),
        'username' => (string) ($_SESSION['username'] ?? ''),
    ];
}

/**
 * Require auth + catalog read; 403 plain text if denied.
 */
function admin_require_catalog_read(): void
{
    requireAuth();

    if (!canReadCatalog()) {
        http_response_code(403);
        header('Content-Type: text/plain; charset=utf-8');
        echo 'Acesso negado.';
        exit;
    }
}

function admin_h(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

/**
 * Store a one-shot flash message for the next request.
 */
function admin_flash_set(string $type, string $message): void
{
    $_SESSION['admin_flash'] = [
        'type' => $type,
        'message' => $message,
    ];
}

/**
 * @return array{type:string, message:string}|null
 */
function admin_flash_take(): ?array
{
    if (!isset($_SESSION['admin_flash']) || !is_array($_SESSION['admin_flash'])) {
        return null;
    }

    $flash = $_SESSION['admin_flash'];
    unset($_SESSION['admin_flash']);

    $type = isset($flash['type']) ? (string) $flash['type'] : 'ok';
    $message = isset($flash['message']) ? (string) $flash['message'] : '';
    if ($message === '') {
        return null;
    }

    return ['type' => $type, 'message' => $message];
}

function admin_is_audit_failure(Throwable $e): bool
{
    return str_contains($e->getMessage(), 'audit_write_failed');
}

const ADMIN_AUDIT_FAIL_MESSAGE = 'audit_write_failed: alteração não foi salva';

/**
 * Window + page-size fields from an admin_*_list() result.
 *
 * @param array{total?:int, page?:int, per_page?:int, total_pages?:int} $list
 * @return array{from:int, to:int, total:int, page:int, per_page:int, total_pages:int}
 */
function admin_list_window(array $list): array
{
    $total = (int) ($list['total'] ?? 0);
    $page = max(1, (int) ($list['page'] ?? 1));
    $perPage = max(1, (int) ($list['per_page'] ?? 20));
    $totalPages = max(1, (int) ($list['total_pages'] ?? 1));

    if ($total < 1) {
        return [
            'from' => 0,
            'to' => 0,
            'total' => 0,
            'page' => $page,
            'per_page' => $perPage,
            'total_pages' => $totalPages,
        ];
    }

    $from = (($page - 1) * $perPage) + 1;
    $to = min($page * $perPage, $total);

    return [
        'from' => $from,
        'to' => $to,
        'total' => $total,
        'page' => $page,
        'per_page' => $perPage,
        'total_pages' => $totalPages,
    ];
}

/**
 * List meta: "42 pontos · exibindo 1–20 · 20 itens".
 *
 * @param array{total?:int, page?:int, per_page?:int, total_pages?:int} $list
 */
function admin_format_list_meta(string $singular, string $plural, array $list): string
{
    $w = admin_list_window($list);
    $total = $w['total'];
    $noun = $total === 1 ? $singular : $plural;

    if ($total < 1) {
        return '0 ' . $plural;
    }

    return sprintf(
        '%d %s · exibindo %d–%d · %d itens',
        $total,
        $noun,
        $w['from'],
        $w['to'],
        $w['per_page']
    );
}

/**
 * Pagination status: "Página 1 de 9 · 20 itens".
 *
 * @param array{total?:int, page?:int, per_page?:int, total_pages?:int} $list
 */
function admin_format_pagination_status(array $list): string
{
    $w = admin_list_window($list);

    return sprintf(
        'Página %d de %d · %d itens',
        $w['page'],
        $w['total_pages'],
        $w['per_page']
    );
}

/**
 * Truncate text for list previews (UTF-8 aware when mbstring is available).
 */
function admin_truncate(string $text, int $max = 80): string
{
    $text = trim(preg_replace('/\s+/u', ' ', $text) ?? $text);
    if ($text === '') {
        return '';
    }

    if (function_exists('mb_strlen') && function_exists('mb_substr')) {
        if (mb_strlen($text) <= $max) {
            return $text;
        }
        return mb_substr($text, 0, max(1, $max - 1)) . '…';
    }

    if (strlen($text) <= $max) {
        return $text;
    }

    return substr($text, 0, max(1, $max - 1)) . '…';
}

/**
 * Human label for Função (tipo).
 */
function admin_ponto_funcao_label(?string $tipo): string
{
    if ($tipo === null || $tipo === '') {
        return '—';
    }

    $canonical = function_exists('admin_pontos_normalize_tipo')
        ? admin_pontos_normalize_tipo($tipo)
        : $tipo;

    if ($canonical !== null && isset(ADMIN_PONTOS_TIPO_LABELS[$canonical])) {
        return ADMIN_PONTOS_TIPO_LABELS[$canonical];
    }

    return $tipo;
}

/**
 * Open HTML document + sage admin chrome.
 */
function admin_render_header(string $title, string $activeNav = 'pontos'): void
{
    $pageTitle = admin_h($title) . ' — Raízes de Aruanda';
    $displayNameRaw = trim((string) ($_SESSION['name'] ?? ''));
    if ($displayNameRaw === '') {
        $displayNameRaw = trim((string) ($_SESSION['username'] ?? ''));
    }
    $displayName = admin_h($displayNameRaw);
    $showCatalogNav = function_exists('canReadCatalog') && canReadCatalog();
    $showAuditNav = function_exists('hasPermission') && hasPermission('audit:read');
    $pontosActive = $activeNav === 'pontos' ? ' aria-current="page"' : '';
    $linhasActive = $activeNav === 'linhas' ? ' aria-current="page"' : '';
    $ritmosActive = $activeNav === 'ritmos' ? ' aria-current="page"' : '';
    $auditoriaActive = $activeNav === 'auditoria' ? ' aria-current="page"' : '';
    $perfilActive = $activeNav === 'perfil' ? ' aria-current="page"' : '';
    $showSidebar = $showCatalogNav || $showAuditNav;
    ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $pageTitle; ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+3:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/main.css">
    <link rel="stylesheet" href="/assets/css/mobile.css">
    <link rel="stylesheet" href="/admin/styles.css">
</head>
<body class="admin-body">
    <header class="admin-header">
        <div class="admin-header__inner">
            <a class="admin-brand" href="/admin/">
                <span class="admin-brand__full">Raízes de Aruanda · Admin</span>
                <span class="admin-brand__short">Admin</span>
            </a>
            <div class="admin-header__user">
                <?php if ($displayName !== ''): ?>
                    <a class="admin-header__name" href="/admin/perfil/" title="Meu perfil" aria-label="Meu perfil"<?php echo $perfilActive; ?>><?php echo $displayName; ?></a>
                <?php endif; ?>
                <a class="admin-header__logout" href="/admin/logout.php">Sair</a>
            </div>
        </div>
    </header>
    <div class="admin-layout">
            <?php if ($showSidebar): ?>
                <aside class="admin-sidebar">
                    <nav class="admin-nav" aria-label="Administração">
                        <?php if ($showCatalogNav): ?>
                            <a class="admin-nav__link" href="/admin/pontos/"<?php echo $pontosActive; ?>>Pontos</a>
                            <a class="admin-nav__link" href="/admin/linhas/"<?php echo $linhasActive; ?>>Linhas</a>
                            <a class="admin-nav__link" href="/admin/ritmos/"<?php echo $ritmosActive; ?>>Ritmos</a>
                        <?php endif; ?>
                        <?php if ($showAuditNav): ?>
                            <a class="admin-nav__link" href="/admin/auditoria/"<?php echo $auditoriaActive; ?>>Auditoria</a>
                        <?php endif; ?>
                    </nav>
                </aside>
            <?php endif; ?>
    <main class="admin-main">
    <?php
}

function admin_render_footer(): void
{
    ?>
    </main>
    </div>
</body>
</html>
    <?php
}
