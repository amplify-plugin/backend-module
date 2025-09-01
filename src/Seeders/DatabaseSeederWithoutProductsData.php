<?php

namespace Amplify\System\Backend\Seeders;

use Amplify\System\Marketing\Seeders\MerchandisingSeeder;
use Amplify\System\Utility\Seeders\DataTransformationSeeder;
use Amplify\System\Utility\Seeders\ImportSeeder;
use App\Models\Contact;
use App\Models\Customer;
use App\Models\Search;
use App\Models\Site;
use App\Models\Store;
use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Database\Seeder;

class DatabaseSeederWithoutProductsData extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserSeed::class);
        $this->call(SiteConfigSeed::class);
        $this->call(CustomerGroupSeeder::class);
        $this->call(ImportSeeder::class);
        $this->call(DataTransformationSeeder::class);
        $this->call(PageSeeder::class);
        $this->call(WidgetSeeder::class);
        $this->call(ManufacturerSeeder::class);
        $this->call(MerchandisingSeeder::class);

        // dummy data store for testing
        Customer::factory(50)
            ->hasContact(1, ['is_admin' => 1])
            ->has(Contact::factory(2))
            ->create();

        Site::factory(5)
            ->has(Search::factory(1))
            ->hasSitePricing(1)
            ->create();

        User::factory(10)->create();

        Warehouse::factory(10)->create();
        Store::factory(15)->create();

        $this->call(MenuSeeder::class);
        $this->call(FaqCategorySeeder::class);
        $this->call(FaqSeeder::class);
    }
}
