<?php
include_once "get_token.php";

// Lire le POST JSON envoyé depuis JS
$input = json_decode(file_get_contents('php://input'), true);
$id_lamp = $input['id_lamp'] ?? null;
$color = $input['color'] ?? null;

if (!$id_lamp || !$color) {
    http_response_code(400);
    echo json_encode(['error' => 'Paramètres manquants']);
    exit;
}

function sendColorCommandToLamp($access_token, $client_id, $secret, $device_id, $color) {
    $timestamp = round(microtime(true) * 1000);
    $nonce = bin2hex(random_bytes(16));
    $path = "/v1.0/iot-03/devices/{$device_id}/commands";
    $url = "https://openapi.tuyaeu.com" . $path;

    $payload = [
        "commands" => [
            [
                "code" => "colour_data_v2",
                "value" => $color
            ]
        ]
    ];
    $body = json_encode($payload, JSON_UNESCAPED_SLASHES);
    $body_hash = hash('sha256', $body);
    $stringToSign = "POST\n{$body_hash}\n\n{$path}";
    $signStr = $client_id . $access_token . $timestamp . $nonce . $stringToSign;
    $sign = strtoupper(hash_hmac('sha256', $signStr, $secret));

    $headers = [
        "client_id: $client_id",
        "access_token: $access_token",
        "t: $timestamp",
        "nonce: $nonce",
        "sign_method: HMAC-SHA256",
        "sign: $sign",
        "Content-Type: application/json"
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    http_response_code($httpCode);
    return $response;
}

// Exécution
$token = getTuyaToken($client_id, $secret);
if ($token) {
    header('Content-Type: application/json');
    echo sendColorCommandToLamp($token, $client_id, $secret, $id_lamp, $color);
} else {
    http_response_code(500);
    echo json_encode(['error' => 'Échec récupération access_token']);
}