<?php

declare(strict_types=1);

namespace Tests\Architecture;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use ReflectionClass;
use ReflectionMethod;
use Tests\Helpers\DirectoryHelper;
use Tests\TestCase;
use Throwable;

// TODO: Update tests for modules
class LaravelTest extends TestCase
{
    public function testAllClassesInTraitsDirectoryAreTraits(): void
    {
        $directory = __DIR__.'/../../app/Traits';


        $files = glob($directory.'/*.php');

        if (empty($files)) {
            $this->markTestSkipped('No files found in App/Traits.');

            return;
        }

        foreach ($files as $filePath) {
            $traitName = DirectoryHelper::getClassNameFromFilePath(realpath($filePath));

            if (trait_exists($traitName, true)) {
                $this->assertTrue(true, "Trait {$traitName} exists.");
            } else {
                $this->fail("Trait {$traitName} does not exist.");
            }
        }
    }

    public function testAllClassesOutsideTraitsDirectoryAreNotTraits(): void
    {
        $directory = __DIR__.'/../../app';

        $classNames = DirectoryHelper::getClassNamesFromDirectory($directory);

        foreach ($classNames as $className) {
            if (strpos($className, 'App\\Traits\\') !== 0) {
                if (class_exists($className) || trait_exists($className)) {
                    $reflection = new ReflectionClass($className);

                    $this->assertFalse(
                        $reflection->isTrait(),
                        "Expected {$className} to not be a trait outside App/Traits."
                    );
                }
            }
        }
    }

    public function testProhibitedFunctionsAreNotUsed(): void
    {
        $prohibitedFunctions = [
            'dd',
            'dump',
            'env',
            'exit',
            'ray',
        ];

        $directory = __DIR__.'/../../app';
        $files = DirectoryHelper::getPhpFilesFromDirectory(realpath($directory));

        foreach ($files as $file) {
            $content = file_get_contents($file);

            foreach ($prohibitedFunctions as $function) {
                $pattern = '/\b'.preg_quote($function).'\s*\(/';

                $this->assertFalse(
                    preg_match($pattern, $content) === 1,
                    "The function {$function} should not be used in file {$file}."
                );
            }
        }
    }

    public function testControllersHaveOnlyAllowedPublicMethods(): void
    {
        $allowedMethods = ['__construct', '__invoke', 'index', 'show', 'create', 'store', 'edit', 'update', 'destroy', 'middleware'];
        $controllersDirectory = __DIR__.'/../../app/Http/Controllers';
        $classNames = DirectoryHelper::getClassNamesFromDirectory($controllersDirectory);

        foreach ($classNames as $className) {
            if (class_exists($className)) {
                $reflection = new ReflectionClass($className);

                foreach ($reflection->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
                    $this->assertTrue(
                        in_array($method->getName(), $allowedMethods),
                        "Public method {$method->getName()} is not allowed in controller {$className}."
                    );
                }
            }
        }
    }

    public function testHttpNamespaceIsOnlyUsedInAppHttp(): void
    {
        $namespace = 'App\\Http';
        $directory = __DIR__.'/../../app';
        $files = DirectoryHelper::getPhpFilesFromDirectory(realpath($directory));

        foreach ($files as $file) {
            if (strpos($file, '/Http/') === false) {
                $content = file_get_contents($file);

                $this->assertStringNotContainsString(
                    $namespace,
                    $content,
                    "Namespace {$namespace} should not be used in file {$file} outside App\\Http."
                );
            }
        }
    }

    public function testControllersHaveControllerSuffix(): void
    {
        $controllersDirectory = __DIR__.'/../../app/Http/Controllers';
        $classNames = DirectoryHelper::getClassNamesFromDirectory($controllersDirectory);

        foreach ($classNames as $className) {
            if (class_exists($className)) {
                $this->assertStringEndsWith(
                    'Controller',
                    $className,
                    "Class {$className} does not have the 'Controller' suffix."
                );
            }
        }
    }

    public function testNoClassInAppHasControllerSuffixExceptInHttpControllers(): void
    {
        $directory = __DIR__.'/../../app';
        $classNames = DirectoryHelper::getClassNamesFromDirectory($directory);

        foreach ($classNames as $className) {
            if (strpos($className, 'App\\Http\\Controllers') === 0) {
                continue;
            }

            $this->assertStringEndsNotWith(
                'Controller',
                $className,
                "Class {$className} should not have the 'Controller' suffix outside of App\\Http\\Controllers."
            );
        }
    }

