<?php

namespace App\Http\Controllers;

use App\Models\Reclamation;
use App\Models\User;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Carbon\Carbon;


class DashBoardController extends Controller
{
    function index() {

        // retard

        $retard = Reclamation::where('etat', '=', 'Non Traité')
            ->where('created_at', '<=', now()->subDays(5))
            ->count();

        // users

        $startOfMonth = now()->startOfMonth();
        $endOfMonth = now()->endOfMonth();

        $users = User::all()->count();
        $usersMonth = User::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count();

        //semaine

        $semaine = now()->startOfWeek();

        $startOfPreviousWeek = now()->startOfWeek()->subWeek();
        $endOfPreviousWeek = now()->endOfWeek()->subWeek();

        $recSemaine = Reclamation::where('created_at', '>', $semaine)
            ->count();
        $previousWeekreclamationsCount = Reclamation::whereBetween('created_at', [$startOfPreviousWeek, $endOfPreviousWeek])->count();

        if ($previousWeekreclamationsCount == 0) {
            $recSemainePercent = 100;
        } else {
            $recSemainePercent = (($recSemaine - $previousWeekreclamationsCount) / $previousWeekreclamationsCount) * 100;
        }

        //PieChart

        $rec_par_etats = Reclamation::select('etat', DB::raw('count(*) as total'))
            ->groupBy('etat')
            ->get()
            ->toArray();

        $rec_par_etats = array_slice($rec_par_etats, 1);

        //linechart

        $week1_start = now()->startOfWeek()->subWeek();
        $week1_end = now()->endOfWeek()->subWeek();
        $week2_start = now()->startOfWeek()->subWeeks(2);
        $week2_end = now()->endOfWeek()->subWeeks(2);
        $week3_start = now()->startOfWeek()->subWeeks(3);
        $week3_end = now()->endOfWeek()->subWeeks(3);
        $week4_start = now()->startOfWeek()->subWeeks(4);
        $week4_end = now()->endOfWeek()->subWeeks(4);

        $reclamations_week1 = reclamation::whereBetween('created_at', [$week1_start, $week1_end])->count();
        $reclamations_week2 = reclamation::whereBetween('created_at', [$week2_start, $week2_end])->count();
        $reclamations_week3 = reclamation::whereBetween('created_at', [$week3_start, $week3_end])->count();
        $reclamations_week4 = reclamation::whereBetween('created_at', [$week4_start, $week4_end])->count();

        $recWeeks = [
            [
                "period" => array($week1_start, $week1_end),
                "count" => $reclamations_week1
            ],
            [
                "period" => array($week2_start, $week2_end),
                "count" => $reclamations_week2
            ],
            [
                "period" => array($week3_start, $week3_end),
                "count" => $reclamations_week3
            ],
            [
                "period" => array($week4_start, $week4_end),
                "count" => $reclamations_week4
            ]
        ];

        //Histogramme

        $recAnnes = DB::table('reclamations')
            ->selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', '>=', 2021)
            ->groupBy('year', 'month')
            ->get();

        return Inertia::render('Dashboard', [
            'retard' => $retard,
            'users' => $users,
            'usersMonth' => $usersMonth,
            'semaine' => $recSemaine,
            'recSemainePercent' => $recSemainePercent,
            'recParEtats' => $rec_par_etats,
            'recWeeks' => $recWeeks,
            'recAnnes' => $recAnnes
        ]);

    }


}
