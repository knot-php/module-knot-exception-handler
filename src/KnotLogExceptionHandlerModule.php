<?php
declare(strict_types=1);

namespace KnotPhp\Module\KnotExceptionHandler;

use Throwable;

use KnotLib\Kernel\EventStream\Channels;
use KnotLib\Kernel\EventStream\Events;
use KnotLib\Kernel\Exception\ModuleInstallationException;
use KnotLib\ExceptionHandler\Handler\LogExceptionHandler;
use KnotLib\ExceptionHandler\DebugtraceRenderer\ConsoleDebugtraceRenderer;
use KnotLib\Kernel\Kernel\ApplicationInterface;
use KnotLib\Kernel\Module\ModuleInterface;
use KnotLib\Kernel\Module\ComponentTypes;

use KnotPhp\Module\KnotExceptionHandler\Adapter\KnotExceptionHandlerAdapter;

class KnotLogExceptionHandlerModule implements ModuleInterface
{
    /**
     * Declare dependency on another modules
     *
     * @return array
     */
    public static function requiredModules() : array
    {
        return [];
    }

    /**
     * Declare dependent on components
     *
     * @return array
     */
    public static function requiredComponentTypes() : array
    {
        return [
            ComponentTypes::EVENTSTREAM,
            ComponentTypes::LOGGER,
        ];
    }

    /**
     * Declare component type of this module
     *
     * @return string
     */
    public static function declareComponentType() : string
    {
        return ComponentTypes::EX_HANDLER;
    }

    /**
     * Install module
     *
     * @param ApplicationInterface $app
     *
     * @throws ModuleInstallationException
     */
    public function install(ApplicationInterface $app)
    {
        try{
            $renderer = new ConsoleDebugtraceRenderer();

            $ex_handler = new KnotExceptionHandlerAdapter(new LogExceptionHandler($app->logger(), $renderer));
            $app->addExceptionHandler($ex_handler);

            // fire event
            $app->eventstream()->channel(Channels::SYSTEM)->push(Events::EX_HANDLER_ADDED, $ex_handler);
        }
        catch(Throwable $e)
        {
            throw new ModuleInstallationException(self::class, $e->getMessage(), 0, $e);
        }
    }
}