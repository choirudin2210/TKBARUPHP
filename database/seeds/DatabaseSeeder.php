<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call(PermissionTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(SettingsTableSeeder::class);
        $this->call(DefaultStoreTableSeeder::class);
        $this->call(DefaultListUnitTableSeeder::class);
        $this->call(PhoneProviderTableSeeder::class);
        $this->call(CreateLookupTableSeeder::class);

        /* DUMMY DATA */
        $this->call(BankTableSeeder::class);
        $this->call(ProductTableSeeder::class);
        $this->call(ProductTypeTableSeeder::class);
        $this->call(SupplierTableSeeder::class);
        $this->call(CustomerTableSeeder::class);
        $this->call(VendorTruckingTableSeeder::class);
        $this->call(WarehouseTableSeeder::class);
    }
}
