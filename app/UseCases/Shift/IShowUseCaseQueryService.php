<?php

namespace app\UseCases\Shift;

use Illuminate\Database\Eloquent\Collection;

interface IShowUseCaseQueryService
{
    /**
     * @param \DateTimeInterface $start_date
     * @param \DateTimeInterface $end_date
     * @param bool $is_published_edit
     * 
     * @return Collection<int, \app\Models\Shift>
     */
    public function __invoke(\DateTimeInterface $start_date, \DateTimeInterface $end_date, bool $is_published_edit): Collection;
}