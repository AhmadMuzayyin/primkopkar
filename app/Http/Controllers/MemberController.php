<?php

namespace App\Http\Controllers;

use App\Helpers\Toastr;
use App\Http\Requests\MemberRequest;
use App\Models\Member;
use App\Repositories\Member\MemberRepository;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    protected $member;
    public function __construct(MemberRepository $member)
    {
        $this->member = $member;
    }
    public function index()
    {
        $members = $this->member->getAll();
        return view('members.index', compact('members'));
    }
    public function store(MemberRequest $request)
    {
        $request->validated();
        try {
            $this->member->create($request->all());
            Toastr::success('Berhasil menambahkan member');
            return redirect()->route('members.index');
        } catch (\Throwable $th) {
            Toastr::error('Gagal menambahkan member');
            return redirect()->route('members.index');
        }
    }
    public function edit(Member $member)
    {
        return view('members.edit', compact('member'));
    }
    public function update(Member $member, MemberRequest $request)
    {
        $request->validated();
        try {
            $validate['name'] = $request['name'];
            $validate['phone'] = $request['phone'];
            $validate['address'] = $request['address'];
            $this->member->updateData($validate, $member->id);
            Toastr::success('Berhasil merubah data member');
            return redirect()->route('members.index');
        } catch (\Throwable $th) {
            dd($th->getMessage());
            Toastr::error('Gagal merubah data member');
            return redirect()->route('members.index');
        }
    }
    public function destroy(Member $member)
    {
        try {
            $this->member->deleteData($member->id);
            return response()->json(['status' => 'success', 'message' => 'Berhasil menghapus data member']);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error', 'message' => 'Gagal menghapus data member']);
        }
    }
}
