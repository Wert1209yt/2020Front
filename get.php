<?php

function innertubeRequest(string $endpoint, array $payload = [], array $headers = []): ?array {
    $ch = curl_init($endpoint);

    $defaultHeaders = [
        'Content-Type: application/json',
        'Accept: application/json',
        'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
    ];

    // Объединяем заголовки
    $allHeaders = array_merge($defaultHeaders, $headers);

    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_HTTPHEADER => $allHeaders,
        CURLOPT_POSTFIELDS => json_encode($payload),
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_SSL_VERIFYPEER => true,
    ]);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if (curl_errno($ch)) {
        error_log('Curl error: ' . curl_error($ch));
        curl_close($ch);
        return null;
    }

    curl_close($ch);

    // Проверяем HTTP код
    if ($httpCode < 200 || $httpCode >= 300) {
        error_log("Innertube request failed with HTTP code $httpCode");
        return null;
    }

    if (json_last_error() !== JSON_ERROR_NONE) {
        error_log('JSON decode error: ' . json_last_error_msg());
        return null;
    }

    return $response;
}
?>