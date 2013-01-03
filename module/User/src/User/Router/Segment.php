<?php

namespace User\Router;

use Zend\Mvc\Router\Http\Segment as BaseSegment,
    Zend\Stdlib\RequestInterface as Request;

/**
 *
 *
 * @author Benjamin Lazarecki <benjamin@widop.com>
 */
class Segment extends BaseSegment
{
    /**
     * {@inheritdoc}
     */
    public function match(Request $request, $pathOffset = null)
    {
        if (!$request->isXmlHttpRequest()) {
            return null;
        }

        return parent::match($request, $pathOffset);
    }
}
