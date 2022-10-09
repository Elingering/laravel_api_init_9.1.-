<?php

namespace App\Api;

use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Pagination\LengthAwarePaginator;
use Symfony\Component\HttpFoundation\Response as FoundationResponse;
use Response;

trait ApiResponse
{
    protected int $httpCode = FoundationResponse::HTTP_OK;

    protected array $header = [];

    public function getHttpCode(): int
    {
        return $this->httpCode;
    }

    public function setHttpCode($httpCode)
    {
        $this->httpCode = $httpCode;
        return $this;
    }

    public function getHeader(): array
    {
        return $this->header;
    }

    public function setHeader($header): static
    {
        $this->header = $header;
        return $this;
    }

    /**
     * @param $data
     * @return mixed
     */
    public function respond($data)
    {
        return Response::json($data, $this->getHttpCode(), $this->header);
    }

    /**
     * @param $status
     * @param  array  $data
     * @param  null  $code
     * @return mixed
     */
    public function status($status, array $data, $code = null)
    {

        if ($code) {
            $this->setHttpCode($code);
        }
        $status = [
            'status' => $status,
            'code' => $this->httpCode
        ];

        $data = array_merge($status, $data);
        return $this->respond($data);

    }

    /**
     * @param $message
     * @param  int  $code
     * @param  string  $status
     * @return mixed
     */
    /*
     * 格式
     * data:
     *  code:422
     *  message:xxx
     *  status:'error'
     */
    public function failed($message, $code = FoundationResponse::HTTP_BAD_REQUEST, $status = 'error')
    {

        return $this->setHttpCode($code)->message($message, $status);
    }

    /**
     * @param $message
     * @param  string  $status
     * @return mixed
     */
    public function message($message, $status = "success")
    {

        return $this->status($status, [
            'message' => $message
        ]);
    }

    /**
     * @param  string  $message
     * @return mixed
     */
    public function internalError($message = "Internal Error!")
    {

        return $this->failed($message, FoundationResponse::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * @param  string  $message
     * @return mixed
     */
    public function created($message = "created")
    {
        return $this->setHttpCode(FoundationResponse::HTTP_CREATED)
            ->message($message);

    }

    /**
     * @param $data
     * @param  string  $status
     * @return mixed
     */
    public function success($data, $status = "success")
    {
        // 简化分页显示
        if ($data instanceof AnonymousResourceCollection && $data->resource instanceof LengthAwarePaginator) {
            $data = [
                'page' => $data->resource->currentPage(),
                'pages' => $data->resource->lastPage(),
                'total' => $data->resource->total(),
                'list' => $data->collection,
            ];
            return $this->status($status, compact('data'));
        }

        return $this->status($status, compact('data'));
    }

    /**
     * @param  string  $message
     * @return mixed
     */
    public function notFond($message = 'Not Fond!')
    {
        return $this->failed($message, Foundationresponse::HTTP_NOT_FOUND);
    }
}
