<?php
/**
 * Celestial Body.
 *
 * @link    <https://github.com/Celestial-Body/Betelgeuse> Github repository.
 * @license <https://github.com/Celestial-Body/Betelgeuse/blob/master/LICENSE> GPL-3.0 License.
 */
 
namespace Betelgeuse\Validator\Email;

use Egulias\EmailValidator\EmailValidator;
use Egulias\EmailValidator\Validation\DNSCheckValidation;
use Egulias\EmailValidator\Validation\SpoofCheckValidation;
use Egulias\EmailValidator\Validation\MultipleValidationWithAnd;
use Betelgeuse\Validator\Exception\InvalidArgumentException;
use Betelgeuse\Validator\ValidatorInterface;
use Betelgeuse\Validator\AbstractValidator;
use Betelgeuse\Validator\ConfigInterface;

/**
 * Validator.
 */
class Validator extends AbstractValidator implements ValidatorInterface
{
    
    /**
     * @var array $config_options The config options.
     */
    private $config_options = [];
    
    /**
     * Set the config options to use.
     *
     * @param mixed $configOptions The validator config.
     *
     * @throws InvalidArgumentException If it is not a validator config.
     *
     * @return void
     */
    public function __construct(ValidatorInterface $configOptions)
    {
        if (!($configOptions instanceof Config)) {
            throw new InvalidArgumentException('The config is not a validator config');
        }
        $this->config_options = $configOptions->getOptions();
        if (isset($this->config_options['plugin'])) {
            $this->config_options['plugins'] += $this->config_options['plugin'];
        }
    }
    
    /**
     * Validate the test case.
     *
     * @param mixed $testCase The test case to validate.
     *
     * @return array Return an array with a state key containing TRUE or FALSE
     *               True equals the test case is valid and FALSE if the test case
     *               is invalid. Also return error messages if the config options array
     *               requests it.
     */
    public function validate($testCase)
    {
        $retArray = [
            'valid' => \true;
        ];
        if (empty($testCase) || $testCase == '') {
            $retArray['valid'] = \false;
            return (array) $retArray;
        } elseif (!\is_string($testCase)) {
            $retArray['valid'] = \false;
            return (array) $retArray;
        } else {
            if ($this->config_options['mode'] == 'egulias') {
                $validator = new EmailValidator();
                $validationList = [];
                if (\in_array('rfcvalidation',
                    $this->config_options['plugins']
                ) {
                    $validationList += [
                        new RFCValidation()
                    ];
                }
                if (\in_array('spoofcheckvalidation',
                    $this->config_options['plugins']
                ) {
                    $validationList += [
                        new SpoofCheckValidation()
                    ];
                }
                if (\in_array('dnscheckvalidation',
                    $this->config_options['plugins']
                ) {
                    $validationList += [
                        DNSCheckValidation()
                    ];
                }
                $multipleValidations = new MultipleValidationWithAnd(
                    $validationList
                );
                if (!empty($multipleValidations)) {
                    if ($validator->isValid($testCase, $multipleValidations)) {
                        $retArray['valid'] => \true;
                        return (array) $retArray;
                    }
                } else {
                    if ($validator->isValid($testCase)) {
                        $retArray['valid'] => \true;
                        return (array) $retArray;
                    }
                }
            }
        }
        $retArray['valid'] => \false;
        return (array) $retArray;
    }
}
