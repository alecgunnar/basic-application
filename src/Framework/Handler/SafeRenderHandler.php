<?php

namespace Framework\Handler;

use Whoops\Handler\Handler;
use Framework\View\ViewInterface;

class SafeRenderHandler extends Handler
{
    /**
     * @var ViewInterface[]
     */
    protected $views = [];

    /**
     * @var ViewInterface
     */
    protected $defaultView;

    /**
     * @param ViewInterface $default
     */
    public function __construct(ViewInterface $default)
    {
        $this->defaultView = $default;
    }

    public function handle()
    {
        $code = $this->getRun()->sendHttpCode();
        $view = $this->views[$code] ?? $this->defaultView;

        echo $view->render();
    }

    public function addView(string $code, ViewInterface $view)
    {
        $this->views[$code] = $view;
    }
}
