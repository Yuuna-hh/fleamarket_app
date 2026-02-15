@extends('layouts.app')

@section('title', '商品出品')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/sell.css') }}">
@endsection

@section('content')
<div class="sell">
    <h1 class="sell__title">商品の出品</h1>

    <form class="sell__form" action="{{ url('/sell') }}" method="POST" enctype="multipart/form-data" novalidate>
        @csrf

        <!-- 商品画像 -->
        <div class="sell__field">
            <p class="sell__label">商品画像</p>

            <div class="sell__imageArea" id="imagePreviewArea">
                <label class="sell__imageSelect">
                    画像を選択する
                    <input type="file" name="image" accept="image/*" class="sell__fileInput" data-preview-input data-preview-area="#imagePreviewArea" data-preview-keep=".sell__imageSelect">
                </label>
            </div>

            @error('image')
                <p class="error-message">{{ $message }}</p>
            @enderror

        <!-- 商品の詳細 -->
        <section class="sell__section">
            <h2 class="sell__sectionTitle">商品の詳細</h2>

            <!-- カテゴリー -->
            <div class="sell__field">
                <p class="sell__label">カテゴリー</p>

                <div class="sell__categoryList">
                    @foreach ($categories as $category)
                        @php
                            $oldCategories = old('categories', []);
                            $checked = in_array($category->id, $oldCategories);
                            $inputId = 'category_' . $category->id;
                        @endphp

                        <input
                            type="checkbox"
                            name="categories[]"
                            value="{{ $category->id }}"
                            id="{{ $inputId }}"
                            class="sell__categoryInput"
                            {{ $checked ? 'checked' : '' }}
                        >
                        <label for="{{ $inputId }}" class="sell__categoryTag">
                            {{ $category->name }}
                        </label>
                    @endforeach
                </div>

                @error('categories')
                    <p class="error-message">{{ $message }}</p>
                @enderror
                @error('categories.*')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <!-- 商品の状態 -->
            <div class="sell__field">
                <label class="sell__label" for="condition">商品の状態</label>
                <select name="condition" id="condition" class="sell__select">
                    <option value="" selected disabled hidden>選択してください</option>
                    <option value="良好">良好</option>
                    <option value="目立った傷や汚れなし">目立った傷や汚れなし</option>
                    <option value="やや傷や汚れあり">やや傷や汚れあり</option>
                    <option value="状態が悪い">状態が悪い</option>
                </select>

                @error('condition')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>
        </section>

        <!-- 商品名と説明 -->
        <section class="sell__section">
            <h2 class="sell__sectionTitle">商品名と説明</h2>

            <div class="sell__field">
                <label class="sell__label" for="name">商品名</label>
                <input type="text" id="name" name="name" class="sell__input" value="{{ old('name') }}">
                @error('name')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <div class="sell__field">
                <label class="sell__label" for="brand">ブランド名</label>
                <input type="text" id="brand" name="brand" class="sell__input" value="{{ old('brand') }}">
                @error('brand')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <div class="sell__field">
                <label class="sell__label" for="description">商品の説明</label>
                <textarea id="description" name="description" class="sell__textarea">{{ old('description') }}</textarea>
                @error('description')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <div class="sell__field">
                <label class="sell__label" for="price">販売価格</label>
                
                <div class="sell__priceRow">
                    <input type="text" id="price" name="price" class="sell__input sell__input--price" value="{{ old('price') }}">
                </div>

                @error('price')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>
        </section>

        <button type="submit" class="btn">出品する</button>
    </form>
</div>
@endsection

@section('js')
    <script src="{{ asset('js/image-preview.js') }}"></script>
@endsection