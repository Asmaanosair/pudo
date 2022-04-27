<?php
/*
*   07.11.2019
*   MenusMenu.php
*/
namespace App\Http\Menus;

use App\MenuBuilder\MenuBuilder;
use Illuminate\Support\Facades\DB;
use App\Models\Menus;
use App\MenuBuilder\RenderFromDatabaseData;

class GetSidebarMenu implements MenuInterface{

    private $mb; //menu builder
    private $menu;

    public function __construct(){
        $this->mb = new MenuBuilder();
    }

    private function getMenuFromDB($menuName, $role){
        $this->menu = Menus::join('menu_role', 'menus.id', '=', 'menu_role.menus_id')
            ->join('menulist', 'menulist.id', '=', 'menus.menu_id')
            ->select('menus.*')
            ->where('menulist.name', '=', $menuName)
            ->where('menu_role.role_name', '=', $role)
            ->orderBy('menus.sequence', 'asc')->get();
    }

    private function getGuestMenu($menuName){
        $this->getMenuFromDB($menuName, 'guest');
    }

    private function getUserMenu($menuName){
        $this->getMenuFromDB($menuName, 'user');
    }

    private function getAdminMenu($menuName){
        $this->getMenuFromDB($menuName, 'admin');
    }
    private function getTeamLeaderMenu($menuName){
        $this->getMenuFromDB($menuName, 'teamleader');
    }
    private function getDispatcherMenu($menuName){
        $this->getMenuFromDB($menuName, 'dispatcher');
    }
    private function getSubAdminMenu($menuName){
        $this->getMenuFromDB($menuName, 'subadmin');
    }
    private function getSupportMenu($menuName){
        $this->getMenuFromDB($menuName, 'support');
    }
    private function getClientMenu($menuName){
        $this->getMenuFromDB($menuName, 'client');
    }
    private function getClientBranchMenu($menuName){
        $this->getMenuFromDB($menuName, 'client-branch');
    }

    public function get($roles, $menuName = 'sidebar menu'){
        $roles = explode(',', $roles);
        if(empty($roles)){
            $this->getGuestMenu($menuName);
        }elseif(in_array('admin', $roles)){
            $this->getAdminMenu($menuName);
        }elseif(in_array('user', $roles)){
            $this->getUserMenu($menuName);
        }elseif(in_array('teamleader', $roles)){
            $this->getTeamLeaderMenu($menuName);
        }elseif(in_array('dispatcher', $roles)){
            $this->getDispatcherMenu($menuName);
        }elseif(in_array('subadmin', $roles)){
            $this->getSubAdminMenu($menuName);
        }elseif(in_array('support', $roles)){
            $this->getSupportMenu($menuName);
        } elseif(in_array('client', $roles)){
               $this->getClientMenu($menuName);
            }
           elseif(in_array('client-branch', $roles)){
           $this->getClientBranchMenu($menuName);
}
        else{
            $this->getGuestMenu($menuName);
        }
        $rfd = new RenderFromDatabaseData;
        return $rfd->render($this->menu);
    }

    public function getAll( $menuId = 1 ){
        $this->menu = Menus::select('menus.*')
            ->where('menus.menu_id', '=', $menuId)
            ->orderBy('menus.sequence', 'asc')->get();
        $rfd = new RenderFromDatabaseData;
        return $rfd->render($this->menu);
    }
}
