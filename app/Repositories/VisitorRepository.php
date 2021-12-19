<?php

namespace App\Repositories;

use App\Models\Visitor;
use Carbon\Carbon;

class VisitorRepository
{
    protected $visitor;

    public function __construct(Visitor $visitor)
    {
        $this->visitor = $visitor;
    }

    public function getAll()
    {
        return $this->visitor->all();
    }

    public function count()
    {
        return $this->visitor->count();
    }

    public function countByDate($date)
    {
        $now = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s');
        return $this->visitor->whereBetween('time', [$date, $now])->count();
    }

    public function countByDevice($device)
    {
        return $this->visitor->where("device", $device)->count();
    }
}
