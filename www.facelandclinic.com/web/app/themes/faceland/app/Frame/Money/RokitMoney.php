<?php

namespace Rokit\Frame\Money;

use Money\Currencies\ISOCurrencies;
use Money\Formatter\IntlMoneyFormatter;
use Money\Parser\DecimalMoneyParser;

/**
 * Format money based on locale and currency
 * This class used Money/Money
 *
 * Recourses and links :
 * http://moneyphp.org/en/stable/index.html
 * https://www.thefinancials.com/Default.aspx?SubSectionID=curformat
 * https://publications.europa.eu/code/en/en-370303.htm
 * https://taaladvies.net/taal/advies/vraag/275/euro_komma_en_streepje_in_de_notatie_van_hele_bedragen/
 * https://taaladvies.net/taal/advies/vraag/463/komma_of_punt_in_geldbedragen/
 */
class RokitMoney {

    /**
     * Format a number string to valid currency amount
     *
     * @param   string  $amount
     * @param   string  $locale
     * @param   string  $currency
     * @return  string
     */
    static function format($amount, $locale = 'nl_NL', $currency = null) {


        if ($locale == true) {
            $locale = 'nl_NL';
        }

        if(empty($currency)) {
            $currency = self::locale2Currency($locale);
        }


        $amountInCents = self::parseToCents($amount, $currency);

        return self::formatAmount($amountInCents, $locale, true);
    }

    /**
     * Parse number string to cents based on currency
     *
     * @param   string  $amount
     * @param   string  $curreny
     * @return  string
     */
    private static function parseToCents($amount, $curreny = 'EUR') {
        $currencies = new ISOCurrencies();
        $moneyParser = new DecimalMoneyParser($currencies);
        return $moneyParser->parse($amount, $curreny);
    }

    /**
     * Format amount based on locale
     *
     * @param   string  $amount
     * @param   string  $locale
     * @param   boolean $trim
     * @return  string
     */
    private static function formatAmount($amount, $locale, $trim = false) {
        $currencies = new ISOCurrencies();
        $numberFormatter = new \NumberFormatter($locale, \NumberFormatter::CURRENCY);
        $moneyFormatter = new IntlMoneyFormatter($numberFormatter, $currencies);
        $moneyFormatted = $moneyFormatter->format($amount);

        if(isset($trim)) {
            $currentyTrimmer = self::currentyTrimmer($locale);
            $moneyFormatted = str_replace(key($currentyTrimmer),$currentyTrimmer[key($currentyTrimmer)],$moneyFormatted);
        }

        return $moneyFormatted;
    }

    /**
     * Get currency ISO value for a specific locale
     *
     * @param   string  $locale
     * @return  string
     */
    private static function locale2Currency($locale) {

        $mapping = [
            'nl_NL' => 'EUR',
            'de_DE' => 'EUR',
            'de_CH' => 'CHF'
        ];

        if(!empty($mapping[$locale])) {
            return $mapping[$locale];
        }

    }

    /**
     * Get currency trim settings for a specific locale
     *
     * @param   string  $locale
     * @return  string
     */
    private static function currentyTrimmer($locale) {

        $mapping = [
            'nl_NL' => [',00' => ',-'],
            'de_DE' => [',00' => ''],
            'de_CH' => ['.00' => ',-']
        ];

        if(!empty($mapping[$locale])) {
            return $mapping[$locale];
        }

    }

}

?>
