<?php

final class NameSuggestionService
{
    private array $suffixes = [
        'geral' => ['Serviços', 'Comercial', 'Grupo', 'Soluções'],
        'tecnologia' => ['Tech', 'Digital', 'Systems', 'Innovation', 'Labs', 'Solutions', 'Next'],
        'construcao' => ['Construções', 'Engenharia', 'Obras', 'Projetos', 'Master'],
        'transporte' => ['Logística', 'Transportes', 'Cargo', 'Express', 'Rápido'],
    ];

    private array $commonSuffixes = ['& Filhos', 'Associados', 'Group'];

    public function suggest(string $baseName, string $area): array
    {
        $area = strtolower($area);
        $options = $this->suffixes[$area] ?? $this->suffixes['geral'];

        // Adiciona os sufixos universais
        $options = array_merge($options, $this->commonSuffixes);

        $suggestions = [];

        // Apenas concatena baseName + sufixo (não permutar)
        foreach ($options as $suffix) {
            $suggestions[] = $baseName . ' ' . $suffix;
        }

        // Para a categoria geral, limita a 6 resultados
        if ($area === 'geral') {
            return array_slice($suggestions, 0, 6);
        }

        return $suggestions;
    }
}
