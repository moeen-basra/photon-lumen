<?php

namespace Photon\Foundation\Exceptions;

use Throwable;
use Photon\Domains\Http\Jobs\JsonErrorResponseJob;
use Photon\Foundation\Traits\JobDispatcherTrait;
use Photon\Foundation\Traits\MarshalTrait;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    use MarshalTrait;
    use JobDispatcherTrait;

    public function render($request, Throwable $e)
    {
        $message = $e->getMessage();
        $class = get_class($e);
        $code = $e->getCode();

        if ($request->expectsJson()) {
            return $this->run(JsonErrorResponseJob::class, [
                'message' => $message,
                'code' => $class,
                'status' => ($code < 100 || $code >= 600) ? 400 : $code,
            ]);
        }

        parent::render($request, $e);
    }
}
