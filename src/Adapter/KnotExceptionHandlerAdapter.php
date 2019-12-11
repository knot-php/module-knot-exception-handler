<?php
namespace KnotModule\KnotExceptionHandler\Adapter;

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
     *
     * @return bool
     */
    public function handleException(Throwable $e) : bool
    {
        return $this->c_handler->handleException($e);
    }

}