<?php
/**
 * Celestial Body.
 *
 * @link    <https://github.com/Celestial-Body/Betelgeuse> Github repository.
 * @license <https://github.com/Celestial-Body/Betelgeuse/blob/master/LICENSE> GPL-3.0 License.
 */
 
namespace Betelgeuse\Validator\Email;

use Betelgeuse\Validator\Exception\InvalidArgumentException;
use Betelgeuse\Validator\Exception\UnexpectedValueException;
use Betelgeuse\Validator\Exception\DomainException;
use Betelgeuse\Validator\ConfigInterface;

/**
 * Config.
 */
class Config implements ConfigInterface
{
    
    /**
     * @var array $current_options The config options.
     */
    private $current_options = [];
    
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
     * @throws DomainException          If both values are passed but only one is required.
     *
     * @return void Return nothing.
     */
    public function __construct(array $options = [])
    {
        if (empty($options)) {
            throw new InvalidArgumentException('The config array is empty.');
        } elseif (\depth($options) != 2) {
            throw new DomainException(\sprintf(
                'The config depth is incorrect. Array depth: %s.',
                (string) \depth($options)
            ));
        } else {
            foreach ($options as $option => $val) {
                $option = \strtolower((string) $option);
                if ($option === 'plugin') {
                    $option = 'plugins';
                }
                if (!\array_key_exists($option, [
                    'mode' =>    '',
                    'plugins' => ''
                ])) {
                    throw new UnexpectedValueException(
                        'The option does not exist or is no longer used.'
                    );
                }
                $mode_state = 2;
                $rcfvalidation = 2;
                $dnscheckvalidation = 2;
                $spoofcheckvalidation = 2;
                if (\is_array($val)) {
                    if ($option === 'mode') {
                        foreach ($val as $key) {
                            if (!\is_string($key)) {
                                throw new InvalidArgumentException(\sprintf(
                                    'The data key has an invalid data type. Data type: %s',
                                    \gettype($key)
                                ));
                            }
                            if ($key != 'internal'
                                && $key != 'egulias') {
                                throw new DomainException('The key value is unknown.');
                            }
                            if ($mode_state == 2) {
                                if ($mode_state == 4
                                    || $mode_state == 3) {
                                    throw new DomainException('Only one value is allowed.');
                                }
                                if ($key == 'internal') {
                                    $mode_state = 4;
                                } else {
                                    $mode_state = 3;
                                }
                            }
                        }
                    }
                    if ($option === 'plugins') {
                        foreach ($val as $key) {
                            if (!\is_string($key)) {
                                throw new InvalidArgumentException(\sprintf(
                                    'The data key has an invalid data type. Data type: %s',
                                    \gettype($key)
                                ));
                            }
                            if ($key != 'rcfvalidation'
                                && $key != 'dnscheckvalidation'
                                && $key != 'spoofcheckvalidation') {
                                throw new DomainException('The key value is unknown.');
                            }
                            if ($key == 'rcfvalidation') {
                                $rfcvalidation = 3;
                            }
                            if ($key == 'dnscheckvalidation') {
                                $rfcvalidation = 3;
                            }
                            if ($key == 'spoofcheckvalidation') {
                                $rfcvalidation = 3;
                            }
                        }
                    }
                } else {
                    throw new InvalidArgumentException(\sprintf(
                        'The option data type is invalid. Data type: %s',
                        \gettype($val)
                    ));
                }
            }
        }
        $this->current_options = $options;
    }
    
    /**
     * Wipe the config from memory after it has been used.
     *
     * @return void Return nothing.
     *
     * @codeCoverageIgnore
     */
    public function __destruct()
    {
        \sodium_memzero($this->current_options);
    }
    
    /**
     * Get the config options.
     *
     * @throws InvalidArgumentException If the config options array
     *                                  is empty.
     *
     * @return array The config options array.
     */
    public function getOptions()
    {
        if (empty($this->current_options)) {
            throw new InvalidArgumentException('The config options array is empty.');
        }
        return (array) $this->current_options;
    }
    
    /**
     * Hide its internal state from var_dump()
     *
     * @return array
     *
     * @codeCoverageIgnore
     */
    public function __debugInfo()
    {
        return [
            'internalConfigOptions' => '*'
        ];
    }
    
    /**
     * Disallow serialization.
     *
     * @return array
     *
     * @codeCoverageIgnore
     */
    public function __sleep()
    {
        return [];
    }
}
