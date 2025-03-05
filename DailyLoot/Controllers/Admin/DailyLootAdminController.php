<?php

namespace CMW\Controller\DailyLoot\Admin;

use CMW\Controller\Users\UsersController;
use CMW\Manager\Package\AbstractController;
use CMW\Manager\Router\Link;
use CMW\Manager\Views\View;
use CMW\Utils\Redirect;
use CMW\Package\DailyLoot\Models\DailyLootModel;
use CMW\Utils\Utils;
use CMW\Manager\Flash\Flash;
use CMW\Manager\Flash\Alert;

/**
 * Class: @DailyLootAdminController
 * @package DailyLoot
 * @version 1.0.0
 */
class DailyLootAdminController extends AbstractController
{
    #[Link('/manage', Link::GET, [], '/cmw-admin/dailyloot')]
    private function dailyLootList(): void
    {
        UsersController::redirectIfNotHavePermissions('core.dashboard', 'dailyloot.admin');

        $dailyLootModel = DailyLootModel::getInstance();
        $rewards = $dailyLootModel->getAllRewards();

        View::createAdminView('DailyLoot', 'manage')
            ->addVariable('rewards', $rewards)
            /**
             * Ajout pour : https://dash.craftmywebsite.fr/tables/sorted .
             */
            ->addStyle('Admin/Resources/Assets/Css/simple-datatables.css')
            ->addScriptAfter(
                'Admin/Resources/Vendors/Simple-datatables/simple-datatables.js',
                'Admin/Resources/Vendors/Simple-datatables/config-datatables.js'
            )
            ->view();
    }

    #[Link('/manage', Link::POST, [], '/cmw-admin/dailyloot')]
    private function dailyLootAddPost(): void
    {
        UsersController::redirectIfNotHavePermissions('core.dashboard', 'dailyloot.create');


        [$rewardName, $rarity, $probability, $command, $image] = Utils::filterInput(
            'reward_name',
            'rarity',
            'probability',
            'command',
            'image'
        );


        $dailyLootModel = DailyLootModel::getInstance();

        $message = '';
        $isError = false;

        if (!$rewardName || !$rarity || !$probability || !$command || !$image) {
            $message = "Tous les champs sont requis.";
            $isError = true;
        } else {
            $dailyLootModel->addReward($rewardName, $rarity, $probability, $command, $image);
            Flash::send(Alert::SUCCESS, 'DailyLoot', 'La récompense a été ajoutée avec succès.');
        }

        $rewards = $dailyLootModel->getAllRewards();

        View::createAdminView('DailyLoot', 'manage')
            ->addVariable('rewards', $rewards)
            ->addVariable('message', $message)
            ->addVariable('isError', $isError)
            ->addStyle('Admin/Resources/Assets/Css/simple-datatables.css')
            ->addScriptAfter(
                'Admin/Resources/Vendors/Simple-datatables/simple-datatables.js',
                'Admin/Resources/Vendors/Simple-datatables/config-datatables.js'
            )
            ->view();
    }
    #[Link('/manage/remove', Link::POST, [], '/cmw-admin/dailyloot')]
    private function dailyLootRemovePost(): void
    {
        UsersController::redirectIfNotHavePermissions('core.dashboard', 'dailyloot.delete');

        $dailyLootModel = DailyLootModel::getInstance();
        [$rewardId] = Utils::filterInput('reward_id');

        if (!$rewardId) {
            Flash::send(Alert::ERROR, 'DailyLoot', 'Erreur : Identifiant de récompense manquant.');
        } else {
            $dailyLootModel->deleteReward($rewardId);
            Flash::send(Alert::SUCCESS, 'DailyLoot', 'La récompense a été supprimée avec succès.');
        }

        $rewards = $dailyLootModel->getAllRewards();
        View::createAdminView('DailyLoot', 'manage')
            ->addVariable('rewards', $rewards)
            ->addStyle('Admin/Resources/Assets/Css/simple-datatables.css')
            ->addScriptAfter(
                'Admin/Resources/Vendors/Simple-datatables/simple-datatables.js',
                'Admin/Resources/Vendors/Simple-datatables/config-datatables.js'
            )
            ->view();
    }
}
