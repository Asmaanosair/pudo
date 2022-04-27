<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class ExampleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data= [

            array(
                'array_data'=> array(
                'name' => 'Orders ',
                'href' => '/orders',
                'icon' => 'cil-list',
                'sequence' => '1',
                'slug' => 'link',
                'menu_id' => '1',
        ),
         'role_name'=>array('admin','client','supplier','branch-client','subadmin','teamleader','dispatcher','support')
            ),
            array(
                'array_data'=> array(
                'name' => 'Map ',
                'href' => '/map',
                'icon' => 'cil-map',
                'sequence' => '0',
                'slug' => 'link',
                'menu_id' => '1',
        ),
         'role_name'=>array('admin','subadmin','teamleader','dispatcher')
            ),
            array(
                'array_data'=> array(
                'name' => 'Orders ',
                'href' => '/orders',
                'icon' => 'cil-list',
                'sequence' => '1',
                'slug' => 'link',
                'menu_id' => '1',
        ),
         'role_name'=>array('admin','client','supplier','branch-client','subadmin','teamleader','dispatcher','support')
            ),
            array(
                'array_data'=> array(
                'name' => 'Orders Issue ',
                'href' => '/issue',
                'icon' => 'cil-list',
                'sequence' => '2',
                'slug' => 'link',
                'menu_id' => '1',
        ),
         'role_name'=>array('admin','client','branch-client','subadmin','teamleader','dispatcher')
            ),
            array(
                'array_data'=> array(
                'name' => 'Orders Issue ',
                'href' => '/issue',
                'icon' => 'cil-list',
                'sequence' => '2',
                'slug' => 'link',
                'menu_id' => '1',
        ),
         'role_name'=>array('admin','client','supplier','branch-client','subadmin','teamleader','dispatcher')
            ),
            array(
                'array_data'=> array(
                'name' => 'Compleated Orders  ',
                'href' => '/completed',
                'icon' => 'cil-list',
                'sequence' => '3',
                'slug' => 'link',
                'menu_id' => '1',
        ),
         'role_name'=>array('admin','client','supplier','branch-client','subadmin','teamleader','dispatcher')
            ),
            array(
                'array_data'=> array(
                'name' => 'Inprogress Orders  ',
                'href' => '/inprogress',
                'icon' => 'cil-list',
                'sequence' => '4',
                'slug' => 'link',
                'menu_id' => '1',
        ),
         'role_name'=>array('admin','client','supplier','branch-client','subadmin','teamleader','dispatcher')
            ),
            array(
                'array_data'=> array(
                'name' => 'Applications',
                'href' => '/driver-applications',
                'icon' => 'cil-attach',
                'sequence' => '5',
                'slug' => 'link',
                'menu_id' => '1',
        ),
         'role_name'=>array('admin','supplier','subadmin','teamleader')
            ),
            array(
                'array_data'=> array(
                'name' => 'Captains ',
                'href' => '/fleets',
                'icon' => 'cil-user',
                'sequence' => '6',
                'slug' => 'link',
                'menu_id' => '1',
        ),
         'role_name'=>array('admin','supplier','subadmin','teamleader')
            ),
            array(
                'array_data'=> array(
                'name' => 'Supplieres ',
                'href' => '/supplier',
                'icon' => 'cil-user',
                'sequence' => '7',
                'slug' => 'link',
                'menu_id' => '1',
        ),
         'role_name'=>array('admin','supplier','subadmin')
            ),
            array(
                'array_data'=> array(
                'name' => 'Members ',
                'href' => '/users',
                'icon' => 'cil-user',
                'sequence' => '8',
                'slug' => 'link',
                'menu_id' => '1',
        ),
         'role_name'=>array('admin')
            ),
            array(
                'array_data'=> array(
                    'name' => 'Countries',
                    'href' => '/countries',
                    'icon' => 'cil-list',
                    'sequence' => '9',
                    'slug' => 'link',
                    'menu_id' => '1',
                ),
                'role_name'=>array('admin','subadmin','teamleader')
            ),
            array(
                'array_data'=> array(
                    'name' => 'Cities',
                    'href' => '/cities',
                    'icon' => 'cil-list',
                    'sequence' => '10',
                    'slug' => 'link',
                    'menu_id' => '1',
                ),
                'role_name'=>array('admin','subadmin','teamleader')
            ),
            array(
                'array_data'=> array(
                    'name' => 'Clients',
                    'href' => '/client',
                    'icon' => 'cil-list',
                    'sequence' => '11',
                    'slug' => 'link',
                    'menu_id' => '1',
                ),
                'role_name'=>array('admin','subadmin')
            ),
            array(
                'array_data'=> array(
                    'name' => 'Branches',
                    'href' => '/branch',
                    'icon' => 'cil-list',
                    'sequence' => '12',
                    'slug' => 'link',
                    'menu_id' => '1',
                ),
                'role_name'=>array('admin','subadmin','client')
            ),
            array(
                'array_data'=> array(
                    'name' => 'Branches Managers',
                    'href' => '/client-branch',
                    'icon' => 'cil-list',
                    'sequence' => '13',
                    'slug' => 'link',
                    'menu_id' => '1',
                ),
                'role_name'=>array('client')
            ),
            array(
                'array_data'=> array(
                    'name' => 'Delivery Cost',
                    'href' => '/delivery-cost',
                    'icon' => 'cil-list',
                    'sequence' => '14',
                    'slug' => 'link',
                    'menu_id' => '1',
                ),
                'role_name'=>array('admin','subadmin','financial')
            ),
            array(
                'array_data'=> array(
                    'name' => 'Delivery Commission',
                    'href' => '/delivery-commission',
                    'icon' => 'cil-list',
                    'sequence' => '15',
                    'slug' => 'link',
                    'menu_id' => '1',
                ),
                'role_name'=>array('admin','subadmin','financial')
            ),
            array(
                'array_data'=> array(
                    'name' => ' Financial',
                    'href' => '/financial',
                    'icon' => 'cil-list',
                    'sequence' => '16',
                    'slug' => 'link',
                    'menu_id' => '1',
                ),
                'role_name'=>array('admin','subadmin','financial')
            ),
            array(
                'array_data'=> array(
                    'name' => ' Main Wallet',
                    'href' => '/main',
                    'icon' => 'cil-list',
                    'sequence' => '17',
                    'slug' => 'link',
                    'menu_id' => '1',
                ),
                'role_name'=>array('admin','subadmin','financial')
            ),
            array(
                'array_data'=> array(
                    'name' => '  Wallet of Captains',
                    'href' => '/main/fleets',
                    'icon' => 'cil-list',
                    'sequence' => '18',
                    'slug' => 'link',
                    'menu_id' => '1',
                ),
                'role_name'=>array('admin','subadmin','financial')
            ),
            array(
                'array_data'=> array(
                    'name' => '  Wallet of Clients',
                    'href' => '/main/clients',
                    'icon' => 'cil-list',
                    'sequence' => '18',
                    'slug' => 'link',
                    'menu_id' => '1',
                ),
                'role_name'=>array('admin','subadmin','financial')
            ),
            array(
                'array_data'=> array(
                    'name' => 'Rules Of Requests',
                    'href' => '/rules',
                    'icon' => 'cil-list',
                    'sequence' => '20',
                    'slug' => 'link',
                    'menu_id' => '1',
                ),
                'role_name'=>array('admin','subadmin')
            ),
            array(
                'array_data'=> array(
                    'name' => 'Requests Of Money',
                    'href' => '/request-money',
                    'icon' => 'cil-list',
                    'sequence' => '21',
                    'slug' => 'link',
                    'menu_id' => '1',
                ),
                'role_name'=>array('admin','subadmin')
            ),
            array(
                'array_data'=> array(
                    'name' => 'Settings',
                    'href' => '/settings',
                    'icon' => 'cil-setting',
                    'sequence' => '22',
                    'slug' => 'link',
                    'menu_id' => '1',
                ),
                'role_name'=>array('admin','client','supplier','branch-client','subadmin','teamleader','dispatcher','support','financial')
            ),
            array(
                'array_data'=> array(
                    'name' => 'Shipping Label Rule',
                    'href' => '/shipping-labels',
                    'icon' => 'cil-list',
                    'sequence' => '23',
                    'slug' => 'link',
                    'menu_id' => '1',

                ),
                'role_name'=>array('admin','subadmin','teamleader')
            ),
            array(
                'array_data'=> array(
                    'name' => 'Route Numbers',
                    'href' => '/route-numbers',
                    'icon' => 'cil-list',
                    'sequence' => '23',
                    'slug' => 'link',
                    'menu_id' => '1',

                ),
                'role_name'=>array('admin','client','supplier','branch-client','subadmin','teamleader','dispatcher')
            ),


        ];

         foreach($data as $item){
        DB::table('menus')->updateOrInsert(
            $item['array_data'],
            $item['array_data']
        );
        $id=DB::table('menus')->where('href',$item['array_data']['href'])->first()->id;
        foreach ($item['role_name'] as $role_name){
        DB::table('menu_role')->updateOrInsert(
            array(
                'role_name' => $role_name,
                'menus_id' =>$id,
            ),array(
            'role_name' => $role_name,
            'menus_id' =>$id,
        ));
        }
          }














    }
}
