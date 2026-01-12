<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Auth\Access\AuthorizationException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->renderable(function (AuthorizationException $e, $request) {
            // Redirect back with an error message on authorization failures
            if ($request->expectsJson()) {
                return response()->json(['message' => $e->getMessage() ?: 'This action is unauthorized.'], 403);
            }

            // Redirect to modules index with an error to ensure we have a valid redirect target
            return redirect()->route('modules.index')->with('error', 'You are not authorized to perform that action.');
        });
    }
}
