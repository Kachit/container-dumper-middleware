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
     * @var bool
     */
    private $dump_mode_phpstorm = false;

    /**
     * DumperMiddleware constructor
     *
     * @param Container $container
     * @param bool $dump_mode_phpstorm
     */
    public function __construct(Container $container, bool $dump_mode_phpstorm = true)
    {
        $this->container = $container;
        $this->dump_mode_phpstorm = $dump_mode_phpstorm;
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
            if ($this->dump_mode_phpstorm) {
                $dumper->dumpPhpstorm($this->container);
            } else {
                $dumper->dumpPimple($this->container);
            }
        }
        return $next($request, $response);
    }
}
