<?php
// bot.php
date_default_timezone_set('America/Sao_Paulo');
header('Content-Type: application/json; charset=utf-8');

// Configurações do banco (ajuste conforme seu ambiente)
$host = getenv('CONN_URI');
$username = getenv('ICNT_MYSQL_USER');
$password = getenv('ICNT_MYSQL_PASSWORD');
$database = getenv('ICNT_MYSQL_DATABASE');

// URL do seu webhook do Discord
$discordWebhook = getenv('DISCORD_WEBHOOK');

try {
    $pdo = new PDO("mysql:host=$host;dbname=$database;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e){
    echo json_encode(["mensagem" => "Erro de conexão: " . $e->getMessage()]);
    exit;
}

// Captura parâmetro ?linha=8,25,...
$linhas = [];
$where = "";

if (isset($_GET['linha']) && !empty($_GET['linha'])) {
    $linhas = explode(",", $_GET['linha']);
    $placeholders = implode(",", array_fill(0, count($linhas), "?"));
    $where = "WHERE a.linha IN ($placeholders)";
}

$query = "
    SELECT
      CONCAT(
        'Bom dia gente, benção pais, mães e mais velhos e que Logun Edé e Exu nos abençoem e bora de ponto. Ponto de ',
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
        CASE
          WHEN a.audio_url IS NOT NULL THEN a.audio_url
          ELSE ''
        END,
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

$stmt = $pdo->prepare($query);
try { 
    // Se houver linhas, passa como parâmetros, senão executa sem WHERE
    if (!empty($linhas)) {
        $stmt->execute($linhas);
    } else {
        $stmt->execute();
    }
} catch(PDOException $e){
    echo json_encode(["mensagem" => "Erro de conexão: " . $e->getMessage()]);
    exit;
}

$result = $stmt->fetch(PDO::FETCH_ASSOC);

if ($result) {
    $mensagem = $result["ponto"];

    // Envia para Discord
    $payload = json_encode([
        "content" => $mensagem
    ], JSON_UNESCAPED_UNICODE);

    $ch = curl_init($discordWebhook);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Content-Length: ' . strlen($payload)
    ]);
    $response = curl_exec($ch);
    curl_close($ch);

    echo json_encode(["mensagem" => $mensagem], JSON_UNESCAPED_UNICODE);
} else {
    echo json_encode(["mensagem" => "Nenhum ponto encontrado"]);
}
