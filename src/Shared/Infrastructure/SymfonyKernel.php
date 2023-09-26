<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\HttpKernel\Kernel;

class SymfonyKernel extends Kernel
{
    use MicroKernelTrait;
}
