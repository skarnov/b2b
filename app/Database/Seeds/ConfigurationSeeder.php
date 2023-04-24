<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ConfigurationSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'config_name' => 'project_name',
            'config_setting' => 'Evis Technology'
        ];

        $this->db->table('configurations')->insert($data);

        $data = [
            'config_name' => 'contact_email',
            'config_setting' => 'sk.obydullah@gmail.com',
        ];

        $this->db->table('configurations')->insert($data);

        $data = [
            'config_name' => 'admin_email',
            'config_setting' => 'connect@obydullah.com',
        ];

        $this->db->table('configurations')->insert($data);

        $data = [
            'config_name' => 'time_zone',
            'config_setting' => 'Asia/Dhaka',
        ];

        $this->db->table('configurations')->insert($data);

        $data = [
            'config_name' => 'time_format',
            'config_setting' => 'g:i A',
        ];

        $this->db->table('configurations')->insert($data);

        $data = [
            'config_name' => 'date_format',
            'config_setting' => 'F j, Y',
        ];

        $this->db->table('configurations')->insert($data);

        $data = [
            'config_name' => 'address',
            'config_setting' => 'Dhaka, Bangladesh',
        ];

        $this->db->table('configurations')->insert($data);

        $data = [
            'config_name' => 'meta_description',
            'config_setting' => 'Evis Technology is the one-stop IT solution company. We sell domains, provides hosting, and develop software solutions for your business.',
        ];

        $this->db->table('configurations')->insert($data);

        $data = [
            'config_name' => 'facebook_page',
            'config_setting' => 'https://facebook.com/evis.technology',
        ];

        $this->db->table('configurations')->insert($data);

        $data = [
            'config_name' => 'currency_sign',
            'config_setting' => '৳',
        ];

        $this->db->table('configurations')->insert($data);

        $data = [
            'config_name' => 'currency_name',
            'config_setting' => 'BDT',
        ];

        $this->db->table('configurations')->insert($data);

        $data = [
            'config_name' => 'cache_time',
            'config_setting' => '0',
        ];

        $this->db->table('configurations')->insert($data);

        $data = [
            'config_name' => 'recaptcha_sitekey',
            'config_setting' => '6LdcEL4jAAAAAAAVs7eQWS4zWPiwxBcXyL3aWb9_',
        ];

        $this->db->table('configurations')->insert($data);

        $data = [
            'config_name' => 'recaptcha_secret',
            'config_setting' => '6LdcEL4jAAAAAGm-oSksFKE-JqAwerfh7tCmJD3J',
        ];

        $this->db->table('configurations')->insert($data);
    }
}