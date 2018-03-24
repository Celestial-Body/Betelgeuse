<?php
/**
 * Celestial Body.
 *
 * @link    <https://github.com/Celestial-Body/Betelgeuse> Github repository.
 * @license <https://github.com/Celestial-Body/Betelgeuse/blob/master/LICENSE> GPL-3.0 License.
 */
 
namespace Betelgeuse\Validator;

/**
 * AbstractValidator.
 */
class AbstractValidator implements AbstractValidatorInterface
{
    
    /**
     * Force extending class to define this method or vars.
     */
    abstract protected $curErrors;
    
    /**
     * Return all errors based on validator messages.
     *
     * @return array Return an array with a list of errors based
     *               the validator.
     */
    public function listErrors()
    {
        return $curErrors;
    }
}
