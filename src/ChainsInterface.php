<?php
/**
 * Celestial Body.
 *
 * @link    <https://github.com/Celestial-Body/Betelgeuse> Github repository.
 * @license <https://github.com/Celestial-Body/Betelgeuse/blob/master/LICENSE> GPL-3.0 License.
 */

namespace Betelgeuse\Validator;

/**
 * ChainsInterface.
 */
interface ChainsInterface
{

    public function __construct($validators);
    public function validate($ts);
}
