<?php

namespace App\Livewire\QrCode;

use App\Helper\Files;
use App\Models\Area;
use Livewire\Component;
use App\Models\Table;

class QrCodes extends Component
{

    public $areaID = null;

    public function downloadQrCode($tableCode, $branchId)
    {
        return response()->download(
            public_path(Files::UPLOAD_FOLDER . '/qrcodes/qrcode-' . $branchId . '-' . $tableCode . '.png')
        );
    }



    public function render()
    {
        $query = Area::with('tables');

        if (!is_null($this->areaID)) {
            $query = $query->where('id', $this->areaID);
        }

        $query = $query->get();

        return view('livewire.qr-code.qr-codes', [
            'tables' => $query,
            'areas' => Area::get()
        ]);
    }

}
