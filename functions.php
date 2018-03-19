<?php
declare(strict_types=1);
/**
 * Celestial Body.
 *
 * @link    <https://github.com/Celestial-Body/Betelgeuse> Github repository.
 * @license <https://github.com/Celestial-Body/Betelgeuse/blob/master/LICENSE> GPL-3.0 License.
 */

if (!function_exists('depth')) {
    function depth($input)
    {
        if (!canVarLoop($input)) {
            return (int) "0";
        }
        $arrayiter = new RecursiveArrayIterator($input);
        $iteriter = new RecursiveIteratorIterator($arrayiter);
        foreach ($iteriter as $value) {
            $d = $iteriter->getDepth() + 1;
            $result[] = "$d";
        }
        return (int) max($result);
    }
}

if (!function_exists('canVarLoop')) {
    function canVarLoop($input)
    {
        return (bool) (is_array($input) || $input instanceof Traversable) ? true : false;
    }
}
