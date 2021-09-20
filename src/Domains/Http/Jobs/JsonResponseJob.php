<?php

namespace Photon\Domains\Http\Jobs;

use Photon\Foundation\Job;

class JsonResponseJob extends Job
{
    protected int $status;

    protected array $content;

    protected array $headers;

    protected mixed $options;

    public function __construct($content, $status = 200, array $headers = [], $options = 0)
    {
        $this->content = $content;
        $this->status = $status;
        $this->headers = $headers;
        $this->options = $options;
    }

    public function handle()
    {
        $response = [
            'data' => $this->content,
            'status' => $this->status,
        ];

        return response()->json($response, $this->status, $this->headers, $this->options);
    }
}
