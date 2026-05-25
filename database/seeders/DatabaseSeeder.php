<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Vendor;
use App\Models\Product;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ========== ADMIN ==========
        User::create([
            'name'      => 'Admin MaliMarket',
            'email'     => 'admin@malimarket.ml',
            'password'  => Hash::make('admin123'),
            'role'      => 'admin',
            'telephone' => '+223 90 85 93 91',
            'is_active' => true,
        ]);

        // ========== VENDEURS ==========
        $vendeur1 = User::create([
            'name'      => 'Mamadou Diallo',
            'email'     => 'mamadou@malimarket.ml',
            'password'  => Hash::make('vendeur123'),
            'role'      => 'vendeur',
            'telephone' => '+223 76 11 22 33',
        ]);

        $vendeur2 = User::create([
            'name'      => 'Fatoumata Coulibaly',
            'email'     => 'fatoumata@malimarket.ml',
            'password'  => Hash::make('vendeur123'),
            'role'      => 'vendeur',
            'telephone' => '+223 65 44 55 66',
        ]);

        $vendeur3 = User::create([
            'name'      => 'Ibrahim Keita',
            'email'     => 'ibrahim@malimarket.ml',
            'password'  => Hash::make('vendeur123'),
            'role'      => 'vendeur',
            'telephone' => '+223 79 77 88 99',
        ]);

        // ========== BOUTIQUES ==========
        $boutique1 = Vendor::create([
            'user_id'      => $vendeur1->id,
            'nom_boutique' => 'Diallo Téléphones',
            'slug'         => 'diallo-telephones',
            'description'  => 'Spécialiste en téléphones et accessoires à Bamako',
            'telephone'    => '+223 76 11 22 33',
            'adresse'      => 'Marché de Médina, Bamako',
            'ville'        => 'Bamako',
            'statut'       => 'approuve',
        ]);

        $boutique2 = Vendor::create([
            'user_id'      => $vendeur2->id,
            'nom_boutique' => 'Mode Africaine Fato',
            'slug'         => 'mode-africaine-fato',
            'description'  => 'Vêtements et pagnes africains de qualité',
            'telephone'    => '+223 65 44 55 66',
            'adresse'      => 'Quartier du Fleuve, Bamako',
            'ville'        => 'Bamako',
            'statut'       => 'approuve',
        ]);

        $boutique3 = Vendor::create([
            'user_id'      => $vendeur3->id,
            'nom_boutique' => 'Ibrahim Électronique',
            'slug'         => 'ibrahim-electronique',
            'description'  => 'Électronique et informatique au meilleur prix',
            'telephone'    => '+223 79 77 88 99',
            'adresse'      => 'ACI 2000, Bamako',
            'ville'        => 'Bamako',
            'statut'       => 'approuve',
        ]);

        // ========== CATEGORIES ==========
        $cats = [
            ['nom' => 'Téléphones',   'image' => 'images/categories/telephones.jpg'],
            ['nom' => 'Vêtements',    'image' => 'images/categories/vetements.jpg'],
            ['nom' => 'Chaussures',   'image' => 'images/categories/chaussures.jpg'],
            ['nom' => 'Électronique', 'image' => 'images/categories/electronique.jpg'],
            ['nom' => 'Alimentation', 'image' => 'images/categories/alimentation.jpg'],
            ['nom' => 'Artisanat',    'image' => 'images/categories/artisanat.jpg'],
            ['nom' => 'Beauté',       'image' => 'images/categories/beaute.jpg'],
            ['nom' => 'Informatique', 'image' => 'images/categories/informatique.jpg'],
        ];

        $categories = [];
        foreach ($cats as $cat) {
            $categories[] = Category::create([
                'nom'    => $cat['nom'],
                'slug'   => Str::slug($cat['nom']),
                'image'  => $cat['image'],
                'active' => true,
            ]);
        }

        // ========== PRODUITS ==========
        $products = [
            // Téléphones
            [
                'vendor_id'   => $boutique1->id,
                'category_id' => $categories[0]->id,
                'nom'         => 'Samsung Galaxy A54',
                'description' => 'Smartphone Samsung Galaxy A54 5G, écran 6.4 pouces, 128Go, caméra 50MP. Parfait pour les photos et vidéos.',
                'prix'        => 285000,
                'prix_promo'  => 265000,
                'stock'       => 15,
                'image'       => 'images/products/samsung.jpg',
                'statut'      => 'actif',
            ],
            [
                'vendor_id'   => $boutique1->id,
                'category_id' => $categories[0]->id,
                'nom'         => 'iPhone 13',
                'description' => 'Apple iPhone 13, 128Go, couleur noir minuit. Batterie longue durée, appareil photo professionnel.',
                'prix'        => 550000,
                'prix_promo'  => null,
                'stock'       => 8,
                'image'       => 'images/products/iphone.jpg',
                'statut'      => 'actif',
            ],
            [
                'vendor_id'   => $boutique1->id,
                'category_id' => $categories[0]->id,
                'nom'         => 'Tecno Spark 10',
                'description' => 'Tecno Spark 10, écran 6.6 pouces HD+, 128Go ROM, batterie 5000mAh. Idéal pour le quotidien.',
                'prix'        => 95000,
                'prix_promo'  => 85000,
                'stock'       => 25,
                'image'       => 'images/products/tecno.jpg',
                'statut'      => 'actif',
            ],
            // Vêtements
            [
                'vendor_id'   => $boutique2->id,
                'category_id' => $categories[1]->id,
                'nom'         => 'Boubou Brodé Homme',
                'description' => 'Magnifique boubou brodé pour homme, tissu bazin riche, disponible en plusieurs couleurs. Parfait pour les cérémonies.',
                'prix'        => 45000,
                'prix_promo'  => null,
                'stock'       => 20,
                'image'       => 'images/products/boubou.jpg',
                'statut'      => 'actif',
            ],
            [
                'vendor_id'   => $boutique2->id,
                'category_id' => $categories[1]->id,
                'nom'         => 'Robe Pagne Africain',
                'description' => 'Belle robe en pagne africain, coupe moderne et élégante. Idéale pour toutes occasions.',
                'prix'        => 35000,
                'prix_promo'  => 28000,
                'stock'       => 15,
                'image'       => 'images/products/robe.jpg',
                'statut'      => 'actif',
            ],
            [
                'vendor_id'   => $boutique2->id,
                'category_id' => $categories[1]->id,
                'nom'         => 'T-Shirt Mali',
                'description' => 'T-Shirt avec motifs maliens, coton 100%, très confortable. Disponible en toutes tailles.',
                'prix'        => 8500,
                'prix_promo'  => null,
                'stock'       => 50,
                'image'       => 'images/products/tshirt.jpg',
                'statut'      => 'actif',
            ],
            // Chaussures
            [
                'vendor_id'   => $boutique2->id,
                'category_id' => $categories[2]->id,
                'nom'         => 'Sandale Artisanale Cuir',
                'description' => 'Sandale en cuir véritable fabriquée artisanalement au Mali. Confortable et durable.',
                'prix'        => 18000,
                'prix_promo'  => 15000,
                'stock'       => 30,
                'image'       => 'images/products/sandale.jpg',
                'statut'      => 'actif',
            ],
            [
                'vendor_id'   => $boutique2->id,
                'category_id' => $categories[2]->id,
                'nom'         => 'Baskets Nike Air',
                'description' => 'Nike Air Max, semelle confortable, design moderne. Parfait pour le sport et le quotidien.',
                'prix'        => 75000,
                'prix_promo'  => null,
                'stock'       => 12,
                'image'       => 'images/products/baskets.jpg',
                'statut'      => 'actif',
            ],
            // Électronique
            [
                'vendor_id'   => $boutique3->id,
                'category_id' => $categories[3]->id,
                'nom'         => 'TV Samsung 43 pouces',
                'description' => 'Téléviseur Samsung 43 pouces 4K Ultra HD Smart TV. Son et image parfaits pour votre salon.',
                'prix'        => 320000,
                'prix_promo'  => 295000,
                'stock'       => 5,
                'image'       => 'images/products/tv.jpg',
                'statut'      => 'actif',
            ],
            [
                'vendor_id'   => $boutique3->id,
                'category_id' => $categories[3]->id,
                'nom'         => 'Climatiseur Hisense 1.5CV',
                'description' => 'Climatiseur Hisense 1.5 CV, économique en énergie, très silencieux. Installation incluse à Bamako.',
                'prix'        => 285000,
                'prix_promo'  => null,
                'stock'       => 8,
                'image'       => 'images/products/climatiseur.jpg',
                'statut'      => 'actif',
            ],
            // Informatique
            [
                'vendor_id'   => $boutique3->id,
                'category_id' => $categories[7]->id,
                'nom'         => 'Laptop HP 15 pouces',
                'description' => 'HP Laptop 15 pouces, Intel Core i5, 8Go RAM, 256Go SSD. Parfait pour le travail et les études.',
                'prix'        => 495000,
                'prix_promo'  => 465000,
                'stock'       => 6,
                'image'       => 'images/products/laptop.jpg',
                'statut'      => 'actif',
            ],
            [
                'vendor_id'   => $boutique3->id,
                'category_id' => $categories[7]->id,
                'nom'         => 'Imprimante Canon PIXMA',
                'description' => 'Imprimante Canon PIXMA multifonction, impression couleur, scanner, copie. Idéale pour bureau.',
                'prix'        => 85000,
                'prix_promo'  => null,
                'stock'       => 10,
                'image'       => 'images/products/imprimante.jpg',
                'statut'      => 'actif',
            ],
            // Artisanat
            [
                'vendor_id'   => $boutique2->id,
                'category_id' => $categories[5]->id,
                'nom'         => 'Sculpture Bois Artisanale',
                'description' => 'Magnifique sculpture en bois faite à la main par des artisans maliens. Décoration unique.',
                'prix'        => 25000,
                'prix_promo'  => null,
                'stock'       => 10,
                'image'       => 'images/products/sculpture.jpg',
                'statut'      => 'actif',
            ],
            [
                'vendor_id'   => $boutique2->id,
                'category_id' => $categories[5]->id,
                'nom'         => 'Sac Bogolan Malien',
                'description' => 'Sac en tissu bogolan authentique du Mali, fait main. Unique et original.',
                'prix'        => 15000,
                'prix_promo'  => 12000,
                'stock'       => 20,
                'image'       => 'images/products/sac.jpg',
                'statut'      => 'actif',
            ],
            // Beauté
            [
                'vendor_id'   => $boutique2->id,
                'category_id' => $categories[6]->id,
                'nom'         => 'Karité Pur du Mali',
                'description' => 'Beurre de karité 100% naturel et pur, récolté au Mali. Hydratant pour peau et cheveux.',
                'prix'        => 5000,
                'prix_promo'  => null,
                'stock'       => 100,
                'image'       => 'images/products/karite.jpg',
                'statut'      => 'actif',
            ],
            // Alimentation
            [
                'vendor_id'   => $boutique2->id,
                'category_id' => $categories[4]->id,
                'nom'         => 'Huile de Karité Alimentaire',
                'description' => 'Huile de karité 100% naturelle, idéale pour la cuisine africaine. Produit local du Mali.',
                'prix'        => 3500,
                'prix_promo'  => null,
                'stock'       => 50,
                'image'       => 'images/products/huile.jpg',
                'statut'      => 'actif',
            ],
            [
                'vendor_id'   => $boutique2->id,
                'category_id' => $categories[4]->id,
                'nom'         => 'Café Touba du Mali',
                'description' => 'Café Touba authentique, aromatisé aux épices. Boisson traditionnelle très appréciée.',
                'prix'        => 2500,
                'prix_promo'  => 2000,
                'stock'       => 100,
                'image'       => 'images/products/cafe.jpg',
                'statut'      => 'actif',
            ],
            [
                'vendor_id'   => $boutique2->id,
                'category_id' => $categories[4]->id,
                'nom'         => 'Mil Local du Mali',
                'description' => 'Mil 100% local cultivé au Mali. Idéal pour le tô, le dégué et autres plats traditionnels.',
                'prix'        => 5000,
                'prix_promo'  => null,
                'stock'       => 80,
                'image'       => 'images/products/mil.jpg',
                'statut'      => 'actif',
            ],
            [
                'vendor_id'   => $boutique2->id,
                'category_id' => $categories[4]->id,
                'nom'         => 'Bissap Séché (Hibiscus)',
                'description' => 'Fleurs de bissap séchées pour faire le jus de bissap, boisson rafraîchissante très populaire au Mali.',
                'prix'        => 1500,
                'prix_promo'  => null,
                'stock'       => 200,
                'image'       => 'images/products/bissap.jpg',
                'statut'      => 'actif',
            ],
        ];

        foreach ($products as $product) {
            Product::create(array_merge($product, [
                'slug' => Str::slug($product['nom']) . '-' . uniqid(),
            ]));
        }
    }
}