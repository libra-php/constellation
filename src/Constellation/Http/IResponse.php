<?php

namespace Constellation\Http;

/**
 * @interface IResponse
 */
interface IResponse
{
    public function prepare(): void;
    public function execute(): void;
}
