<?php
include_once "get_token.php";

$token = getTuyaToken($client_id, $secret);
$results = [];

if ($token) {
    foreach ($array_lamp as $lamp) {
        $res = sendColorCommand($token, $client_id, $secret, $lamp['id_lamp']);
        $results[] = [
            'lamp' => $lamp['num_lamp'],
            'id' => $lamp['id_lamp'],
            'response' => $res
        ];
    }
    header('Content-Type: application/json');
    echo json_encode(['success' => true, 'results' => $results], JSON_PRETTY_PRINT);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Impossible de récupérer le token']);
}