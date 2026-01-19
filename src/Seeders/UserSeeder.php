<?php

namespace Amplify\System\Backend\Seeders;

use Amplify\System\Backend\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->data() as $user) {

            $user['password'] = 'password';
            $user['type'] = 'admin';
            $user['is_admin'] = true;
            $user['password_reset_required'] = true;
            $user['enabled'] = true;

            User::create($user);
        }
    }

    public function data(): array
    {
        return [
            [
                'name' => 'Mark Dimmery',
                'email' => 'markd@easyask.com',
            ],
            [
                'name' => 'Nosin Atia',
                'email' => 'nosin.atia@easyask.com',
            ],
            [
                'name' => 'Hafijul Islam',
                'email' => 'hafijul.islam@easyask.com',
            ],
            [
                'name' => 'Srinivas Kotamreddy',
                'email' => 'skotamreddy@easyask.com',
            ],
        ];
    }
}
