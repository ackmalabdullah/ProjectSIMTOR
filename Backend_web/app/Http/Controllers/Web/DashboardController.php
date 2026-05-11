<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Motor;
use App\Models\Users;
use App\Models\Admin;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $motors = Motor::all();
        $users = Users::all();
        $admins = Admin::all();

        // dummy simulasi
        $simulasis = collect([
            [
                'user_id' => 'USR001',
                'motor_id' => 'MTR001'
            ],
            [
                'user_id' => 'USR002',
                'motor_id' => 'MTR002'
            ]
        ]);

        return view('dashboard.index', [
            'totalMotor' => $motors->count(),
            'totalUser' => $users->count(),
            'totalAdmin' => $admins->count(),
            'totalSimulasi' => $simulasis->count(),

            'motors' => $motors,
            'users' => $users,
            'admins' => $admins,
            'simulasis' => $simulasis,

            'chartLabels' => ['Motor', 'User', 'Admin', 'Simulasi'],
            'chartData' => [
                $motors->count(),
                $users->count(),
                $admins->count(),
                $simulasis->count()
            ]
        ]);
    }

    // =====================================================
    // EXPORT MOTOR CSV
    // =====================================================

    public function exportMotor()
    {
        $data = Motor::all();

        $csv = "Nama Motor,Harga,Merk,Tipe\n";

        foreach ($data as $item) {
            $csv .= "{$item->nama_motor},{$item->harga},{$item->merk},{$item->tipe}\n";
        }

        return response(
            $csv,
            200,
            [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="motor.csv"',
            ]
        );
    }

    // =====================================================
    // EXPORT USER CSV
    // =====================================================

    public function exportUser()
    {
        $data = Users::all();

        $csv = "Nama,Email,No Telp,Pekerjaan,Gaji\n";

        foreach ($data as $item) {
            $csv .= "{$item->nama},{$item->email},{$item->no_telp},{$item->pekerjaan},{$item->gaji_per_bulan}\n";
        }

        return response(
            $csv,
            200,
            [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="users.csv"',
            ]
        );
    }

    // =====================================================
    // EXPORT ADMIN CSV
    // =====================================================

    public function exportAdmin()
    {
        $data = Admin::all();

        $csv = "Nama,Email,Username\n";

        foreach ($data as $item) {
            $csv .= "{$item->name},{$item->email},{$item->username}\n";
        }

        return response(
            $csv,
            200,
            [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="admins.csv"',
            ]
        );
    }

    // =====================================================
    // EXPORT SIMULASI CSV
    // =====================================================

    public function exportSimulasi()
    {
        $data = [
            ['USR001', 'MTR001'],
            ['USR002', 'MTR002']
        ];

        $csv = "User ID,Motor ID\n";

        foreach ($data as $item) {
            $csv .= "{$item[0]},{$item[1]}\n";
        }

        return response(
            $csv,
            200,
            [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="simulasi.csv"',
            ]
        );
    }
}