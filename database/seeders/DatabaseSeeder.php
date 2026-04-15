<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use App\Models\JobOffer;
use App\Models\Slider;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // =====================================================
        // ADMINISTRATEUR
        // =====================================================
        User::updateOrCreate(
            ['email' => 'admin@mimosaflour.com'],
            [
                'name'     => 'Admin Mimosa',
                'email'    => 'admin@mimosaflour.com',
                'password' => Hash::make('Admin@2024!'),
                'is_admin' => true,
            ]
        );

        // =====================================================
        // SLIDERS (utilisent les images présentes dans public/images)
        // =====================================================
        $sliders = [
            [
                'title'       => 'La Qualité au Cœur de Notre Production',
                'subtitle'    => 'Mimosa Flour – Leader de la production de farine de blé de qualité supérieure au Cameroun',
                'image'       => 'sliders/slider1.jpg',
                'button_text' => 'Découvrir nos produits',
                'button_link' => '/produits',
                'order'       => 1,
                'is_active'   => true,
            ],
            [
                'title'       => 'Farine Premium pour Professionnels',
                'subtitle'    => 'Des solutions adaptées aux boulangeries, pâtisseries et industries agroalimentaires',
                'image'       => 'sliders/slider2.jpg',
                'button_text' => 'Nos services',
                'button_link' => '/services',
                'order'       => 2,
                'is_active'   => true,
            ],
            [
                'title'       => 'Rejoignez Notre Équipe Talentueuse',
                'subtitle'    => 'Construisez votre avenir avec Mimosa Flour et participez au développement industriel du Cameroun',
                'image'       => 'sliders/slider3.jpg',
                'button_text' => 'Voir les offres',
                'button_link' => '/carrieres',
                'order'       => 3,
                'is_active'   => true,
            ],
        ];

        // Copier les images de public/images vers storage/public/sliders
        $sourceImages = [
            'slider1.jpg' => public_path('images/slider-minoterie-moderne-saker-farine-de-ble-02-copie-3-qq4g6nbocpyf9lys4yjzo0fvoxwg94bbquyjrktbqw.jpg'),
            'slider2.jpg' => public_path('images/bf068541-d51e-4a93-a5b5-b3fc4a2f7b87.jfif'),
            'slider3.jpg' => public_path('images/16d1942a-3411-4f6c-8f5a-c05abc430fb7 (1).jfif'),
        ];

        $sliderDir = storage_path('app/public/sliders');
        if (!is_dir($sliderDir)) mkdir($sliderDir, 0755, true);

        foreach ($sourceImages as $name => $src) {
            $dst = $sliderDir . '/' . $name;
            if (file_exists($src) && !file_exists($dst)) {
                copy($src, $dst);
            }
        }

        foreach ($sliders as $slider) {
            Slider::updateOrCreate(['title' => $slider['title']], $slider);
        }

        // =====================================================
        // PRODUITS
        // =====================================================
        $productsDir = storage_path('app/public/products');
        if (!is_dir($productsDir)) mkdir($productsDir, 0755, true);

        $productImages = [
            'premium1kg.jpg' => public_path('images/Prenuim1kg.jpg'),
            'premium50kg.jpg' => public_path('images/Prenuim50kg.jpg'),
            'galimoise.jpg'  => public_path('images/galimoise.jpg'),
            'makala.jpg'     => public_path('images/Makala.jpg'),
            'beignet.jpg'    => public_path('images/Beignet saker.jpg'),
            'premium.jpg'    => public_path('images/prenium.jpg'),
        ];

        foreach ($productImages as $name => $src) {
            $dst = $productsDir . '/' . $name;
            if (file_exists($src) && !file_exists($dst)) {
                copy($src, $dst);
            }
        }

        $products = [
            [
                'name'        => 'Farine Premium Mimosa 1kg',
                'description' => 'Notre farine de blé ménagère de qualité supérieure, idéale pour la pâtisserie, les gâteaux, beignets et la cuisine du quotidien. Texture fine et blanche, riche en gluten naturel. Conditionnée dans un emballage hermétique pour préserver la fraîcheur.',
                'image'       => 'products/premium1kg.jpg',
                'price'       => 2500,
                'category'    => 'ménage',
                'weight'      => '1 kg',
                'is_featured' => true,
                'is_active'   => true,
            ],
            [
                'name'        => 'Farine Premium Mimosa 50kg',
                'description' => 'Sac professionnel 50 kg destiné aux boulangeries, hôtels, restaurants et revendeurs en gros. Qualité constante garantie, production journalière. Le choix des professionnels exigeants de tout le Cameroun.',
                'image'       => 'products/premium50kg.jpg',
                'price'       => 95000,
                'category'    => 'industrie',
                'weight'      => '50 kg',
                'is_featured' => true,
                'is_active'   => true,
            ],
            [
                'name'        => 'Farine Galimoise Mimosa',
                'description' => 'Farine spéciale boulangerie à haute teneur en gluten, idéale pour des pains croustillants, baguettes et viennoiseries. La préférée des boulangers professionnels pour des résultats constants et de qualité supérieure.',
                'image'       => 'products/galimoise.jpg',
                'price'       => 45000,
                'category'    => 'boulangerie',
                'weight'      => '25 kg',
                'is_featured' => true,
                'is_active'   => true,
            ],
            [
                'name'        => 'Farine Spéciale Makala',
                'description' => 'Farine spécialement sélectionnée pour la friture. Donne des makala et beignets légers, moelleux et croustillants, sans grumeaux. La farine préférée des vendeurs de beignets dans tout le Cameroun.',
                'image'       => 'products/makala.jpg',
                'price'       => 2800,
                'category'    => 'friture',
                'weight'      => '1 kg',
                'is_featured' => false,
                'is_active'   => true,
            ],
            [
                'name'        => 'Farine Beignets Saker Mimosa',
                'description' => 'Mélange prêt-à-l\'emploi pour beignets traditionnels camerounais. Résultats parfaits à chaque fois, même pour les débutants. Texture aérée, goût authentique.',
                'image'       => 'products/beignet.jpg',
                'price'       => 1500,
                'category'    => 'pâtisserie',
                'weight'      => '500 g',
                'is_featured' => false,
                'is_active'   => true,
            ],
            [
                'name'        => 'Farine Premium Standard Mimosa',
                'description' => 'Farine tout usage, idéale pour un usage quotidien : sauces, soupes, fritures et pâtisseries légères. Format économique pour les familles et les petits commerces.',
                'image'       => 'products/premium.jpg',
                'price'       => 8500,
                'category'    => 'ménage',
                'weight'      => '5 kg',
                'is_featured' => true,
                'is_active'   => true,
            ],
        ];

        foreach ($products as $product) {
            Product::updateOrCreate(['name' => $product['name']], $product);
        }

        // =====================================================
        // OFFRES D'EMPLOI
        // =====================================================
        $jobs = [
            [
                'title'       => 'Ingénieur Qualité Agroalimentaire',
                'description' => "Dans le cadre de son développement, Mimosa Flour recrute un(e) Ingénieur Qualité Agroalimentaire.\n\nMissions principales :\n- Superviser les contrôles qualité en cours de production\n- Analyser les échantillons en laboratoire (humidité, gluten, cendres)\n- Rédiger les rapports de contrôle et assurer la traçabilité\n- Former les opérateurs aux bonnes pratiques d'hygiène\n- Assurer la conformité aux normes ISO et réglementations locales",
                'requirements'=> "Profil recherché :\n- Diplôme en Ingénierie Agroalimentaire ou Sciences des Aliments (Bac+5)\n- Minimum 3 ans d'expérience en industrie agroalimentaire\n- Maîtrise des normes HACCP, ISO 22000\n- Bonne maîtrise du français ; l'anglais est un atout\n- Capacité d'analyse, rigueur et sens du détail",
                'location'    => 'Douala, Cameroun',
                'type'        => 'CDI',
                'deadline'    => now()->addMonths(2)->toDateString(),
                'is_active'   => true,
            ],
            [
                'title'       => 'Technicien de Maintenance Industrielle',
                'description' => "Mimosa Flour recherche un Technicien de Maintenance pour assurer le bon fonctionnement de ses équipements industriels.\n\nMissions :\n- Maintenance préventive et curative des équipements de mouture\n- Diagnostic et réparation des pannes mécaniques et électriques\n- Gestion du stock de pièces de rechange\n- Participation aux projets d'amélioration continue",
                'requirements'=> "Profil :\n- BTS / DUT en Maintenance Industrielle ou Électromécanique\n- Expérience souhaitée : 2 ans minimum en industrie\n- Compétences en mécanique, électrotechnique et automatisme\n- Disponibilité pour astreintes éventuelles",
                'location'    => 'Douala, Cameroun',
                'type'        => 'CDI',
                'deadline'    => now()->addMonths(1)->addDays(15)->toDateString(),
                'is_active'   => true,
            ],
            [
                'title'       => 'Commercial(e) – Grands Comptes',
                'description' => "Pour renforcer son équipe commerciale, Mimosa Flour recrute un(e) Chargé(e) de Développement Commercial.\n\nMissions :\n- Développer et fidéliser un portefeuille de clients professionnels (boulangeries, hôtels, supermarchés)\n- Prospecter de nouveaux clients dans les régions\n- Négocier les contrats de fourniture\n- Atteindre les objectifs de vente trimestriels\n- Assurer le suivi des commandes et la satisfaction client",
                'requirements'=> "Profil :\n- Licence en Commerce, Marketing ou équivalent\n- Minimum 3 ans d'expérience en vente B2B\n- Excellent relationnel et capacité de négociation\n- Permis de conduire obligatoire\n- Connaissance du secteur alimentaire souhaitée",
                'location'    => 'Douala / Régions, Cameroun',
                'type'        => 'CDI',
                'deadline'    => now()->addMonths(2)->addDays(10)->toDateString(),
                'is_active'   => true,
            ],
        ];

        foreach ($jobs as $job) {
            JobOffer::updateOrCreate(['title' => $job['title']], $job);
        }

        $this->command->info('✅ Base de données initialisée avec succès !');
        $this->command->info('👤 Administrateur : admin@mimosaflour.com / Admin@2024!');
        $this->command->info('🛒 ' . Product::count() . ' produits créés');
        $this->command->info('💼 ' . JobOffer::count() . ' offres d\'emploi créées');
        $this->command->info('🖼  ' . Slider::count() . ' slides créées');
    }
}
