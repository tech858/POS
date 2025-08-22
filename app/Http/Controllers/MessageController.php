namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MessageController extends Controller
{
    public function show()
    {
        // Call the API route
        $response = Http::get(url('/api/message'));
        $data = $response->json();

        // Pass the JSON data to the view
        return view('message', ['data' => $data]);
    }
}
