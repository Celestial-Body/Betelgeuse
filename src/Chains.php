<?php
/**
 * Celestial Body.
 *
 * @link    <https://github.com/Celestial-Body/Betelgeuse> Github repository.
 * @license <https://github.com/Celestial-Body/Betelgeuse/blob/master/LICENSE> GPL-3.0 License.
 */

namespace Betelgeuse\Validator;

use SplObjectStorage;

/**
 * Chains.
 */
class Chains implements ChainsInterface
{
    
    /**
     * @var SplObjectStorage $list A list of all validators.
     */
    private $list;
    
    /**
     * @var array $keys The key id holder.
     */
    private $keys = [];
    
    /**
     * Register multiple validators in one chain.
     *
     * @param mixed $validators A list of all validators.
     *
     * @throws InvalidArgumentException If no validators were passed.
     * @throws InvalidArgumentException If $validators is not foreach compatible.
     * @throws InvalidArgumentException If $validator is not an instance of ValidatorInterface.
     *
     * @return void Return nothing.
     */
    public function __construct($validators)
    {
        if (empty($validators)) {
            throw new Exception\InvalidArgumentException('No validators were passed.');
        }
        $this->list = new SplObjectStorage();
        if (!\is_array() && !($validators instanceof Traversable)) {
            throw new Exception\InvalidArgumentException(\sprintf(
                'The variable $validators needs to be foreach compatible. Passed: %s.',
                \gettype($validators);
            ));
        }        
        foreach ($validators as $validator) {
            $this->list->attach($validator);
            if (!($validator instanceof ValidatorInterface)) {
                throw new Exception\InvalidArgumentException(\sprintf(
                    'The variable $validator needs to be an instance of ValidatorInterface. Passed: %s.',
                    \gettype($validator);
                ));
            }
            $this->keys += [
                $validator
            ];
        }
    }

    /**
     * Run the validator chain.
     *
     * @param mixed The test case to validate.
     *
     * @return bool Return TRUE if the test case is valid and
     *              FALSE if otherwise.
     */
    public function validate($ts)
    {
        foreach ($keys as $key) {
            if ($this->list->contains($key)) {
                if (!$key->validate($ts)) {
                    return \false;
                }
            }
        }
        return \true;
    }
}
