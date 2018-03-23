<?php
/**
 * Celestial Body.
 *
 * @link    <https://github.com/Celestial-Body/Betelgeuse> Github repository.
 * @license <https://github.com/Celestial-Body/Betelgeuse/blob/master/LICENSE> GPL-3.0 License.
 */
 
namespace Betelgeuse\Validator;

/**
 * ValidatorInterface.
 */
interface ValidatorInterface
{
    
    public function __construct(ConfigInterface $options);
    public function validate($ts);
}
