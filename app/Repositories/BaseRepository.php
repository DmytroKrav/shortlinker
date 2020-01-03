<?php

namespace App\Repositories;

class BaseRepository
{
    public $model;
    public $sortBy = 'created_at';
    public $sortOrder = 'asc';

    public function all()
    {
        return $this->model
            ->orderBy($this->sortBy, $this->sortOrder)
            ->get();
    }
}