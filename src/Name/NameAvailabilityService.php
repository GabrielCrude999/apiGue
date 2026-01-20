<?php

final class NameAvailabilityService
{
    public function nameExists(string $html): bool
    {
        if (stripos($html, 'Nenhum registo encontrado') !== false) {
            return false;
        }
        return stripos($html, '<table') !== false;
    }

    public function extractNames(string $html): array
    {
        $names = [];
        if (preg_match_all('/<td[^>]*>(.*?)<\/td>/i', $html, $matches)) {
            foreach ($matches[1] as $td) {
                $clean = trim(strip_tags($td));
                if ($clean !== '') {
                    $names[] = $clean;
                }
            }
        }
        return array_unique($names);
    }
}
