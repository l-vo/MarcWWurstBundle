<?php

namespace MarcW\Bundle\WurstBundle;

use Symfony\Component\Console\Application;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class MarcWWurstBundle extends Bundle
{
    public function getContainerExtension()
    {
        if (!class_exists('Symfony\Component\DependencyInjection\Extension\Extension')) {
            $this->extension = false;
        }

        return parent::getContainerExtension();
    }
}
