<?php

namespace Constellation\Controller;

use Constellation\Http\Request;
use Constellation\Model\User;

/**
 * @class Controller
 */
class Controller
{
    public function __construct(
        private Request $request,
        private User $user
    ) {
    }
}