    public function testNoClassInAppHasServiceProviderSuffixExceptInProviders(): void
    {
        $directory = __DIR__.'/../../app';
        $classNames = DirectoryHelper::getClassNamesFromDirectory($directory);

        foreach ($classNames as $className) {
            if (strpos($className, 'App\\Providers') === 0) {
                continue;
            }

            $this->assertStringEndsNotWith(
                'ServiceProvider',
                $className,
                "Class {$className} should not have the 'ServiceProvider' suffix outside of App\\Providers."
            );
        }
    }

    public function testNoClassExtendsServiceProviderExceptInProviders(): void
    {
        $directory = __DIR__.'/../../app';
        $classNames = DirectoryHelper::getClassNamesFromDirectory($directory);

        foreach ($classNames as $className) {
            if (strpos($className, 'App\\Providers') === 0) {
                continue;
            }

            if (class_exists($className)) {
                $reflection = new ReflectionClass($className);

                $this->assertFalse(
                    $reflection->isSubclassOf('Illuminate\Support\ServiceProvider'),
                    "Class {$className} should not extend Illuminate\\Support\\ServiceProvider outside of App\\Providers."
                );
            }
        }
    }

    public function testProvidersNamespaceIsNotUsed(): void
    {
        $directory = __DIR__.'/../../app';
        $files = DirectoryHelper::getPhpFilesFromDirectory(realpath($directory));

        foreach ($files as $file) {
            if (strpos($file, '/Providers/') === false) {
                $content = file_get_contents($file);

                $this->assertStringNotContainsString(
                    'App\\Providers',
                    $content,
                    "The namespace App\\Providers is used in file {$file}, which should not happen."
                );
            }
        }
    }

    public function testProvidersExtendServiceProvider(): void
    {
        $providersDirectory = __DIR__.'/../../app/Providers';
        $classNames = DirectoryHelper::getClassNamesFromDirectory($providersDirectory);

        foreach ($classNames as $className) {
            if (class_exists($className)) {
                $reflection = new ReflectionClass($className);

                $this->assertTrue(
                    $reflection->isSubclassOf('Illuminate\Support\ServiceProvider'),
                    "Class {$className} should extend Illuminate\\Support\\ServiceProvider."
                );
            }
        }
    }

    public function testProvidersHaveServiceProviderSuffix(): void
    {
        $providersDirectory = __DIR__.'/../../app/Providers';
        $classNames = DirectoryHelper::getClassNamesFromDirectory($providersDirectory);

        foreach ($classNames as $className) {
            if (class_exists($className)) {
                $this->assertStringEndsWith(
                    'ServiceProvider',
                    $className,
                    "Class {$className} does not have the 'ServiceProvider' suffix."
                );
            }
        }
    }

    public function testNoClassExtendsNotificationExceptInNotifications(): void
    {
        $directory = __DIR__.'/../../app';
        $classNames = DirectoryHelper::getClassNamesFromDirectory($directory);

        foreach ($classNames as $className) {
            if (strpos($className, 'App\\Notifications') === 0) {
                continue;
            }

            if (class_exists($className)) {
                $reflection = new ReflectionClass($className);

                $this->assertFalse(
                    $reflection->isSubclassOf('Illuminate\Notifications\Notification'),
                    "Class {$className} should not extend Illuminate\\Notifications\\Notification outside of App\\Notifications."
                );
            }
        }
    }

    public function testNotificationsExtendNotification(): void
    {
        $notificationsDirectory = __DIR__.'/../../app/Notifications';
        $classNames = DirectoryHelper::getClassNamesFromDirectory($notificationsDirectory);

        if (empty($classNames)) {
            $this->markTestSkipped('No classes found in App\Notifications.');

            return;
        }

        foreach ($classNames as $className) {
            if (class_exists($className)) {
                $reflection = new ReflectionClass($className);

                $this->assertTrue(
                    $reflection->isSubclassOf('Illuminate\Notifications\Notification'),
                    "Class {$className} should extend Illuminate\\Notifications\\Notification."
                );
            }
        }
    }

    public function testListenersHaveHandleMethod(): void
    {
        $listenersDirectory = __DIR__.'/../../app/Listeners';
        $classNames = DirectoryHelper::getClassNamesFromDirectory($listenersDirectory);

        if (empty($classNames)) {
            $this->markTestSkipped('No classes found in App\Listeners.');

            return;
        }

        foreach ($classNames as $className) {
            if (class_exists($className)) {
                $reflection = new ReflectionClass($className);

                $this->assertTrue(
                    $reflection->hasMethod('handle'),
                    "Class {$className} does not have a 'handle' method."
                );
            }
        }
    }

