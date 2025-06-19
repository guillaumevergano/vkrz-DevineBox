<?php
$client_id = "cruj8q9rrkpkrwghdpgs";
$secret = "2165b05fe5594054a3dbb4d27cab254c";

$timestamp = round(microtime(true) * 1000); // 13-digit timestamp
$nonce = uuid_create(); // Requires PHP >= 7.0 with uuid PECL extension

$method = "GET";
$path = "/v1.0/token";
$query = "grant_type=1";
$url = "https://openapi.tuyaeu.com$path?$query";

// === Step 1: Hash of empty body
$empty_body_hash = hash('sha256', ''); // SHA256 of empty string

// === Step 2: Build stringToSign
$stringToSign = $method . "\n" .
                $empty_body_hash . "\n" .
                "\n" .
                "$path?$query";

// === Step 3: Final string for HMAC
$signStr = $client_id . $timestamp . $nonce . $stringToSign;

// === Step 4: Generate HMAC-SHA256 and uppercase
$sign = strtoupper(hash_hmac('sha256', $signStr, $secret));

// === Step 5: Prepare headers
$headers = [
    "client_id: $client_id",
    "sign: $sign",
    "t: $timestamp",
    "sign_method: HMAC-SHA256",
    "nonce: $nonce"
];

// === Step 6: Make cURL request
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

// === Step 7: Return JSON
http_response_code($httpCode);
header('Content-Type: application/json');
echo $response;