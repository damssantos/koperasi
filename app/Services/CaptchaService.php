<?php

namespace App\Services;

class CaptchaService
{
    protected const CHARACTERS = '23456789ABCDEFGHJKMNPQRSTUVWXYZ';

    /**
     * Generate a new captcha code and store in session.
     */
    public static function generate(int $length = 5): string
    {
        $charactersLength = strlen(self::CHARACTERS);
        $code = '';

        for ($i = 0; $i < $length; $i++) {
            $code .= self::CHARACTERS[random_int(0, $charactersLength - 1)];
        }

        session(['captcha_code' => $code]);

        return $code;
    }

    /**
     * Validate the given captcha code.
     */
    public static function validate(?string $input): bool
    {
        $expected = session('captcha_code');

        // Always invalidate the current captcha after validation attempt
        session()->forget('captcha_code');

        if (empty($expected) || empty($input)) {
            return false;
        }

        return hash_equals(strtoupper(trim($expected)), strtoupper(trim($input)));
    }

    /**
     * Render SVG captcha image.
     */
    public static function renderSvg(?string $code = null): string
    {
        if (empty($code)) {
            $code = self::generate();
        }

        $width = 180;
        $height = 46;
        $length = strlen($code);

        // Palette of modern colors for characters
        $colors = ['#1D4ED8', '#2563EB', '#0D9488', '#0284C7', '#4F46E5', '#7C3AED', '#0369A1'];

        // Noise lines
        $lines = '';
        for ($i = 0; $i < 4; $i++) {
            $x1 = random_int(5, 30);
            $y1 = random_int(5, $height - 5);
            $x2 = random_int($width - 30, $width - 5);
            $y2 = random_int(5, $height - 5);
            $stroke = $colors[array_rand($colors)];
            $lines .= "<line x1='{$x1}' y1='{$y1}' x2='{$x2}' y2='{$y2}' stroke='{$stroke}' stroke-width='1.5' stroke-opacity='0.25' stroke-linecap='round' />";
        }

        // Noise dots
        $dots = '';
        for ($i = 0; $i < 25; $i++) {
            $cx = random_int(5, $width - 5);
            $cy = random_int(5, $height - 5);
            $r = random_int(1, 2);
            $dots .= "<circle cx='{$cx}' cy='{$cy}' r='{$r}' fill='#94A3B8' opacity='0.3' />";
        }

        // Render characters with slight random rotation & offset
        $charsSvg = '';
        $charWidth = ($width - 30) / $length;

        for ($i = 0; $i < $length; $i++) {
            $char = $code[$i];
            $x = 18 + ($i * $charWidth);
            $y = random_int(30, 34);
            $angle = random_int(-15, 15);
            $color = $colors[$i % count($colors)];

            $charsSvg .= "<text x='{$x}' y='{$y}' fill='{$color}' font-size='24' font-weight='800' font-family='Courier New, monospace, sans-serif' transform='rotate({$angle}, {$x}, {$y})'>{$char}</text>";
        }

        return <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" width="{$width}" height="{$height}" viewBox="0 0 {$width} {$height}" style="background-color: #F8FAFC; border-radius: 8px; user-select: none;">
    <defs>
        <linearGradient id="bgGrad" x1="0%" y1="0%" x2="100%" y2="100%">
            <stop offset="0%" stop-color="#F1F5F9" />
            <stop offset="100%" stop-color="#E2E8F0" />
        </linearGradient>
    </defs>
    <rect width="{$width}" height="{$height}" fill="url(#bgGrad)" rx="8" />
    {$lines}
    {$dots}
    {$charsSvg}
</svg>
SVG;
    }
}
