<?php

namespace Amplify\System\Backend\Http\Controllers;

use Amplify\System\Backend\Models\Faq;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function faqViewed($faq_id): void
    {
        Faq::findOrFail($faq_id)->increment('no_views');
    }

    public function faqReaction(Request $request): void
    {
        $faq_id = $request->get('faq_id');
        $reaction = $request->get('reaction');

        Faq::findOrFail($faq_id)
            ->when($reaction === 'useful', fn ($query) => $query->increment('useful'))
            ->when($reaction === 'not_useful', fn ($query) => $query->increment('not_useful'));
    }
}
