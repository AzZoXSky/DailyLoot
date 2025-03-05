<?php

namespace CMW\Package\DailyLoot\Models;

error_reporting(E_ALL);
ini_set('display_errors', 1);

use CMW\Manager\Database\DatabaseManager;
use CMW\Manager\Package\AbstractModel;

/**
 * Class @DailyLootModel
 * @package DailyLoot
 * @author AzZoXSky
 * @version 1.0.0
 */
class DailyLootModel extends AbstractModel
{
    protected static string $tableRewards = "cmw_daily_rewards";

    public static function getInstance(): static
    {
        return parent::getInstance();
    }

    /**
     * Ajoute une récompense à la base de données.
     */
    public function addReward(string $name, string $rarity, float $probability, string $command, ?string $image = null): void
    {
        $sql = "INSERT INTO " . self::$tableRewards . " (name, rarity, probability, command, image) 
                VALUES (:name, :rarity, :probability, :command, :image)";
        $db = DatabaseManager::getInstance();
        $req = $db->prepare($sql);

        $req->execute([
            'name'        => $name,
            'rarity'      => $rarity,
            'probability' => $probability,
            'command'     => $command,
            'image'       => $image
        ]);
    }



    /**
     * Supprime une récompense de la base de données.
     */
    public function deleteReward(int $rewardId): void
    {
        $sql = "DELETE FROM " . self::$tableRewards . " WHERE id = :reward_id";
        $db = DatabaseManager::getInstance();
        $req = $db->prepare($sql);

        $req->execute(['reward_id' => $rewardId]);
    }

    /**
     * Sélectionne une récompense aléatoire.
     */
    public function getRandomReward(): ?array
    {
        $sql = "SELECT * FROM " . self::$tableRewards;
        $db = DatabaseManager::getInstance();
        $res = $db->prepare($sql);

        if (!$res->execute()) {
            return null;
        }

        $rewards = $res->fetchAll(\PDO::FETCH_ASSOC);
        if (!$rewards) {
            return null;
        }

        $totalWeight = array_sum(array_column($rewards, 'probability'));
        $random = mt_rand(1, $totalWeight);

        foreach ($rewards as $reward) {
            $random -= $reward['probability'];
            if ($random <= 0) {
                return $reward;
            }
        }

        return null;
    }

    /**
     * Récupère la liste de toutes les récompenses disponibles.
     */
    public function getAllRewards(): array
    {
        $sql = "SELECT * FROM " . self::$tableRewards;
        $db = DatabaseManager::getInstance();
        $res = $db->prepare($sql);

        if (!$res->execute()) {
            return [];
        }

        return $res->fetchAll(\PDO::FETCH_ASSOC);
    }
}
