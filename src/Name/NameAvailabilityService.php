<?php

final class NameAvailabilityService
{
    public function nameExists(string $html): bool
    {
        // Heurística simples (MVP!)
        // O site do GUE mostra resultados numa tabela
        if (stripos($html, 'Nenhum registo encontrado') !== false) {
            return false;
        }

        // Se existir tabela ou resultados
        return stripos($html, '<table') !== false;
    }
}
