<?php

namespace App\Exceptions;

use Auth;
use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        if ($this->shouldReport($exception) && app()->bound('sentry')) {
            app('sentry')->captureException($exception);
        }

        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        $message = $exception->getMessage();
        $file = $exception->getFile();
        $code = $exception->getCode();
        $user = Auth::check() ? Auth::user()->name : null;
        $url = $request->fullUrl();
        $token = env("SLACK_TOKEN");
        $stack_trace = $exception->getTraceAsString();
        $type = get_class($exception);

        $exclude = [
            'Symfony\Component\HttpKernel\Exception\NotFoundHttpException',
            'Symfony\Component\HttpKernel\Exception\HttpException'

        ];

        if(!in_array($type, $exclude) && $message != 'CSRF token mismatch.') {
            $c = curl_init();

            curl_setopt($c, CURLOPT_URL, "https://hooks.slack.com/services/T6VJX9GAX/BSY1E5WF9/$token");
            curl_setopt($c, CURLOPT_POST, 1);
            curl_setopt($c, CURLOPT_POSTFIELDS, json_encode([
                'text' => "Code: $code\nIn File: $file\nOn Page: $url\nUser: $user\n\nMessage: $message\nStack trace:\n$stack_trace"
            ]));
            curl_setopt($c, CURLOPT_HEADER, [
                "Content-type" => "application/json"
            ]);

            curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);

            curl_exec($c);
        }

        return parent::render($request, $exception);
    }
}
