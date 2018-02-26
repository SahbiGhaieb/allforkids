<?php

namespace Allforkids\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class AllforkidsUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
