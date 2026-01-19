<?php

final class NameAvailabilityService
{
    public function nameExists(string $html): bool
    {
<<<<<<< HEAD
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
=======
        // Heurística simples (MVP!)
        // O site do GUE mostra resultados numa tabela
        if (stripos($html, 'Nenhum registo encontrado') !== false) {
            return false;
        }

        // Se existir tabela ou resultados
        return stripos($html, '<table') !== false;
    }
>>>>>>> 7247bd5d16bc361dff6ac80555ed591a09c8ba5d
}
