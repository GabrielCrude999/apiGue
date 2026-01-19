<?php

final class GueClient
{
    private string $baseUrl = 'https://gue.gov.ao/portal/publicacao';

    public function searchByName(string $companyName): string
    {
        $query = http_build_query([
            'empresa'  => $companyName,
            'nome'     => '',
            'ndi'      => '',
            'telefone' => ''
        ]);

        $url = $this->baseUrl . '?' . $query;

        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_TIMEOUT => 15,
            CURLOPT_USERAGENT => 'Mozilla/5.0 (MVP Name Checker)'
        ]);

        $html = curl_exec($ch);

        if ($html === false) {
            throw new RuntimeException('Erro ao contactar o GUE');
        }

        curl_close($ch);

        return $html;
    }
}
