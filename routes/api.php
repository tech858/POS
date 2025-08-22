use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MessageController;

Route::get('/message', MessageController::class); // => /api/message
