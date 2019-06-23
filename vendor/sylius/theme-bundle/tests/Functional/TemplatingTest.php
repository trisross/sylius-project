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

namespace Sylius\Bundle\ThemeBundle\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class TemplatingTest extends WebTestCase
{
    /**
     * @test
     * @dataProvider getBundleTemplates
     */
    public function it_renders_bundle_templates(string $templateName, string $contents): void
    {
        $client = self::createClient();

        $crawler = $client->request('GET', '/template/' . $templateName);
        $this->assertEquals($contents, trim($crawler->text()));
    }

    public function getBundleTemplates(): array
    {
        return [
            ['TestBundle:Templating:vanillaTemplate.txt.twig', 'TestBundle:Templating:vanillaTemplate.txt.twig'],
            ['TestBundle:Templating:vanillaOverriddenTemplate.txt.twig', 'TestBundle:Templating:vanillaOverriddenTemplate.txt.twig (app overridden)'],
            ['TestBundle:Templating:vanillaOverriddenThemeTemplate.txt.twig', 'TestBundle:Templating:vanillaOverriddenThemeTemplate.txt.twig|sylius/first-test-theme'],
            ['TestBundle:Templating:bothThemesTemplate.txt.twig', 'TestBundle:Templating:bothThemesTemplate.txt.twig|sylius/first-test-theme'],
            ['TestBundle:Templating:lastThemeTemplate.txt.twig', 'TestBundle:Templating:lastThemeTemplate.txt.twig|sylius/second-test-theme'],
        ];
    }

    /**
     * @test
     * @dataProvider getBundleTemplatesUsingNamespacedPaths
     */
    public function it_renders_bundle_templates_using_namespaced_paths(string $templateName, string $contents): void
    {
        $client = self::createClient();

        $crawler = $client->request('GET', '/template/' . $templateName);
        $this->assertEquals($contents, trim($crawler->text()));
    }

    public function getBundleTemplatesUsingNamespacedPaths(): array
    {
        return [
            ['@Test/Templating/vanillaTemplate.txt.twig', 'TestBundle:Templating:vanillaTemplate.txt.twig'],
            ['@Test/Templating/vanillaOverriddenTemplate.txt.twig', 'TestBundle:Templating:vanillaOverriddenTemplate.txt.twig (app overridden)'],
            ['@Test/Templating/vanillaOverriddenThemeTemplate.txt.twig', 'TestBundle:Templating:vanillaOverriddenThemeTemplate.txt.twig|sylius/first-test-theme'],
            ['@Test/Templating/bothThemesTemplate.txt.twig', 'TestBundle:Templating:bothThemesTemplate.txt.twig|sylius/first-test-theme'],
            ['@Test/Templating/lastThemeTemplate.txt.twig', 'TestBundle:Templating:lastThemeTemplate.txt.twig|sylius/second-test-theme'],
            ['@Test/Templating/twigNamespacedVanillaTemplate.txt.twig', '@Test/Templating/twigNamespacedVanillaTemplate.txt.twig'],
            ['@Test/Templating/twigNamespacedVanillaOverriddenTemplate.txt.twig', '@Test/Templating/twigNamespacedVanillaOverriddenTemplate.txt.twig (templates overridden)'],
            ['@Test/Templating/twigNamespacedVanillaOverriddenThemeTemplate.txt.twig', '@Test/Templating/twigNamespacedVanillaOverriddenThemeTemplate.txt.twig|sylius/first-test-theme'],
            ['@Test/Templating/twigNamespacedBothThemesTemplate.txt.twig', '@Test/Templating/twigNamespacedBothThemesTemplate.txt.twig|sylius/first-test-theme'],
            ['@Test/Templating/twigNamespacedLastThemeTemplate.txt.twig', '@Test/Templating/twigNamespacedLastThemeTemplate.txt.twig|sylius/second-test-theme'],
        ];
    }

    /**
     * @test
     * @dataProvider getPluginTemplatesUsingNamespacedPaths
     */
    public function it_renders_sylius_plugin_templates_using_namespaced_paths(string $templateName, string $contents): void
    {
        $client = self::createClient();

        $crawler = $client->request('GET', '/template/' . $templateName);
        $this->assertEquals($contents, trim($crawler->text()));
    }

    public function getPluginTemplatesUsingNamespacedPaths(): array
    {
        return [
            ['@TestPlugin/Templating/twigNamespacedVanillaOverriddenThemeTemplate.txt.twig', '@TestPlugin/Templating/twigNamespacedVanillaOverriddenThemeTemplate.txt.twig|sylius/first-test-theme'],
            ['@TestPlugin/Templating/twigNamespacedBothThemesTemplate.txt.twig', '@TestPlugin/Templating/twigNamespacedBothThemesTemplate.txt.twig|sylius/first-test-theme'],
        ];
    }

    /**
     * @test
     * @dataProvider getAppTemplates
     */
    public function it_renders_application_templates(string $templateName, string $contents): void
    {
        $client = self::createClient();

        $crawler = $client->request('GET', '/template/' . $templateName);
        $this->assertEquals($contents, trim($crawler->text()));
    }

    public function getAppTemplates(): array
    {
        return [
            [':Templating:vanillaTemplate.txt.twig', ':Templating:vanillaTemplate.txt.twig'],
            [':Templating:bothThemesTemplate.txt.twig', ':Templating:bothThemesTemplate.txt.twig|sylius/first-test-theme'],
            [':Templating:lastThemeTemplate.txt.twig', ':Templating:lastThemeTemplate.txt.twig|sylius/second-test-theme'],
        ];
    }

    /**
     * @test
     * @dataProvider getAppTemplatesUsingNamespacedPaths
     */
    public function it_renders_application_templates_using_namespaced_paths(string $templateName, string $contents): void
    {
        $client = self::createClient();

        $crawler = $client->request('GET', '/template/' . $templateName);
        $this->assertEquals($contents, trim($crawler->text()));
    }

    public function getAppTemplatesUsingNamespacedPaths(): array
    {
        return [
            ['Templating/vanillaTemplate.txt.twig', ':Templating:vanillaTemplate.txt.twig'],
            ['Templating/bothThemesTemplate.txt.twig', ':Templating:bothThemesTemplate.txt.twig|sylius/first-test-theme'],
            ['Templating/lastThemeTemplate.txt.twig', ':Templating:lastThemeTemplate.txt.twig|sylius/second-test-theme'],
            ['Templating/twigNamespacedVanillaTemplate.txt.twig', 'Templating/twigNamespacedVanillaTemplate.txt.twig'],
            ['Templating/twigNamespacedBothThemesTemplate.txt.twig', 'Templating/twigNamespacedBothThemesTemplate.txt.twig|sylius/first-test-theme'],
            ['Templating/twigNamespacedLastThemeTemplate.txt.twig', 'Templating/twigNamespacedLastThemeTemplate.txt.twig|sylius/second-test-theme'],
        ];
    }
}
