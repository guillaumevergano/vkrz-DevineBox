<?php
$client_id = "cruj8q9rrkpkrwghdpgs";
$secret = "2165b05fe5594054a3dbb4d27cab254c";

// === 1. Obtenir le token ===
function getTuyaToken($client_id, $secret) {
    $timestamp = round(microtime(true) * 1000);
    $nonce = bin2hex(random_bytes(16));
    $method = "GET";
    $path = "/v1.0/token?grant_type=1";
    $url = "https://openapi.tuyaeu.com" . $path;

    $body_hash = hash('sha256', '');
    $stringToSign = $method . "\n" . $body_hash . "\n\n" . $path;
    $signStr = $client_id . $timestamp . $nonce . $stringToSign;
    $sign = strtoupper(hash_hmac('sha256', $signStr, $secret));

    $headers = [
        "client_id: $client_id",
        "t: $timestamp",
        "nonce: $nonce",
        "sign_method: HMAC-SHA256",
        "sign: $sign"
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $response = curl_exec($ch);
    curl_close($ch);

    $json = json_decode($response, true);
    return $json["result"]["access_token"] ?? null;
}

function sendGroupProperties($access_token, $client_id, $secret, $properties) {
    $timestamp = round(microtime(true) * 1000);
    $nonce = bin2hex(random_bytes(16));
    $method = "POST";
    $path = "/v2.0/cloud/thing/group/properties";
    $url = "https://openapi.tuyaeu.com" . $path;

    $payload = [
        "group_id" => "12717769",
        "properties" => $properties
    ];
    $body = json_encode($payload, JSON_UNESCAPED_SLASHES);
    $body_hash = hash('sha256', $body);

    $stringToSign = $method . "\n" . $body_hash . "\n\n" . $path;
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
    header('Content-Type: application/json');
    echo $response;
}

function sendColorCommand($access_token, $client_id, $secret, $device_id, $h = 0, $s = 1000, $v = 1000) {
    $timestamp = round(microtime(true) * 1000);
    $nonce = bin2hex(random_bytes(16));
    $method = "POST";
    $path = "/v1.0/iot-03/devices/$device_id/commands";
    $url = "https://openapi.tuyaeu.com" . $path;

    $payload = [
        "commands" => [
            [
                "code" => "colour_data_v2",
                "value" => [
                    "h" => $h,
                    "s" => $s,
                    "v" => $v
                ]
            ]
        ]
    ];
    $body = json_encode($payload, JSON_UNESCAPED_SLASHES);
    $body_hash = hash('sha256', $body);

    $stringToSign = $method . "\n" . $body_hash . "\n\n" . $path;
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
    curl_close($ch);

    return json_decode($response, true);
}

$array_lamp = [
    ['num_lamp' => 1, 'id_lamp' => 'bfe3274eb32ec3b8415k1g'],
    ['num_lamp' => 2, 'id_lamp' => 'bf66d769548c66895aa7wn'],
    ['num_lamp' => 3, 'id_lamp' => 'bf635bd67ca0552054gprb'],
    ['num_lamp' => 4, 'id_lamp' => 'bf9d17dcb317aa8eafc42c'],
    ['num_lamp' => 5, 'id_lamp' => 'bf8171b908d7da6c8eztuv'],
    ['num_lamp' => 6, 'id_lamp' => 'bfb22c704aca6596b1zdgy'],
    ['num_lamp' => 7, 'id_lamp' => 'bf5c94b20ba80b1ce3akgc'],
    ['num_lamp' => 8, 'id_lamp' => 'bf720df872433721fboegd'],
    ['num_lamp' => 9, 'id_lamp' => 'bff26538836e8d695aqa30'],
    ['num_lamp' => 10, 'id_lamp' => 'bf043979fea49251c1wp25']
];