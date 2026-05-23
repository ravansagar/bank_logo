<?php

namespace Ravansagar\BankLogoFetcher;

class BankLogo
{
    private const BANK_URLS = [
        "Agriculture Development Bank Ltd." => "https://www.adbl.gov.np/",
        "Citizens Bank International Ltd." => "https://www.ctznbank.com/",
        "Everest Bank Ltd." => "https://www.everestbankltd.com/",
        "Global IME Bank Ltd." => "https://www.globalimebank.com/",
        "Himalayan Bank Ltd." => "https://www.himalayanbank.com/",
        "Kumari Bank Ltd." => "https://www.kumaribank.com/",
        "Laxmi Sunrise Bank Ltd." => "https://www.laxmisunrise.com/",
        "Machhapuchhre Bank Ltd." => "https://www.machbank.com/",
        "Nabil Bank Ltd." => "https://www.nabilbank.com/",
        "Nepal Bank Ltd." => "https://www.nepalbank.com.np/",
        "Nepal Investment Mega Bank Ltd." => "https://www.nimb.com.np/",
        "Nepal SBI Bank Ltd." => "https://nsbl.statebank/",
        "NIC ASIA Bank Ltd." => "https://www.nicasiabank.com/",
        "NMB Bank Ltd." => "https://nmb.com.np",
        "Prabhu Bank Ltd." => "https://www.prabhubank.com/",
        "Prime Commercial Bank Ltd." => "https://www.primebank.com.np/",
        "Rastriya Banijya Bank Ltd." => "https://www.rbb.com.np/",
        "Sanima Bank Ltd." => "https://www.sanimabank.com/",
        "Siddhartha Bank Ltd." => "https://www.siddharthabank.com/",
        "Standard Chartered Bank Nepal Ltd." => "https://www.sc.com/np",
    ];

    private const ALIASES = [
        'nmb' => 'NMB Bank Ltd.',
        'nimb' => 'Nepal Investment Mega Bank Ltd.',
        'nic' => 'NIC ASIA Bank Ltd.',
        'nic asia' => 'NIC ASIA Bank Ltd.',
        'nabil' => 'Nabil Bank Ltd.',
        'adbl' => 'Agriculture Development Bank Ltd.',
        'rbb' => 'Rastriya Banijya Bank Ltd.',
        'scb' => 'Standard Chartered Bank Nepal Ltd.',
        'sbi' => 'Nepal SBI Bank Ltd.',
        'global ime' => 'Global IME Bank Ltd.',
        'himalayan' => 'Himalayan Bank Ltd.',
        'everest' => 'Everest Bank Ltd.',
        'kumari' => 'Kumari Bank Ltd.',
        'laxmi' => 'Laxmi Sunrise Bank Ltd.',
        'machha' => 'Machhapuchhre Bank Ltd.',
        'prabhu' => 'Prabhu Bank Ltd.',
        'prime' => 'Prime Commercial Bank Ltd.',
        'sanima' => 'Sanima Bank Ltd.',
        'siddhartha' => 'Siddhartha Bank Ltd.',
        'sidhartha' => 'Siddhartha Bank Ltd.',
        'citizens' => 'Citizens Bank International Ltd.',
    ];

    private const API_URI = 'https://www.google.com/s2/favicons?sz=128&domain=';

    private static function normalize(string $name): string
    {
        $name = strtolower(trim($name));
        $name = str_replace(['.', ',', '-', '_'], ' ', $name);
        $name = preg_replace('/\b(ltd|limited|and|the|of)\b/', '', $name);
        $name = preg_replace('/\s+/', ' ', trim($name));
        return $name;
    }

    public static function resolve(string $input): ?string
    {
        if (isset(self::BANK_URLS[$input]))
            return $input;

        $aliasKey = strtolower(trim($input));
        $aliasKey = preg_replace('/\b(ltd|limited|\.)\b/', '', $aliasKey);
        $aliasKey = trim(preg_replace('/\s+/', ' ', $aliasKey));
        $aliasKey = rtrim($aliasKey, ' bank');
        $aliasKey = trim($aliasKey);

        if (isset(self::ALIASES[$aliasKey]))
            return self::ALIASES[$aliasKey];

        $normalizedInput = self::normalize($input);

        foreach (array_keys(self::BANK_URLS) as $key) {
            $normalizedKey = self::normalize($key);
            if ($normalizedInput === $normalizedKey) return $key;
        }

        if (strlen($normalizedInput) > 5) {
            $bestKey   = null;
            $bestScore = PHP_INT_MAX;

            foreach (array_keys(self::BANK_URLS) as $key) {
                $distance = levenshtein($normalizedInput, self::normalize($key));
                if ($distance < $bestScore) {
                    $bestScore = $distance;
                    $bestKey = $key;
                }
            }

            $threshold = (int)(strlen($normalizedInput) * 0.35);
            if ($bestScore <= $threshold)
                return $bestKey;
        }

        return null;
    }

    public static function getUrl(string $bankName): ?string
    {
        $key = self::resolve($bankName);
        return $key ? self::BANK_URLS[$key] : null;
    }

    public static function getLogo(string $bankName): ?string
    {
        $url = self::getUrl($bankName);
        if (!$url) return null;

        return self::API_URI . $url;
    }
}
