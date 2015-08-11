<?php

namespace Rentalhost\VanillaValidation;

use Rentalhost\VanillaValidation\Result\Fail;
use Symfony\Component\Translation\Translator;
use Symfony\Component\Translation\MessageSelector;
use Symfony\Component\Translation\Loader\PhpFileLoader;

class ValidationLocalize
{
    /**
     * Store this singleton.
     * @var self
     */
    private static $singleton;

    /**
     * Store the translator.
     * @var Translator
     */
    public static $translator;

    /**
     * Block constructor.
     */
    private function __construct()
    {
        self::$translator = new Translator("en", new MessageSelector());
        self::$translator->addLoader("php", new PhpFileLoader());

        foreach (glob(__DIR__ . "/../../locales/messages.*.php") as $file) {
            if (preg_match('/\.([\w-]+)\.php$/', basename($file), $fileLocaleMatch)) {
                self::$translator->addResource("php", $file, $fileLocaleMatch[1]);
            }
        }
    }

    /**
     * Translate a fail result.
     * @param  Fail $fail Fail to translate.
     * @return string
     */
    public function translateFail(Fail $fail)
    {
        self::configureLocale();

        $failData = $fail->getData();

        $failTranslationKey = "fail:" . $fail->rule->originalName;
        $failTranslationData = array_combine(array_map("self::maskKey", array_keys($failData)), array_values($failData));

        // Fill field name or remove it.
        $failTranslationDataFieldKey = $fail->field ? ":field" : ' ":field"';
        $failTranslationData[$failTranslationDataFieldKey] = $fail->field ? $fail->field->name : null;

        return self::$translator->trans($failTranslationKey, $failTranslationData);
    }

    /**
     * Mask key names.
     * @return string
     */
    private static function maskKey($key)
    {
        return ":{$key}";
    }

    /**
     * Configure translator locale.
     * @return void
     */
    private static function configureLocale()
    {
        $localeOption = Validation::option("locale");

        if (is_string($localeOption)) {
            self::$translator->setLocale($localeOption);
            self::$translator->setFallbackLocale($localeOption);
        }
        else {
            self::$translator->setLocale(array_shift($localeOption));
            self::$translator->setFallbackLocales($localeOption);
        }
    }

    /**
     * Get this singleton.
     * @return self
     */
    public static function singleton()
    {
        if (!self::$singleton) {
            self::$singleton = new self;
        }

        return self::$singleton;
    }
}
