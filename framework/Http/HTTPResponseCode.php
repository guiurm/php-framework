<?php

namespace Framework\Http;

class HTTPResponseCode
{
    /** 
     * @var int Indicates the initial part of a request has been received and has not yet been rejected by the server.
     */
    public const CONTINUE = 100;

    /** 
     * @var int Indicates the server is switching protocols as requested by the client.
     */
    public const SWITCHING_PROTOCOLS = 101;

    /** 
     * @var int Indicates that the server is processing a WebDAV request.
     */
    public const PROCESSING_WEBDAV = 102;

    /** 
     * @var int Used to return hints before the final response.
     */
    public const EARLY_HINTS = 103;

    /** 
     * @var int Indicates that the request has succeeded.
     */
    public const OK = 200;

    /** 
     * @var int Indicates that a resource has been successfully created.
     */
    public const CREATED = 201;

    /** 
     * @var int Indicates that the request has been accepted for processing, but the processing is not complete.
     */
    public const ACCEPTED = 202;

    /** 
     * @var int Indicates that the request was successful, but the returned meta-information is not from the origin server.
     */
    public const NON_AUTHORITATIVE_INFORMATION = 203;

    /** 
     * @var int Indicates that the server successfully processed the request and is not returning any content.
     */
    public const NO_CONTENT = 204;

    /** 
     * @var int Indicates that the server successfully processed the request and the client should reset the document view.
     */
    public const RESET_CONTENT = 205;

    /** 
     * @var int Indicates that the server is delivering only part of the resource, as requested by the client.
     */
    public const PARTIAL_CONTENT = 206;

    /** 
     * @var int Used in WebDAV to provide information about multiple resources.
     */
    public const MULTI_STATUS_WEBDAV = 207;

    /** 
     * @var int Used in WebDAV to indicate that the members of a DAV binding have already been enumerated.
     */
    public const ALREADY_REPORTED_WEBDAV = 208;

    /** 
     * @var int Indicates that the server has fulfilled a request for the resource and that the response is a representation of the result of one or more instance-manipulations applied to the current instance.
     */
    public const IM_USED = 226;

    /** 
     * @var int Indicates that there are multiple options for the resource from which the client may choose.
     */
    public const MULTIPLE_CHOICES = 300;

    /** 
     * @var int Indicates that the resource has been permanently moved to a new URL.
     */
    public const MOVED_PERMANENTLY = 301;

    /** 
     * @var int Indicates that the resource has been temporarily moved to a different URL.
     */
    public const FOUND = 302;

    /** 
     * @var int Indicates that the response to the request can be found at another URI using a GET method.
     */
    public const SEE_OTHER = 303;

    /** 
     * @var int Indicates that the resource has not been modified since the last request.
     */
    public const NOT_MODIFIED = 304;

    /** 
     * @var int Indicates that the requested resource must be accessed through the specified proxy.
     */
    public const USE_PROXY_DEPRECATED = 305;

    /** 
     * @var int Reserved for future use.
     */
    public const UNUSED = 306;

    /** 
     * @var int Indicates that the resource is temporarily located at a different URI.
     */
    public const TEMPORARY_REDIRECT = 307;

    /** 
     * @var int Indicates that the resource has been permanently moved to a new URI.
     */
    public const PERMANENT_REDIRECT = 308;

    /** 
     * @var int Indicates that the server cannot or will not process the request due to a client error.
     */
    public const BAD_REQUEST = 400;

    /** 
     * @var int Indicates that the request requires user authentication.
     */
    public const UNAUTHORIZED = 401;

    /** 
     * @var int Indicates that payment is required to access the resource.
     */
    public const PAYMENT_REQUIRED_EXPERIMENTAL = 402;

    /** 
     * @var int Indicates that the server understands the request but refuses to authorize it.
     */
    public const FORBIDDEN = 403;

    /** 
     * @var int Indicates that the server can't find the requested resource.
     */
    public const NOT_FOUND = 404;

    /** 
     * @var int Indicates that the request method is known by the server but is not supported by the resource.
     */
    public const METHOD_NOT_ALLOWED = 405;

    /** 
     * @var int Indicates that the resource is only capable of generating content not acceptable according to the Accept headers sent in the request.
     */
    public const NOT_ACCEPTABLE = 406;

    /** 
     * @var int Indicates that the client must first authenticate itself with the proxy.
     */
    public const PROXY_AUTHENTICATION_REQUIRED = 407;

    /** 
     * @var int Indicates that the server timed out waiting for the request.
     */
    public const REQUEST_TIMEOUT = 408;

    /** 
     * @var int Indicates that the request could not be processed due to a conflict with the current state of the resource.
     */
    public const CONFLICT = 409;

    /** 
     * @var int Indicates that the resource is no longer available and will not be available again.
     */
    public const GONE = 410;

    /** 
     * @var int Indicates that the server refuses to accept the request without a defined Content-Length.
     */
    public const LENGTH_REQUIRED = 411;

    /** 
     * @var int Indicates that one or more conditions in the request header fields evaluated to false.
     */
    public const PRECONDITION_FAILED = 412;

    /** 
     * @var int Indicates that the request is larger than the server is willing or able to process.
     */
    public const PAYLOAD_TOO_LARGE = 413;

    /** 
     * @var int Indicates that the URI provided was too long for the server to process.
     */
    public const URI_TOO_LONG = 414;

    /** 
     * @var int Indicates that the request entity has a media type which the server or resource does not support.
     */
    public const UNSUPPORTED_MEDIA_TYPE = 415;

    /** 
     * @var int Indicates that the range specified by the Range header field in the request cannot be fulfilled.
     */
    public const RANGE_NOT_SATISFIABLE = 416;

