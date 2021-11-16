<?php

namespace Hillus\SinTicketingClient\Rest;

use Psr\Http\Message\ResponseInterface as ResponseInterfaceGuzzle;

/**
 * Representation of an outgoing, server-side response.
 *
 * Per the HTTP specification, this interface includes properties for
 * each of the following:
 *
 * - Protocol version
 * - Status code and reason phrase
 * - Headers
 * - Message body
 *
 * Responses are considered immutable; all methods that might change state MUST
 * be implemented such that they retain the internal state of the current
 * message and return an instance that contains the changed state.
 */
interface ResponseInterface
{

    public function __construct(ResponseInterfaceGuzzle $response);
    /**
     * Gets the response status code.
     *
     * The status code is a 3-digit integer result code of the server's attempt
     * to understand and satisfy the request.
     *
     * @return int Status code.
     */
    public function status() : int;

    public function body() : string;

    public function json();

    public function header($header) : string;

    public function headers() : array;

    public function error() : string;
}