<?php

namespace App\Http\Controllers;

use App\Models\DokumenPermohonan;
use App\Models\TopikRiset;
use App\Models\TopikUsageStat;
use App\Models\User;
use App\Models\KantorBeaCukai;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{
    // Feature 2: Statistics of employee vs non-employee applicants
    public function getApplicantTypeStats(Request $request)
    {
        $year = $request->get('year', Carbon::now()->year);
        $month = $request->get('month');

        $query = DokumenPermohonan::with('user')
            ->whereYear('created_at', $year);

        if ($month) {
            $query->whereMonth('created_at', $month);
        }

        $totalApplications = $query->count();

        // Count pegawai (non-mahasiswa with instansi)
        $pegawaiCount = $query->clone()
            ->whereHas('user', function ($q) {
                $q->where('kategori', 'nonmahasiswa')->whereNotNull('instansi');
            })->count();

        // Count non-pegawai (mahasiswa + non-mahasiswa without instansi)
        $nonPegawaiCount = $query->clone()
            ->whereHas('user', function ($q) {
                $q->where('kategori', 'mahasiswa')
                  ->orWhere(function ($subQ) {
                      $subQ->where('kategori', 'nonmahasiswa')->whereNull('instansi');
                  });
            })->count();

        return response()->json([
            'total_applications' => $totalApplications,
            'pegawai_count' => $pegawaiCount,
            'non_pegawai_count' => $nonPegawaiCount,
            'pegawai_percentage' => $totalApplications > 0 ? round(($pegawaiCount / $totalApplications) * 100, 2) : 0,
            'non_pegawai_percentage' => $totalApplications > 0 ? round(($nonPegawaiCount / $totalApplications) * 100, 2) : 0,
            'period' => [
                'year' => $year,
                'month' => $month
            ]
        ]);
    }

    // Feature 3: Period statistics - applications per period and popular topics
    public function getPeriodStats(Request $request)
    {
        $year = $request->get('year', Carbon::now()->year);
        $groupBy = $request->get('group_by', 'month'); // month or year

        if ($groupBy === 'month') {
            // Monthly statistics for the year
            $monthlyStats = [];
            for ($month = 1; $month <= 12; $month++) {
                $applicationCount = DokumenPermohonan::whereYear('created_at', $year)
                    ->whereMonth('created_at', $month)
                    ->count();

                $monthlyStats[] = [
                    'month' => $month,
                    'month_name' => Carbon::create($year, $month, 1)->format('M'),
                    'application_count' => $applicationCount
                ];
            }

            // Most popular topics for the year
            $popularTopics = DokumenPermohonan::select('topik_tujuan_riset', DB::raw('count(*) as total'))
                ->whereYear('created_at', $year)
                ->groupBy('topik_tujuan_riset')
                ->orderBy('total', 'desc')
                ->limit(10)
                ->get();

            return response()->json([
                'monthly_stats' => $monthlyStats,
                'popular_topics' => $popularTopics,
                'year' => $year
            ]);
        } else {
            // Yearly statistics
            $yearlyStats = DokumenPermohonan::select(
                    DB::raw('YEAR(created_at) as year'),
                    DB::raw('count(*) as application_count')
                )
                ->groupBy(DB::raw('YEAR(created_at)'))
                ->orderBy('year', 'desc')
                ->limit(5)
                ->get();

            return response()->json([
                'yearly_stats' => $yearlyStats
            ]);
        }
    }

    // Feature 4: Top 10 topics provided by officers and their usage
    public function getTopicUsageStats(Request $request)
    {
        $limit = $request->get('limit', 10);
        $year = $request->get('year', Carbon::now()->year);
        $month = $request->get('month');

        $query = TopikRiset::with(['dokumenPermohonans' => function($q) use ($year, $month) {
            $q->whereYear('created_at', $year);
            if ($month) {
                $q->whereMonth('created_at', $month);
            }
        }]);

        $topics = $query->get()->map(function ($topic) use ($year, $month) {
            $usageCount = $topic->dokumenPermohonans->count();
            return [
                'id' => $topic->id,
                'nama_topik' => $topic->nama_topik,
                'deskripsi' => $topic->deskripsi,
                'usage_count' => $usageCount,
                'created_at' => $topic->created_at
            ];
        })->sortByDesc('usage_count')->take($limit)->values();

        return response()->json([
            'top_topics' => $topics,
            'period' => [
                'year' => $year,
                'month' => $month
            ]
        ]);
    }

    // Feature 5: Office destinations statistics
    public function getOfficeDestinationStats(Request $request)
    {
        $year = $request->get('year', Carbon::now()->year);
        $month = $request->get('month');

        $query = DokumenPermohonan::with('kantorBeaCukai')
            ->whereNotNull('kantor_tujuan')
            ->whereYear('created_at', $year);

        if ($month) {
            $query->whereMonth('created_at', $month);
        }

        $officeStats = $query->select('kantor_tujuan', DB::raw('count(*) as total'))
            ->groupBy('kantor_tujuan')
            ->orderBy('total', 'desc')
            ->get()
            ->map(function ($item) {
                $office = KantorBeaCukai::where('kode_kantor', $item->kantor_tujuan)->first();
                return [
                    'kode_kantor' => $item->kantor_tujuan,
                    'nama_kantor' => $office ? $office->nama_kantor : 'Unknown',
                    'provinsi' => $office ? $office->provinsi : 'Unknown',
                    'kota' => $office ? $office->kota : 'Unknown',
                    'total_applications' => $item->total
                ];
            });

        return response()->json([
            'office_stats' => $officeStats,
            'period' => [
                'year' => $year,
                'month' => $month
            ]
        ]);
    }

    // Feature 6 & 7: Research completion tracking
    public function getResearchCompletionStats(Request $request)
    {
        $currentDate = Carbon::now();

        // Research status distribution
        $statusStats = DokumenPermohonan::select('status_penelitian', DB::raw('count(*) as total'))
            ->where('status', 'diterima') // Only approved research
            ->groupBy('status_penelitian')
            ->get();

        // Overdue research
        $overdueResearch = DokumenPermohonan::where('status', 'diterima')
            ->where('status_penelitian', '!=', 'selesai')
            ->where('deadline_penelitian', '<', $currentDate)
            ->with(['user', 'kantorBeaCukai'])
            ->get();

        // Researchers who cannot get new permits
        $bannedResearchers = User::whereHas('dokumenPermohonans', function ($q) {
            $q->where('dapat_perijinan_lagi', false);
        })->with(['dokumenPermohonans' => function ($q) {
            $q->where('dapat_perijinan_lagi', false);
        }])->get();

        // Completed research with DOI/PDF
        $completedResearch = DokumenPermohonan::where('status_penelitian', 'selesai')
            ->where(function ($q) {
                $q->whereNotNull('doi_number')->orWhereNotNull('file_paper_pdf');
            })
            ->count();

        return response()->json([
            'status_distribution' => $statusStats,
            'overdue_research' => $overdueResearch,
            'banned_researchers' => $bannedResearchers,
            'completed_with_output' => $completedResearch,
            'total_approved_research' => DokumenPermohonan::where('status', 'diterima')->count()
        ]);
    }

    // Dashboard view for statistics
    public function statisticsDashboard()
    {
        return view('dashboard.statistics');
    }

    // Update research status for all overdue research (can be called via cron job)
    public function updateOverdueResearch()
    {
        $overdueCount = 0;
        
        $overdueResearch = DokumenPermohonan::where('status', 'diterima')
            ->where('status_penelitian', '!=', 'selesai')
            ->where('deadline_penelitian', '<', Carbon::now())
            ->get();

        foreach ($overdueResearch as $research) {
            $research->updateResearchStatus();
            $overdueCount++;
        }

        return response()->json([
            'message' => "Updated {$overdueCount} overdue research records",
            'updated_count' => $overdueCount
        ]);
    }
}