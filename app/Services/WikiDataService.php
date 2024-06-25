<?php

namespace App\Services;

use DOMDocument;
use DOMXPath;
use Illuminated\Wikipedia\Wikipedia;

class WikiDataService
{
    protected string $wikiSummary;
    protected string $wikiImg;
    public function setWikiData(string $url)
    { 
        $page = (new Wikipedia)->page(basename($url));

        $zebi = $page->getBody();

        $dom = new DOMDocument();

        @$dom->loadHTML($zebi);
        $xpath = new DOMXPath($dom);

         $plainText = '';
        // // Extract paragraphs (from the first div.iwg-section)
        // $firstSection = $xpath->query('//div[contains(@class, "iwg-section")][1]');
        // if ($firstSection->length > 0) {
        //     // Select all direct child nodes of the first .iwg-section div
        //     $childNodes = $firstSection->item(0)->childNodes;

        //     // Process each child node
        //     foreach ($childNodes as $childNode) {
        //         // Exclude nodes with class iwg-media-desc
        //         if ($childNode->nodeType === XML_TEXT_NODE || ($childNode->nodeName === 'br' && $childNode->parentNode->nodeName === 'div' && strpos($childNode->parentNode->getAttribute('class'), 'iwg-section') !== false)) {
        //             $text = trim($childNode->nodeValue);

        //             // If the node is <br>, append newline to plain text
        //             if ($childNode->nodeName === 'br') {
        //                 $plainText .= "\n";
        //             } else {
        //                 // Append text to plain string with a space
        //                 $plainText .= ' ' . $text;
        //             }
        //         }
        //     }
        // }

        // Extract the main image
        $mainImage = null;
        $imgNodes = $xpath->query('//div[contains(@class, "iwg-media") and contains(@class, "right")]//img');
        if ($imgNodes->length > 0) {
            $mainImage = $imgNodes->item(0)->getAttribute('src');
        }

        // $this->wikiSummary = $plainText;
        $this->wikiImg = $mainImage;
    }
    public function getWikiSummary() : string
    {
        return $this->wikiSummary;
    }

    public function getWikiImg() : string
    {
        return $this->wikiImg;
    }

}