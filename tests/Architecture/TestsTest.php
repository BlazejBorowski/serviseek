<?php

namespace Tests\Architecture;

use ReflectionClass;
use Tests\Helpers\DirectoryHelper;
use Tests\TestCase;

class TestsTest extends TestCase
{
    private array $testDirectories = [
        __DIR__.'/../../tests/Unit',
        __DIR__.'/../../tests/Feature',
        __DIR__.'/../../tests/Architecture',
    ];

    private array $otherDirectories = [
        __DIR__.'/../../tests/Helpers',
    ];

    public function testAllTestClassesExtendTestCase(): void
    {
        $classNames = [];
        foreach ($this->testDirectories as $directory) {
            $classNames = array_merge($classNames, DirectoryHelper::getClassNamesFromDirectory($directory));
        }

        if (empty($classNames)) {
            $this->markTestSkipped('No test classes found in Unit, Feature or Architecture directories.');

            return;
        }

        foreach ($classNames as $className) {
            if (class_exists($className)) {
                $reflection = new ReflectionClass($className);

                $this->assertTrue(
                    $reflection->isSubclassOf(\PHPUnit\Framework\TestCase::class),
                    'Test class '.$className.' does not extend TestCase.'
                );
            }
        }
    }

    public function testDirectoriesCountMatches(): void
    {
        $expectedDirectories = array_merge($this->testDirectories, $this->otherDirectories);
        $expectedCount = count($expectedDirectories);

        $testsDirectory = __DIR__.'/../../tests';
        $actualCount = DirectoryHelper::countDirectoriesInFolder($testsDirectory);

        $this->assertEquals(
            $expectedCount,
            $actualCount,
            "The number of directories in the 'tests' folder does not match the expected count."
        );
    }
}
