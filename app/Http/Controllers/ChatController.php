<?php

namespace App\Http\Controllers;

use App\Http\Requests\Chat\StoreRequest;
use App\Http\Resources\Chat\ChatResource;
use App\Http\Resources\User\UserResource;
use App\Models\Chat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{
    # СТРАНИЦА ЧАТОВ И ЮЗЕРОВ
    public function index() {
        $users = UserResource::collection(User::where('id', '!=', Auth::id())->get())->resolve();
        $chats = auth()->user()->chats()->get();

        $chats = ChatResource::collection($chats)->resolve();
        return inertia('Chat/Index', compact('users', 'chats'));
    }

    # СОЗДАНИЕ ЧАТА
    public function store(StoreRequest $request) {
        $data = $request->validated();
        $usersIds = array_merge($data['users'], [Auth::id()]);

        $usersIdsString = implode('-', $usersIds);

        try {
            DB::beginTransaction();

            $chat = Chat::firstOrCreate([
                'users' => $usersIdsString
            ], [
                'title' => $data['title']
            ]);

            $chat->users()->sync($usersIds);

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
        }

        $chat = ChatResource::make($chat)->resolve();

        return inertia('Chat/Show', compact('chat'));
    }

    # СТРАНИЦА ЧАТА
    public function show(Chat $chat) {
        $chat = ChatResource::make($chat)->resolve();
        return inertia('Chat/Show', compact('chat'));
    }
}
