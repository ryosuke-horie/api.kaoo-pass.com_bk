<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMemberRequest;
use App\Http\Requests\UpdateMemberRequest;
use App\Models\Member;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class MemberController extends Controller
{
    protected Member $member;

    protected int $limit_count = 50;

    public function __construct()
    {
        $this->member = new Member();
    }

    /**
     * 会員情報一覧
     */
    public function index(): Response|RedirectResponse
    {
        // ログインユーザー情報を取得
        $user = auth()->user();

        // ログインしていない場合はログイン画面にリダイレクト
        if (!$user) {
            return redirect()->route('login');
        }

        // user（ジム）に紐づく会員情報を取得
        $members = $this->member->getAllMemberByUserId($user->id);

        return Inertia::render('Members/Index', [
            'user' => $user,
            'members' => $members,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        $user = auth()->user();

        return Inertia::render('Members/Create', [
            'user' => $user,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMemberRequest $request): RedirectResponse
    {
        // 会員情報を登録
        $this->member->storeMember($request);

        return redirect()->route('members.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Member $member): Response
    {
        return Inertia::render('Members/Show', [
            'member' => $member,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $member_id): Response
    {
        echo $member_id;

        return Inertia::render('Members/Edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMemberRequest $request, Member $member): Response
    {
        return Inertia::render('Members/Index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $member_id): Response
    {
        echo $member_id;

        return Inertia::render('Members/Index');
    }
}
