<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Sylius\Bundle\ThemeBundle\Translation\Resource;

interface TranslationResourceInterface
{
    public function getName(): string;

    public function getLocale(): string;

    public function getFormat(): string;

    public function getDomain(): string;
}
