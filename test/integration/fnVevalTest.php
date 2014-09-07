<?php

use PHPUnit_Framework_TestCase as TestCase;
use Vfs\FileSystem;
use Vfs\FileSystemRegistry;

class fnVevalTest extends TestCase
{
    public function tearDown()
    {
        $reg = FileSystemRegistry::getInstance();

        if ($reg->has(Veval::SCHEME)) {
            $fs = $reg->get(Veval::SCHEME);
            $fs->unmount();
        }
    }

    public function testDebug()
    {
        $code = '<?php "foo";';
        Veval\execute($code, 'foo');

        $files = [];

        Veval\debug(function ($name, $content) use (&$files) {
            $files[$name] = $content;
        });

        $this->assertSame(['foo' => $code], $files);
    }

    public function testDump()
    {
        $scheme = 'vevaldump';
        $code = '<?php "foo";';
        Veval\execute($code, 'foo');

        $fs = FileSystem::factory($scheme);
        Veval\dump("$scheme://");

        $this->assertEquals($code, file_get_contents("$scheme:///veval-foo.php"));

        $fs->unmount();
    }

    public function testDumpWithPattern()
    {
        $scheme = 'vevaldump';
        $code = '<?php "foo";';
        Veval\execute($code, 'foo');

        $fs = FileSystem::factory($scheme);
        Veval\dump("$scheme://", '%s');

        $this->assertEquals($code, file_get_contents("$scheme:///foo"));

        $fs->unmount();
    }

    public function testEvaluate()
    {
        Veval\execute(<<<'EOF'
<?php
namespace fnVevalTest;
class testEvaluate {}
EOF
        );

        $this->assertTrue(class_exists('fnVevalTest\testEvaluate'));
    }

    public function testEvaluateWithName()
    {
        Veval\execute(<<<'EOF'
<?php
namespace fnVevalTest;
class testEvaluateWithName {}
EOF
        , 'foo');

        $this->assertTrue(class_exists('fnVevalTest\testEvaluateWithName'));
    }

    public function testIterator()
    {
        $code = '<?php "foo";';
        Veval\execute($code, 'foo');

        foreach (Veval\iterator() as $name => $content) {
            $this->assertEquals('foo', $name);
            $this->assertEquals($code, $content);
        }
    }
}
