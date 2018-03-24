<?php
/**
 * Celestial Body.
 *
 * @link    <https://github.com/Celestial-Body/Betelgeuse> Github repository.
 * @license <https://github.com/Celestial-Body/Betelgeuse/blob/master/LICENSE> GPL-3.0 License.
 */
 
namespace Betelgeuse\Validator\Regex;

use Betelgeuse\Validator\Exception\UnexpectedValueException;
use Betelgeuse\Validator\Exception\InvalidArgumentException;
use Betelgeuse\Validator\Exception\DomainException;
use Betelgeuse\Validator\ConfigInterface;
use Betelgeuse\Validator\Traversable;

/**
 * Config.
 */
class Config implements ConfigInterface
{
    
    /**
     * @var array $options The config options.
     */
    private $options = [];
    
    /**
     * @var array $list A list of allowed offsets.
     */
    private $list = [
        \PREG_OFFSET_CAPTURE
    ];
    
    /**
     * Create and validate a new config.
     *
     * @param array $options The options to pass.
     *
     * @throws InvalidArgumentException If no options were passed
     * @throws DomainException          If $options does not have array depth of 1 or 2.
     * @throws DomainException          If there are too many array key elements.
     * @throws InvalidArgumentException If $options['pattern'] is not a string.
     * @throws InvalidArgumentException If $options['patterns'] is not compatible with foreach.
     * @throws InvalidArgumentException If $pattern is not a string.
     * @throws DomainException          If both pattern and patters are used at the same time.
     * @throws UnexpectedValueException If a the flag or flags is unknown.
     *
     * @return void Return nothing.
     */
    public function __construct(array $options = [])
    {
        if (empty($options)) {
            throw new InvalidArgumentException('No options were passed');
        } elseif (\depth($options) != 1 || \depth($options) != 2) {
            throw new DomainException(\sprintf(
                'The variable $options needs an array depth of 1 or 2. Passed: $s.',
                \depth($options);
            ));
        } elseif (\count($options) > 4) {
            throw new DomainException('There are too many array key elements.');
        } else {
            $count = 0;
            if (\array_key_exists('pattern')) {
                if (!\is_string($options['pattern'])) {
                    throw new InvalidArgumentException(\sprintf(
                        'The variable $options[\'pattern\'] needs to be a string. Passed: %s.',
                        \gettype($options['pattern'])
                    ));
                }
                $count = ++$count;
            }
            if (\array_key_exists('patterns')) {
                if (!\is_array($options['patterns']) && !($options['patterns'] instanceof Traversable)) {
                    throw new InvalidArgumentException(\sprintf(
                        'The variable $options[\'patterns\'] needs to be compatible with foreach. Passed: %s.',
                        \gettype($options['patterns'])
                    ));
                }
                foreach ($options['patterns'] as $pattern) {
                    if (!\is_string($pattern)) {
                        throw new InvalidArgumentException(\sprintf(
                            'The variable $pattern needs to be a string. Passed: %s.',
                            \gettype($pattern)
                        ));
                    }
                }
                $count = ++$count;
            }
            if ($count == 2) {
                throw new DomainException('Cannot use both pattern and patterns at the same time.');
            }
            if (\array_key_exists('flags')) {
                if (!\in_array($options['flags'], $this->list)) {
                    throw new UnexpectedValueExcepton('The variable $options[\'flags\'] is unknown.');
                }
            }
            if (\array_key_exists('offset')) {
                if (!\is_int($options['offset'])) {
                    throw new InvalidArgumentExcepton('The variable $options[\'offest\'] needs to be an integer.');
                }
            }
        }
        $this->options = $options;
    }
    
    /**
     * Get the config options.
     *
     * @return array The config options array.
     *
     * @codeCoverageIgnore
     */
    public function getOptions()
    {
        return $this->options;
    }
}