    public function testJobsHaveHandleMethod(): void
    {
        $jobsDirectory = __DIR__.'/../../app/Jobs';
        $classNames = DirectoryHelper::getClassNamesFromDirectory($jobsDirectory);

        if (empty($classNames)) {
            $this->markTestSkipped('No classes found in App\Jobs.');

            return;
        }

        foreach ($classNames as $className) {
            if (class_exists($className)) {
                $reflection = new ReflectionClass($className);

                $this->assertTrue(
                    $reflection->hasMethod('handle'),
                    "Class {$className} does not have a 'handle' method."
                );
            }
        }
    }

    public function testJobsImplementShouldQueue(): void
    {
        $jobsDirectory = __DIR__.'/../../app/Jobs';
        $classNames = DirectoryHelper::getClassNamesFromDirectory($jobsDirectory);

        if (empty($classNames)) {
            $this->markTestSkipped('No classes found in App\Jobs.');

            return;
        }

        foreach ($classNames as $className) {
            if (class_exists($className)) {
                $reflection = new ReflectionClass($className);

                $this->assertTrue(
                    $reflection->implementsInterface('Illuminate\Contracts\Queue\ShouldQueue'),
                    "Class {$className} does not implement Illuminate\\Contracts\\Queue\\ShouldQueue."
                );
            }
        }
    }

    public function testNoClassExtendsMailableExceptInMail(): void
    {
        $directory = __DIR__.'/../../app';
        $classNames = DirectoryHelper::getClassNamesFromDirectory($directory);

        foreach ($classNames as $className) {
            if (strpos($className, 'App\\Mail') === 0) {
                continue;
            }

            if (class_exists($className)) {
                $reflection = new ReflectionClass($className);

                $this->assertFalse(
                    $reflection->isSubclassOf('Illuminate\Mail\Mailable'),
                    "Class {$className} should not extend Illuminate\\Mail\\Mailable outside of App\\Mail."
                );
            }
        }
    }

    public function testMailClassesImplementShouldQueue(): void
    {
        $mailDirectory = __DIR__.'/../../app/Mail';
        $classNames = DirectoryHelper::getClassNamesFromDirectory($mailDirectory);

        if (empty($classNames)) {
            $this->markTestSkipped('No classes found in App\Mail.');

            return;
        }

        foreach ($classNames as $className) {
            if (class_exists($className)) {
                $reflection = new ReflectionClass($className);

                $this->assertTrue(
                    $reflection->implementsInterface('Illuminate\Contracts\Queue\ShouldQueue'),
                    "Class {$className} does not implement Illuminate\\Contracts\\Queue\\ShouldQueue."
                );
            }
        }
    }

    public function testMailClassesExtendMailable(): void
    {
        $mailDirectory = __DIR__.'/../../app/Mail';
        $classNames = DirectoryHelper::getClassNamesFromDirectory($mailDirectory);

        if (empty($classNames)) {
            $this->markTestSkipped('No classes found in App\Mail.');

            return;
        }

        foreach ($classNames as $className) {
            if (class_exists($className)) {
                $reflection = new ReflectionClass($className);

                $this->assertTrue(
                    $reflection->isSubclassOf('Illuminate\Mail\Mailable'),
                    "Class {$className} should extend Illuminate\\Mail\\Mailable."
                );
            }
        }
    }

    public function testNoClassExtendsCommandExceptInConsoleCommands(): void
    {
        $directory = __DIR__.'/../../app';
        $classNames = DirectoryHelper::getClassNamesFromDirectory($directory);

        foreach ($classNames as $className) {
            if (strpos($className, 'App\\Console\\Commands') === 0) {
                continue;
            }

            if (class_exists($className)) {
                $reflection = new ReflectionClass($className);

                $this->assertFalse(
                    $reflection->isSubclassOf('Illuminate\Console\Command'),
                    "Class {$className} should not extend Illuminate\\Console\\Command outside of App\\Console\\Commands."
                );
            }
        }
    }

