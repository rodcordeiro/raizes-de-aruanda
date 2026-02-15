<?php
declare(strict_types=1);

date_default_timezone_set('America/Sao_Paulo');
header('Content-Type: application/json; charset=utf-8');

function json_out(array $data, int $statusCode = 200): void {
    http_response_code($statusCode);
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit;
}

function saudacao_por_hora(?DateTimeInterface $now = null): string {
    $now ??= new DateTimeImmutable('now', new DateTimeZone('America/Sao_Paulo'));
    $h = (int)$now->format('G'); // 0-23
    if ($h >= 5 && $h < 12) return 'Bom dia';
    if ($h >= 12 && $h < 18) return 'Boa tarde';
    return 'Boa noite';
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

// ?linha=8,25,...
$linhas = [];
$where  = "";
$params = [
    ':saudacao' => saudacao_por_hora(),
];

if (isset($_GET['linha']) && trim((string)$_GET['linha']) !== '') {
    $raw = array_map('trim', explode(',', (string)$_GET['linha']));
    $linhas = array_values(array_unique(array_filter($raw, fn($v) => ctype_digit($v) && (int)$v > 0)));

    if (!empty($linhas)) {
        $in = [];
        foreach ($linhas as $i => $linhaId) {
            $key = ":l{$i}";
            $in[] = $key;
            $params[$key] = (int)$linhaId;
        }
        $where = "WHERE a.linha IN (" . implode(',', $in) . ")";
    }
}

$query = "
    SELECT
      CONCAT(
        :saudacao, ' gente, benção pais, mães e mais velhos e que Logun Edé e Exu nos abençoem e bora de ponto. Ponto de ',
        CASE
          WHEN a.tipo LIKE '%subida%' THEN 'subida de '
          ELSE ''
        END,
        b.nome,
        ', no ritmo ',
        c.nome,
        '. *',
        b.saudacao,
        '*.\n\n```\n',
        a.letra,
        '\n```\n',
        COALESCE(a.audio_url, ''),
        '\n\nMais pontos de ',
        b.nome,
        ' no https://raizes.rodrigocordeiro.com.br/index.php?buscar=',
        REPLACE(b.nome, ' ', '%20'),
        '#',
        a.id
      ) AS ponto
    FROM tb_pontos a
    JOIN tb_linhas b ON a.linha = b.id
    JOIN tb_ritmos c ON a.ritmo = c.id
    $where
    ORDER BY RAND()
    LIMIT 1
";

try {
    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    $result = $stmt->fetch();
} catch (PDOException $e) {
    // Para depurar rápido sem vazar detalhes em produção:
    // json_out(["mensagem"=>"Erro ao consultar pontos.", "detalhe"=>$e->getMessage()], 500);
    json_out(["mensagem" => "Erro ao consultar pontos."], 500);
}

if (!$result || empty($result['ponto'])) {
    json_out(["mensagem" => "Nenhum ponto encontrado"], 404);
}

$mensagem = $result['ponto'];

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
