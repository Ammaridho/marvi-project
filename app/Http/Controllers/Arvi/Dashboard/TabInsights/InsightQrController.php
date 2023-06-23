<?php

namespace App\Http\Controllers\Arvi\Dashboard\TabInsights;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Company;
use App\Models\Merchant;

use Spatie\Analytics\Period;

use Google\Analytics\Data\V1beta\BetaAnalyticsDataClient;
use Google\Analytics\Data\V1beta\DateRange;
use Google\Analytics\Data\V1beta\Dimension;
use Google\Analytics\Data\V1beta\Metric;


class InsightQrController extends Controller
{
    
    function index(Request $request){
        $companyCode = $request->companyCode;
        $companyId = Company::where('code',$companyCode)->first()->id;

        $merchants = Merchant::where('company_id',$companyId)
        ->select('name','id','address')
        ->get();

        return view('arvi.backend.dashboard.insights.qr-traffic',
            compact('companyCode','merchants'));
    }
    
    function show(Request $request){
        {
            $companyCode = $request->companyCode;
            $start_date = $request->startDate;
            $end_date   = $request->endDate;
            $merchant = Merchant::find($request->id);
            putenv("GOOGLE_APPLICATION_CREDENTIALS=".
                storage_path('app/analytics/'.
                $merchant->ga_app_credential_json)
            );
            $property_id = $merchant->ga_property_id;
            
            $client = new BetaAnalyticsDataClient();
            
            // Total QR Access.
            $response = $client->runReport([
                'property' => 'properties/' . $property_id,
                'dateRanges' => [
                    new DateRange([
                        'start_date' => $start_date,
                        'end_date' => $end_date,
                    ]),
                ],
                'dimensions' => [new Dimension(
                    [
                        'name' => 'date',
                    ]
                ),
                ],
                'metrics' => [new Metric(
                    [
                        'name' => 'totalUsers',
                    ]
                )
                ]
            ]);
            $data = $response->getRows();
            $totalAccess['date'] = array();
            $totalAccess['user'] = array();
            foreach ($data as $key => $value) {
                $date = strtotime($value->getDimensionValues()[0]->getValue());
                array_push($totalAccess['date'],date('d M', $date));
                array_push($totalAccess['user'],$value->getMetricValues()[0]->getValue());
            }
    
            // Engagement.
            $response = $client->runReport([
                'property' => 'properties/' . $property_id,
                'dateRanges' => [
                    new DateRange([
                        'start_date' => $start_date,
                        'end_date' => $end_date,
                    ]),
                ],
                'dimensions' => [new Dimension(
                    [
                        'name' => 'eventName',
                    ]
                ),
                ],
                'metrics' => [new Metric(
                    [
                        'name' => 'eventCount',
                    ]
                )
                ]
            ]);
            $events = $response->getRows();
    
            // User Acquisition.
            $response = $client->runReport([
                'property' => 'properties/' . $property_id,
                'dateRanges' => [
                    new DateRange([
                        'start_date' => $start_date,
                        'end_date' => $end_date,
                    ]),
                ],
                'dimensions' => [new Dimension(
                    [
                        'name' => 'sessionDefaultChannelGroup',
                    ]
                ),
                ],
                'metrics' => [new Metric(
                    [
                        'name' => 'newUsers',
                    ]
                )
                ]
            ]);
            $userAcquisition = $response->getRows();
    
            // Landing page.
            $response = $client->runReport([
                'property' => 'properties/' . $property_id,
                'dateRanges' => [
                    new DateRange([
                        'start_date' => $start_date,
                        'end_date' => $end_date,
                    ]),
                ],
                'dimensions' => [new Dimension(
                    [
                        'name' => 'landingPage',
                    ]
                ),
                ],
                'metrics' => [new Metric(
                    [
                        'name' => 'sessions',
                    ]
                )
                ]
            ]);
            $landingPage = $response->getRows();
    
            // TITLE.
            $response = $client->runReport([
                'property' => 'properties/' . $property_id,
                'dateRanges' => [
                    new DateRange([
                        'start_date' => $start_date,
                        'end_date' => $end_date,
                    ]),
                ],
                'dimensions' => [new Dimension(
                    [
                        'name' => 'pageTitle',
                    ]
                ),
                ],
                'metrics' => [new Metric(
                    [
                        'name' => 'screenPageViews',
                    ]
                )
                ]
            ]);
            $titlePage = $response->getRows();
    
            // demographic by country.
            $response = $client->runReport([
                'property' => 'properties/' . $property_id,
                'dateRanges' => [
                    new DateRange([
                        'start_date' => $start_date,
                        'end_date' => $end_date,
                    ]),
                ],
                'dimensions' => [new Dimension(
                    [
                        'name' => 'country',
                    ]
                ),
                ],
                'metrics' => [new Metric(
                    [
                        'name' => 'activeUsers',
                    ]
                )
                ]
            ]);
            $demographic = $response->getRows();
    
            // Operating System.
            $response = $client->runReport([
                'property' => 'properties/' . $property_id,
                'dateRanges' => [
                    new DateRange([
                        'start_date' => $start_date,
                        'end_date' => $end_date,
                    ]),
                ],
                'dimensions' => [new Dimension(
                    [
                        'name' => 'country',
                    ]
                ),
                ],
                'metrics' => [new Metric(
                    [
                        'name' => 'activeUsers',
                    ]
                )
                ]
            ]);
            $demographic = $response->getRows();
    
            // By device Category.
            $response = $client->runReport([
                'property' => 'properties/' . $property_id,
                'dateRanges' => [
                    new DateRange([
                        'start_date' => $start_date,
                        'end_date' => $end_date,
                    ]),
                ],
                'dimensions' => [new Dimension(
                    [
                        'name' => 'platform',
                    ]
                ),
                ],
                'metrics' => [new Metric(
                    [
                        'name' => 'activeUsers',
                    ]
                )
                ]
            ]);
            $data = $response->getRows();
            $deviceCategory['platform'] = array();
            $deviceCategory['user'] = array();
            foreach ($data as $key => $value) {
                array_push($deviceCategory['platform'],$value->getDimensionValues()[0]->getValue());
                array_push($deviceCategory['user'],$value->getMetricValues()[0]->getValue());
            }
    
            // Operating System.
            $response = $client->runReport([
                'property' => 'properties/' . $property_id,
                'dateRanges' => [
                    new DateRange([
                        'start_date' => $start_date,
                        'end_date' => $end_date,
                    ]),
                ],
                'dimensions' => [new Dimension(
                    [
                        'name' => 'operatingSystem',
                    ]
                ),
                ],
                'metrics' => [new Metric(
                    [
                        'name' => 'activeUsers',
                    ]
                )
                ]
            ]);
            $data = $response->getRows();
            $operatingSystem['operatingSystem'] = array();
            $operatingSystem['user'] = array();
            foreach ($data as $key => $value) {
                array_push($operatingSystem['operatingSystem'],$value->getDimensionValues()[0]->getValue());
                array_push($operatingSystem['user'],$value->getMetricValues()[0]->getValue());
            }
    
            return view('arvi.backend.dashboard.insights.qr-traffic-detail',
                compact('companyCode','totalAccess','totalAccess','userAcquisition',
                'events','titlePage','landingPage','demographic',
                'deviceCategory','operatingSystem'));
        }
    }

}
