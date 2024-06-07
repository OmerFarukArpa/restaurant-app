@extends('admin.layouts.app')

@section('title')
    Ayarlar
@endsection

@section('css')
@endsection

@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-12 grid-margin">
                    <div class="card h-100">
                        <div class="card-body">
                            <h3 class="card-title mb-4">Şirket Bilgileri</h3>
                            <form class="forms-sample" enctype="multipart/form-data" action="{{route('settings')}}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="name">Admin adı</label>
                                    <input type="text" class="form-control" value="{{$setting->user->name ?? ''}}" id="name" name="name">
                                    @if($errors->has('name'))
                                        <div class="alert alert-danger">{{$errors->first('name')}}</div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="company_name">Şirket adı</label>
                                    <input type="text" class="form-control" value="{{$setting->company_name ?? ''}}" id="company_name" name="company_name">
                                    @if($errors->has('company_name'))
                                        <div class="alert alert-danger">{{$errors->first('company_name')}}</div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail3">Email</label>
                                    <input type="text" class="form-control" value="{{$setting->user->email ?? ''}}"  id="email" name="email">
                                    @if($errors->has('email'))
                                        <div class="alert alert-danger">{{$errors->first('email')}}</div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="image">Logo</label>
                                    <div class="input-group col-xs-12">
                                        <input type="file" class="form-control" name="image"  id="image" accept="image/png, image/jpeg, image/jpg">
                                    </div>
                                    @if($errors->has('image'))
                                        <div class="alert alert-danger">{{$errors->first('image')}}</div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="info">Şirket bilgisi</label>
                                    <textarea class="form-control" id="info" name="info" rows="5">{{$setting->info ?? ''}} </textarea>
                                    @if($errors->has('info'))
                                        <div class="alert alert-danger">{{$errors->first('info')}}</div>
                                    @endif
                                </div>
                                <div class="d-flex justify-content-end align-items-center mt-5">
                                    <button type="submit" class="btn btn-success mr-2">Kaydet</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 grid-margin">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <h3 class="card-title mb-4">Kategori Ekle</h3>
                                <a type="button" id="category_delete" class="btn btn-danger btn-fw mr-1 btn-modal">Kategori sil</a>
                                <div data-id="category_delete" id="myModal" class="modal">

                                    <!-- Modal content -->
                                    <div class="modal-content">
                                        <div class="d-flex justify-content-between mb-4">
                                            <h4 class="mb-4">Kategori Sil</h4>
                                            <span class="modal-close">&times;</span>
                                        </div>

                                        <form class="forms-sample" enctype="multipart/form-data" action="{{route('delete_category')}}" method="POST" >
                                            @csrf
                                            <div class="form-group">
                                                <label for="country_id">Kategori</label>
                                                <select class="form-control" id="category_id" name="category_id">
                                                    <option value="">Seçim yapın</option>
                                                    @foreach($categories as $category)
                                                        <option value="{{$category->id}}">{{ucfirst($category->name)}}</option>
                                                    @endforeach
                                                </select>
                                                @if($errors->has('category_id'))
                                                    <div class="alert alert-danger">{{$errors->first('category_id')}}</div>
                                                @endif
                                            </div>
                                            <div class="d-flex justify-content-end mt-4 mb-2">
                                                <button type="submit" class="btn btn-danger  btm-md">Sil</button>
                                            </div>
                                        </form>
                                    </div>

                                </div>
                            </div>

                            <form class="forms-sample" enctype="multipart/form-data" action="{{route('add_category')}}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="name">Kategori adı</label>
                                    <input type="text" class="form-control" id="category_name" name="category_name">
                                    @if($errors->has('category_name'))
                                        <div class="alert alert-danger">{{$errors->first('category_name')}}</div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="image">Resim</label>
                                    <div class="input-group col-xs-12">
                                        <input type="file" class="form-control" name="category_image"  id="category_image" accept="image/png, image/jpeg, image/jpg">
                                    </div>
                                    @if($errors->has('category_image'))
                                        <div class="alert alert-danger">{{$errors->first('category_image')}}</div>
                                    @endif
                                </div>
                                <div class="d-flex justify-content-end align-items-center mt-5">
                                    <button type="submit" class="btn btn-success mr-2">Kaydet</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 grid-margin">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <h3 class="card-title mb-4">Mesaj Konusu Ekle</h3>
                                <a type="button" id="topic_delete" class="btn btn-danger btn-fw mr-1 btn-modal">Konu başlığı sil</a>
                                <div data-id="topic_delete" id="myModal" class="modal">

                                    <!-- Modal content -->
                                    <div class="modal-content">
                                        <div class="d-flex justify-content-between mb-4">
                                            <h4 class="mb-4">Konu Başlığı Sil</h4>
                                            <span class="modal-close">&times;</span>
                                        </div>

                                        <form class="forms-sample" enctype="multipart/form-data" action="{{route('delete_topic')}}" method="POST" >
                                            @csrf
                                            <div class="form-group">
                                                <label for="country_id">Konu başlığı</label>
                                                <select class="form-control" id="topic_id" name="topic_id">
                                                    <option value="">Seçim yapın</option>
                                                    @foreach($topics as $topic)
                                                        <option value="{{$topic->id}}">{{ucfirst($topic->name)}}</option>
                                                    @endforeach
                                                </select>
                                                @if($errors->has('topic_id'))
                                                    <div class="alert alert-danger">{{$errors->first('topic_id')}}</div>
                                                @endif
                                            </div>
                                            <div class="d-flex justify-content-end mt-4 mb-2">
                                                <button type="submit" class="btn btn-danger  btm-md">Sil</button>
                                            </div>
                                        </form>
                                    </div>

                                </div>
                            </div>

                            <form class="forms-sample" enctype="multipart/form-data" action="{{route('add_topic')}}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="name">Konu adı</label>
                                    <input type="text" class="form-control" id="topic_name" name="topic_name">
                                    @if($errors->has('topic_name'))
                                        <div class="alert alert-danger">{{$errors->first('topic_name')}}</div>
                                    @endif
                                </div>
                                <div class="d-flex justify-content-end align-items-center mt-5">
                                    <button type="submit" class="btn btn-success mr-2">Kaydet</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        @if(session('message'))
            Swal.fire({
                icon: 'success',
                title: 'Başarılı!',
                html: '{!! session('message') !!}',
                confirmButtonText: 'Tamam'
            });
        @endif
    </script>
@endsection
