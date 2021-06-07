<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class LocationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('locations')->insert([
            [
                'name'=>"Užice",
                'picture_url'=>"https://vilaborova.rs/blog/wp-content/uploads/2017/12/grad_uzice-960x576.jpg",
                'description'=>"Ima komplet lepinju, ništa drugo nije potrebno reći",
                'price'=> 500.00
            ],
            [
                'name'=>"Zlatibor",
                'picture_url'=>"https://upload.wikimedia.org/wikipedia/commons/thumb/a/a1/Zlatibor-vazdušna_banja_006.jpg/1200px-Zlatibor-vazdušna_banja_006.jpg",
                'description'=>"Odmah je pored Užica. A Užice ima komplet lepinju, ništa drugo nije potrebno reći",
                'price'=> 2000.00
            ],
            [
                'name'=>"Sarajevo",
                'picture_url'=>"https://kondortravel.rs/wp-content/uploads/2020/08/sarajevo.jpg",
                'description'=>"Jaka konkurencija Užicu, jer ima ćevape i burek. A ni Užice nije daleko",
                'price'=> 1984.00
            ],
            [
                'name'=>"Mirijevo",
                'picture_url'=>"https://cityexpert.rs/blog/sites/default/files/styles/900x450/public/slika/mirijevo.jpg",
                'description'=>"Jedino što Mirijevo ima su rupe po putu",
                'price'=> 0.56
            ],
            [
                'name'=>"Čortanovci",
                'picture_url'=>"https://ocdn.eu/pulscms-transforms/1/L-_k9lMaHR0cDovL29jZG4uZXUvaW1hZ2VzL3B1bHNjbXMvTVdVN01EQV8vNDIzODk5NjgyZGFkMWQ4MThmOGNhMDU1NmU2MTU1ZmIuanBlZ5GTAs0EsACBAAE",
                'description'=>"Ima najskuplju crkvu u istoriji Srbije reklo bi se",
                'price'=> 123.59
            ]
        ]);
    }
}
