<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use League\Csv\Reader;
use App\Student;

class importStudents extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:students';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import of students from csv files';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $csvLocation = 'csv'; //Folder w storage/app
        $files = Storage::files($csvLocation);

        foreach ($files as $file) {
            $studentCount = 0;
            $filePath = storage_path('app/').$file;
            echo $filePath . PHP_EOL;
            $csv = Reader::createFromPath($filePath);
            $csv->setOffset(1); //because we don't want to insert the header
            $insert = $csv->each(function ($row) use (&$studentCount) {
                $studentCount++;
//                dd(json_encode($row));
                //Do not forget to validate your data before inserting it in your database
                $student = new Student();
                $student->imie = $row[2];
                $student->drugie_imie = $row[3];
                $student->nazwisko = $row[1];
                $student->imie_ojca = $row[4];
                $student->liczba_punktow = $row[5];
                if ($row[7] == 0) {
                    $student->jedna_gwiazdka = false;
                } else {
                    $student->jedna_gwiazdka = true;
                }
                if ($row[8] == 0) {
                    $student->dwie_gwiazdki = false;
                } else {
                    $student->dwie_gwiazdki = true;
                }
                $student->kierunek_id = $row[9];
                //TODO FIX DATA
//                $student->wydzial_short = $row[11];
//                $student->kierunek_short = $row[13];
                $student->save();

                return true;
            });
            echo PHP_EOL . $studentCount . PHP_EOL;
        }
    }
}
