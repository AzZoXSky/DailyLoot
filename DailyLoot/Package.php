<?php

namespace CMW\Package\DailyLoot;

use CMW\Manager\Package\IPackageConfig;
use CMW\Manager\Package\PackageMenuType;
use CMW\Manager\Package\PackageSubMenuType;

class Package implements IPackageConfig
{
    public function name(): string
    {
        return 'DailyLoot';
    }

    public function version(): string
    {
        return '1.0.0';
    }

    public function authors(): array
    {
        return ['AzZoXSky'];
    }

    public function isGame(): bool
    {
        return false;
    }

    public function isCore(): bool
    {
        return false;
    }

    public function menus(): ?array
    {
        return [
            new PackageMenuType(
                icon: 'fas fa-gift',
                title: 'DailyLoot',
                url: null,
                permission: 'dailyloot.admin',
                subMenus: [
                    new PackageSubMenuType(
                        title: 'Paramètre DailyLoot',
                        permission: 'dailyloot.admin',
                        url: 'dailyloot/manage',
                    ),
                ]
            ),
        ];
    }

    public function requiredPackages(): array
    {
        return ['Core'];
    }

    public function uninstall(): bool
    {
        return true;
    }
}