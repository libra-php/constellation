<?php

namespace Constellation\Http;

interface IResponse
{
    public function prepare();
    public function execute();
}
