<?php

require_once '__ajax.php';

\Geekality\CrossOriginProxy::proxy([
    ['host' => 'crashteamranking.com'],
    ['host' => 'github.com'],
]);
