<?php

namespace App\Repositories\Inquiry;

use App\Domains\Inquiry\IInquiryRepository;
use App\Domains\Inquiry\Inquiry;
use \App\Models\Inquiry as InquiryModel;

class InquiryRepository implements IInquiryRepository
{
    /**
     * 1件取得
     * 
     * @param int $id
     * @return \App\Models\Inquiry
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
     * 
     * @param \App\Domains\Inquiry\Inquiry $inquiry
     * @return void
     */
    public function create(Inquiry $inquiry): void {
        InquiryModel::create($inquiry->convertParams());
    }

    /**
     * アップデート処理
     * 
     * @param \App\Domains\Inquiry\Inquiry $inquiry
     * @return void
     */
    public function update(Inquiry $inquiry): void {
        $model = InquiryModel::find($inquiry->id);

        if ($model && is_a($model, InquiryModel::class)) {
            InquiryModel::updateOrCreate(
                ['id' => $inquiry->id], 
                $inquiry->convertParams()
            );
        }
        
        throw new \Exception('問合せのデータが存在しません。');
    }
}