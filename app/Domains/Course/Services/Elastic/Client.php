<?php
namespace App\Domains\Product\Services\Elastic;

use Elasticsearch\Client as ESClient;

class Client
{
    protected $client;

    public function __construct(ESClient $client)
    {
        $this->client = $client;
    }

    /**
     * Index a single item
     *
     * @param  array  $parameters [index, type, id, body]
     */
    public function create(array $parameters)
    {
        return $this->client->indices()->create($parameters);
    }

    /**
     * Index a single item
     *
     * @param  array  $parameters [index, type, id, body]
     */
    public function mapping(array $parameters)
    {
        return $this->client->indices()->putMapping($parameters);
    }

    /**
     * Index a single item
     *
     * @param  array  $parameters [index, type, id, body]
     */
    public function index(array $parameters)
    {
        return $this->client->index($parameters);
    }

    /**
     * Delete a single item
     *
     * @param  array  $parameters
     */
    public function delete(array $parameters)
    {
        return $this->client->delete($parameters);
    }

    /**
     * Delete all items
     *
     * @param  array  $parameters
     */
    public function truncate(array $parameters)
    {
        return $this->client->indices()->delete($parameters);
    }

    public function search(string $index, array $parameters)
    {
        $indexParams = [
            'index' => $index,
            'type' => '_doc'
        ];
		$indexParams['body']  = $parameters;
        $response = $this->client->search($indexParams);

        return $response;
    }
}
?>