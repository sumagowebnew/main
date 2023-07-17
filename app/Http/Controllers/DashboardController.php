<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ContactEnquiries;
use App\Models\CareerEnquiries;
use App\Models\Portfolio;
use App\Models\Achievements;
use App\Models\News;
use App\Models\Certificate;
use App\Models\Mou;
use App\Models\ClientLogo;

use Validator;
class DashboardController extends Controller
{
    public function get_dashboard_count(Request $request)
    {
        $contactEnquiries = ContactEnquiries::count();
        $careerEnquiries = CareerEnquiries::count();
        $portfolios = Portfolio::count();
        // $achievements = Achievements::count();
        $news = News::count();
        $certificates = Certificate::count();
        $mous = Mou::count();
        $clientlogos = ClientLogo::count();
        // return $this->responseApi($contactEnq,'All data get','success',200);
        return response()->json(['contactEnquiries' => $contactEnquiries,
        'careerEnquiries' => $careerEnquiries,
        'portfolios' => $portfolios,
        // 'achievements' => $achievements,
        'news' => $news,
        'certificates' => $certificates,
        'mous' => $mous,
        'clientlogos' => $clientlogos,
        'message' => 'All data fetched successfully','StatusCode'=>'200']);

    }

}
 