<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace VendorPatches202401\Symfony\Component\Console\Helper;

use VendorPatches202401\Symfony\Component\Console\Input\InputAwareInterface;
use VendorPatches202401\Symfony\Component\Console\Input\InputInterface;
/**
 * An implementation of InputAwareInterface for Helpers.
 *
 * @author Wouter J <waldio.webdesign@gmail.com>
 */
abstract class InputAwareHelper extends Helper implements InputAwareInterface
{
    /**
     * @var \Symfony\Component\Console\Input\InputInterface
     */
    protected $input;
    public function setInput(InputInterface $input) : void
    {
        $this->input = $input;
    }
}
