<?php

namespace App\Http\Controllers\API;

use App\Services\FeedService;
use Illuminate\Http\Request;

class FeedController extends Controller
{
    protected $feedService;

    public function __construct(FeedService $feedService)
    {
        $this->feedService = $feedService;
    }

    public function findAll()
    {
        $user = $this->getAccount();

        return response()->json([
            'feeds' => $this->feedService->findAll($user)
        ]);
    }

    public function find($id)
    {
        $feed = $this->feedService->find($id);

        return response()->json([
            'feed' => $feed
        ]);
    }

    public function create(Request $request)
    {
        $user = $this->getAccount();
        $feed = $this->feedService->make([
            'user_id' => $user->id,
            'title' => $request->title,
            'rss_link' => $request->rss_link,
            'website_link' => $request->website_link,
            'copyright' => $request->copyright,
        ]);

        return response()->json([
            'feed' => $feed
        ]);
    }
}
