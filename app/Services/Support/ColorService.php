<?php

namespace App\Services\Support;

class ColorService
{
    public function generateColor(): string
    {
        return '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
    }

    public function generateColorPalette(int $count): array
    {
        $colors = [];
        for ($i = 0; $i < $count; $i++) {
            $colors[] = $this->generateColor();
        }
        return $colors;
    }

    public function adjustBrightness(string $hex, int $steps): string
    {
        $steps = max(-255, min(255, $steps));
        $hex = str_replace('#', '', $hex);

        if (strlen($hex) == 3) {
            $hex = str_repeat(substr($hex, 0, 1), 2) .
                str_repeat(substr($hex, 1, 1), 2) .
                str_repeat(substr($hex, 2, 1), 2);
        }

        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 1, 2));
        $b = hexdec(substr($hex, 2, 2));

        $r = max(0, min(255, $r + $steps));
        $g = max(0, min(255, $g + $steps));
        $b = max(0, min(255, $b + $steps));

        return '#' . str_pad(dechex($r), 2, '0', STR_PAD_LEFT) .
            str_pad(dechex($g), 2, '0', STR_PAD_LEFT) .
            str_pad(dechex($b), 2, '0', STR_PAD_LEFT);
    }
}
