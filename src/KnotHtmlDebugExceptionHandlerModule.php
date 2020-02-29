<?php
declare(strict_types=1);

namespace KnotPhp\Module\KnotExceptionHandler;

use Throwable;

use KnotLib\ExceptionHandler\DebugtraceRenderer\HtmlDebugtraceRenderer;
use KnotLib\ExceptionHandler\Handler\PrintExceptionHandler;
use KnotLib\Kernel\EventStream\Channels;
use KnotLib\Kernel\EventStream\Events;
use KnotLib\Kernel\Exception\ModuleInstallationException;
use KnotLib\Kernel\Kernel\ApplicationInterface;
use KnotLib\Kernel\Module\ComponentTypes;
use KnotLib\Kernel\Module\ModuleInterface;

use KnotPhp\Module\KnotExceptionHandler\Adapter\KnotExceptionHandlerAdapter;

class KnotHtmlDebugExceptionHandlerModule implements ModuleInterface
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
            $renderer = new HtmlDebugtraceRenderer();

            $ex_handler = new KnotExceptionHandlerAdapter(new PrintExceptionHandler($renderer));
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