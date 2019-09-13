<?php

namespace App;

/**
 * Class HttpResponse
 * @package App
 */
class HttpResponse
{
    protected $data = [];

    /**
     * HttpResponse constructor.
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        $this->setData($data);
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @param array $data
     * @return HttpResponse
     */
    public function setData(array $data): self
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @param string $key
     * @param $value
     * @return HttpResponse
     */
    public function addData(string $key, $value): self
    {
        $data = $this->getData();

        $data[$key] = $value;

        return $this->setData($data);
    }

    /**
     * @param string $html
     * @return string
     */
    public static function html($html)
    {
        $response = new self([
            'html' => $html
        ]);

//        echo $response->getData()['html'];
    }

    /**
     * @param array $data
     * @return string
     */
    public static function ajax(array $data = [])
    {
        $response = new self($data);

        echo json_encode($response->getData());
    }
}