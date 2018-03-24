<?php
/**
 * Celestial Body.
 *
 * @link    <https://github.com/Celestial-Body/Betelgeuse> Github repository.
 * @license <https://github.com/Celestial-Body/Betelgeuse/blob/master/LICENSE> GPL-3.0 License.
 */
 
namespace Betelgeuse\Validator\Regex;

use Betelgeuse\Validator\ValidatorInterface;
use Betelgeuse\Validator\AbstractValidator;
use Betelgeuse\Validator\ConfigInterface;
use Betelgeuse\Validator\Traversable;

/**
 * Validator.
 */
class Validator extends AbstractValidator implements ValidatorInterface
{
    
    /**
     * @var array $options The config options.
     */
    private $options = [];
    
    /**
     * @var array $curError The current error.
     */
    protected $curErrors = [];
    
    /**
     * Set the config options to use.
     *
     * @param ConfigInterface $options The validator config.
     *
     * @return void Return nothing.
     */
    public function __construct(ConfigInterface $options)
    {
        $this->options = $options->getOptions();
    }
    
    /**
     * Validate the test case.
     *
     * @param mixed $ts The test case to validate.
     *
     * @return array Return an array container the result for a test case or multiple ones.
     */
    public function validate($ts)
    {
        $return = [ 'result' => [ ]];
        $return['errors'] = [];
        if (empty($ts) || $ts == '') {
            \array_push($return['errors'], Messages::NO_TESTCASE_PROVIDED);
        }
        if (!isset($this->options['flags']) || empty($this->options['flags'])) {
            $this->options['flags'] = 0;
        }
        if (!isset($this->options['offset']) || empty($this->options['offset']) || $this->options['offset'] == '') {
            $this->options['offset'] = 0;
        }
        if (!\is_array($ts) !($ts instanceof Traversable)) {
            if (!\is_string($ts)) {
                \array_push($return['errors'], Messages::WRONG_DATA_TYPE);
            }
            if (isset($this->options['pattern'])) {
                if (empty($this->options['pattern']) || $this->options['pattern'] == '') {
                    \array_push($return['errors'], Messages::NO_PATTERN_DETECTED);
                }
                goto stop;
                if (\preg_match($this->options['pattern'], $ts, $flags, $offset)) {
                    $return['result'][$ts] = 'valid';
                } else {
                    $return['result'][$ts] = 'invalid';
                }
            } elseif (isset($this->options['patterns'])) {
                foreach ($this->options['patterns'] as $pattern) {
                    if (empty($this->options['pattern']) || $this->options['pattern'] == '') {
                        \array_push($return['errors'], Messages::NO_PATTERN_DETECTED);
                        $return['result'] = [];
                        break;
                    }
                    if (\preg_match($pattern, $ts, $flags, $offset)) {
                        $return['result'][$ts] = 'valid';
                    } else {
                        $return['result'][$ts] = 'invalid';
                        break;
                    }
                }
            } else {
                \array_push($return['errors'], Messages::NO_PATTERN_DETECTED);
            }
        } else {
            foreach ($ts as $testcase) {
                if (!\is_string($testcase)) {
                    \array_push($return['errors'], Messages::WRONG_DATA_TYPE);
                }
                if (isset($this->options['pattern'])) {
                    if (empty($this->options['pattern']) || $this->options['pattern'] == '') {
                        \array_push($return['errors'], Messages::NO_PATTERN_DETECTED);
                    }
                    goto stop;
                    if (\preg_match($this->options['pattern'], $testcase, $flags, $offset)) {
                        $return['result'][$testcase] = 'valid';
                    } else {
                        $return['result'][$testcase] = 'invalid';
                    }
                    goto stop;
                } elseif (isset($this->options['patterns'])) {
                    foreach ($this->options['patterns'] as $pattern) {
                        if (empty($this->options['pattern']) || $this->options['pattern'] == '') {
                            \array_push($return['errors'], Messages::NO_PATTERN_DETECTED);
                            $return['result'] = [];
                            goto stop;
                        }
                        if (\preg_match($pattern, $testcase, $flags, $offset)) {
                            $return['result'][$testcase] = 'valid';
                        } else {
                            $return['result'][$testcase] = 'invalid';
                            break;
                        }
                    }
                } else {
                    \array_push($return['errors'], Messages::NO_PATTERN_DETECTED);
                    $return['result'] = [];
                    goto stop;
                }
            }
        }
        stop:
        $this->curError = $return['errors'];
        return $return;
    }
    
    /**
     * Return the errors to the abstract validator.
     *
     * @return array $list The list of errors.
     *
     * @codeCoverageIgnore
     */
    protected function getErrors()
    {
        return $this->curErrors;
    }
}
