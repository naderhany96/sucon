<?php

namespace App\Traits;

trait ApiResponser {

    protected function successResponse($message = null, $code = 200, $data = null)
	{
		$response['status'] = 'success';
		$response['message'] = $message;
		if ($data) $response['data'] = $data;

		return response()->json($response, $code);
	}

	protected function errorResponse($message = null, $code)
	{
		return response()->json([
			'status' => 'error',
			'message' => $message
		], $code);
	}
}