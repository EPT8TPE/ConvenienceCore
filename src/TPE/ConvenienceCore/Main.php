<?php

declare(strict_types=1);

namespace TPE\ConvenienceCore;

use pocketmine\block\Block;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\item\Item;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\IntTag;
use pocketmine\nbt\tag\StringTag;
use pocketmine\Player;
use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\tile\Tile;

class Main extends PluginBase implements Listener {

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
        if($this->config->get("feed-feature-disabled") == false) {
            if ($sender instanceof Player) {
                if ($sender->hasPermission("feed.command")) {
                    if ($command->getName() == "feed") {
                        $sender->setFood(20);
                        $sender->setSaturation(20);
                        $sender->sendMessage($this->config->get("message-sent-to-player-when-fed"));
                    }
                } else {
                    $sender->sendMessage($this->config->get("no-perms-message-feed"));
                    return false;
                }
            } else {
                $sender->sendMessage("You can not run this command via console!");
            }
        } else {
            $sender->sendMessage($this->config->get("feed-feature-disabled-message"));
            return false;
        }

        if($this->config->get("fly-feature-disabled") == false) {
            if($sender instanceof Player) {
                if ($sender->hasPermission("fly.allow")) {
                    if ($command->getName() == "fly") {
                        if (!isset($this->flist[$sender->getName()])) {
                            $this->flist[$sender->getName()] = $sender->getName();
                            $sender->setFlying(true);
                            $sender->setAllowFlight(true);
                            $sender->sendMessage($this->config->get("message-sent-to-player-on-flight-enable"));
                        } else {
                            unset($this->flist[$sender->getName()]);
                            $sender->setFlying(false);
                            $sender->setAllowFlight(false);
                            $sender->sendMessage($this->config->get("message-sent-to-player-on-flight-disable"));
                        }
                    }
                } else {
                    $sender->sendMessage($this->config->get("no-perms-message-fly"));
                    return false;
                }
            } else {
                $sender->sendMessage("You can not run this command via console!");
                return false;
            }
        } else {
            $sender->sendMessage($this->config->get("fly-feature-disabled"));
        }

        if($this->config->get("heal-feature-disabled") == false) {
            if ($command->getName() == "heal") {
                if ($sender instanceof Player) {
                    if ($sender->hasPermission("heal.allow")) {
                        $sender->setHealth($sender->getMaxHealth());
                        $sender->sendMessage($this->config->get("message-sent-to-player-when-healed"));
                    } else {
                        $sender->sendMessage($this->config->get("no-perms-message-heal"));
                    }
                } else {
                    $sender->sendMessage("You can not run this command via console!");

                }
            }
        } else {
            $sender->sendMessage($this->config->get("heal-feature-disabled-message"));
            return false;
        }

        if($this->config->get("setlore-feature-disabled") == false) {
            if ($command->getName() == "setlore") {
                if ($sender instanceof Player) {
                    if ($sender->hasPermission("setlore.allow")) {
                        $l = implode(" ", $args);
                        $it = $sender->getInventory()->getItemInHand();
                        if ($it->getId() == 0) {
                            $sender->sendMessage($this->config->get("message-sent-to-player-when-hand-is-empty-setlore"));
                            return true;
                        }
                        $it->setLore(explode("\n\n", $l));
                        $sender->getInventory()->setItemInHand($it);
                        $sender->sendMessage($this->config->get("message-sent-to-player-when-setlore"));

                    } else {
                        $sender->sendMessage($this->config->get("no-perms-message-setlore"));

                    }
                } else {
                    $sender->sendMessage("You can not run this command via console!");

                }
            }
            } else {
            $sender->sendMessage($this->config->get("setlore-feature-disabled-message"));
            return false;
        }

        if($this->config->get("rename-feature-disabled") == false) {
            if($command->getName() == "rename") {
                if($sender instanceof Player) {
                    if($sender->hasPermission("rename.allow")) {
                        $item = $sender->getInventory()->getItemInHand();
                        if($item->isNull()) {
                            $sender->sendMessage($this->config->get("message-sent-to-player-when-hand-is-empty-rename"));
                            return false;
                        }
                        $item->setCustomName(implode(" ", $args));
                        $sender->getInventory()->setItemInHand($item);
                        $sender->sendMessage($this->config->get("message-sent-to-player-when-rename"));
                    } else {
                        $sender->sendMessage($this->config->get("no-perms-message-rename"));

                    }
                } else {
                    $sender->sendMessage("You can not run this command via console!");

                }
            }
        } else {
            $sender->sendMessage($this->config->get("rename-feature-disabled-message"));
            return false;
        }

        if($this->config->get("clearinv-feature-disabled") == false){
            if($command->getName() == "clearinventory") {
                if($sender instanceof Player) {
                    if($sender->hasPermission("clearinv.allow")) {
                        $removed = 0;
                        foreach ($sender->getInventory()->getContents() as $index => $item) {
                            $sender->getInventory()->setItem($index, Item::get(Item::AIR));
                            $removed++;
                        }
                        $sender->sendMessage($this->config->get("message-sent-to-player-when-clearinv"));
                    } else {
                        $sender->sendMessage($this->config->get("no-perms-messages-clearinv"));

                    }
                } else {
                    $sender->sendMessage("You can not run this command via console!");

                }
            }

        } else {
            $sender->sendMessage($this->config->get("clearinv-feature-disabled-message"));
            return false;
        }
      if($this->config->get("enderchest-feature-disabled") == false) {
          if ($command->getName() == "enderchest") {
              if ($sender instanceof Player) {
                  if ($sender->hasPermission("enderchest.allow")) {
                      $nbt = new CompoundTag("", [new StringTag("id", Tile::CHEST), new StringTag("CustomName", "EnderChest"), new IntTag("x", (int)floor($sender->x)), new IntTag("y", (int)floor($sender->y) - 4), new IntTag("z", (int)floor($sender->z))]);
                      $tile = Tile::createTile("EnderChest", $sender->getLevel(), $nbt);
                      $block = Block::get(Block::ENDER_CHEST);
                      $block->x = (int)$tile->x;
                      $block->y = (int)$tile->y;
                      $block->z = (int)$tile->z;
                      $block->level = $tile->getLevel();
                      $block->level->sendBlocks([$sender], [$block]);
                      $sender->getEnderChestInventory()->setHolderPosition($tile);
                      $sender->addWindow($sender->getEnderChestInventory());
                      $sender->sendPopup($this->config->get("pop-up-message-enderchest"));
                  } else {
                      $sender->sendMessage($this->config->get("no-perms-message-enderchest"));
                      
                  }
              } else {
                  $sender->sendMessage("You can not run this command via console!");

              }
          }
      } else {
          $sender->sendMessage($this->config->get("enderchest-feature-disabled-message"));
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