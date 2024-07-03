<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;
use Exception; // Update this import
use App\Models\Cart; // Tambahkan ini di bagian atas file


class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('index', compact('products'));
    }

    public function create()
    {
        return view('tambah_makanan');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'harga' => 'required|numeric',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
       
        $path = $request->file('gambar')->store('images', 'public');
    
        $product = new Product();
        $product->nama = $request->nama;
        $product->harga = $request->harga;
        $product->gambar = $path;
        $product->save();
    
        return redirect()->route('index')->with('success', 'Product created successfully.');
    }

   public function addToCart(Request $request)
{
    // Validasi request
    $validator = Validator::make($request->all(), [
        'product_id' => 'required|exists:products,id',
        'quantity' => 'required|integer|min:1',
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    $productId = $request->input('product_id');
    $quantity = $request->input('quantity');

    // Ambil informasi produk dari database
    $product = Product::findOrFail($productId);

    // Simpan produk ke dalam session keranjang
    $cart = session()->get('cart', []);

    // Jika produk sudah ada di keranjang, tambahkan jumlahnya
    if (isset($cart[$productId])) {
        $cart[$productId]['quantity'] += $quantity;
    } else {
        // Jika produk belum ada di keranjang, tambahkan ke keranjang
        $cart[$productId] = [
            'id' => $productId,
            'name' => $product->nama, // Tambahkan kunci 'name' dengan nilai nama produk
            'price' => $product->harga, // Tambahkan kunci 'price' dengan nilai harga produk
            'gambar' => $product->gambar, // Tambahkan kunci 'gambar' dengan nilai gambar produk
            'quantity' => $quantity,
        ];
    }

    session()->put('cart', $cart);

    return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang.');
}

public function __construct()
{
    $this->middleware('auth');
}

public function updateCart(Request $request)
{
    $productId = $request->input('product_id');
    $quantity = $request->input('quantity');

    // Cari item keranjang belanja berdasarkan product_id
    $cart = session()->get('cart', []);

    if (isset($cart[$productId])) {
        // Perbarui jumlah jika item ditemukan
        $cart[$productId]['quantity'] = $quantity;

        // Simpan kembali ke session
        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Keranjang belanja berhasil diperbarui.');
    }

    return redirect()->back()->with('error', 'Item keranjang belanja tidak ditemukan.');
}

    
    public function showCart()
    {
        $cart_products = collect(request()->session()->get('cart'));
    
        $cart_total = 0;
        if(session('cart')){
            foreach ($cart_products as $key => $product) {
                $cart_total+= $product['quantity'] * $product['price']; // Menggunakan 'harga' tanpa diskon
            }
        }
    
        return view('cart', compact('cart_products', 'cart_total'));
    }
    

    

    private function validateRequest(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|integer',
            'quantity' => 'required|integer',
        ]);

        if ($validator->fails()) {
            throw new InvalidArgumentException('Invalid request data');
        }
    }

    private function getProduct($productId)
    {
        return Product::findOrFail($productId);
    }

    private function getCart()
    {
        return Session::get('keranjang', []);
    }

    private function productAlreadyInCart($cart, $productId)
    {
        return isset($cart[$productId]);
    }

    private function updateCartQuantity($cart, $productId, $quantity)
    {
        $cart[$productId]['jumlah'] += $quantity;
    }

    private function addProductToCart($cart, $product, $quantity)
    {
        $cart[$product->id] = [
            'id' => $product->id,
            'nama' => $product->nama,
            'harga' => $product->harga,
            'jumlah' => $quantity,
        ];
    }
public function show($id)
{
    $product = Product::findOrFail($id);
    return view('show', compact('product'));
}

public function checkout(Request $request)
{
    $request->validate([
        'nama' => 'required|string|max:255',
        'rombel' => 'required|string|max:255',
        'uang' => 'required|numeric|min:0',
    ]);

    $cart = session()->get('cart', []);
    $cart_total = 0;

    foreach ($cart as $product) {
        $cart_total += $product['quantity'] * $product['price'];
    }

    $uang = $request->input('uang');
    
    if ($uang < $cart_total) {
        return redirect()->back()->with('error', 'Jumlah uang yang diberikan tidak mencukupi untuk membayar total belanjaan.');
    }

    $kembalian = $uang - $cart_total;

    // Lakukan proses penyimpanan data transaksi atau logika lainnya di sini
    // ...

    // Hapus keranjang setelah checkout berhasil
    session()->forget('cart');

    return redirect()->route('index')->with('success', "Checkout berhasil. Kembalian Anda: Rp. " . number_format($kembalian, 0, ',', '.'));
}

public function removeCart(Request $request)
{
    $productId = $request->input('product_id');

    // Ambil keranjang dari session
    $cart = session()->get('cart', []);

    // Hapus item keranjang yang sesuai dengan product_id
    if (isset($cart[$productId])) {
        unset($cart[$productId]);
        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Item keranjang berhasil dihapus.');
    }

    return redirect()->back()->with('error', 'Item keranjang tidak ditemukan.');
}
protected function authenticated(Request $request, $user)
{
    $cart = session()->get('cart', []);
    // Simpan keranjang belanja ke dalam session dengan user_id yang sesuai
    // Contoh: $cart['user_id'] = $user->id;
    session()->put('cart', $cart);
}
}