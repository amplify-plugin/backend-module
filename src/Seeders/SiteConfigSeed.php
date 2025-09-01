<?php

namespace Amplify\System\Backend\Seeders;

use App\Models\SiteConfig;
use Illuminate\Database\Seeder;

class SiteConfigSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SiteConfig::query()->create(
            [
                'admin_logo' => 'uploads/images/site_config/images.png',
                'favicon' => 'uploads/images/site_config/default-profile-3.png',
                'admin_footer' => "<p><span style=\"color: #869ab8; font-family: 'Source Sans Pro', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, 'Noto Sans', sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol', 'Noto Color Emoji'; font-size: 14.4px;\">Developed by </span><a style=\"box-sizing: border-box; color: #7c69ef; text-decoration-line: none; font-family: 'Source Sans Pro', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, 'Noto Sans', sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol', 'Noto Color Emoji'; font-size: 14.4px;\" title=\"MediusWare\" href=\"https://mediusware.com/\" target=\"_blank\" rel=\"noopener\">MediusWare</a><span style=\"color: #869ab8; font-family: 'Source Sans Pro', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, 'Noto Sans', sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol', 'Noto Color Emoji'; font-size: 14.4px;\">. Powered by <a title=\"Easy Ask\" href=\"http://www.easyask.com\" target=\"_blank\" rel=\"noopener\">EasyAsk</a></span><span style=\"color: #869ab8; font-family: 'Source Sans Pro', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, 'Noto Sans', sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol', 'Noto Color Emoji'; font-size: 14.4px;\">.</span></p>",
            ]
        );
    }
}
