<?php
/**
 * Helper de Idiomas
 * Sistema de Gerenciamento de Ordens de Serviço - Preditix
 */

class Language {
    private static $currentLang = 'pt-br';
    private static $translations = [];
    
    public static function initialize() {
        // Detectar idioma da sessão ou usar padrão
        if (isset($_SESSION['language'])) {
            self::$currentLang = $_SESSION['language'];
        }
        
        self::loadTranslations();
    }
    
    public static function setLanguage($lang) {
        $allowedLangs = ['pt-br', 'en-gb', 'es-es'];
        
        if (in_array($lang, $allowedLangs)) {
            self::$currentLang = $lang;
            $_SESSION['language'] = $lang;
            self::loadTranslations();
        }
    }
    
    public static function getCurrentLanguage() {
        return self::$currentLang;
    }
    
    public static function get($key, $default = null) {
        return self::$translations[$key] ?? $default ?? $key;
    }
    
    // Alias para função mais curta
    public static function t($key, $default = null) {
        return self::get($key, $default);
    }
    
    private static function loadTranslations() {
        $langFile = "lang/" . self::$currentLang . ".php";
        
        if (file_exists($langFile)) {
            self::$translations = include $langFile;
        } else {
            // Fallback para português
            $langFile = "lang/pt-br.php";
            if (file_exists($langFile)) {
                self::$translations = include $langFile;
            }
        }
    }
    
    public static function getAvailableLanguages() {
        return [
            'pt-br' => [
                'name' => 'Português',
                'flag' => '🇧🇷',
                'flag_img' => 'assets/img/flags/br.png'
            ],
            'en-gb' => [
                'name' => 'English',
                'flag' => '🇬🇧',
                'flag_img' => 'assets/img/flags/gb.png'
            ],
            'es-es' => [
                'name' => 'Español',
                'flag' => '🇪🇸',
                'flag_img' => 'assets/img/flags/es.png'
            ]
        ];
    }
    
    public static function formatDate($date, $format = null) {
        if (!$date) return '';
        
        $formats = [
            'pt-br' => 'd/m/Y \à\s H:i',
            'en-gb' => 'Y-m-d \a\t H:i',
            'es-es' => 'd/m/Y \a \l\a\s H:i'
        ];
        
        $format = $format ?: $formats[self::$currentLang];
        
        if (is_string($date)) {
            $date = new DateTime($date);
        }
        
        return $date->format($format);
    }
}