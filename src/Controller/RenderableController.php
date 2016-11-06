<?php

namespace Maverick\Controller;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Maverick\View\ViewInterface;

class RenderableController
{
    /**
     * @var ViewInterface
     */
    protected $view;

    /** 
     * @param ViewInterface $view
     */
    public function __construct(ViewInterface $view)
    {
        $this->view = $view;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $response->getBody()
            ->write($this->view->render());

        return $response;
    }
}
