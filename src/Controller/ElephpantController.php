<?php

namespace App\Controller;

use Bolt\Factory\ContentFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ElephpantController extends AbstractController
{

    /**
     * @Route("/random-elephpant", name="random_elephpant", methods={"GET"})
     */
    public function index(Request $request, HttpClientInterface $httpClient): Response
    {
        $response = $httpClient->request('GET', 'https://unsplash.com/s/photos/elephants');

        $crawler = new Crawler($response->getContent());
        $crawler = $crawler->filterXPath('descendant-or-self::img');

        $imageArray = [];
        $crawler->each(function (Crawler $node) use (&$imageArray) {
            $src = $node->attr('src');
            $alt = $node->attr('alt');

            if ($src && $alt) {
                $imageArray[] = [
                    'src' => $src,
                    'alt' => $alt
                ];
            }
        });

        $imageIndex = rand(0, count($imageArray) - 1);
        $imageAtRandom = false;
        if ($imageIndex >= 0) {
            $imageAtRandom = $imageArray[$imageIndex];
        }

        if ($imageAtRandom) {
            return $this->json([
                'status' => Response::HTTP_OK,
                'image' => $imageAtRandom,
            ]);
        }

        return $this->json([
            'status' => Response::HTTP_NOT_FOUND,
            'message' => 'No image found',
        ]);
    }

    /**
     * @Route("/random-elephpant", name="store_elephpant", methods={"POST"})
     */
    public function storeImage(Request $request, ContentFactory $contentFactory): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $query = $request->getContent();
        $query = json_decode($query, true);
        $src = "";
        $alt = "";

        if (isset($query['src'])) {
            $src = $query['src'];
        }

        if (isset($query['alt'])) {
            $alt = $query['alt'];
        }

        if ($src && $alt) {
            $elephpantContent = $contentFactory->upsert('elephpant', 
                [
                    'name' => 'Random Elephpant',
                ]
            );

            $elephpantContent->setFieldValue('src', $src);
            $elephpantContent->setFieldValue('alt', $alt);
            $elephpantContent->setFieldValue('slug', 'random-elephpant');

            $contentFactory->save($elephpantContent);
            return $this->json(['status' => Response::HTTP_OK, 'image' => ['src' => $src, 'alt' => $alt]]);
        }

        return $this->json(['status' => Response::HTTP_INTERNAL_SERVER_ERROR]);
    }
}