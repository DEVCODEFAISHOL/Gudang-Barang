<?php

namespace App\Http\Controllers\manager;

use App\Http\Controllers\Controller;
use App\Models\Permintaan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PersetujuanController extends Controller
{
    //
      public function index()
    {
        // Tampilkan semua permintaan yang butuh persetujuan
        $permintaans = Permintaan::where('status', 'pending')->with('user', 'details.barang')->latest()->paginate(10);
        return view('manager.persetujuan.index', compact('permintaans'));
    }

    public function show(Permintaan $permintaan)
    {
        if ($permintaan->status !== 'pending') {
            abort(404);
        }
        $permintaan->load(['user', 'details.barang']);
        return view('manager.persetujuan.show', compact('permintaan'));
    }

    // Proses persetujuan
    public function proses(Request $request, Permintaan $permintaan)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
            'catatan' => 'nullable|string',
            'details' => 'required_if:status,approved|array',
            'details.*.id' => 'required|exists:permintaan_details,id',
            'details.*.jumlah_disetujui' => 'required|integer|min:0',
        ]);

        if ($permintaan->status !== 'pending') {
            return back()->with('error', 'Permintaan ini sudah diproses.');
        }

        DB::transaction(function () use ($request, $permintaan) {
            $permintaan->persetujuan()->create([
                'user_id' => Auth::id(),
                'status' => $request->status,
                'catatan' => $request->catatan,
                'tanggal_persetujuan' => Carbon::now(),
            ]);

            $permintaan->update(['status' => $request->status]);

            // Jika disetujui, update jumlah yang disetujui di detail
            if ($request->status == 'approved') {
                foreach ($request->details as $item) {
                    $detail = $permintaan->details()->find($item['id']);
                    if ($detail) {
                        $detail->update(['jumlah_disetujui' => $item['jumlah_disetujui']]);
                    }
                }
            }
        });

        return redirect()->route('manager.persetujuan.index')->with('success', 'Permintaan berhasil di-' . $request->status);
    }
}
