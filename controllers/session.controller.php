<?php

$timeout = 14400; // Tempo da sessao em segundos
// Verifica se existe o parametro timeout, ou seja, se a sessão foi iniciada
if (isset($_SESSION['timeout'])) {
    // Calcula o tempo que ja se passou desde a criação da sessao
    $duracao = time() - (int) $_SESSION['timeout'];
    // Verifica se ja expirou o tempo da sessao
    if ($duracao > $timeout) {
        // Destroi a sessao e cria uma nova
        session_destroy();
        session_start();
    }
} else {
    // Define o timeout com o horario atual
    session_start();
    $_SESSION['timeout'] = time();
}



class User
{
    private $connection;
    private $table_name = 'icnt_users';
    public $id;
    public $username;
    public $pwd;

    private function redirect($url)
    {
        if (headers_sent()) {
            die('<script type="text/javascript">window.location=\'' . $url . '\';</script>');
        } else {
            header('Location: ' . $url);
            die();
        }
    }

    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    public function isAuthenticated()
    {
        if (!isset($_SESSION['user'])) {
            $this->redirect('http://rodrigocordeiro.com.br/Umbanda/admin/login');
        }
    }
    public function login()
    {
        $sql = "SELECT * FROM " . $this->table_name . " WHERE username='" . $this->username . "' and password = '" . $this->password . "';";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $data = '';
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if ($row) {
                extract($row);
                $_SESSION['uid'] = $id;
                $_SESSION['user'] = $username;
                $this->redirect('http://rodrigocordeiro.com.br/Umbanda/admin/');
            }
        }
    }
}
