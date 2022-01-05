<?php

namespace MulkiAqi192\DoubleJump;

use pocketmine\player\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJumpEvent;
use pocketmine\world\particle\FlameParticle;
use pocketmine\math\Vector3;
use pocketmine\utils\TextFormat as TF;

class main extends PluginBase implements Listener {

    public $modeon = [];

    public function onEnable(): void{
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }

    public function onCommand(CommandSender $sender, Command $cmd, String $label, Array $args) : bool {

        switch($cmd->getName()){
            case "djump":
                if($sender instanceof Player){
                    if(isset($this->modeon[$sender->getName()])){
                        unset($this->modeon[$sender->getName()]);
                        $sender->sendMessage(TF::RED . "[DoubleJump] Double Jump deactived!");
                        return true;
                    } else {
                        $this->modeon[$sender->getName()] = $sender->getName();
                        $sender->sendMessage(TF::GREEN . "[DoubleJump] Double Jump actived!");
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
        $level = $player->getWorld();
        $x = $player->getPosition()->getX();
        $y = $player->getPosition()->getY();
        $z = $player->getPosition()->getZ();
        if(isset($this->modeon[$player->getName()])){
            $player->setMotion(new Vector3(0, 0.8, 0));
            $level->addParticle(new Vector3($x-0.3, $y, $z), new FlameParticle(new Vector3($x-0.3, $y, $z)));
            $level->addParticle(new Vector3($x, $y, $z-0.3), new FlameParticle(new Vector3($x, $y, $z-0.3)));
            $level->addParticle(new Vector3($x+0.3, $y, $z), new FlameParticle(new Vector3($x+0.3, $y, $z)));
            $level->addParticle(new Vector3($x, $y, $z+0.3), new FlameParticle(new Vector3($x, $y, $z+0.3)));
        }
    }

}
