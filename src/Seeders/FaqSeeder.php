<?php

namespace Amplify\System\Backend\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Faq::truncate();
        $faqs = [
            ['id' => '1', 'faq_category_id' => '1', 'question' => 'What makes the EasyAsk solution different from other search solutions?', 'response' => '<p>The EasyAsk solution uses a natural language engine to process the user&rsquo;s query. This means that EasyAsk understands the query no matter how it is entered. Consider the following 2 examples: black mens waterproof jacket Men&rsquo;s rainproof coat in black EasyAsk treats both of these queries as the same, recognising that &ldquo;mens&rdquo; and &ldquo;man&rsquo;s&rdquo; are gender constraints, &ldquo;jacket&rdquo; and &ldquo;coat&rdquo; are synonymous (in this context), and &ldquo;black&rdquo; is a color attribute. EasyAsk also knows how to handle the non‐product terms in a search (such as &ldquo;in&rdquo; above), meaning that verbose long‐tail searches can be processed correctly: &ldquo;I&rsquo;m looking for a long‐sleeved cotton top in blue for not more than $25&rdquo; The ability to handle such searches and return exactly the right products makes EasyAsk the ideal solution as more and more customers turn to voice input when shopping on Smartphones. With tuneable relevance, term relaxation, term redefinition, search redirects, intelligent spell‐ correction and concept matching (instead of keyword matching), EasyAsk natural language search ensures the customer sees the right products every time.</p>', 'no_views' => '242', 'useful' => '56', 'not_useful' => '2', 'created_at' => '2022-05-17 08:17:01', 'updated_at' => '2022-05-17 10:28:49'],
            ['id' => '2', 'faq_category_id' => '1', 'question' => 'Will EasyAsk work with my new responsive site?', 'response' => '<p>Yes. EasyAsk works at a data level, leaving your front‐end code to decide how any displays should appear. This means it will work exactly the same with your desktop site, your responsive site or even your dedicated mobile site or application.</p>', 'no_views' => '12', 'useful' => '10', 'not_useful' => '0', 'created_at' => '2022-05-17 09:22:59', 'updated_at' => '2022-05-17 10:28:42'],
            ['id' => '3', 'faq_category_id' => '2', 'question' => 'What does “actionable analytics” mean?', 'response' => '<p>When viewing EasyAsk analytics reports within our Commerce Studio tool, all report entries are &ldquo;live&rdquo; links. Clicking on them will show instant preview of results and each entry, where applicable, will have an &ldquo;edit&rdquo; icon that allows the user to immediately analyse and fix problem areas.</p>', 'no_views' => '123', 'useful' => '100', 'not_useful' => '5', 'created_at' => '2022-05-17 09:23:47', 'updated_at' => '2022-05-17 10:28:36'],
        ];
        Faq::insert(($faqs));
    }
}
