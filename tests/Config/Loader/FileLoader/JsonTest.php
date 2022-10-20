<?php
/**
 * This file is part of the Monolog Cascade package.
 *
 * (c) Raphael Antonmattei <rantonmattei@theorchard.com>
 * (c) The Orchard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cascade\Tests\Config\Loader\FileLoader;

use Cascade\Tests\Fixtures;
use PHPUnit\Framework\MockObject\MockBuilder;
use PHPUnit\Framework\TestCase;

/**
 * Class JsonTest.
 *
 * @author Raphael Antonmattei <rantonmattei@theorchard.com>
 */
class JsonTest extends TestCase
{
    /**
     * JSON loader mock builder.
     *
     * @var MockBuilder
     */
    protected $jsonLoader = null;

    public function setUp() : void
    {
        parent::setUp();

        $fileLocatorMock = $this->getMockBuilder('Symfony\Component\Config\FileLocatorInterface')
                                ->getMock();

        $this->jsonLoader = $this->getMockBuilder(
            'Cascade\Config\Loader\FileLoader\Json'
        )
            ->setConstructorArgs([$fileLocatorMock])
            ->setMethods(['readFrom', 'isFile', 'validateExtension'])
            ->getMock();
    }

    public function tearDown() : void
    {
        $this->jsonLoader = null;
        parent::tearDown();
    }

    /**
     * Test loading a JSON string.
     */
    public function testLoad()
    {
        $json = Fixtures::getSampleJsonString();

        $this->jsonLoader->expects($this->once())
            ->method('readFrom')
            ->willReturn($json);

        $this->assertEquals(
            json_decode($json, true),
            $this->jsonLoader->load($json)
        );
    }

    /**
     * Data provider for testSupportsWithInvalidResource.
     *
     * @return array array non-string values
     */
    public function notStringDataProvider()
    {
        return [
            [[]],
            [true],
            [123],
            [123.456],
            [null],
            [new \stdClass()],
            [function () {
            }],
        ];
    }

    /**
     * Test loading resources supported by the JsonLoader.
     *
     * @param mixed $invalidResource Invalid resource value
     *
     * @dataProvider notStringDataProvider
     */
    public function testSupportsWithInvalidResource($invalidResource)
    {
        $this->assertFalse($this->jsonLoader->supports($invalidResource));
    }

    /**
     * Test loading a JSON string.
     */
    public function testSupportsWithJsonString()
    {
        $this->jsonLoader->expects($this->once())
            ->method('isFile')
            ->willReturn(false);

        $json = Fixtures::getSampleJsonString();

        $this->assertTrue($this->jsonLoader->supports($json));
    }

    /**
     * Test loading a JSON file
     * Note that this function tests isJson with a valid Json string.
     */
    public function testSupportsWithJsonFile()
    {
        $this->jsonLoader->expects($this->once())
            ->method('isFile')
            ->willReturn(true);

        $this->jsonLoader->expects($this->once())
            ->method('validateExtension')
            ->willReturn(true);

        $jsonFile = Fixtures::getSampleJsonFile();

        $this->assertTrue($this->jsonLoader->supports($jsonFile));
    }

    /**
     * Test isJson method with invalid JSON string.
     * Valid scenario is tested by the method above.
     */
    public function testSupportsWithNonJsonString()
    {
        $this->jsonLoader->expects($this->once())
            ->method('isFile')
            ->willReturn(false);

        $someString = Fixtures::getSampleString();

        $this->assertFalse($this->jsonLoader->supports($someString));
    }
}
