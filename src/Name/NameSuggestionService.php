<?php

final class NameSuggestionService
{
    private array $suffixes = [
<<<<<<< HEAD
        'Serviços', 'Comercial', 'Grupo',
        'Tech', 'Digital', 'Logística', 'Express'
    ];

    private int $maxSuggestions = 8;
    private float $rootSimilarityThreshold = 0.70;

    public function suggest(string $baseName, array $existingNames = []): array
    {
        $suggestions = [];
        $baseNorm = $this->normalize($baseName);

        $roots = $this->generateGenericRoots($baseName);

        foreach ($roots as $root) {

            // raiz ainda demasiado parecida com a original
            if ($this->similar($this->normalize($root), $baseNorm) >= $this->rootSimilarityThreshold) {
                continue;
            }

            // raiz conflita com nomes existentes
            if ($this->rootConflicts($root, $existingNames)) {
                continue;
            }

            // um sufixo por raiz
            $suffix = $this->suffixes[array_rand($this->suffixes)];
            $candidate = $root . ' ' . $suffix;

            // nome final conflita
            if ($this->nameConflicts($candidate, $existingNames)) {
                continue;
            }

            $suggestions[] = $candidate;

            if (count($suggestions) >= $this->maxSuggestions) {
                break;
            }
=======
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
>>>>>>> 7247bd5d16bc361dff6ac80555ed591a09c8ba5d
        }

        return $suggestions;
    }
<<<<<<< HEAD

    /**
     * Geração genérica de raízes (independente do nome)
     */
    private function generateGenericRoots(string $name): array
    {
        $n = mb_strtolower($name);
        $len = mb_strlen($n);

        $roots = [];

        // 1️⃣ cortes estruturais
        if ($len >= 5) {
            $roots[] = mb_substr($n, 0, 4);
            $roots[] = mb_substr($n, 0, 3) . mb_substr($n, -1);
            $roots[] = mb_substr($n, 1, 4);
        }

        // 2️⃣ deslocamento interno
        if ($len >= 6) {
            $roots[] = mb_substr($n, 0, 2) . mb_substr($n, 3, 2);
        }

        // 3️⃣ variação fonética genérica
        $roots[] = $this->phoneticTransform($n);

        // 4️⃣ extensões neutras (brandáveis)
        $roots[] = mb_substr($n, 0, 3) . 'ex';
        $roots[] = mb_substr($n, 0, 3) . 'on';
        $roots[] = mb_substr($n, 0, 4) . 'a';
        $roots[] = 'neo' . mb_substr($n, 0, 3);

        return array_unique(array_map('ucfirst', $roots));
    }

    /**
     * Transformação fonética genérica (serve para qualquer nome)
     */
    private function phoneticTransform(string $name): string
    {
        $map = [
            'ph' => 'f',
            'ck' => 'k',
            'qu' => 'k',
            'x'  => 'ks',
            'y'  => 'i',
            'z'  => 's',
            'ss' => 's',
            'll' => 'l',
        ];

        return str_replace(
            array_keys($map),
            array_values($map),
            $name
        );
    }

    private function rootConflicts(string $root, array $existingNames): bool
    {
        $rootNorm = $this->normalize($root);

        foreach ($existingNames as $existing) {
            if ($this->similar($rootNorm, $this->normalize($existing)) >= 0.6) {
                return true;
            }
        }
        return false;
    }

    private function nameConflicts(string $candidate, array $existingNames): bool
    {
        $candNorm = $this->normalize($candidate);

        foreach ($existingNames as $existing) {
            if ($this->similar($candNorm, $this->normalize($existing)) >= 0.7) {
                return true;
            }
        }
        return false;
    }

    private function normalize(string $str): string
    {
        return preg_replace('/[^a-z0-9]/u', '', mb_strtolower($str));
    }

    private function similar(string $a, string $b): float
    {
        similar_text($a, $b, $p);
        return $p / 100;
    }
=======
>>>>>>> 7247bd5d16bc361dff6ac80555ed591a09c8ba5d
}
