<?php
namespace Enes5519\Popup;

use pocketmine\plugin\PluginBase;
use pocketmine\scheduler\PluginTask;
use pocketmine\event\Listener;
use pocketmine\utils\TextFormat as R;
use pocketmine\utils\Config;

class Main extends PluginBase implements Listener{
    public function onEnable(){
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        @mkdir($this->getDataFolder());
        $config = new Config($this->getDataFolder() . "config.yml", Config::YAML);
        if($config->get("popuplar") == null){
            $config->set("popuplar", array("§eEnes§65519", "§6Enes§e5519"));
            $config->save();
        }
        $popuplar = $config->get("popuplar");
        $popup1 = $config->get("popuplar", $popuplar[0]);
        $popup2 = $config->get("popuplar", $popuplar[1]);
        $this->getServer()->getScheduler()->scheduleRepeatingTask(new Popup($this, $popup1), 5);
        $this->getServer()->getScheduler()->scheduleRepeatingTask(new Popup($this, $popup2), 3);
    }
}

class Popup extends PluginTask{
    public function __construct(Main $plugin, $popuplar){
        parent::__construct($plugin);
        $this->popuplar = $popuplar;
        $this->plugin = $plugin;
    }
	
    public function onRun($suankiZaman){
        $config = new Config($this->plugin->getDataFolder() . "config.yml", Config::YAML);
    	   if($this->plugin->isEnabled()){
	          foreach($this->plugin->getServer()->getOnlinePlayers() as $oyuncular){
	              $popuplarr = $config->get("popuplar");
	              $animasyon = array_rand($popuplarr, 1);
	              $oyuncular->sendPopup($popuplarr[$animasyon]);
            }
        }
    }
}
?>
