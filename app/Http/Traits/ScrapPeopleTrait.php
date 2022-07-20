<?php

namespace App\Http\Traits;

use Goutte\Client;

use App\Models\People;
use function PHPUnit\Framework\isEmpty;

trait ScrapPeopleTrait
{
    public function scrap_linkedin_people_data($firstName = 'a', $lastName = null)
    {
        $firstName = empty($firstName) ? 'a' : $firstName;
        $lastName = empty($lastName) ? null : $lastName;

        $url = 'https://www.linkedin.com/pub/dir?firstName='.$firstName.'&lastName='.$lastName.'&trk=people-guest_people-search-bar_search-submit';

        $client = new Client();
        $crawler = $client->request('GET', $url);


        dd($crawler, $url);
        $crawler->filter('.serp-page__results-list > ul > li')->each(function($node) use ($client) {
            $name           = $node->filter('a')->text();
            $subtitle       = $node->filter('.base-search-card__subtitle')->text();
            $external_link  = $node->filter('a')->link()->getUri();
            $country        = $node->filter(' .people-search-card__location ')->text();

            dd($name);
            if($node->filter('.entity-list-meta')->count()){
                $info          = $node->filter(' .entity-list-meta__entities-list ')->text();
            } else {
                $info = null;
            }
            // $detail = $client->request('GET', $external_link);

            $arr = [
                'name'          =>$name,
                'subtitle'      =>$subtitle,
                'country'       =>$country,
                'external_url'  =>$external_link,
                'info'          =>$info,
            ];

            dd($name);

            People::create($arr);
        });

    }
}


?>