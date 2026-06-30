use Illuminate\Support\Facades\Http;
use App\Models\Product;

class SyncProductEmbedding
{
    public $productId;

    public function __construct($productId)
    {
        $this->productId = $productId;
    }

    public function handle()
    {
        $product = Product::find($this->productId);

        if (!$product) return;

        // 🧠 ساخت متن برای embedding
        $text = $product->name . " " . $product->description;

        // 🤖 گرفتن embedding
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
        ])->post('https://api.openai.com/v1/embeddings', [
            "model" => "text-embedding-3-small",
            "input" => $text
        ]);

        $vector = $response->json()['data'][0]['embedding'];

        // 📦 ارسال به Qdrant
        Http::put("http://localhost:6333/collections/products/points", [
            "points" => [
                [
                    "id" => $product->id,
                    "vector" => $vector,
                    "payload" => [
                        "name" => $product->name,
                        "description" => $product->description,
                        "price" => $product->price
                    ]
                ]
            ]
        ]);
    }
}