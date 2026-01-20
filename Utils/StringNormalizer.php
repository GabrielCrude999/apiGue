<?php

final class StringNormalizer
{
    public static function normalize(string $value): string
    {
        $value = trim(mb_strtolower($value));
        $value = iconv('UTF-8', 'ASCII//TRANSLIT', $value);
        $value = preg_replace('/[^a-z0-9 ]/', '', $value);

        return preg_replace('/\s+/', ' ', $value);
    }
}
