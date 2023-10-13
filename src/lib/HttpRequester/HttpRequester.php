<?php

class HttpRequester {
    function get($url, $header = array(), $data = array()) {
        $query = http_build_query($data);

        if (!empty($query)) {
            $url = $url . '?' . $query;
        }

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        $responseData = json_decode($response, true);

        if ($httpCode >= 400) {
            if ($responseData && isset($responseData['error'])) {
                $result = array("httpCode" => $httpCode, "error" => $responseData['error']);
            } else {
                $result = array("httpCode" => $httpCode, "error" => "Errore HTTP senza messaggio.");
            }
        } else {
            $result = array("httpCode" => $httpCode, "data" => $responseData);
        }

        curl_close($ch);

        return $result;
    }

    function post($url, $header = array(), $data = array()) {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        $responseData = json_decode($response, true);

        if ($httpCode >= 400) {
            if ($responseData && isset($responseData['error'])) {
                $result = array("httpCode" => $httpCode, "error" => $responseData['error']);
            } else {
                $result = array("httpCode" => $httpCode, "error" => "Errore HTTP senza messaggio.");
            }
        } else {
            $result = array("httpCode" => $httpCode, "data" => $responseData);
        }

        curl_close($ch);

        return $result;
    }
}