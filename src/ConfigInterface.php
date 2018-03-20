<?php
/**
 * Celestial Body.
 *
 * @link    <https://github.com/Celestial-Body/Betelgeuse> Github repository.
 * @license <https://github.com/Celestial-Body/Betelgeuse/blob/master/LICENSE> GPL-3.0 License.
 */
 
namespace Betelgeuse\Validator\Email;

/**
 * Config.
 */
interface ConfigInterface
{
    
    /**
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
    public function __construct(array $options = []);
    
    /**
     * Get the config options.
     *
     * @throws InvalidArgumentException If the config options array
     *                                  is empty.
     *
     * @return array The config options array.
     */
    public function getOptions(): array;
    
    /**
     * Hide its internal state from var_dump()
     *
     * @return array
     */
    public function __debugInfo();
    
    /**
     * Disallow serialization.
     *
     * @return array
     */
    public function __sleep(): array;
}
