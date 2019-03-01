<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 12/12/18
 * Time: 15:34
 */
namespace Memed\Services;
use Illuminate\Support\Facades\Cache;
use Ixudra\Curl\Facades\Curl;
use Memed\Regex\RegexMemed;
use \Memed\Curls\Curl as CurlPerson;

class MedicalServices
{

    protected $curl;
    protected $regexMemed;

    public function __construct( CurlPerson $curl,RegexMemed $regexMemed)
    {
        $this->curl = $curl;
        $this->regexMemed = $regexMemed;
    }

    public function processCrawlerMemed($search)
    {

        $data = [];

        if(!Cache::has('token')) {

            $data_raw = '{"email":"fernandojoly@hotmail.com","password":"123456"}';
            $url_base = 'https://api.memed.com.br/v1/login';
            $headers = ['X-Requested-With: XMLHttpRequest', 'Content-Type: application/json; charset=utf-8'];

            $page = $this->curl->exeCurl(
                [
                    CURLOPT_URL => $url_base,
                    CURLOPT_HTTPHEADER => $headers,
                    CURLOPT_COOKIESESSION => true,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_POSTFIELDS => $data_raw
                ]

            );

            Cache::store('file')->put('status_url', $this->curl->statuspageCurl(), 86400);
        }
        if (Cache::get('status_url') == 200) {

            if(!Cache::has('token')) {
                $token = $this->regexMemed->capturaToken($page);
                Cache::store('file')->put('token', $token, 86400);
            }else{
                $token = Cache::get('token');
            }


            $header = ['Accept: application/vnd.api+json; charset=utf-8; Content-Type: application/json'];

            $response = Curl::to('https://api.memed.com.br/v1/apresentacoes')
                ->withHeaders($header)
                ->withData(array(
                    'filter[categoria]' => 'industrializados',
                    'filter[q]' => $search,
                    'filter[origem]' => 'Prescrição',
                    'page[limit]' => 500,
                    'page[offset]' => 0,
                    'token' => $token))
                ->get();

            $results = json_decode($response, true);


            foreach ($results as $key => $items){
                foreach ($items as $item){
                    if(isset($item['attributes']))
                        $data['attributes'][] = $item['attributes'];

                }
            }


            $total_page = (int)($results['meta']['total'] / $results['meta']['limit']);
            $data['total'] = $results['meta']['total'];

            if(isset($results['links']['next'])) {
                $links = $this->regexMemed->capturaLinks($results['links']['next']);

                for ($i = 0; $i <= $total_page; $i++) {

                    $response = Curl::to($links . 'page[offset]=' . $i * 100)
                        ->withHeaders($header)
                        ->get();

                    $results_two = json_decode($response, true);

                    foreach ($results_two as $key => $items) {
                        foreach ($items as $item) {
                            if (isset($item['attributes']))
                                $data['attributes'][] = $item['attributes'];
                        }
                    }
                }
                return $data;
            }else{
                return $data;
            }
        }
        return $data['status_url'] = $this->curl->statuspageCurl();
    }

}