<?php 

namespace app\QueryServices\Shift;

use app\Models\Shift;
use app\UseCases\Shift\IShowUseCaseQueryService;
use Illuminate\Database\Eloquent\Collection;

class ShowUseCaseQueryService implements IShowUseCaseQueryService 
{
    /**
     * @param \DateTimeInterface $start_date
     * @param \DateTimeInterface $end_date
     * @param bool $is_published_edit
     * 
     * @return Collection<int, Shift>
     */
    public function __invoke(
        \DateTimeInterface $start_date, 
        \DateTimeInterface $end_date,
        bool $is_published_edit,
    ): Collection {
        return Shift::with(['shiftAssignments', 'shiftAssignments.user'])
            ->whereBetween('date', [$start_date, $end_date])
            ->when(
                $is_published_edit, 
                fn($builder) => $builder->whereHas('shiftPublishedEvent'),
                fn($builder) => $builder->whereDoesntHave('shiftPublishedEvent'), 
            )
            ->get();
    }
}