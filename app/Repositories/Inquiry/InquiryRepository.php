<?php

namespace App\Repositories\Inquiry;

use App\Domains\Inquiry\IInquiryRepository;
use App\Domains\Inquiry\Inquiry;
use App\Models\Inquiry as InquiryModel;

class InquiryRepository implements IInquiryRepository
{
    /**
     * 1件取得
     */
    public function find(int $id): InquiryModel
    {
        return InquiryModel::find($id);
    }

    public function findAll(): \Illuminate\Database\Eloquent\Collection
    {
        return InquiryModel::all();
    }

    /**
     * インサート処理
     */
    public function create(Inquiry $inquiry): void
    {
        InquiryModel::create($inquiry->convertParams());
    }

    /**
     * アップデート処理
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
