<?php

/**
 * Exemplo de uso da API de NFE
 * 
 * Este arquivo demonstra como fazer requisições para a API
 * usando cURL ou outras bibliotecas HTTP.
 */

// Configurações da API
$apiUrl = 'https://seudominio.com/api/v1';
$apiKey = 'sua_api_key_aqui';

// Função para fazer requisições HTTP
function makeRequest($url, $method = 'GET', $data = null, $headers = [])
{
    $ch = curl_init();
    
    $defaultHeaders = [
        'Content-Type: application/json',
        'Accept: application/json',
        'User-Agent: NFE-API-Client/1.0'
    ];
    
    $headers = array_merge($defaultHeaders, $headers);
    
    curl_setopt_array($ch, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTPHEADER => $headers,
        CURLOPT_SSL_VERIFYPEER => true,
        CURLOPT_SSL_VERIFYHOST => 2
    ]);
    
    if ($method === 'POST') {
        curl_setopt($ch, CURLOPT_POST, true);
        if ($data) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }
    }
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    
    curl_close($ch);
    
    if ($error) {
        throw new Exception("Erro cURL: $error");
    }
    
    return [
        'status_code' => $httpCode,
        'body' => json_decode($response, true)
    ];
}

// Exemplo 1: Health Check
echo "=== Health Check ===\n";
try {
    $response = makeRequest("$apiUrl/health");
    echo "Status: " . $response['status_code'] . "\n";
    echo "Resposta: " . json_encode($response['body'], JSON_PRETTY_PRINT) . "\n\n";
} catch (Exception $e) {
    echo "Erro: " . $e->getMessage() . "\n\n";
}

// Exemplo 2: Consultar NFE
echo "=== Consultar NFE ===\n";
try {
    $data = [
        'chave_acesso' => '35150112345678901234567890123456789012345678'
    ];
    
    $response = makeRequest("$apiUrl/nfe/consultar", 'POST', $data);
    echo "Status: " . $response['status_code'] . "\n";
    echo "Resposta: " . json_encode($response['body'], JSON_PRETTY_PRINT) . "\n\n";
} catch (Exception $e) {
    echo "Erro: " . $e->getMessage() . "\n\n";
}

// Exemplo 3: Validar NFE
echo "=== Validar NFE ===\n";
try {
    $data = [
        'chave_acesso' => '35150112345678901234567890123456789012345678'
    ];
    
    $response = makeRequest("$apiUrl/nfe/validar", 'POST', $data);
    echo "Status: " . $response['status_code'] . "\n";
    echo "Resposta: " . json_encode($response['body'], JSON_PRETTY_PRINT) . "\n\n";
} catch (Exception $e) {
    echo "Erro: " . $e->getMessage() . "\n\n";
}

// Exemplo 4: Verificar Status
echo "=== Verificar Status ===\n";
try {
    $data = [
        'chave_acesso' => '35150112345678901234567890123456789012345678'
    ];
    
    $response = makeRequest("$apiUrl/nfe/status", 'POST', $data);
    echo "Status: " . $response['status_code'] . "\n";
    echo "Resposta: " . json_encode($response['body'], JSON_PRETTY_PRINT) . "\n\n";
} catch (Exception $e) {
    echo "Erro: " . $e->getMessage() . "\n\n";
}

// Exemplo 5: Consultar Destinatário
echo "=== Consultar Destinatário ===\n";
try {
    $data = [
        'chave_acesso' => '35150112345678901234567890123456789012345678'
    ];
    
    $response = makeRequest("$apiUrl/nfe/destinatario", 'POST', $data);
    echo "Status: " . $response['status_code'] . "\n";
    echo "Resposta: " . json_encode($response['body'], JSON_PRETTY_PRINT) . "\n\n";
} catch (Exception $e) {
    echo "Erro: " . $e->getMessage() . "\n\n";
}

// Exemplo usando Guzzle (se disponível)
echo "=== Exemplo com Guzzle ===\n";
if (class_exists('GuzzleHttp\Client')) {
    try {
        $client = new \GuzzleHttp\Client([
            'base_uri' => $apiUrl,
            'timeout' => 30,
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'User-Agent' => 'NFE-API-Client/1.0'
            ]
        ]);
        
        $response = $client->post('/nfe/consultar', [
            'json' => [
                'chave_acesso' => '35150112345678901234567890123456789012345678'
            ]
        ]);
        
        $data = json_decode($response->getBody()->getContents(), true);
        echo "Status: " . $response->getStatusCode() . "\n";
        echo "Resposta: " . json_encode($data, JSON_PRETTY_PRINT) . "\n\n";
        
    } catch (Exception $e) {
        echo "Erro: " . $e->getMessage() . "\n\n";
    }
} else {
    echo "Guzzle não está disponível. Instale com: composer require guzzlehttp/guzzle\n\n";
}

echo "=== Fim dos Exemplos ===\n"; 