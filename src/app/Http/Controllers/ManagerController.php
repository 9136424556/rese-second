<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ManagerRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Shop;
use App\Models\Reservation;
use App\Models\Area;
use App\Models\Genre;
use App\Models\Manager;
use App\Models\Image;

class ManagerController extends Controller
{
    public function managerIndex()
    {
        $user = Auth::user();

        return view('admin.manager', compact('user'));
    }

    public function managerReservation($shop_id)
    {
        $reservations = Reservation::with('user')->orderBy('date','asc')->orderBy('time', 'asc')->where('shop_id', $shop_id)->get();

        return view('admin.reservation', compact('reservations'));
    }

    public function managerNew()
    {
        $areas = Area::all();
        $genres = Genre::all();
        $managers = Manager::all();
        $images = Image::all();

        return view('admin.shop-create', compact('areas', 'genres','managers','images'));
    }

    //入力した内容を確認フォームに自動入力
    public function show(Request $request)
    {
        $manager_id = $request->only('shopManager');
        $shopManager = !empty($manager_id) ? Manager::find($manager_id['shopManager']) : null ;
        $managerName = $shopManager ? $shopManager->name : '' ;

        return redirect('/manager/new')->withInput()->with('managerName', $managerName);
    }

    //店舗情報作成処理
    public function managerCreate(ManagerRequest $request)
    {
        $shop = $request->only('name','area','genre','comment','img_url');
        Shop::create($shop);

        $manager_id = $request->only('managerId');
        if(!empty($manager_id['managerId'])) {
            $newShop = Shop::latest()->where('name', $shop['name'])->first();
            $newShopId['shop_id'] = $newShop['id'];

            Manager::find($manager_id['managerId'])->update($newShopId);

            return redirect('/manager/new')->with('message','作成完了しました');
        }else{
            return redirect('/manager/new')->with('message', '作成完了しました');
        }
    }

    public function managerEdit($shop_id)
    {
        $shop = Shop::find($shop_id);
        $areas = Area::all();
        $genres = Genre::all();
        $images = Image::all();
        $managers = Manager::all();
        $user = Auth::user();

        return view('admin.shop-update', compact('shop','areas','genres','images','managers','user'));
    }

    public function showEdit(Request $request)
    {
        $managerId = $request->only('shopManager');
        $shopManager = !empty($managerId) ? Manager::find($managerId['shopManager']) : null ;

        $user = Auth::user();
        $managerName = $shopManager ? $shopManager->name : $user['name'];

        return redirect()->route('managerEdit', ['store' => $user['shop_id']])->withInput()->with('managerName', $managerName);
    }

    public function managerUpdate(ManagerRequest $request) {
        $edit = $request->only('name', 'img_url', 'area', 'genre', 'comment');
        Shop::find($request->shop_id)->update($edit);

        $shopId = $request->only('shop_id');

        return redirect()->route('managerEdit', ['store' => $shopId['shop_id']])->with('message', '更新完了しました');
    }


    //画像をアップロード
    public function managerUpload(Request $request) {
        $dir = 'image';
        $fileName = $request->file('image')->getClientOriginalName();

        $request->file('image')->storeAs('public/' . $dir, $fileName);

        $image['image_name'] = $fileName;
        $image['image_url'] = 'storage/' . $dir . '/' . $fileName;
        Image::create($image);

        return redirect('/manager/index')->with('message', 'アップロード完了しました');
    }
}
