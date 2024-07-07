<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;


class WikiDataService
{
    public string $urlApi = 'https://en.wikipedia.org/w/api.php';
    public string $url = 'https://en.wikipedia.org/wiki/';
    protected string $wikiSummary;
    protected string $wikiImg = '';

    /**
     * Retrieve and set wikipedia main image with the given wikipedia url
     * 
     * @return void
     */
    public function setWikiData(string $url): void
    {
        $pageTitle = basename($url);

        $params = [
            'action' => 'query',
            'titles' => $pageTitle,
            'prop' => 'pageimages',
            'format' => 'json',
            'pithumbsize' => 500,
        ];

        $query_url = $this->urlApi . '?' . http_build_query($params);

        $response = Http::get($query_url);

        // Check if the request was successful
        if ($response->successful()) {
            $data = $response->json();
            $page_id = key($data['query']['pages']);

            // Check if the thumbnail exists in the response
            if (!empty($data['query']['pages'][$page_id]['thumbnail']['source'])) {
                $this->wikiImg = $data['query']['pages'][$page_id]['thumbnail']['source'];
            }
        }
    }

    /**
     * Retrieve the wiki main image link
     * 
     * @return string
     */
    public function getWikiImg(): string
    {
        return $this->wikiImg;
    }

}