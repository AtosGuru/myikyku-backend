<?php

namespace App\Services;

use App\Models\Feed;
use App\Models\User;

class FeedService
{
    public function findAll(User $user)
    {
        return Feed::where('user_id', '=', $user->id)->get();
    }

    public function make(Array $data)
    {
        $feed = new Feed($data);

        $feed->save();

        return $feed;
    }

    public function find($id)
    {
        return Feed::find($id);
    }
}
