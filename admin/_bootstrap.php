<?php

require_once __DIR__ . '/../db/db.class.php';
require_once __DIR__ . '/../utils/functions.php';
require_once __DIR__ . '/../controllers/audit.controller.php';
require_once __DIR__ . '/../controllers/rbac.controller.php';
require_once __DIR__ . '/../controllers/session.controller.php';

admin_session_start();

$db = new DBClass();
$connection = $db->getConnection();
