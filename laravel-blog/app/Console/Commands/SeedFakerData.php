<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use App\Models\User;
use App\Models\Article;
use App\Models\Categorie;

class SeedFakerData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seed:faker-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return int
     */
    public function handle()
    {
        $faker = Faker::create();
        // $gender = $faker->randomElement(['male', 'female']);
        $gender = $faker->randomElement(['mme', 'mr']);
        foreach (range(1,10) as $index) {
            $userModel = User::find($index);
            $articleModel = Article::find($index);
            $categorieModel = Categorie::find($index);
            $titre=$faker->sentence();
       
            DB::table('categories')->insert([
                'nom' => $faker->sentence(),
                'slug' => $faker->name(),
                'couleur' => $faker->colorName(),
              
              
            ]);
            DB::table('commentaires')->insert([
                'contenu' => $faker->paragraph(),
                'user_id' => $userModel->id,
                'article_id' => $articleModel->id
              
            ]);
             DB::table('media')->insert([
                'src' => $faker->text(),
                'alt' => $faker->word(),
                'article_id' => $articleModel->id
              
            ]);

            DB::table('article_categories')->insert([
               
                'article_id' => $articleModel->id,
                'categorie_id' => $categorieModel->id
              
              
            ]);
         
        }
           DB::table('pages')->insert([
                'titre' => $faker->sentence(),
                'description' => $faker->text(),
                'logo' => $faker->text(),
                'nbre_article' =>  $faker->numberBetween(0, 9),
                'apropos_user' => 1
              
            ]);
        $this->info('Faker data seeded successfully.');
    }

    private function generateSlug($title)
{
    // Nettoyez le titre en remplaçant les caractères non alphabétiques par des tirets
    $slug = preg_replace('/[^a-zA-Z0-9]+/', '-', $title);

    // Supprimez les tirets en début et fin de chaîne
    $slug = trim($slug, '-');

    // Convertissez en minuscules
    $slug = strtolower($slug);

    return $slug;
}
}
