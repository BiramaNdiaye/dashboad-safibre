<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TypeTache;

class TypeTacheSeeder extends Seeder
{
    public function run()
    {
        TypeTache::create(['nom' => 'ROP', 'description' => 'Tâche de type ROP']);
        TypeTache::create(['nom' => 'BLO', 'description' => 'Tâche de type BLO']);
        TypeTache::create(['nom' => 'DOE', 'description' => 'Tâche de type DOE']);
        TypeTache::create(['nom' => 'Accompagnement', 'description' => 'Tâche de type Accompagnement']);
        TypeTache::create(['nom' => 'Production APD + DOE GC', 'description' => 'Tâche de type Production APD + DOE GC']);
    }
}