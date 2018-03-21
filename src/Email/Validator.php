<?php
/**
 * Celestial Body.
 *
 * @link    <https://github.com/Celestial-Body/Betelgeuse> Github repository.
 * @license <https://github.com/Celestial-Body/Betelgeuse/blob/master/LICENSE> GPL-3.0 License.
 */
 
namespace Betelgeuse\Validator\Email;

use Betelgeuse\Validator\ValidatorInterface;
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
    }
}
