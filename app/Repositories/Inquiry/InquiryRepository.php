<?php

namespace App\Repositories\Inquiry;

use App\Domains\Inquiry\IInquiryRepository;
use App\Domains\Inquiry\Inquiry;
use App\Models\Inquiry as InquiryModel;

class InquiryRepository implements IInquiryRepository
{
    /**
     * @param int $id
     * @return InquiryModel|null
     */
    public function find(int $id): InquiryModel
    {
        return InquiryModel::find($id);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection<int, InquiryModel>
     */
    public function findAll(): \Illuminate\Database\Eloquent\Collection
    {
        return InquiryModel::all();
    }

    /**
     * @param \App\Domains\Inquiry\Inquiry $inquiry
     * @return void
     */
    public function create(Inquiry $inquiry): void
    {
        InquiryModel::create($inquiry->convertParams());
    }

    /**
     * @param \App\Domains\Inquiry\Inquiry $inquiry
     * @throws \Exception
     * @return void
     */
    public function update(Inquiry $inquiry): void
    {
        $model = InquiryModel::find($inquiry->id);
        if ($model && is_a($model, InquiryModel::class)) {
            $model->fill($inquiry->convertParams())->save();

            return;
        }

        throw new \Exception('問合せのデータが存在しません。');
    }
}
