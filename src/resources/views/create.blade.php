@extends('layouts.app')

@section('main')
<form action="{{ route('image_upload') }}" method="POST" class="bl_form" enctype="multipart/form-data">
        @csrf
        <div class="bl_formGroup">
            <label for="image" class="el_label">画像アップロード</label>
            <input type="file" class="el_form" name="image">
        </div>
        <button type="submit">アップロード</button>
    </form>
@endsection