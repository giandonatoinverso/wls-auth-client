<?php

require_once 'config/config.php';
require_once BASE_PATH . '/lib/HttpRequester/HttpRequester.php';

class OauthServerConnector {
    private string $host = '';
    private string $clientId = '';
    private string $clientSecret = '';
    private HttpRequester $http_request;

    public function __construct($clientId, $clientSecret) {
        $this->host = OAUTH_SERVER;
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->http_request = new HttpRequester();
    }

    private function get($url, $token = "", $data = array()) {

        $header = array(
            "ClientId: " . $this->clientId,
            "ClientSecret: " . $this->clientSecret,
            "Authorization: Bearer " . $token
        );

        $result = $this->http_request->get($url, $header, $data);

        if(isset($result["error"]))
            throw new Exception($result["error"], $result["httpCode"]);
        else
            return $result;
    }

    private function post($url, $token = "", $data = array()) {

        $header = array(
            "ClientId: " . $this->clientId,
            "ClientSecret: " . $this->clientSecret,
            "Authorization: Bearer " . $token,
            "Content-Type: application/json"
        );

        $result = $this->http_request->post($url, $header, $data);

        if(isset($result["error"]))
            throw new Exception($result["error"], $result["httpCode"]);
        else
            return $result;
    }

    public function getClientInfo() {
        $url = $this->host . "oauth/clientInfo/";

        $data = array(
            "clientId" => $this->clientId,
            "clientSecret" => $this->clientSecret
        );

        try {
            $result = $this->post($url, "", $data);
            return $result;

        } catch(Exception $e) {
            throw $e;
        }
    }

    public function getUserInfo($username, $password) {
        $url = $this->host . "oauth/userInfo/";

        $data = array(
            "username" => $username,
            "password" => $password
        );

        try {
            $result = $this->post($url, "", $data);
            return $result;

        } catch(Exception $e) {
            throw $e;
        }
    }

    public function getAuthorizationCode($userInfoToken) {
        $url = $this->host . "oauth/authorizationCode/";

        try {
            $result = $this->get($url, $userInfoToken);
            return $result;

        } catch(Exception $e) {
            throw $e;
        }
    }

    public function getClientId() {
        return $this->clientId;
    }

    public function getClientSecret() {
        return $this->clientSecret;
    }


    public function debug($data) {
        echo '<pre>' . var_export($data, true) . '</pre>';
        exit();
    }
}