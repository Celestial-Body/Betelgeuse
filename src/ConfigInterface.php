<?php
/**
 * Celestial Body.
 *
 * @link    <https://github.com/Celestial-Body/Betelgeuse> Github repository.
 * @license <https://github.com/Celestial-Body/Betelgeuse/blob/master/LICENSE> GPL-3.0 License.
 */
 
namespace Betelgeuse\Validator;

/**
 * ConfigInterface.
 */
interface ConfigInterface
{
    
    public function __construct(array $options = []);
    public function getOptions();
}
