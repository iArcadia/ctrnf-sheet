<?php

namespace App;

use App\Game\Option;

/**
 * Class Lang
 * @package App
 */
class Lang
{
    /**
     * @return string
     */
    public static function getLang(): string
    {
        return Option::findBySlug('language')->getValue();
    }

    /**
     * @param string $lang
     */
    public static function setLang(string $lang)
    {
        Option::findBySlug('language')->setValue($lang)->save();
    }

    /**
     * @param string $key
     * @param string $lang
     * @return string
     */
    public static function translate(string $key, ?string $lang = null): string
    {
        if (!$lang) {
            $lang = self::getLang();
        }

        $lang = strtolower($lang);

        if ($lang === 'fr') {
            return $key;
        }

        if (preg_match('/\/|\\\\$/', $_SERVER['DOCUMENT_ROOT'])) {
            $translations = require($_SERVER['DOCUMENT_ROOT'] . 'lang/' . $lang . '.php');
        } else {
            $translations = require($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'lang/' . $lang . '.php');
        }

        if (isset($translations[$key])) {
            return $translations[$key];
        } else {
            return $key;
        }
    }
}