    public function testConsoleCommandsHaveHandleMethod(): void
    {
        $commandsDirectory = __DIR__.'/../../app/Console/Commands';
        $classNames = DirectoryHelper::getClassNamesFromDirectory($commandsDirectory);

        if (empty($classNames)) {
            $this->markTestSkipped('No classes found in App\Console\Commands.');

            return;
        }

        foreach ($classNames as $className) {
            if (class_exists($className)) {
                $reflection = new ReflectionClass($className);

                $this->assertTrue(
                    $reflection->hasMethod('handle'),
                    "Class {$className} does not have a 'handle' method."
                );
            }
        }
    }

    public function testConsoleCommandsExtendCommand(): void
    {
        $commandsDirectory = __DIR__.'/../../app/Console/Commands';
        $classNames = DirectoryHelper::getClassNamesFromDirectory($commandsDirectory);

        if (empty($classNames)) {
            $this->markTestSkipped('No classes found in App\Console\Commands.');

            return;
        }

        foreach ($classNames as $className) {
            if (class_exists($className)) {
                $reflection = new ReflectionClass($className);

                $this->assertTrue(
                    $reflection->isSubclassOf('Illuminate\Console\Command'),
                    "Class {$className} does not extend Illuminate\\Console\\Command."
                );
            }
        }
    }

    public function testConsoleCommandsHaveCommandSuffix(): void
    {
        $commandsDirectory = __DIR__.'/../../app/Console/Commands';
        $classNames = DirectoryHelper::getClassNamesFromDirectory($commandsDirectory);

        if (empty($classNames)) {
            $this->markTestSkipped('No classes found in App\Console\Commands.');

            return;
        }

        foreach ($classNames as $className) {
            if (class_exists($className)) {
                $this->assertStringEndsWith(
                    'Command',
                    (new ReflectionClass($className))->getShortName(),
                    "Class {$className} does not have the 'Command' suffix."
                );
            }
        }
    }

    public function testNoClassExtendsFormRequestExceptInHttpRequests(): void
    {
        $directory = __DIR__.'/../../app';
        $classNames = DirectoryHelper::getClassNamesFromDirectory($directory);

        foreach ($classNames as $className) {
            if (strpos($className, 'App\\Http\\Requests') === 0) {
                continue;
            }

            if (class_exists($className)) {
                $reflection = new ReflectionClass($className);

                $this->assertFalse(
                    $reflection->isSubclassOf('Illuminate\Foundation\Http\FormRequest'),
                    "Class {$className} should not extend Illuminate\\Foundation\\Http\\FormRequest outside of App\\Http\\Requests."
                );
            }
        }
    }

    public function testHttpRequestsHaveRulesMethod(): void
    {
        $requestsDirectory = __DIR__.'/../../app/Http/Requests';
        $classNames = DirectoryHelper::getClassNamesFromDirectory($requestsDirectory);

        if (empty($classNames)) {
            $this->markTestSkipped('No classes found in App\Http\Requests.');

            return;
        }

        foreach ($classNames as $className) {
            if (class_exists($className)) {
                $reflection = new ReflectionClass($className);

                $this->assertTrue(
                    $reflection->hasMethod('rules'),
                    "Class {$className} does not have a 'rules' method."
                );
            }
        }
    }

    public function testHttpRequestsExtendFormRequest(): void
    {
        $requestsDirectory = __DIR__.'/../../app/Http/Requests';
        $classNames = DirectoryHelper::getClassNamesFromDirectory($requestsDirectory);

        if (empty($classNames)) {
            $this->markTestSkipped('No classes found in App\Http\Requests.');

            return;
        }

        foreach ($classNames as $className) {
            if (class_exists($className)) {
                $reflection = new ReflectionClass($className);

                $this->assertTrue(
                    $reflection->isSubclassOf('Illuminate\Foundation\Http\FormRequest'),
                    "Class {$className} does not extend Illuminate\\Foundation\\Http\\FormRequest."
                );
            }
        }
    }

    public function testHttpRequestsHaveRequestSuffix(): void
    {
        $requestsDirectory = __DIR__.'/../../app/Http/Requests';
        $classNames = DirectoryHelper::getClassNamesFromDirectory($requestsDirectory);

        if (empty($classNames)) {
            $this->markTestSkipped('No classes found in App\Http\Requests.');

            return;
        }

        foreach ($classNames as $className) {
            if (class_exists($className)) {
                $this->assertStringEndsWith(
                    'Request',
                    (new ReflectionClass($className))->getShortName(),
                    "Class {$className} does not have the 'Request' suffix."
                );
            }
        }
    }

