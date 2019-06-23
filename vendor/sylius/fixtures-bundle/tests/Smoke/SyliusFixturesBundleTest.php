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

namespace Sylius\Bundle\FixturesBundle\Tests\Smoke;

use PHPUnit\Framework\Assert;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ContainerInterface;

final class SyliusFixturesBundleTest extends KernelTestCase
{
    /**
     * @test
     */
    public function its_services_are_initializable(): void
    {
        /** @var ContainerBuilder $container */
        $container = self::bootKernel()->getContainer();

        $services = $container->getServiceIds();

        $services = array_filter($services, function (string $serviceId): bool {
            return 0 === strpos($serviceId, 'sylius_fixtures.') || 0 === strpos($serviceId, 'Sylius\\Bundle\\FixturesBundle\\');
        });

        foreach ($services as $id) {
            Assert::assertNotNull($container->get($id, ContainerInterface::NULL_ON_INVALID_REFERENCE));
        }
    }
}
