<?php

namespace CMW\Permissions\DailyLoot;

use CMW\Manager\Lang\LangManager;
use CMW\Manager\Permission\IPermissionInit;
use CMW\Manager\Permission\PermissionInitType;

class Permissions implements IPermissionInit
{
    public function permissions(): array
    {
        return [
            new PermissionInitType(
                code: 'dailyloot.view',
                description: LangManager::translate('dailyloot.permissions.view'),
            ),
            new PermissionInitType(
                code: 'dailyloot.admin',
                description: LangManager::translate('dailyloot.permissions.admin'),
            ),
        ];
    }
}
