<?php

namespace App\Http\Controllers;

use App\Models\Periode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class Periodecontroller extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if (!$user) {
            abort(403, 'Unauthorized');
        }
        $title = 'Periode Akademik';
        return view('admin.periode.index', compact('title', 'user'));
    }

    public function periode_data()
    {
        $periode = Periode::orderBy('id', 'desc')->get();

        return DataTables::of($periode)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = '<button class="btn btn-warning btn-sm btnEdit" data-id="' . $row->id . '" title="Edit Periode">
                            Edit
                        </button>';
                return $btn;
            })
            ->addColumn('tahun', function ($row) {
                $bt = $row->awal . "/" . $row->akhir;
                return $bt . "";
            })
            ->addColumn('stats', function ($row) {
                if ($row->status == 1) {
                    $badge = '<span class="badge badge-success-light">Aktif</span>';
                } else {
                    $badge = '<span class="badge badge-danger-light">Nonaktif</span>';
                }
                $bt = $badge;
                return $bt . "";
            })
            ->rawColumns(['action', 'tahun', 'stats'])
            ->make(true);
    }
}
