<?php

namespace App\Instagram\Api;

use App\Instagram\Exceptions\InstagramClientException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class Media
{
    protected Client $request;
    protected array $headers;

    public Media $media;

    public function __construct(string $accessToken)
    {
        $this->request = new Client(['base_uri' => $this->getUri()]);
        $this->headers = [
            'Authorization' => 'Bearer '. $accessToken,
            'Accept' => 'application/json',
        ];
    }

    protected function getUri(): string
    {
        $service = config('instagram.base_url');
        $version = config('instagram.version');

        return "$service/$version";
    }

    /**
     * @throws InstagramClientException
     * @throws GuzzleException
     */
    protected function get(string $request,$parameters = [])
    {
        $response = $this->request
            ->request('GET',$request, [
                'headers' => $this->headers,
                'query' => $parameters,
                'http_errors' => false,
            ]);

        if ($response->getStatusCode() !== 200) {
            $error = $response->getBody()->getContents();

            throw new InstagramClientException("Request failed [" . $response->getStatusCode() . "]: $error");
        }

        return json_decode($response->getBody());
    }

    public function getRecentMedia(): array
    {
        $parameters = [
            'fields' => 'id,username,media{media_url,comments_count,like_count,media_type,caption,thumbnail_url,timestamp}',
        ];

        return $this->get('me', $parameters)->media->data ?? [];
    }


    /**
     * @throws InstagramClientException
     * @throws GuzzleException
     */
    public function getAll(): array
    {
        $parameters = [
            'fields' => 'id,username,media{media_url,comments_count,like_count,media_type,caption,thumbnail_url,timestamp}',
        ];

        $data = [];

        do {
            $response = $this->get('me', $parameters);
            $data = array_merge($data, $response->media->data);
        } while (isset($response->media->paging->next));

        return $data;
    }

    /**
     * @throws GuzzleException
     * @throws InstagramClientException
     */
    public function getMediaChildren(int $id)
    {
        $parameters = [
            'fields' => 'id,media_url',
        ];

        return $this->get("$id/children", $parameters);
    }


}
