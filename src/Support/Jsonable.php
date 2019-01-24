<?php

namespace Murilo\Pagamento\Support;

/**
 * Interface Jsonable
 * @package Murilo\Pagamento\Support
 */
interface Jsonable
{
    /**
     * Convert the object to its JSON representation.
     *
     * @param  int $options
     * @return string
     */
    public function toJson($options = 0);
}
