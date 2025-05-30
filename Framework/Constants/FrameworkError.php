<?php

namespace Framework\Constants;

class FrameworkError
{
    // 100 series: Middleware & Routing Errors
    public const APPLY_MIDDLEWARE_ERROR = 101;
    public const ROUTE_NOT_FOUND = 102;
    public const CONTROLLER_NOT_FOUND = 103;
    public const METHOD_NOT_FOUND = 104;
    public const INVALID_ROUTE_DEFINITION = 105;
    public const INVALID_MIDDLEWARE = 106;

    // 200 series: Request & Response Errors
    public const INVALID_REQUEST = 201;
    public const RESPONSE_ERROR = 202;

    // 300 series: Configuration & Environment Errors
    public const CONFIGURATION_ERROR = 301;
    public const ENVIRONMENT_VARIABLE_ERROR = 302;

    // 400 series: Database & Cache Errors
    public const DATABASE_CONNECTION_ERROR = 401;
    public const CACHE_ERROR = 402;

    // 500 series: View & File Errors
    public const VIEW_RENDER_ERROR = 501;
    public const FILE_NOT_FOUND = 502;

    // 600 series: Session, Auth & Security Errors
    public const SESSION_ERROR = 601;
    public const AUTHENTICATION_ERROR = 602;
    public const AUTHORIZATION_ERROR = 603;

    // 700 series: Parameter & Dependency Errors
    public const INVALID_PARAMETER = 701;
    public const DEPENDENCY_RESOLUTION_ERROR = 702;
    public const SERVICE_NOT_FOUND = 703;


    public static function getMessageForCode(int $code): string
    {
        // Definimos un mapa de códigos a mensajes
        $errorMessages = [
            self::APPLY_MIDDLEWARE_ERROR,
            self::ROUTE_NOT_FOUND,
            self::CONTROLLER_NOT_FOUND,
            self::METHOD_NOT_FOUND,
            self::INVALID_ROUTE_DEFINITION,
            self::INVALID_MIDDLEWARE,
            // 200 series: Request & Response Errors
            self::INVALID_REQUEST,
            self::RESPONSE_ERROR,
            // 300 series: Configuration & Environment Errors
            self::CONFIGURATION_ERROR,
            self::ENVIRONMENT_VARIABLE_ERROR,
            // 400 series: Database & Cache Errors
            self::DATABASE_CONNECTION_ERROR,
            self::CACHE_ERROR,
            // 500 series: View & File Errors
            self::VIEW_RENDER_ERROR,
            self::FILE_NOT_FOUND,
            // 600 series: Session, Auth & Security Errors
            self::SESSION_ERROR,
            self::AUTHENTICATION_ERROR,
            self::AUTHORIZATION_ERROR,
            // 700 series: Parameter & Dependency Errors
            self::INVALID_PARAMETER,
            self::DEPENDENCY_RESOLUTION_ERROR,
            self::SERVICE_NOT_FOUND,
        ];

        // Si el código no está en el mapa, devolvemos un mensaje genérico
        return $errorMessages[$code] ?? 'Unknown error';
    }
}
