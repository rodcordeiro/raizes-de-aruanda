<?php

declare(strict_types=1);

date_default_timezone_set('America/Sao_Paulo');
header('Content-Type: application/json; charset=utf-8');

const CATALOGO_BASE = 'https://raizes.rodrigocordeiro.com.br/index.php';
const REGENTES_ANO = ['Omulu', 'Oxum'];

function json_out(array $data, int $statusCode = 200): void
{
    http_response_code($statusCode);
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit;
}

function saudacao_por_hora(?DateTimeInterface $now = null): string
{
    $now ??= new DateTimeImmutable('now', new DateTimeZone('America/Sao_Paulo'));
    $h = (int)$now->format('G'); // 0-23
    if ($h >= 5 && $h < 12) return 'Bom dia';
    if ($h >= 12 && $h < 18) return 'Boa tarde';
    return 'Boa noite';
}

function ids_de_linha_da_query(?string $raw): array
{
    if ($raw === null || trim($raw) === '') {
        return [];
    }

    $partes = array_map('trim', explode(',', $raw));
    return array_values(array_unique(array_filter($partes, fn($v) => ctype_digit($v) && (int)$v > 0)));
}

function buscar_ponto_aleatorio(PDO $pdo, array $linhaIds = [], array $linhaNomes = [], array $excluirPontoIds = []): ?array
{
    $where = [];
    $params = [];

    if (!empty($linhaIds)) {
        $in = [];
        foreach (array_values($linhaIds) as $i => $linhaId) {
            $key = ":lid{$i}";
            $in[] = $key;
            $params[$key] = (int)$linhaId;
        }
        $where[] = 'a.linha IN (' . implode(',', $in) . ')';
    }

    if (!empty($linhaNomes)) {
        $in = [];
        foreach (array_values($linhaNomes) as $i => $nome) {
            $key = ":ln{$i}";
            $in[] = $key;
            $params[$key] = $nome;
        }
        $where[] = 'b.nome IN (' . implode(',', $in) . ')';
    }

    if (!empty($excluirPontoIds)) {
        $in = [];
        foreach (array_values($excluirPontoIds) as $i => $pontoId) {
            $key = ":xid{$i}";
            $in[] = $key;
            $params[$key] = (int)$pontoId;
        }
        $where[] = 'a.id NOT IN (' . implode(',', $in) . ')';
    }

    $whereSql = empty($where) ? '' : 'WHERE ' . implode(' AND ', $where);

    $query = "
        SELECT
            a.id,
            a.letra,
            a.audio_url,
            b.nome AS linha,
            b.saudacao
        FROM tb_pontos a
        JOIN tb_linhas b ON a.linha = b.id
        $whereSql
        ORDER BY RAND()
        LIMIT 1
    ";

    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    $row = $stmt->fetch();

    return $row ?: null;
}

function anunciar_ponto(array $ponto): string
{
    $nome = (string)$ponto['linha'];
    $saudacao = trim((string)($ponto['saudacao'] ?? ''));
    if ($saudacao === '') {
        return $nome;
    }
    return $nome . ', *' . $saudacao . '*';
}

function bloco_letra(array $ponto): string
{
    $letra = str_replace(["\r\n", "\r"], "\n", trim((string)$ponto['letra']));
    $audio = trim((string)($ponto['audio_url'] ?? ''));
    $link = CATALOGO_BASE . '?buscar=' . rawurlencode((string)$ponto['linha']) . '#' . (int)$ponto['id'];

    $linhas = ["```\n{$letra}\n```"];
    if ($audio !== '') {
        $linhas[] = $audio;
    }
    $linhas[] = $link;

    return implode("\n", $linhas);
}

function montar_mensagem(string $saudacaoHora, array $regente, array $gira): string
{
    $regentesItalico = array_map(fn(string $nome) => "_{$nome}_", REGENTES_ANO);

    return $saudacaoHora . ', a benção pais, mães e mais velhos e que Logun Edé e Exu nos abençoem e bora de ponto.' . "\n"
        . 'Este ano nossa casa é regida por ' . implode(' e ', $regentesItalico)
        . ', e hoje vamos com um ponto de ' . anunciar_ponto($regente) . ".\n\n"
        . bloco_letra($regente) . "\n\n"
        . 'E para a gira dessa semana, vamos com um ponto de ' . anunciar_ponto($gira) . ".\n\n"
        . bloco_letra($gira);
}

$host     = getenv('CONN_URI') ?: '';
$username = getenv('ICNT_MYSQL_USER') ?: '';
$password = getenv('ICNT_MYSQL_PASSWORD') ?: '';
$database = getenv('ICNT_MYSQL_DATABASE') ?: '';
$discordWebhook = getenv('DISCORD_WEBHOOK') ?: '';

if ($host === '' || $username === '' || $database === '' || $discordWebhook === '') {
    json_out(["mensagem" => "Variáveis de ambiente obrigatórias não configuradas."], 500);
}

try {
    $dsn = "mysql:host={$host};dbname={$database};charset=utf8mb4";
    $pdo = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ]);
} catch (PDOException $e) {
    json_out(["mensagem" => "Erro de conexão com o banco."], 500);
}

$linhasFiltro = ids_de_linha_da_query(isset($_GET['linha']) ? (string)$_GET['linha'] : null);
$nomesRegentes = REGENTES_ANO;
shuffle($nomesRegentes);

try {
    $pontoRegente = null;
    foreach ($nomesRegentes as $nomeRegente) {
        $pontoRegente = buscar_ponto_aleatorio($pdo, [], [$nomeRegente]);
        if ($pontoRegente !== null) {
            break;
        }
    }

    $pontoGira = buscar_ponto_aleatorio(
        $pdo,
        $linhasFiltro,
        [],
        $pontoRegente ? [(int)$pontoRegente['id']] : []
    );
} catch (PDOException $e) {
    json_out(["mensagem" => "Erro ao consultar pontos."], 500);
}

if ($pontoRegente === null || $pontoGira === null) {
    json_out(["mensagem" => "Nenhum ponto encontrado"], 404);
}

$mensagem = montar_mensagem(saudacao_por_hora(), $pontoRegente, $pontoGira);

$payload = json_encode(["content" => $mensagem], JSON_UNESCAPED_UNICODE);

$ch = curl_init($discordWebhook);
curl_setopt_array($ch, [
    CURLOPT_CUSTOMREQUEST  => "POST",
    CURLOPT_POSTFIELDS     => $payload,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER     => [
        'Content-Type: application/json',
        'Content-Length: ' . strlen($payload),
    ],
    CURLOPT_TIMEOUT        => 15,
]);

$response  = curl_exec($ch);
$curlError = curl_error($ch);
$httpCode  = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($response === false || $httpCode < 200 || $httpCode >= 300) {
    json_out([
        "mensagem" => "Falha ao enviar mensagem ao Discord.",
        "httpCode" => $httpCode,
        "erro"     => $curlError ?: null,
        "resposta" => $response ?: null,
    ], 502);
}

json_out(["mensagem" => $mensagem]);
