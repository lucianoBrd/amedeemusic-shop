<?php

namespace App\Service;

class LanguageService
{
    public function getLanguageCodeOnly(string $local = 'fr_FR'): string {
        switch ($local) {
            case 'fr_FR':
                return 'fr';
            case 'fr':
                return 'fr';
            case 'en_EN':
                return 'en';
            case 'en':
                return 'en';
            default:
                return 'fr';
        }
    }
}
