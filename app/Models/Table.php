<?php

namespace App\Models;

use App\Helper\Files;
use App\Traits\HasBranch;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\Label\Font\NotoSans;
use Endroid\QrCode\Label\LabelAlignment;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Symfony\Component\HttpFoundation\File\File;

class Table extends Model
{

    use HasFactory;
    use HasBranch;

    protected $guarded = ['id'];

    public function area(): BelongsTo
    {
        return $this->belongsTo(Area::class);
    }

    public function activeOrder(): HasOne
    {
        return $this->hasOne(Order::class)->whereIn('status', ['billed', 'kot']);
    }

    public function qRCodeUrl(): Attribute
    {
        return Attribute::get(function (): string {
            return asset_url_local_s3('qrcodes/qrcode-' . $this->branch_id . '-' . $this->table_code . '.png');
        });
    }

    public function generateQrCode()
    {
        $result = Builder::create()
            ->writer(new PngWriter())
            ->writerOptions([])
            ->data(route('table_order', [$this->hash]))
            ->encoding(new Encoding('UTF-8'))
            ->errorCorrectionLevel(ErrorCorrectionLevel::High)
            ->size(300)
            ->margin(10)
            ->roundBlockSizeMode(RoundBlockSizeMode::Margin)
            ->labelText(__('modules.table.table') . ' ' . $this->table_code)
            ->labelFont(new NotoSans(20))
            ->labelAlignment(LabelAlignment::Center)
            ->validateResult(false)
            ->build();

        Files::createDirectoryIfNotExist('qrcodes');
        $filePath = public_path(Files::UPLOAD_FOLDER . '/qrcodes/qrcode-' . $this->branch_id . '-' . $this->table_code . '.png');
        $result->saveToFile($filePath);
        // Store to file_storage database table so as we can delete in future
        Files::fileStore(new File($filePath), 'qrcodes', 'qrcode-' . $this->branch_id . '-' . $this->table_code . '.png', uploaded: false);

    }

    public function activeWaiterRequest(): HasOne
    {
        return $this->hasOne(WaiterRequest::class)->where('status', 'pending');
    }

    public function waiterRequests(): HasMany
    {
        return $this->hasMany(WaiterRequest::class);
    }

}
