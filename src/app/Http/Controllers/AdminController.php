<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AdminRequest;
use App\Http\Requests\MultiLoginRequest;
use App\Http\Requests\CsvFileRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Shop;
use App\Models\Area;
use App\Models\Genre;
use App\Models\Mark;
use App\Models\Manager;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Imports\ShopsImport;
use Maatwebsite\Excel\Facades\Excel;
class AdminController extends Controller
{

    //管理者・店舗代表者マルチログイン画面
    public function multiIndex() 
    {
        return view('multi.multi-login');
    }

      //店舗代表者　ログイン処理
    public function multiLogin(MultiLoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        //選択肢から役職を選択
        $guard = $request->input('guard');
        
        //セレクトボックスで管理者を選ぶとRoute::prefix('admin')の'/index'へ、
        //店舗代表者を選ぶとRoute::prefix('manager')の'/index'へ移動
        if(Auth::guard($guard)->attempt($credentials)) {
            return redirect($guard . '/index');
        }

        return back()->withErrors(['auth' => ['認証に失敗しました']] );
    }
    //管理者権限からログアウト
    public function logout()
    {
        // adminガードでログアウト処理を実行
        Auth::guard('admin')->logout();

        return redirect('/multi/index')->with('success', 'ログアウトしました');
    }
    //管理者メイン画面
    public function adminindex()
    {
        $shops = Shop::all();

        return view('admin.admin', compact('shops'));
    }

    public function admincreate(AdminRequest $request)
    {
       $manager = $request->only('shop_id','name','email');
       $manager['password'] = Hash::make($request->password);
       $manager['email_verified_at'] = Carbon::now();

       Manager::create($manager);

       return redirect('/admin/index')->with('message', '登録完了しました');
    }

    //店舗、口コミ一覧
    public function adminlist()
    {
        $shops = Shop::all();
        return view('admin.list',compact('shops'));
    }

    public function shopdetail($id)
    {
        $shop = Shop::find($id);
        $marks = Mark::where('shop_id', $shop->id)->get();
        return view('admin.detail',compact('shop','marks'));
    }
    //店舗情報をインポート処理で追加
    public function addShop()
    {
        $areas = Area::all();
        $genres = Genre::all();

        return view('admin.addShop',compact('areas','genres'));
    }

    public function importCsv(CsvFileRequest $request)
    {
        // アップロードされたCSVファイルを取得
        if ($request->hasFile('csv_file')) {
        $file = $request->file('csv_file');
        Log::info('File uploaded: ' . $file->getClientOriginalName());
        Log::info('File mime type: ' . $file->getMimeType());
        } else {
            Log::info('No file uploaded.');

        }
        // CSVデータを読み込む
        $csvData = array_map('str_getcsv', file($file->getRealPath()));
        // CSVデータを読み込む
        try {
            $csvData = array_map('str_getcsv', file($file->getRealPath()));
            Log::info('CSV file read successfully.');
        } catch (\Exception $e) {
            Log::error('Failed to read CSV file: ' . $e->getMessage());
            return redirect()->route('admin.addShop')->with('error', 'CSVファイルの読み込みに失敗しました。');
        }
        // ヘッダー行を削除
        array_shift($csvData);

        // データ格納用配列
       $shopData = [];
       $skippedRows = []; // 処理をスキップした行を記録

       foreach ($csvData as $row) {
        // 列数のチェック（期待する列数：5）
        if (count($row) !== 5) {
            $skippedRows[] = "列数が不正: " . implode(', ', $row);
            continue;
        }

        // 各列を変数に割り当て
        [$shop_name, $areaName, $genreName, $imagePath, $introduction] = $row;

        // 文字コードの変換処理
        $shop_name = mb_convert_encoding($shop_name, 'UTF-8', 'auto');

        // 文字コードの変換処理(エリア)
        $areaName = mb_convert_encoding($areaName, 'UTF-8', 'auto');
        // エリア名をIDに変換
        $area = Area::where('name', $areaName)->first();
        if (!$area) {
            Log::warning("Invalid area name: '{$areaName}'");
            $skippedRows[] = "エリア名が不正: '{$areaName}'";
            continue;
        }

        // 文字コードの変換処理(ジャンル)
        $genreName = mb_convert_encoding($genreName,'UTF-8','auto');  
        // ジャンル名をIDに変換
        $genre = Genre::where('name', $genreName)->first();
        if (!$genre) {
            Log::warning("Invalid genre name: '{$genreName}'");
            $skippedRows[] = "ジャンル名が不正: '{$genreName}'";
            continue;
        }

        // 画像の処理
        $imageFileName = null;
        if (filter_var($imagePath, FILTER_VALIDATE_URL)) {
            // URLから画像をダウンロードして保存
            $imageFileName = 'image/' . uniqid() . '.jpg';
            try {
                $imageContent = file_get_contents($imagePath);
                if ($imageContent === false) {
                    throw new \Exception("HTTP request failed! HTTP/1.1 404 Not Found");
                }
                $imageFileName = 'image/' . uniqid() . '.jpg';
                Storage::put('public/' . $imageFileName, $imageContent);
            } catch (\Exception $e) {
                Log::error('Image download failed', ['imagePath' => $imagePath, 'error' => $e->getMessage()]);
                $skippedRows[] = "画像ダウンロード失敗: '{$imagePath}'";
                continue;
            }
        } elseif (Storage::exists($imagePath)) {
            // ローカルパスの場合、相対パスを設定
            $imageFileName = 'image/' . basename($imagePath);  // ここで相対パスを取得
        } else {
            $skippedRows[] = "画像パスが不正: '{$imagePath}";
            continue;
        }
        
        // 文字コードの変換処理(店舗概要)
        $introduction = mb_convert_encoding($introduction,'UTF-8','auto');

        // 重複店舗のチェック
        if (Shop::where('shop_name', $shop_name)->exists()) {
            // エラーをセッションに追加
            session()->flash('error', "重複店舗名: '{$shop_name}' が既に存在します。");
            continue;
        }

        // 登録用データを配列に追加
        $shopData[] = [
            'shop_name' => $shop_name,
            'area_id' => $area->id,
            'genre_id' => $genre->id,
            'image' => $imageFileName,
            'introduction' => $introduction,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    try {
        DB::transaction(function () use ($shopData) {
            if (!empty($shopData)) {
                Shop::insert($shopData);
            }
        });
    } catch (\Exception $e) {
        Log::error('Shop data insert failed', ['error' => $e->getMessage(), 'data' => $shopData]);
        return redirect()->route('admin.addShop')
            ->with('error', '店舗情報のインポート中にエラーが発生しました。');
    }
    // 処理結果を表示
    if (!empty($skippedRows)) {
        return redirect()->route('admin.addShop')
            ->with('success', '店舗情報をインポートしましたが、一部の行をスキップしました。')
            ->with('skipped', $skippedRows);
    }

        return redirect()->route('admin.addShop')->with('success', '店舗情報を追加しました！');
    }
}
