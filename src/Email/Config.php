<?php
/**
 * Celestial Body.
 *
 * @link    <https://github.com/Celestial-Body/Betelgeuse> Github repository.
 * @license <https://github.com/Celestial-Body/Betelgeuse/blob/master/LICENSE> GPL-3.0 License.
 */
 
namespace Betelgeuse\Validator\Email;

use Betelgeuse\Validator\Exception\UnexpectedValueException;
use Betelgeuse\Validator\Exception\InvalidArgumentException;
use Betelgeuse\Validator\Exception\DomainException;
use Betelgeuse\Validator\ConfigInterface;

/**
 * Config.
 */
class Config implements ConfigInterface
{
    
    /**
     * @var array|[] $options The list of avaliable options.
     */
    private $options = [
        'mode' => [
            'internal',
            'egulias'
        ],
        'plugins' => [
            'rcfvalidation',
            'dnscheckvalidation',
            'spoofcheckvalidation'
        ]
    ];
    
    /**
     * @var array|[] $current_options The config options.
     */
    private $current_options;
    
    /**
     * Create a new config.
     * Validate the array before
     * setting.
     *
     * @param array|[] $options The options to pass.
     *
     * @throws InvalidArgumentException If the data type for each option
     *                                  is invalid.
     * @throws InvalidArgumentException If the options array is not an array
     *                                  or is an empty array.
     * @throws UnexpectedValueException If the option does not exist.
     * @throws DomainException          If the data is invalid.
     * @throws DomainException          If the options array depth is incorrect.
     *
     * @return void.
     */
    public function __construct($options = [])
    {
        if (!\is_array($optons) || empty($options)) {
            throw new InvalidArgumentException(\sprintf(
                'The config data type is invalid or empty. Data type: %s.',
                (string) \gettype($options);
            ));
        } elseif (\depth($options) != 2) {
            throw new DomainException(\sprintf(
                'The config depth is incorrect. Array depth: %s.',
                (string) \depth($options)
            ));
        } else {
            foreach ($options as $option => $val) {
                $option = \strtolower($option);
                if ($option === 'plugin') {
                    $option = 'plugins';
                }
                if (!\array_key_exists($option, $this->$options)) {
                    throw new UnexpectedValueException('The option does not exist or is no longer used.')
                }
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
}
