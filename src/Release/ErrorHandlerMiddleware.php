<?php

namespace Release;

use ErrorException;
use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Throwable;
use Zend\Diactoros\Response\JsonResponse;

class ErrorHandlerMiddleware implements MiddlewareInterface
{
    private $enabled;

    public function __construct(bool $enabled = false)
    {
        $this->enabled = $enabled;
    }

    /**
     * @return JsonResponse
     */
    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        if (! $this->enabled) {
            return $delegate->process($request);
        }

        set_error_handler([$this, 'handleError']);

        try {
            return $delegate->process($request);
        } catch (Throwable $e) {
        } finally {
            restore_error_handler();
        }

        $payload = [
            'type'           => 'https://httpstatus.es/500',
            'title'          => 'Internal Server Error',
            'detail'         => $e->getMessage(),
            'exception_type' => get_class($e),
            'trace'          => $e->getTraceAsString(),
        ];

        $previous = [];
        while ($e = $e->getPrevious()) {
            $previous[] = [
                'type'           => 'https://httpstatus.es/500',
                'title'          => 'Internal Server Error',
                'detail'         => $e->getMessage(),
                'exception_type' => get_class($e),
                'trace'          => $e->getTraceAsString(),
            ];
        }

        if (0 < count($previous)) {
            $payload['previous'] = $previous;
        }

        return new JsonResponse($payload, 500, ['Content-Type' => 'application/problem+json']);
    }

    /**
     * @param int $severity
     * @param string $message
     * @param string $file
     * @param int $line
     * @throws ErrorException
     */
    public function handleError($severity, $message, $file, $line)
    {
        throw new ErrorException($message, 0, $severity, $file, $line);
    }
}
