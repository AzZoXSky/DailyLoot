<?php

namespace CMW\Controller\DailyLoot\Public;

use CMW\Manager\Package\AbstractController;
use CMW\Manager\Router\Link;
use CMW\Manager\Views\View;
use CMW\Controller\Users\UsersSessionsController;
use CMW\Package\DailyLoot\Models\DailyLootModel;
use CMW\Controller\Users\UsersController;
use CMW\Manager\Flash\Alert;
use CMW\Manager\Flash\Flash;
use CMW\Utils\Redirect;

/**
 * Class: @DailyLootPublicController
 * @package DailyLoot
 * @version 1.0.0
 */
class DailyLootPublicController extends AbstractController
{
    #[Link('/dailyloot', Link::GET)]
    private function frontDailyLoot(): void
    {
        /**
         * Utilisateur connecté pour accéder à la page .
         */
        if (!UsersController::isUserLogged()) {
            Flash::send(
                Alert::WARNING,
                'DailyLoot',
                'Connectez-vous avant d\'accéder à la page dailyLoot'
            );
            Redirect::redirect('login');
        }

        $user = UsersSessionsController::getInstance()->getCurrentUser();

        /**
         * Utilisateur connecté pour accéder à la page .
         */

        if (!$user) {
            View::createPublicView('DailyLoot', 'main')
                ->addVariable('rewardsList', [])
                ->view();
            return;
        }

        $dailyLootModel = DailyLootModel::getInstance();

        // Récupération de toutes les récompenses pour la roulette
        $allRewards     = $dailyLootModel->getAllRewards();

        View::createPublicView('DailyLoot', 'main')
            ->addVariableList([
                'rewardsList'   => $allRewards
            ])
            ->view();
    }
}
