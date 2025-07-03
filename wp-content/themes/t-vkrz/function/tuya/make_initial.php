<?php
include_once "get_token.php";
$token = getTuyaToken($client_id, $secret);
if ($token) {
    sendGroupProperties($token, $client_id, $secret, "{\"work_mode\":\"scene\"}");
} else {
    http_response_code(500);
    echo json_encode(["error" => "Impossible de récupérer le token Tuya"]);
}