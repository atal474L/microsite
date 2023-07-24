<?php


namespace App\Http\Admin\Controllers;

use App\Http\Admin\Requests\SocialMediaAccountStoreRequest;
use App\Http\Controller;
use App\Models\SocialMedia;
use App\Models\SocialMediaAccount;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SocialMediaAccountController extends Controller
{
    public function index(Request $request)
    {
        $socialMedias = SocialMedia::pluck('name', 'id');

        $accounts = SocialMediaAccount::with(['socialMedia', 'posts' => function(HasMany $query) {
            $query->whereHas('photos')
                ->with('photos')
                ->orderByDesc('posted_at');
        }])
            ->withCount('posts')
            ->where('user_id', '=', $request->user()->id)
            ->get();

        return view('admin.socialMediaAccounts.index', [
            'socialMedias' => $socialMedias,
            'accounts' => $accounts,
        ]);
    }

    public function store(SocialMediaAccountStoreRequest $request): RedirectResponse
    {
        $request->user()->socialMediaAccounts()->create($request->validated());

        return redirect()->route('admin.index');
    }

    public function destroy(SocialMediaAccount $account): RedirectResponse
    {
        $account->delete();
        return redirect()->route('admin.index');
    }


}
