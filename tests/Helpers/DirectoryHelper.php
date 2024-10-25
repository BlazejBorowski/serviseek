<?php

namespace Tests\Helpers;

class DirectoryHelper
{
    public static function getClassNameFromFilePath(string $filePath): string
    {
        $content = file_get_contents($filePath);

        if (preg_match('/namespace\s+(.+?);/', $content, $matches)) {
            $namespace = $matches[1];
        } else {
            $namespace = '';
        }

        $class = basename($filePath, '.php');

        return $namespace ? $namespace.'\\'.$class : $class;
    }

    public static function getClassNamesFromDirectory(string $directory): array
    {
        $classNames = [];
        $files = glob($directory.'/*.php');
        $subdirectories = glob($directory.'/*', GLOB_ONLYDIR);

        foreach ($files as $file) {
            $classNames[] = self::getClassNameFromFilePath(realpath($file));
        }

        foreach ($subdirectories as $subdirectory) {
            $classNames = array_merge($classNames, self::getClassNamesFromDirectory($subdirectory));
        }

        return $classNames;
    }

    public static function getPhpFilesFromDirectory(string $directory): array
    {
        $files = glob($directory.'/*.php');
        $subdirectories = glob($directory.'/*', GLOB_ONLYDIR);

        foreach ($subdirectories as $subdirectory) {
            $files = array_merge($files, self::getPhpFilesFromDirectory($subdirectory));
        }

        return $files;
    }

    public static function countDirectoriesInFolder(string $folderPath): int
    {
        $directoryIterator = new \RecursiveDirectoryIterator($folderPath, \FilesystemIterator::SKIP_DOTS);

        $directoryCount = 0;

        foreach ($directoryIterator as $fileInfo) {
            if ($fileInfo->isDir()) {
                $directoryCount++;
            }
        }

        return $directoryCount;
    }
}