    public function testNoClassExtendsModelExceptInModels(): void
    {
        $directory = __DIR__.'/../../app';
        $classNames = DirectoryHelper::getClassNamesFromDirectory($directory);

        foreach ($classNames as $className) {
            if (strpos($className, 'App\\Models') === 0) {
                continue;
            }

            if (class_exists($className)) {
                $reflection = new ReflectionClass($className);

                $this->assertFalse(
                    $reflection->isSubclassOf('Illuminate\Database\Eloquent\Model'),
                    "Class {$className} should not extend Illuminate\\Database\\Eloquent\\Model outside of App\\Models."
                );
            }
        }
    }

    public function testModelsDoNotHaveModelSuffix(): void
    {
        $modelsDirectory = __DIR__.'/../../app/Models';
        $classNames = DirectoryHelper::getClassNamesFromDirectory($modelsDirectory);

        if (empty($classNames)) {
            $this->markTestSkipped('No classes found in App\Models.');

            return;
        }

        foreach ($classNames as $className) {
            if (class_exists($className)) {
                $this->assertStringEndsNotWith(
                    'Model',
                    (new ReflectionClass($className))->getShortName(),
                    "Class {$className} should not have the 'Model' suffix."
                );
            }
        }
    }

    public function testModelsExtendEloquentModelExceptInScopes(): void
    {
        $modelsDirectory = __DIR__.'/../../app/Models';
        $classNames = DirectoryHelper::getClassNamesFromDirectory($modelsDirectory);

        if (empty($classNames)) {
            $this->markTestSkipped('No classes found in App\Models.');

            return;
        }

        foreach ($classNames as $className) {
            if (strpos($className, 'App\\Models\\Scopes') === 0) {
                continue;
            }

            if (class_exists($className)) {
                $reflection = new ReflectionClass($className);

                $this->assertTrue(
                    $reflection->isSubclassOf('Illuminate\Database\Eloquent\Model'),
                    "Class {$className} does not extend Illuminate\\Database\\Eloquent\\Model."
                );
            }
        }
    }

    public function testMiddlewareClassesHaveHandleMethod(): void
    {
        $middlewareDirectory = __DIR__.'/../../app/Http/Middleware';
        $classNames = DirectoryHelper::getClassNamesFromDirectory($middlewareDirectory);

        if (empty($classNames)) {
            $this->markTestSkipped('No classes found in App\Http\Middleware.');

            return;
        }

        foreach ($classNames as $className) {
            if (class_exists($className)) {
                $reflection = new ReflectionClass($className);

                $this->assertTrue(
                    $reflection->hasMethod('handle'),
                    "Class {$className} does not have a 'handle' method."
                );
            }
        }
    }

    public function testNoClassImplementsThrowableExceptInExceptions(): void
    {
        $directory = __DIR__.'/../../app';
        $classNames = DirectoryHelper::getClassNamesFromDirectory($directory);

        foreach ($classNames as $className) {
            if (strpos($className, 'App\\Exceptions') === 0) {
                continue;
            }

            if (class_exists($className)) {
                $reflection = new ReflectionClass($className);

                $this->assertFalse(
                    $reflection->implementsInterface(Throwable::class),
                    "Class {$className} should not implement Throwable outside of App\\Exceptions."
                );
            }
        }
    }

    public function testExceptionsImplementThrowableExceptHandler(): void
    {
        $exceptionsDirectory = __DIR__.'/../../app/Exceptions';
        $classNames = DirectoryHelper::getClassNamesFromDirectory($exceptionsDirectory);

        if (empty($classNames)) {
            $this->markTestSkipped('No classes found in App\Exceptions.');

            return;
        }

        foreach ($classNames as $className) {
            if ($className === 'App\\Exceptions\\Handler') {
                continue;
            }

            if (class_exists($className)) {
                $reflection = new ReflectionClass($className);

                $this->assertTrue(
                    $reflection->implementsInterface(Throwable::class),
                    "Class {$className} does not implement Throwable."
                );
            }
        }
    }

    public function testNoClassIsEnumExceptInEnums(): void
    {
        $directory = __DIR__.'/../../app';
        $classNames = DirectoryHelper::getClassNamesFromDirectory($directory);

        foreach ($classNames as $className) {
            if (strpos($className, 'App\\Enums') === 0) {
                continue;
            }

            if (class_exists($className)) {
                $reflection = new ReflectionClass($className);

                $this->assertFalse(
                    $reflection->isEnum(),
                    "Class {$className} should not be an enum outside of App\\Enums."
                );
            }
        }
    }
}
