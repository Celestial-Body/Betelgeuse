<?php
/**
 * Celestial Body.
 *
 * @link    <https://github.com/Celestial-Body/Betelgeuse> Github repository.
 * @license <https://github.com/Celestial-Body/Betelgeuse/blob/master/LICENSE> GPL-3.0 License.
 */

use PHPUnit\Framework\TestCase;

use Betelgeuse\Validator\Exception\InvalidArgumentException;
use Betelgeuse\Validator\Exception\UnexpectedValueException;
use Betelgeuse\Validator\Exception\DomainException;
use Betelgeuse\Validator\Email\Config

/**
 * ConfigTest.
 */
class ConfigTest extends TestCase
{

    /**
     * {{
     *
     * Create and validate a new config.
     *
     * @param array $options The options to pass.
     *
     * @throws InvalidArgumentException If the data type for each option is invalid.
     * @throws InvalidArgumentException If the options array is an empty array.
     * @throws UnexpectedValueException If the option does not exist.
     * @throws InvalidArgumentException If the data is invalid.
     * @throws DomainException          If the options array depth is incorrect.
     * @throws DomainException          If the key value is unknown.
     *
     * @return void Return nothing.
     */
    public function testConfig()
    {
        $this->expectException(InvalidArgumentException::class);
        $config = new Config([
        ]);
    }
    /**
     * }}
     */
}
