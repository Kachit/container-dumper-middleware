<?php
/**
 * Class ContainerDumperMiddleware
 *
 * @package Kachit\Container\Dumper
 * @author Kachit
 */
namespace Kachit\Container\Dumper;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use JBZoo\PimpleDumper\PimpleDumper;
use Pimple\Container;

class DumperMiddleware
{
    /**
     * @var Container
     */
    private $container;

    /**
     * DumperMiddleware constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * Call the middleware
     *
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @param callable $next
     * @return ResponseInterface
     */
    public function __invoke(RequestInterface $request, ResponseInterface $response, callable $next)
    {
        if ($this->container['debug']) {
            $dumper = new PimpleDumper();
            $dumper->dumpPimple($this->container);
        }
        return $next($request, $response);
    }
}