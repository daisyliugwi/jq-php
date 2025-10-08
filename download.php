<?php
$azureKey = 'e0ba48b4ef4744ec8200f833c1e7b43b';
$azureUrl = 'https://offsetsregister.detsi.qld.gov.au/api/offsetsregister/authorities/v1/exceldownload';

$ch = curl_init($azureUrl);

curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Ocp-Apim-Subscription-Key: ' . $azureKey
]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 30); // timeout after 30s

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
$headers = substr($response, 0, $header_size);
$body = substr($response, $header_size);

curl_close($ch);

// Handle errors
if ($httpCode !== 200 || !$body) {
    http_response_code(500);
    echo "Failed to download file from Azure.";
    exit;
}

// Send headers to browser
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="report.xlsx"');
echo $body;
