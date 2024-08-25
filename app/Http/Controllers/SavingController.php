<?php

namespace App\Http\Controllers;

use App\Http\Requests\SavingTransactionRequest;
use App\Models\Member;
use App\Models\MemberSaving;
use App\Models\SavingCategory;
use App\Models\SavingTrasaction;
use App\Repositories\MemberSaving\MemberSavingRepository;
use App\Repositories\Saving\SavingRepository;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SavingController extends Controller
{
    protected $savingRepository, $memberSavingRepository;
    public function __construct(SavingRepository $savingRepository, MemberSavingRepository $memberSavingRepository)
    {
        $this->savingRepository = $savingRepository;
        $this->memberSavingRepository = $memberSavingRepository;
    }
    public function index()
    {
        $members = Member::all();
        $categories = SavingCategory::all();
        if (request()->ajax()) {
            $saving_members = $this->memberSavingRepository->getMemberSavings();
            return DataTables::of($saving_members)
                ->addIndexColumn()
                ->addColumn('member_name', function ($row) {
                    return $row->member->name;
                })
                ->addColumn('saving_category_name', function ($row) {
                    return $row->savingCategory->name;
                })
                ->addColumn('nominal', function ($row) {
                    return 'Rp. ' . number_format($row->saldo, 0, ',', '.');
                })
                ->addColumn('action', 'savings.include.btn')
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('savings.index', compact('members', 'categories'));
    }
    public function show(Member $member, Request $request)
    {
        $validate = $request->validate([
            'type' => 'required'
        ]);
        try {
            $savings = $this->savingRepository->getSavingByMember($member->id, $validate['type']);
            return response()->json([
                'status' => 'success',
                'message' => 'Data berhasil diambil',
                'data' => $savings->count() > 0 ? $savings : $member
            ]);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage());
        }
    }
    public function store(SavingTransactionRequest $request)
    {
        $validate = $request->validated();
        try {
            $validate['transaction_type'] = 'Setoran';
            $validate['saving_date'] = date('Y-m-d');
            $data = $this->savingRepository->createSaving($validate);
            $saldo = $this->memberSavingRepository->getMemberSavingByMember($validate['member_id'], $validate['saving_category_id']);
            if (!$saldo) {
                $dataSaldo = [
                    'member_id' => $validate['member_id'],
                    'saving_category_id' => $validate['saving_category_id'],
                    'saldo' => $validate['nominal']
                ];
                $this->memberSavingRepository->createMemberSaving($dataSaldo);
            } else {
                $dataSaldo = [
                    'saldo' => $validate['nominal'] + $saldo->saldo
                ];
                $this->memberSavingRepository->updateMemberSaving($dataSaldo, $saldo->id);
            }
            return response()->json([
                'status' => 'success',
                'message' => 'Data berhasil disimpan',
                'data' => $data
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ]);
        }
    }
    public function update(SavingTransactionRequest $request)
    {
        $validate = $request->validated();
        try {
            $validate['transaction_type'] = 'Penarikan';
            $validate['saving_date'] = date('Y-m-d');
            $data = $this->memberSavingRepository->getMemberSavingByMember($validate['member_id'], $validate['saving_category_id']);
            $this->savingRepository->createSaving($validate);
            $saldo = $data->saldo - $validate['nominal'];
            $this->memberSavingRepository->updateMemberSaving(['saldo' => $saldo], $data->id);
            return response()->json([
                'status' => 'success',
                'message' => 'Data berhasil disimpan',
                'data' => $data
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ]);
        }
    }
    public function destroy(MemberSaving $saving)
    {
        try {
            $this->memberSavingRepository->deleteMemberSaving($saving->id);
            return response()->json([
                'status' => 'success',
                'message' => 'Data berhasil dihapus'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ]);
        }
    }
    public function history(MemberSaving $member)
    {
        if (request()->ajax()) {
            $histories = $this->savingRepository->getSavingByMember($member->member_id, $member->saving_category_id);
            return DataTables::of($histories)
                ->addIndexColumn()
                ->addColumn('saving_date', function ($row) {
                    return date('d-m-Y', strtotime($row->saving_date));
                })
                ->addColumn('saving_category_name', function ($row) {
                    return $row->savingCategory->name;
                })
                ->addColumn('nominal', function ($row) {
                    return 'Rp. ' . number_format($row->nominal, 0, ',', '.');
                })
                ->addColumn('type', function ($row) {
                    return $row->transaction_type;
                })
                ->addColumn('action', 'savings.include.btn-history')
                ->rawColumns(['action'])
                ->make(true);
        }
    }
    public function historyDestroy(SavingTrasaction $saving)
    {
        try {
            if ($saving->transaction_type == 'Setoran') {
                $memberSaving = $this->memberSavingRepository->getMemberSavingByMember($saving->member_id, $saving->saving_category_id);
                $saldo = $memberSaving->saldo - $saving->nominal;
                $this->memberSavingRepository->updateMemberSaving(['saldo' => $saldo], $memberSaving->id);
            } elseif ($saving->transaction_type == 'Penarikan') {
                $memberSaving = $this->memberSavingRepository->getMemberSavingByMember($saving->member_id, $saving->saving_category_id);
                $saldo = $memberSaving->saldo + $saving->nominal;
                $this->memberSavingRepository->updateMemberSaving(['saldo' => $saldo], $memberSaving->id);
            }
            $this->savingRepository->delete($saving->id);
            return response()->json([
                'status' => 'success',
                'message' => 'Data berhasil dihapus'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ]);
        }
    }
}
