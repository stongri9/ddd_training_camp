<?php

namespace app\UseCases\Shift;

use Illuminate\Database\Eloquent\Collection;

interface IShowUseCaseQueryService
{
    /**
     * @return Collection<int, \app\Models\Shift>
     */
    public function __invoke(\DateTimeInterface $start_date, \DateTimeInterface $end_date, bool $is_published_edit): Collection;
}
