<?php
namespace Clickatell\Test\Cases\Component;

#-> Add's an autoloader to load test dependencies
require_once __DIR__ . "/../../autoload.php";

use Clickatell\Exception\ValidateException as ValidateException;
use \ReflectionClass as ReflectionClass;
use \PHPUnit_Framework_TestCase as PHPUnit_Framework_TestCase;

/**
 * Test Suite for testing the validation class.
 *
 * @package Clickatell\Test\Cases\Component
 * @author Chris Brand
 */
class ValidateTest extends PHPUnit_Framework_TestCase
{
    /**
     * Ensures that leading zero validation returns true if first
     * character in string is 0
     *
     * @return boolean
     */
    public function testValidateLeadingZero()
    {
        $reflectionValidate = new ReflectionClass('Clickatell\Component\Validate');

        $method = $reflectionValidate->getMethod('_validateLeadingZero');
        $method->setAccessible(true);
        
        $validation = $reflectionValidate->newInstance();

        $this->assertEquals(true, $method->invoke($validation, "0215556666"));
        $this->assertEquals(false, $method->invoke($validation, "2215556666"));
    }

    /**
     * Ensures that the intput is numeric.
     *
     * @return boolean
     */
    public function testValidateInt()
    {
        $reflectionValidate = new ReflectionClass('Clickatell\Component\Validate');

        $method = $reflectionValidate->getMethod('_validateInt');
        $method->setAccessible(true);
        
        $validation = $reflectionValidate->newInstance();

        $this->assertEquals(true, $method->invoke($validation, "0215556666"));
        $this->assertEquals(false, $method->invoke($validation, "a215556666"));
    }

    /**
     * Ensures that the intput is telephone number.
     *
     * @return boolean
     */
    public function testValidateTelephone()
    {
        $reflectionValidate = new ReflectionClass('Clickatell\Component\Validate');

        $method = $reflectionValidate->getMethod('_validateTelephone');
        $method->setAccessible(true);
        
        $validation = $reflectionValidate->newInstance();

        $this->assertEquals(true, $method->invoke($validation, "27215556666"));

        try
        {
            $method->invoke($validation, "a215556666");
        }
        catch (ValidateException $exception)
        {
            $this->assertSame(ValidateException::ERR_INVALID_NUM, $exception->getMessage());
            return true;
        }

        #-> Silly way to test exceptions
        $this->assertTrue(false);
    }
}