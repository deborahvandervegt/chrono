<?php

namespace Accompli\Chrono\Test;

use Accompli\Chrono\Process\ProcessExecutionResult;
use PHPUnit_Framework_TestCase;

/**
 * ProcessExecutionResultTest.
 *
 * @author Niels Nijens <nijens.niels@gmail.com>
 */
class ProcessExecutionResultTest extends PHPUnit_Framework_TestCase
{
    /**
     * Tests if construction of ProcessExecutionResult sets the properties.
     */
    public function testConstruct()
    {
        $processExecutionResult = new ProcessExecutionResult(0, 'Output', 'Error');

        $this->assertAttributeSame(0, 'exitCode', $processExecutionResult);
        $this->assertAttributeSame('Output', 'output', $processExecutionResult);
        $this->assertAttributeSame('Error', 'errorOutput', $processExecutionResult);
    }

    /**
     * Tests if ProcessExecutionResult::isSuccessful returns true when the exit code is 0.
     */
    public function testIsSuccesfulReturnsTrueWhenExitCodeIsZero()
    {
        $processExecutionResult = new ProcessExecutionResult(0, 'Output', 'Error');

        $this->assertTrue($processExecutionResult->isSuccessful());
    }

    /**
     * Tests if ProcessExecutionResult::isSuccessful returns false when the exit code is not 0.
     */
    public function testIsSuccesfulReturnsFalseWhenExitCodeIsNotZero()
    {
        $processExecutionResult = new ProcessExecutionResult(1, 'Output', 'Error');

        $this->assertFalse($processExecutionResult->isSuccessful());
    }

    /**
     * Tests if ProcessExecutionResult::getExitCode returns the same value as during construction of ProcessExecutionResult.
     */
    public function testGetExitCode()
    {
        $processExecutionResult = new ProcessExecutionResult(0, 'Output', 'Error');

        $this->assertSame(0, $processExecutionResult->getExitCode());
    }

    /**
     * Tests if ProcessExecutionResult::getOutput returns the same value as during construction of ProcessExecutionResult.
     */
    public function testGetOutput()
    {
        $processExecutionResult = new ProcessExecutionResult(0, 'Output', 'Error');

        $this->assertSame('Output', $processExecutionResult->getOutput());
    }

    /**
     * Tests if ProcessExecutionResult::getOutputAsArray returns the value of ProcessExecutionResult::getOutput, but separated by newline.
     *
     * @dataProvider provideGetOutputAsArray
     */
    public function testGetOutputAsArray($output, array $expectedArray)
    {
        $processExecutionResult = new ProcessExecutionResult(0, $output, 'Error');

        $this->assertSame($expectedArray, $processExecutionResult->getOutputAsArray());
    }

    /**
     * Tests if ProcessExecutionResult::getErrorOutput returns the same value as during construction of ProcessExecutionResult.
     */
    public function testGetErrorOutput()
    {
        $processExecutionResult = new ProcessExecutionResult(0, 'Output', 'Error');

        $this->assertSame('Error', $processExecutionResult->getErrorOutput());
    }

    /**
     * Returns the test data array for testGetOutputAsArray.
     *
     * @return array
     */
    public function provideGetOutputAsArray()
    {
        return array(
            array('', array()),
            array('Output line1', array('Output line1')),
            array("Output line1\n", array('Output line1')),
            array("Output line1\nOutput line2", array('Output line1', 'Output line2')),
            array("Output line1\r\n", array('Output line1')),
            array("Output line1\r\nOutput line2", array('Output line1', 'Output line2')),
        );
    }
}
