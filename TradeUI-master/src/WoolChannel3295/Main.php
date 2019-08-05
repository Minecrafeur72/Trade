<?php

namespace WoolChannel3295;

use pocketmine\Server;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\{command\ConsoleCommandSender, Player, utils\TextFormat};
use pocketmine\command\CommandExecutor;

use jojoe77777\FormAPI;
use onebone\economyapi\EconomyAPI;

use pocketmine\item\Item;
use pocketmine\item\enchantment\Enchantment;
use pocketmine\item\enchantment\EnchantmentInstance;

use pocketmine\utils\Config;

class Main extends PluginBase implements Listener{


	public function onEnable(): void{
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		$this->getLogger()->Info("§c§l<3 Trade Đã Được Bật");
	}


	public function onDisable(): void{
		$this->getLogger()->Info("§a§l<3 Trade Đã Được Tắt");
	}


	public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args): bool{
		switch($cmd->getName()) {
			case "trade":
			if(!($sender instanceof Player)){
				$sender->sendMessage("Vui Lòng Sử Dụng Lệnh Này trong trò chơi");
                return true;
			}
						$this->tradeForm($sender);
		}
		return true;
	}


	public function tradeForm($sender){
		$api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
        $form = $api->createSimpleForm(function (Player $sender, $data){
        	$result = $data;
            if ($result == null) {
            }
			switch($data) {
				case 0:
				$this->Trade($sender);
				break;

				case 1:
				$this->Info($sender);
				break;
			}
		});
	    $form->setTitle("§6§lＭＥＮＵ ＴＲＡＤＥ");
	    $form->addButton("§a§lTrade\n§8Tools, Kit,...", 0);
	    $form->addButton("§a§lInfo", 1);
	    $form->addButton("§cEXIT");
        $form->sendToPlayer($sender);
	}


	public function Info($sender){
		$api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createSimpleForm(function (Player $sender, $data){
			$result = $data;
			if ($result == null) {
			}
		});
		$form->setTitle("§6§lＩＮＦＯ ＴＲＡＤＥ");
		    $form->setContent("§c§l☩ §rTrade Được Thiết Kế Với Dao Diện UI\n§c§l☩ §rTrade Được Tạo Bởi WoolChannel3295\n§c§l☩ §rChúc Các Bạn Chơi Game Vui Vẻ Và Gặp Được Nhiều May Mắn\n§c§l☩ Cảm Ơn Bạn Đã Đọc\n§aLink Facebook:§b§l https://www.facebook.com/profile.php?id=100035665299288\n§c§l    THANHKS FOR DOWLOAD");
		        $form->addButton("§cEXIT");
		            $form->sendToPlayer($sender);
	}


	public function Trade($sender){
		$api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
        $form = $api->createSimpleForm(function (Player $sender, $data){
        	$result = $data;
            if ($result == null) {
            }
			switch($data) {
				case 0:
                $this->Tools($sender);
                break;
            }
        });
        $form->setTitle("§6§lＴＲＡＤＥ");
	    $form->addButton("§a§lTools", 0);
	    $form->addButton("§cEXIT");
        $form->sendToPlayer($sender);
	}


	public function Tools($sender){
		$api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
        $form = $api->createSimpleForm(function (Player $sender, $data){
        	$result = $data;
            if ($result == null) {
            }
			switch($data) {
				case 0:
                $this->Pickaxe($sender);
                break;
            }
        });
        $form->setTitle("§6§lＴＲＡＤＥ");
	    $form->addButton("§a§lPickaxe", 0);
	    $form->addButton("§cEXIT");
        $form->sendToPlayer($sender);
	}


	public function Pickaxe($sender){
		$api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
        $form = $api->createSimpleForm(function (Player $sender, $data){
        	$result = $data;
            if ($result == null) {
            }
			switch($data) {
				case 0:
                $this->Yes($sender);
                break;
            }
        });
        $form->setTitle("§6§lＴＲＡＤＥ");
        $form->setContent("- Cúp Server:\n  - Nguyên Liệu:\n   + 10 Mảnh Server\n   + 100k");
	    $form->addButton("§a§lĐồng Ý", 0);
	    $form->addButton("§cEXIT");
        $form->sendToPlayer($sender);
	}


	public function Yes($sender){
		$api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
		$money = EconomyAPI::getInstance()->myMoney($sender);
		$cost = 100000;
			if($money >= $cost){
				EconomyAPI::getInstance()->reduceMoney($sender, $cost);
				if($sender instanceof Player){
				    $inv = $sender->getInventory();
				        if($inv->contains(Item::get(175, 0, 10))){
				    			$item = Item::get(278, 0, 1);
				    			$item->setCustomName("§c§lCÚP SERVER");
				    			$item->setLore(array("Vật Phẩm Cực Quý Hiểm\nKhông Bán Tại Shop"));
                                $ench = new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::EFFICIENCY));
                                $ench->setLevel(10);
                                $ench1 = new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::UNBREAKING));
                                $ench1->setLevel(100);
                                $item->addEnchantment($ench);
                                $item->addEnchantment($ench1);
				    			$inv->removeItem(Item::get(175, 0, 10));
				    			$inv->addItem($item);
				    			$sender->sendMessage("Chúc Mừng Bạn Đã Trade Thàn Công");
				    			return true;
				        }
				}
        }else{
        	$sender->sendMessage("Vui Lòng Kiểm Tra Lại Số Tiền Và Số Thủy Ngọc Của Bạn");
		    return true;
        }
	}
}