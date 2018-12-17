<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\EshopCommunity\Internal\Twig\Escaper;

use Twig\Environment;

/**
 * Class NonStdEscaper
 *
 * Escape non-standard chars, such as ms document quotes
 *
 * @author Tomasz Kowalewski (t.kowalewski@createit.pl)
 */
class NonStdEscaper implements EscaperInterface
{

    /**
     * @return string
     */
    public function getStrategy(): string
    {
        return 'nonstd';
    }

    /**
     * Escape non-standard chars, such as ms document quotes
     *
     * @param Environment $environment
     * @param string      $string
     * @param string      $charset
     *
     * @return string
     */
    public function escape(Environment $environment, $string, $charset): string
    {
        $return = '';

        for ($i = 0, $length = strlen($string); $i < $length; $i++) {
            $ord = ord(substr($string, $i, 1));
            // non-standard char, escape it
            if ($ord >= 126) {
                $return .= '&#' . $ord . ';';
            } else {
                $return .= substr($string, $i, 1);
            }
        }

        return $return;
    }
}