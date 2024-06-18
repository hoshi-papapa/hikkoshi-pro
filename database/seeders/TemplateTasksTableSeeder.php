<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\TemplateTask;
use League\Csv\Reader;

class TemplateTasksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $csv = Reader::createFromPath(database_path('seeders/template_tasks.csv'), 'r');
        $csv->setHeaderOffset(0);
        $records = $csv->getRecords();

        foreach ($records as $record) {
            DB::table('template_tasks')->insert([
                'title' => $record['title'],
                'description' => $record['description'],
                'start_date_offset' => $record['start_date_offset'],
                'end_date_offset' => $record['end_date_offset'],
            ]);
        }
    }
}
