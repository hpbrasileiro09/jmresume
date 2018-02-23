<?php

namespace App\Exceptions;

use Barryvdh\Cors\Stack\CorsService;
use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use League\OAuth2\Server\Exception\OAuthException;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    /**
     * @var CorsService
     */
    private $corsService;

    public function __construct(LoggerInterface $log, CorsService $corsService)
    {
        parent::__construct($log);
        $this->corsService = $corsService;
    }

    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {

        if ($e instanceof ModelNotFoundException) {
            $e = new NotFoundHttpException($e->getMessage(), $e);
        // Se for instância do OAuthException, gera uma resposta baseada no oatuh2
        } elseif($e instanceof OAuthException) {

            // Resposta baseada na resposta que a gente precisa em JS
            $response = response()->json([
                // Tipo do erro
                'error' => $e->errorType,
                // Pegando o erro mesmo
                'error_description' => $e->getMessage()
            ],$e->httpStatusCode,$e->getHttpHeaders());

            // Pega o response e a requisição que eu fiz e coloca os cabeçalhos do cors
            // addActualRequestHeaders verifica quais cabeçalhos precisa incluir e inclue no nosso caso o Access-Control-Allow-Origin
            // que estava em conflito
            return $this->corsService->addActualRequestHeaders($response,$request);
        }

        return parent::render($request, $e);
    }
}
