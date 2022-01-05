<?php

namespace MulkiAqi192\DoubleJump;

use pocketmine\Server;
use pocketmine\Player;

use pocketmine\plugin\PluginBase;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJumpEvent;

use pocketmine\level\particle\FlameParticle;

use pocketmine\math\Vector3;

class main extends PluginBase implements Listener {

    public function onEnable(){
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }

    public $modeon = [];

    public function onCommand(CommandSender $sender, Command $cmd, String $label, Array $args) : bool {

        switch($cmd->getName()){
            case "djump":
                if($sender instanceof Player){
                    if($sender->hasPermission("djump.cmd")){
                        if(isset($this->modeon[$sender->getName()])){
                            unset($this->modeon[$sender->getName()]);
                            $sender->sendMessage("§7[§aDouble§6Jump§7] §cDouble Jump deactived!");
                            return true;
                        } else {
                            $this->modeon[$sender->getName()] = $sender->getName();
                            $sender->sendMessage("§7[§aDouble§6Jump§7] §aDouble Jump actived!");
                            return true;
                        }
                    } else {
                        $sender->sendMessage("§7[§aDouble§6Jump§7] §cYou dont have permission to use this command!");
                        return true;
                    }
                } else {
                    $sender->sendMessage("§cPlease use this command in-game");
                    return true;
                }
            }   
        return true;
    }

    public function onJump(PlayerJumpEvent $event){
        $player = $event->getPlayer();
        $level = $player->getLevel();
        $x = $player->getX();
		$y = $player->getY();
		$z = $player->getZ();
        if(isset($this->modeon[$player->getName()])){
            $player->setMotion(new Vector3(0, 0.8, 0));
            $level->addParticle(new FlameParticle($player));
            $level->addParticle(new FlameParticle(new Vector3($x-0.3, $y, $z)));
			$level->addParticle(new FlameParticle(new Vector3($x, $y, $z-0.3)));
			$level->addParticle(new FlameParticle(new Vector3($x+0.3, $y, $z)));
			$level->addParticle(new FlameParticle(new Vector3($x, $y, $z+0.3)));
        }
    }

}
