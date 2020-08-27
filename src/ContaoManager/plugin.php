<?php
/*
 * This file is part of Wolf20.
 *
 * (c) Markus Schenker 2020
 *
 * @license LGPL-3.0-or-later
 */
namespace Pnwscm60\Wolf20Bundle\ContaoManager;
use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
class Plugin implements BundlePluginInterface
{
    public function getBundles(ParserInterface $parser)
    {
        return [
            BundleConfig::create('Pnwscm60\Wolf20Bundle\Pnwscm60Wolf20Bundle')
                ->setLoadAfter(['Contao\CoreBundle\ContaoCoreBundle'])
                ->setReplace(['wolf20']),
        ];
    }
}
