<?php

namespace Rentalhost\VanillaValidation;

use InvalidArgumentException;
use Rentalhost\VanillaEvent\EventListener;
use Rentalhost\VanillaValidation\Result\Fail;
use Symfony\Component\Translation\Loader\PhpFileLoader;
use Symfony\Component\Translation\MessageSelector;
use Symfony\Component\Translation\Translator;

/**
 * Class ValidationLocalize
 * @package Rentalhost\VanillaValidation
 */
class ValidationLocalize
{
    /**
     * Store the translator.
     * @var Translator
     */
    public static $translator;
    /**
     * Store this singleton.
     * @var self
     */
    private static $instance;

    /**
     * Block constructor.
     * @throws InvalidArgumentException
     */
    private function __construct()
    {
        self::$translator = new Translator('en', new MessageSelector());
        self::$translator->addLoader('php', new PhpFileLoader());

        foreach (glob(__DIR__ . '/../../locales/messages.*.php') as $file) {
            if (preg_match('/\.([\w-]+)\.php$/', basename($file), $fileLocaleMatch)) {
                /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
                self::$translator->addResource('php', $file, $fileLocaleMatch[1]);
            }
        }

        self::configureLocale();

        // Reconfigure locale if it was changed.
        EventListener::$global->on('rentalhost.validation::option.set.locale', [ self::class, 'configureLocale' ]);
    }

    /**
     * Configure translator locale.
     * @return void
     */
    public static function configureLocale()
    {
        $localeOption = Validation::option('locale');

        if (!is_array($localeOption)) {
            /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
            self::$translator->setLocale($localeOption);
            /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
            self::$translator->setFallbackLocales([ $localeOption ]);
        }
        else {
            /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
            self::$translator->setLocale(array_shift($localeOption));
            /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
            self::$translator->setFallbackLocales($localeOption);
        }
    }

    /**
     * Get this singleton.
     * @return self
     * @throws InvalidArgumentException
     */
    public static function singleton()
    {
        if (!self::$instance) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    /**
     * Mask key names.
     *
     * @param string $key Key to mask.
     *
     * @return string
     */
    protected static function maskKey($key)
    {
        return ":{$key}";
    }

    /**
     * Translate a fail result.
     *
     * @param  Fail $fail Fail to translate.
     *
     * @return string
     */
    public function translateFail(Fail $fail)
    {
        $failData = $fail->getData();

        $failTranslationKey  = 'fail:' . $fail->rule->originalName;
        $failTranslationData = array_combine(array_map([ self::class, 'maskKey' ], array_keys($failData)), array_values($failData));

        // Fill field name or remove it.
        $failTranslationDataFieldKey                       = $fail->field ? ':field' : ' ":field"';
        $failTranslationData[$failTranslationDataFieldKey] = $fail->field ? $fail->field->name : null;

        // If "quantify" data was defined, so use transChoice, instead.
        if (array_key_exists(':quantify', $failTranslationData)) {
            /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
            return self::$translator->transChoice($failTranslationKey, (int) $failTranslationData[':quantify'], $failTranslationData);
        }

        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */

        return self::$translator->trans($failTranslationKey, $failTranslationData);
    }
}
