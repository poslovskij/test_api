<?php
namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Throwable;

class Handler extends ExceptionHandler
{
	/**
	 * Render an exception into an HTTP response.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Throwable  $exception
	 * @return \Illuminate\Http\Response
	 */
	public function render($request, Throwable $exception)
	{
		// Примусово повертаємо JSON для ModelNotFoundException
		if ($exception instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
			return response()->json([
				'error' => 'Resource not found',
				'message' => $exception->getMessage(),
			], 404);
		}

		// Інші виключення
		return parent::render($request, $exception);
	}
}
