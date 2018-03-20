<?php
/**
 * Celestial Body.
 *
 * @link    <https://github.com/Celestial-Body/Betelgeuse> Github repository.
 * @license <https://github.com/Celestial-Body/Betelgeuse/blob/master/LICENSE> GPL-3.0 License.
 */

use PHPUnit\Framework\TestCase;

use Betelgeuse\Validator\Exception\InvalidArgumentException;
use Betelgeuse\Validator\Exception\UnexpectedValueException;
use Betelgeuse\Validator\Exception\DomainException;
use Betelgeuse\Validator\Email\Config;

/**
 * ConfigTest.
 */
class ConfigTest extends TestCase
{

    /**
     * {{
     *
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
     *
     * @return void Return nothing.
     */
    public function testConfig()
    {
        $this->expectException(InvalidArgumentException::class);
        $config = new Config([
        ]);
    }
    public function testConfig_2()
    {
        $this->expectException(DomainException::class);
        $config = new Config([
            'foo',
            'bar'
        ]);
    }
    public function testConfig_3()
    {
        $this->expectException(DomainException::class);
        $config = new Config([
            'foo',
            'bar' => [
                'meo' => [
                     'test' => \true
                ]
            ]
        ]);
    }
    public function testConfig_4()
    {
        $this->expectException(UnexpectedValueException::class);
        $config = new Config([
            'hello_world' => [
                'foo',
                'bar'
            ],
            'bar' => [
                'hello',
                'world'
            ]
        ]);
    }
    public function testConfig_5()
    {
        $this->expectException(InvalidArgumentException::class);
        $config = new Config([
            'mode' => [
                true
            ]
        ]);
    }
    public function testConfig_6()
    {
        $this->expectException(DomainException::class);
        $config = new Config([
            'mode' => [
                'hello_world'
            ]
        ]);
    }
    public function testConfig_7()
    {
        $this->expectException(DomainException::class);
        $config = new Config([
            'mode' => [
                'internal',
                'egulias'
            ]
        ]);
    }
    public function testConfig_8()
    {
        $this->expectException(DomainException::class);
        $config = new Config([
            'mode' => [
                'egulias'
            ]
        ]);
    }
    public function testConfig_9()
    {
        $this->expectException(DomainException::class);
        $config = new Config([
            'mode' => [
                'egulias'
            ],
            'plugin' => [    
            ]
        ]);
    }
    public function testConfig_10()
    {
        $config = new Config([
            'mode' => [
                'egulias'
            ],
            'plugins' => [
                'rcfvalidation',
                'dnscheckvalidation',
                'spoofcheckvalidation'
            ]
        ]);
        $this->assertTrue(\true);
    }
    public function testConfig_10()
    {
        $this->expectException(InvalidArgumentException::class);
        $config = new Config([
            'mode' => [
                'egulias'
            ],
            'plugins' => [
                true
            ]
        ]);
    }
    public function testConfig_10()
    {
        $this->expectException(DomainException::class);
        $config = new Config([
            'mode' => [
                'egulias'
            ],
            'plugins' => [
                'hello_world'
            ]
        ]);
    }
    /**
     * }}
     */
}