    /** 
     * @var int Indicates that the expectation given in the Expect request header field could not be met by the server.
     */
    public const EXPECTATION_FAILED = 417;

    /** 
     * @var int Indicates that the server refuses to brew coffee because it is a teapot (an April Fools' joke).
     */
    public const IM_A_TEAPOT = 418;

    /** 
     * @var int Indicates that the request was directed at a server that is not able to produce a response.
     */
    public const MISDIRECTED_REQUEST = 421;

    /** 
     * @var int Indicates that the server understands the content type of the request entity, and the syntax is correct, but it was unable to process the contained instructions.
     */
    public const UNPROCESSABLE_CONTENT_WEBDAV = 422;

    /** 
     * @var int Indicates that the resource that is being accessed is locked.
     */
    public const LOCKED_WEBDAV = 423;

    /** 
     * @var int Indicates that the request failed due to failure of a previous request.
     */
    public const FAILED_DEPENDENCY_WEBDAV = 424;

    /** 
     * @var int Indicates that the server is unwilling to risk processing a request that might be replayed.
     */
    public const TOO_EARLY_EXPERIMENTAL = 425;

    /** 
     * @var int Indicates that the client should switch to a different protocol.
     */
    public const UPGRADE_REQUIRED = 426;

    /** 
     * @var int Indicates that the origin server requires the request to be conditional.
     */
    public const PRECONDITION_REQUIRED = 428;

    /** 
     * @var int Indicates that the user has sent too many requests in a given amount of time.
     */
    public const TOO_MANY_REQUESTS = 429;

    /** 
     * @var int Indicates that the server is unwilling to process the request because its header fields are too large.
     */
    public const REQUEST_HEADER_FIELDS_TOO_LARGE = 431;

    /** 
     * @var int Indicates that the resource is unavailable for legal reasons.
     */
    public const UNAVAILABLE_FOR_LEGAL_REASONS = 451;

    /** 
     * @var int Indicates that the server encountered an unexpected condition that prevented it from fulfilling the request.
     */
    public const INTERNAL_SERVER_ERROR = 500;

    /** 
     * @var int Indicates that the server does not support the functionality required to fulfill the request.
     */
    public const NOT_IMPLEMENTED = 501;

    /** 
     * @var int Indicates that the server, while acting as a gateway or proxy, received an invalid response from the upstream server.
     */
    public const BAD_GATEWAY = 502;

    /** 
     * @var int Indicates that the server is currently unable to handle the request due to temporary overloading or maintenance of the server.
     */
    public const SERVICE_UNAVAILABLE = 503;

    /** 
     * @var int Indicates that the server, while acting as a gateway or proxy, did not receive a timely response from the upstream server.
     */
    public const GATEWAY_TIMEOUT = 504;

    /** 
     * @var int Indicates that the server does not support the HTTP protocol version that was used in the request.
     */
    public const HTTP_VERSION_NOT_SUPPORTED = 505;

    /** 
     * @var int Indicates that the server has an internal configuration error.
     */
    public const VARIANT_ALSO_NEGOTIATES = 506;

    /** 
     * @var int Indicates that the server is unable to store the representation needed to complete the request.
     */
    public const INSUFFICIENT_STORAGE_WEBDAV = 507;

    /** 
     * @var int Indicates that the server detected an infinite loop while processing a request.
     */
    public const LOOP_DETECTED_WEBDAV = 508;

    /** 
     * @var int Indicates that further extensions to the request are required for the server to fulfill it.
     */
    public const NOT_EXTENDED = 510;

    /** 
     * @var int Indicates that the client needs to authenticate to gain network access.
     */
    public const NETWORK_AUTHENTICATION_REQUIRED = 511;

    public const CDN_UPLOAD_FAILED = 600;

    public const MESSAGE_HTTP = [
        100 => "Continue",
        101 => "Switching Protocol",
        102 => "Processing",
        103 => "Early Hints",
        200 => "Ok",
        201 => "Created",
        202 => "Accepted",
        203 => "Non Authoritative Information",
        204 => "No Content",
        205 => "Reset Content",
        206 => "Partial Content",
        207 => "Multi Status",
        226 => "Im Used",
        300 => "Multiple Choice",
        301 => "Moved Permanently",
        302 => "Found",
        303 => "See Others",
        304 => "Not Modified",
        305 => "Use Proxy",
        306 => "Unused",
        307 => "Temporary Redirect",
        308 => "Permanent Redirect",
        400 => "Bad Request",
        401 => "Unauthorized",
        402 => "Payment Required",
        403 => "Forbidden",
        404 => "Not Found",
        405 => "Method Not Allowed",
        406 => "Not Acceptable",
        407 => "Proxy Authentication Required",
        408 => "Request Timeout",
        409 => "Conflict",
        410 => "Gone",
        411 => "Length Required",
        412 => "Precondition Failed",
        413 => "Payload Too Large",
        414 => "Uri Too Long",
        415 => "Unsupported Media Type",
        416 => "Request Range Not Satisfiable",
        417 => "Expectation Failed",
        418 => "Im A Teapot",
        421 => "Misdirected Request",
        422 => "Unprocessable Entity",
        423 => "Locked",
        424 => "Failed Dependency",
        426 => "Upgrade Required",
        428 => "Precondition Required",
        429 => "Too Many Request",
        431 => "Request Headers Fields Too Large",
        451 => "Unavailable For Legal Reasons",
        500 => "Internal Server Error",
        501 => "Not Implemented",
        502 => "Bad Gateway",
        503 => "Service Unavailable",
        504 => "Gateway Timeout",
        505 => "Http Version Not Supported",
        506 => "Variant Also Negotiates",
        507 => "Insufficient Storage",
        508 => "Loop Detected",
        510 => "Not Extended",
        511 => "Network Authentication Required",
        600 => "File Upload Failed"
    ];
}
