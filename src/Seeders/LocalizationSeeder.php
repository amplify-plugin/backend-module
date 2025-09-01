<?php

namespace Amplify\System\Backend\Seeders;

use App\Models\Localization;
use Illuminate\Database\Seeder;

class LocalizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $localizations = [
            ['key' => 'Login to your account.', 'lang' => '{"en":"Login to your account.","fr":"Connectez-vous \\u00e0 votre compte.","de":"Log in op jouw account.","it":"Accedi al tuo account."}', 'created_at' => '2022-06-30 15:54:03', 'updated_at' => '2022-06-30 16:10:41'],
            ['key' => 'Featured Products', 'lang' => '{"en":"Featured Products","fr":"Produits populaires","de":"Aanbevolen producten","it":"Prodotti sponsorizzati"}', 'created_at' => '2022-07-01 12:28:36', 'updated_at' => '2022-07-01 12:28:36'],
            ['key' => 'Add to Order', 'lang' => '{"en":"Add to Order","fr":"Ajouter \\u00e0 la commande","de":"Toevoegen aan bestelling","it":"Aggiungi all\'ordine"}', 'created_at' => '2022-07-01 12:30:13', 'updated_at' => '2022-07-01 12:32:00'],
            ['key' => 'Best SELLERS', 'lang' => '{"en":"Best SELLERS","fr":"Meilleurs VENDEURS","de":"Beste VERKOPERS","it":"I migliori venditori"}', 'created_at' => '2022-07-01 12:42:54', 'updated_at' => '2022-07-01 12:42:54'],
            ['key' => 'New Arrivals', 'lang' => '{"en":"New Arrivals","fr":"Nouvelles Arriv\\u00e9es","de":"Nieuw binnen","it":"Nuovi arrivi"}', 'created_at' => '2022-07-01 12:44:53', 'updated_at' => '2022-07-01 12:44:53'],
            ['key' => 'Managers Choice', 'lang' => '{"en":"Managers Choice","fr":"Choix des gestionnaires","de":"Managers keuze","it":"Scelta dei gestori"}', 'created_at' => '2022-07-01 12:45:42', 'updated_at' => '2022-07-01 12:45:42'],
            ['key' => 'Manufacturers', 'lang' => '{"en":"Manufacturers","fr":"Fabricants","de":"fabrikanten","it":"Produttori"}', 'created_at' => '2022-07-01 13:06:59', 'updated_at' => '2022-07-01 13:06:59'],
            ['key' => 'No manufacturers found.', 'lang' => '{"en":"No manufacturers found.","fr":"Aucun fabricant trouv\\u00e9.","de":"Geen fabrikanten gevonden.","it":"Nessun produttore trovato."}', 'created_at' => '2022-07-01 13:07:31', 'updated_at' => '2022-07-01 13:07:31'],
            ['key' => 'Money Back Guarantee', 'lang' => '{"en":"Money Back Guarantee","fr":"Garantie de remboursement","de":"Geldteruggarantie","it":"Soddisfatti o rimborsati"}', 'created_at' => '2022-07-01 13:29:01', 'updated_at' => '2022-07-01 13:29:01'],
            ['key' => '24/7 Customer Support', 'lang' => '{"en":"24\\/7 Customer Support","fr":"Assistance client 24h\\/24 et 7j\\/7","de":"24\\/7 klantenondersteuning","it":"Assistenza clienti 24 ore su 24, 7 giorni su 7"}', 'created_at' => '2022-07-01 13:30:11', 'updated_at' => '2022-07-01 13:30:11'],
            ['key' => 'Secure Online Payment', 'lang' => '{"en":"Secure Online Payment","fr":"Paiement en ligne s\\u00e9curis\\u00e9","de":"Veilig online betalen","it":"Pagamento online sicuro"}', 'created_at' => '2022-07-01 13:31:04', 'updated_at' => '2022-07-01 13:31:04'],
            ['key' => 'We return money within 30 days', 'lang' => '{"en":"We return money within 30 days","fr":"Nous remboursons l\'argent dans les 30 jours","de":"Wij retourneren geld binnen 30 dagen","it":"Restituiamo denaro entro 30 giorni"}', 'created_at' => '2022-07-01 14:17:41', 'updated_at' => '2022-07-01 14:17:41'],
            ['key' => 'Friendly 24/7 customer support', 'lang' => '{"en":"Friendly 24\\/7 customer support","fr":"Support client convivial 24h\\/24 et 7j\\/7","de":"Vriendelijke 24\\/7 klantenondersteuning","it":"Amichevole assistenza clienti 24 ore su 24, 7 giorni su 7"}', 'created_at' => '2022-07-01 14:18:23', 'updated_at' => '2022-07-01 14:18:23'],
            ['key' => 'We posess SSL / Secure Certificate', 'lang' => '{"en":"We posess SSL \\/ Secure Certificate","fr":"Nous poss\\u00e9dons SSL \\/ Secure Certificate","de":"Wij zijn in het bezit van SSL \\/ Secure Certificaat","it":"Possediamo SSL\\/Certificato Sicuro"}', 'created_at' => '2022-07-01 14:19:24', 'updated_at' => '2022-07-01 14:19:24'],
            ['key' => 'Shipping', 'lang' => '{"en":"Shipping","fr":"Exp\\u00e9dition","de":"Verzenden","it":"Spedizione"}', 'created_at' => '2022-07-01 14:20:35', 'updated_at' => '2022-07-01 14:20:35'],
            ['key' => 'Free Worldwide Shipping', 'lang' => '{"en":"Free Worldwide Shipping","fr":"Livraison gratuite \\u00e0 travers le monde","de":"Gratis wereldwijde verzending","it":"Spedizione gratuita in tutto il mondo"}', 'created_at' => '2022-07-01 14:23:53', 'updated_at' => '2022-07-01 14:23:53'],
            ['key' => 'Free shipping for all orders over $100', 'lang' => '{"en":"Free shipping for all orders over $100","fr":"Livraison gratuite pour toutes les commandes de plus de 100 $","de":"Gratis verzending voor alle bestellingen van meer dan $ 100","it":"Spedizione gratuita per tutti gli ordini superiori a $ 100"}', 'created_at' => '2022-07-01 14:24:38', 'updated_at' => '2022-07-01 14:24:38'],
        ];

        Localization::insert($localizations);
    }
}
