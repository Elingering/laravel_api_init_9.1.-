<?php

namespace App\Http\Resources\Api;

use App\Models\Enum\Auser;
use Illuminate\Http\Resources\Json\JsonResource;

class AuserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'status' => Auser::from($this->status)->getStatus(),
            'created_at' => (string) $this->created_at,
            'updated_at' => (string) $this->updated_at
        ];
    }
}
