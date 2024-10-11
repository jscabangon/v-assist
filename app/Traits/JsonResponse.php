<?php

namespace App\Traits;

trait JsonResponse
{
    private $message = '';
    private $data = [];
    private $headers = [];
    private $error_code = '';

    /**
     * To initiate trait
     * 
     * @return this object
     */
    public function jsonRes()
    {
        return $this;
    }

    /**
     * Put message on the json response
     * 
     * @param string $message
     * @return this object
     */
    public function message(String $message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Put data on the json response
     * 
     * @param Any $data
     * @return this object
     */
    public function data($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Put error code on the json response
     * 
     * @param Array<mixed> $data
     * @return this object
     */
    public function errorcode(String $code)
    {
        $this->error_code = $code;

        return $this;
    }

    /**
     * Put headers on the json response
     * 
     * @param Array<mixed> $data
     * @return this object
     */
    public function header(Array $headers)
    {
        $this->headers = $headers;

        return $this;
    }

    /**
     * Return a success json response
     * 
     * @return json
     */
    public function success()
    {
        $response = response()->json([
            "status" => 1,
            "message" => ($this->message == '') ? 'Request Success.' : $this->message,
            "data" => $this->data
        ], 200);

        if (!empty($this->headers)) {
            foreach ($this->headers as $header) {
                $hData = explode(',', $header);

                $response->header($hData[0], $hData[1]);
            }
        }

        return $response;
    }

    /**
     * Return an error json response
     * 
     * @return json
     */
    public function error()
    {
        $response = response()->json([
            "status" => 0,
            "message" => ($this->message == '') ? 'Request Failed.' : $this->message,
            "data" => $this->data
        ], 422);

        if (!empty($this->headers)) {
            foreach ($this->headers as $header) {
                $response->header($header);
            }
        }

        return $response;
    }

    /**
     * Return an authorized json response
     * 
     * @return json
     */
    public function unauthorized()
    {
        return response()->json([
            "status" => 0,
            "message" => 'You don\'t have an access on this resource.',
            "data" => $this->data
        ], 403);
    }

    /**
     * Return an unauthenticated json response
     * 
     * @return json
     */
    public function unauthenticated()
    {
        return response()->json([
            "status" => 0,
            "message" => 'Session Expired. Please Login.',
            "data" => $this->data
        ], 401);
    }

    /**
     * Return an error json response
     * 
     * @return json
     */
    public function request_error()
    {
        $errorCode = ($this->error_code == '') ? 'Unknown' : $this->error_code;

        $response = response()->json([
            "status" => 0,
            "message" => "Failed to process request.",
            "data" => $this->data
        ], 406);

        return $response;
    }

    /**
     * Return an error json response
     * 
     * @return json
     */
    public function server_error()
    {
        $errorCode = ($this->error_code == '') ? 'Unknown' : $this->error_code;

        $response = response()->json([
            "status" => 0,
            "message" => "Server Error ($errorCode): Failed to process request. Please contact the administrator.",
            "data" => $this->data
        ], 500);

        return $response;
    }
}