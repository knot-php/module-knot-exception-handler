<?php
declare(strict_types=1);

namespace KnotPhp\Module\KnotExceptionHandler\Adapter;

use Throwable;

use KnotLib\Kernel\ExceptionHandler\ExceptionHandlerInterface;
use KnotLib\ExceptionHandler\ExceptionHandlerInterface as CalgamoExceptionHandler;

class KnotExceptionHandlerAdapter implements ExceptionHandlerInterface
{
    /** @var CalgamoExceptionHandler */
    private $c_handler;

    /**
     * CalgamoExceptionHandlerAdapter constructor.
     *
     * @param CalgamoExceptionHandler $c_handler
     */
    public function __construct(CalgamoExceptionHandler $c_handler)
    {
        $this->c_handler = $c_handler;
    }

    /**
     * Handle exception
     *
     * @param Throwable $e
     */
    public function handleException(Throwable $e)
    {
        $this->c_handler->handleException($e);
    }
}