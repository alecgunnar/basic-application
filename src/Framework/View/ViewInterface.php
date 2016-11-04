<?php

namespace Framework\View;

interface ViewInterface
{
    /**
     * Returns a string which represents the
     * rendered view
     *
     * @return string
     */
    public function render(): string;
}
