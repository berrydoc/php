<?php

namespace BerryDoc\Php;

use Exception;

class DocumentGenerator 
{
    /**
     * The API URL for document generation.
     *
     * @var string
     */
    private string $apiUrl = "https://app.berrydoc.io/serv/api";

    /**
     * The email address used for authentication.
     *
     * @var string
     */
    private string $email;

    /**
     * The password used for authentication.
     *
     * @var string
     */
    private string $password;

    /**
     * The cookies used for authentication.
     *
     * @var string
     */
    protected string $cookies;
    
    /**
     * Initialize the DocumentGenerator class with the API URL, email address, and password.
     *
     * @param string $apiUrl
     * @param string $email
     * @param string $password
     */
    public function __construct(string $email, string $password) 
    {
        $this->email = $email;
        $this->password = $password;

        $this->login();
    }

    /**
     * Makes a request to the API and returns the response.
     *
     * @param string $url
     * @param string $method
     * @param array $body
     * @param array $header
     * @return string
     * @throws Exception
     */
    private function request(string $url, string $method, array $body = [], array $header = []) 
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_VERBOSE, false);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
          'Content-Type: application/json',
          (isset($this->cookies) ? $this->cookies : '')
        ]);
        
        $response = curl_exec($ch);
        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $header = substr($response, 0, $header_size);
        $body = substr($response, $header_size);
        $err = curl_error($ch);

        curl_close($ch);

        $this->setCookies($status, $header);

        if ($err) {
            throw new Exception($err);
        }

        if ($status >= 400) {
          throw new Exception($body);
        }

        return $body;
    }

    /**
     * Extracts and sets session cookies from the response header
     *
     * @param int $status
     * @param string $header
     * @return void
     */
    private function setCookies(int $status, $header)
    {
        if ($status === 401) {
            unset($this->cookies);
            return;
        }

        // Extract cookies from the header and store it in the `cookies` property
        if (preg_match_all('/^Set-Cookie:\s*([^;]*)/mi', $header, $matches)) {
            $cookies = [];
            foreach($matches[1] as $item) {
                $cookies[] = $item;
            }
            
            $this->cookies = 'Cookie: ' . join(";", $cookies);
        }
    }

    public function login()
    {
        $url = $this->apiUrl . "/auth/login";

        $body = [
          "email" => $this->email, 
          "password" => $this->password
        ];
        
        $response = $this->request($url, "POST", $body);
        return json_decode($response, true);
    }

    public function logout()
    {
        $url = $this->apiUrl . "/auth/logout";

        $response = $this->request($url, "GET");
        return json_decode($response, true);
    }

    public function getTemplates(int $per_page = 0, int $page = 1)
    {
        $url = $this->apiUrl . "/templates";

        $body = [];
        if ($per_page > 0) {
            $body = [
              "per_page" => $per_page,
              "page" => $page
            ];
        }
        
        $response = $this->request($url, "GET", $body);
        return json_decode($response, true);
    }

    public function getTemplateById(string $id) 
    {
        $url = $this->apiUrl . "/templates/" . $id;
        
        $response = $this->request($url, "GET");
        return json_decode($response, true);
    }

    public function generate(string $id, array $data, string $format, string $output)
    {
        $url = $this->apiUrl . "/templates/" . $id . "/generate";

        $body = [
          "data" => $data,
          "format" => $format,
          "output" => $output
        ];

        return $this->request($url, "POST", $body);
    }
}
