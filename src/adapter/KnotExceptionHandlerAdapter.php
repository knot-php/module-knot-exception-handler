<?php
declare(strict_types=1);

namespace knotphp\module\knotexceptionhandler\adapter;

use Throwable;

use knotlib\kernel\exceptionhandler\ExceptionHandlerInterface;
use knotlib\exceptionhandler\ExceptionHandlerInterface as CalgamoExceptionHandler;

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