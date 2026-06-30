<?php
namespace App\Http\Controllers\Voyager;

use App\Models\Marketer;
use Illuminate\Http\Request;
use TCG\Voyager\Facades\Voyager;
use TCG\Voyager\Http\Controllers\VoyagerBaseController;
use TCG\Voyager\Models\DataType;
use TCG\Voyager\Actions\DeleteAction;
use TCG\Voyager\Actions\ViewAction;
use TCG\Voyager\Actions\EditAction;

class MarketerController extends VoyagerBaseController
{
    public function index(Request $request)
    {
        $slug = 'marketers';
        $dataType = DataType::where('slug', $slug)->firstOrFail();

        // بررسی استفاده از SoftDeletes
        $usesSoftDeletes = method_exists(Marketer::class, 'bootSoftDeletes');

        // دریافت داده‌ها و مرتب‌سازی بر اساس بیشترین دعوت‌کننده
        $dataTypeContent = Marketer::select('marketers.*')
            ->selectRaw('(SELECT COUNT(*) FROM marketers AS m WHERE m.inviter = marketers.inviter) as inviter_count')
            ->orderByDesc('inviter_count')
            ->paginate(10);

        // مقداردهی متغیر actions
        $actions = [
             new ViewAction(),
            new EditAction(),
            new DeleteAction(),
        ];

        return Voyager::view('voyager::bread.browse', compact('dataType', 'dataTypeContent', 'usesSoftDeletes', 'actions'));
    }
}
