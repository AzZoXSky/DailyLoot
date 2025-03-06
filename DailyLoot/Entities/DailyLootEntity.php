<?php

namespace CMW\Entity\DailyLoot;

use CMW\Entity\Users\UserEntity;
use CMW\Manager\Env\EnvManager;
use CMW\Manager\Package\AbstractEntity;
use CMW\Utils\Date;
use CMW\Utils\Website;

class DailyLootEntity extends AbstractEntity
{
    private int $id;
    private string $name;
    private string $rarity;
    private float $probability;
    private string $command;
    private ?string $image;
    private string $open_date;
    private UserEntity $user;

    /**
     * @param int $id
     * @param string $name
     * @param string $rarity
     * @param float $probability
     * @param string $command
     * @param string $image
     * @param string $open_date
     * @param UserEntity $user
     */
    public function __construct(int $id, string $name, string $rarity, float $probability, string $command, ?string $image, string $open_date, UserEntity $user)
    {
        $this->id = $id;
        $this->name = $name;
        $this->rarity = $rarity;
        $this->probability = $probability;
        $this->command = $command;
        $this->image = $image;
        $this->open_date = $open_date;
        $this->user = $user;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getRarity(): string
    {
        return $this->rarity;
    }

    /**
     * @return float
     */
    public function getProbability(): float
    {
        return $this->probability;
    }

    /**
     * @return string
     */
    public function getCommand(): string
    {
        return $this->command;
    }

    /**
     * @return string|null
     */
    public function getImage(): ?string
    {
        return $this->image;
    }

    /**
     * @return UserEntity
     */
    public function getUser(): UserEntity
    {
        return $this->user;
    }

    /**
     * @return string
     */
    public function getRewardFormatted(): string
    {
        return "<span class='rarity-" . htmlspecialchars($this->rarity) . "'>" . htmlspecialchars($this->name) . "</span>";
    }

    /**
     * @return string
     */
    public function getFormattedUrl(): string
    {
        return Website::getProtocol() . '://' . $_SERVER['SERVER_NAME'] . EnvManager::getInstance()->getValue('PATH_SUBFOLDER') . "dailyloot/view/" . $this->id;
    }
}
