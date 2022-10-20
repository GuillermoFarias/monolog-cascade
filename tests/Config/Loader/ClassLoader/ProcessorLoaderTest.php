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

namespace Cascade\Tests\Config\Loader\ClassLoader;

use Cascade\Config\Loader\ClassLoader\ProcessorLoader;
use Monolog\Processor\WebProcessor;
use PHPUnit\Framework\TestCase;

/**
 * Class ProcessorLoaderTest.
 *
 * @author Kate Burdon <kburdon@tableau.com>
 */
class ProcessorLoaderTest extends TestCase
{
    public function testProcessorLoader()
    {
        $options = [
            'class' => 'Monolog\Processor\WebProcessor',
        ];
        $processors = [new WebProcessor()];
        $loader = new ProcessorLoader($options, $processors);

        $this->assertEquals($loader->class, $options['class']);
    }
}
