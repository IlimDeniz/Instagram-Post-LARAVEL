<?php

namespace App\Http\Controllers;

use App\Models\InstagramPost;
use App\Models\InstagramUser;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Socialite;

class InstagramController extends Controller
{
    // Instagram'a login yönlendirmesi
    public function loginInstagram()
    {
        return Socialite::driver('instagrambasic')->redirect();
    }

    // Instagram Callback işlemi
    public function instagramCallback()
    {
        try {
            $user = Socialite::driver('instagrambasic')->stateless()->user();
            $accessToken = $user->token;

            // Kullanıcı bilgilerini kaydet
            InstagramUser::updateOrCreate(
                ['username' => $user->getNickname()],
                [
                    'user_id' => $user->getId(),
                    'access_token' => $accessToken,
                    'token_expired_at' => now()->addDays(60), // Token süresi (yaklaşık 60 gün)
                ]
            );

            return redirect('/instagram/posts');
        } catch (\Exception $e) {
            return redirect('/login/instagram')->with('error', 'Instagram login failed');
        }
    }

    // Instagram postlarını çekme
    public function instagramFetchPost(Request $request)
    {
        // Kullanıcı verilerini çek
        $instagramUser = InstagramUser::first();
        if (!$instagramUser) {
            echo "girdi";
            exit;
            return redirect('/login/instagram')->with('error', 'Instagram user not found');
        }

        // Instagram Graph API'den medya verilerini çek
        $response = Http::get("https://graph.instagram.com/{$instagramUser->user_id}/media", [
            'access_token' => $instagramUser->access_token,
            'fields' => 'id,caption,media_url,media_type,permalink,timestamp',
        ]);

        $posts = $response->json()['data'] ?? [];

        // Veritabanına kaydet
        foreach ($posts as $post) {
            InstagramPost::updateOrCreate(
                ['media_id' => $post['id']],
                [
                    'media_type' => $post['media_type'],
                    'media_url' => $post['media_url'],
                    'permalink' => $post['permalink'],
                    'caption' => $post['caption'] ?? null,
                    'posted_at' => Carbon::parse($post['timestamp']),
                ]
            );
        }

        return view('instagram_posts', ['posts' => InstagramPost::all()]);
    }
}
