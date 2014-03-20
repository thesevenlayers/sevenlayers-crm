<?php

namespace Seven\FEBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class SevenFEBundle extends Bundle
{
    function getParent()
    {
        return "FOSUserBundle";
    }
}
