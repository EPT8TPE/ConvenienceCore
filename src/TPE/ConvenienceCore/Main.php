<?php

declare(strict_types=1);

namespace TPE\ConvenienceCore;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\Player;
use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;

class main extends PluginBase implements Listener {

    public $config;
    public $flist = [];

    public function onEnable() : void {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        @mkdir($this->getDataFolder());
        $this->config = $this->getConfig();
        $this->saveDefaultConfig();
    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool
    {
        if ($sender instanceof Player) {
            if ($sender->hasPermission("feed.command")) {
                if ($command->getName() == "feed") {
                    $sender->setFood(20);
                    $sender->setSaturation(20);
                    $sender->sendMessage($this->config->get("message-sent-to-player-when-fed"));
                }
            } else {
                $sender->sendMessage(TextFormat::RED . "You do not have permission to use this command!");
                return false;
            }
        }
        if($command->getName() == "fly") {
            if ($sender->hasPermission("fly.allow")) {
                if (!isset($this->flist[$sender->getName()])) {
                    $this->flist[$sender->getName()] = $sender->getName();
                    $sender->setFlying(true);
                    $sender->setAllowFlight(true);
                    $sender->sendMessage($this->config->get("Message-sent-to-player-on-flight-enable"));


                } else {
                    unset($this->flist[$sender->getName()]);
                    $sender->setFlying(false);
                    $sender->setAllowFlight(false);
                    $sender->sendMessage($this->config->get("Message-sent-to-player-on-flight-disable"));
                }

            } else {
                $sender->sendMessage(TextFormat::RED . "You do not have permission to use this command!");
                return false;

            }
        }
        if($command === "heal") {
            if($sender->hasPermission("heal.command") && $sender instanceof Player) {
                $sender->setHealth($sender->getMaxHealth());
                $sender->sendMessage(TextFormat::AQUA . "You have been healed!");
            }
        } else {
            $sender->sendMessage(TextFormat::RED . "You do not have permission to use this command!");
            return false;
        }
        return true;
    }
    public function onDamage(EntityDamageEvent $event) : void
    {
        $entity = $event->getEntity();
        if($this->getConfig()->get("flight-disabled-on-hit") === true) {
            if ($event instanceof EntityDamageByEntityEvent) {
                if ($entity instanceof Player) {
                    $ouch = $event->getDamager();
                    if (!$ouch instanceof Player) return;
                    if ($ouch->isCreative()) return;
                    if ($ouch->getAllowFlight() === true) {
                        $ouch->sendMessage($this->config->get("no-flight-during-combat-message"));
                        $ouch->setAllowFlight(false);
                        $ouch->setFlying(false);
                    }

                }
            }
        }
    }
}