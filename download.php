<?php
// Replace with your actual Azure subscription key and API URL
$azureKey = 'e0ba48b4ef4744ec8200f833c1e7b43b';  // DO NOT expose this in frontend!
$azureUrl = 'https://offsetsregister.detsi.qld.gov.au/api/offsetsregister/authorities/v1/exceldownload';

// Initialize cURL session
$ch = curl_init($azureUrl);

// Set cURL options
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Ocp-Apim-Subscription-Key: ' . $azureKey
]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

// Execute the request
$response = curl_exec($ch);
$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
$headers = substr($response, 0, $header_size);
$body = substr($response, $header_size);

// Close the session
curl_close($ch);

// Send headers to client
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="report.xlsx"');
echo $body;
