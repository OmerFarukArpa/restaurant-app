@extends('admin.layouts.app')

@section('title')
    {{ucfirst($category->name)}} Listesi
@endsection

@section('css')
@endsection

@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row ">
                <div class="col-12 grid-margin">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h4 class="card-title">{{ucfirst($category->name)}} Listesi</h4>
                                <a type="button" data-action="meal_add" id="add_update_food" class="btn btn-outline-success btn-fw mr-1 btn-meal btn-modal">{{ucfirst($category->name)}} ekle</a>
                                <div data-id="add_update_food" id="myModal" class="modal">

                                    <!-- Modal content -->
                                    <div class="modal-content">
                                        <div class="d-flex justify-content-between mb-4">
                                            <h4 class="mb-4">{{ucfirst($category->name)}}</h4>
                                            <span class="modal-close">&times;</span>
                                        </div>

                                        <form id="form_add_update" class="forms-sample" enctype="multipart/form-data" action="" method="POST" >
                                            @csrf
                                            <input id="hidden_input" type="text" class="d-none" value="{{$category->id}}" name="category_id">
                                            <div class="form-group">
                                                <label for="name">{{ucfirst($category->name)}} adı</label>
                                                <input type="text" class="form-control" id="name" name="name">
                                                @if($errors->has('name'))
                                                    <div class="alert alert-danger">{{$errors->first('name')}}</div>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <label for="image">Resim yükle</label>
                                                <div class="input-group col-xs-12">
                                                    <input type="file" class="form-control" name="image" id="image" accept="image/png, image/jpeg, image/jpg">
                                                    @if($errors->has('image'))
                                                        <div class="alert alert-danger">{{$errors->first('image')}}</div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="description">Ürün bilgisi</label>
                                                <textarea class="form-control" name="description" id="description" rows="4"></textarea>
                                                @if($errors->has('description'))
                                                    <div class="alert alert-danger">{{$errors->first('description')}}</div>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <label for="">Fiyat</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text text-primary">₺</span>
                                                    </div>
                                                    <input type="number" step="0.01" class="form-control" name="price" id="price">
                                                </div>
                                                @if($errors->has('price'))
                                                    <div class="alert alert-danger">{{$errors->first('price')}}</div>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input type="checkbox" class="form-check-input" name="status" id="status"> Gıdayı pasifle <i class="input-helper"></i></label>
                                                </div>
                                            </div>

                                            <div class="d-flex justify-content-end mt-4 mb-2">
                                                <button type="submit" class="btn btn-success  btm-md">Kaydet</button>
                                            </div>
                                        </form>
                                    </div>

                                </div>
                            </div>
                            <form id="form_get_id" action="" method="POST">
                                @csrf
                                <input type="text" id="id" name="id" class="d-none">
                            </form>
                            <div class="table-responsive">
                                <table class="table mb-4">
                                    <thead>
                                    <tr>
                                        <th>
                                            No
                                        </th>
                                        <th>Resim</th>
                                        <th> Ad </th>
                                        <th>Fiyat</th>
                                        <th> Durum </th>
                                        <th> İşlemler </th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($meals as $meal)

                                        <tr>
                                            <td>{{$loop->index + $meals->firstItem()}}</td>
                                            <td><img style="width: 50px;height: 50px;border-radius: 5px" src="{{asset($meal->image)}}" alt="food"></td>
                                            <td>
                                                <span class="pl-2">{{$meal->name}}</span>
                                            </td>
                                            <td> ₺ {{$meal->price}} </td>
                                            <td> <button data-action="change_status" data-id="{{$meal->id}}" class="btn-meal btn btn-outline-{{$meal->status ? 'success' : 'danger'}} btn-fw mr-1">{{$meal->status ? 'Aktif' : 'Pasif'}}</button> </td>
                                            <td>
                                                <a data-action="meal_edit" data-id="{{$meal->id}}" id="add_update_food" class="btn btn-outline-warning btn-fw mr-1 btn-meal btn-modal">Güncelle</a>
                                                <a data-action="meal_detail" data-id="{{$meal->id}}" id="detail" class="btn btn-outline-primary btn-fw mr-1 btn-meal btn-modal">Detay</a>
                                                <a data-action="meal_delete" data-id="{{$meal->id}}" class="btn btn-outline-danger btn-fw btn-meal">Sil</a>
                                            </td>
                                        </tr>
                                    @endforeach


                                    </tbody>
                                </table>
                                {{$meals->links()}}
                                <div data-id="detail" id="myModal" class="modal">

                                    <!-- Modal content -->
                                    <div class="modal-content">
                                        <div class="d-flex justify-content-between mb-4">
                                            <h4 id="detail_head" class="mb-4 text-white d-inline-block"></h4>
                                            <span class="modal-close">&times;</span>
                                        </div>
                                        <div id="detail_container">

                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        const formGetId = $('#form_get_id');
        const formAddUpdate = $('#form_add_update');
        $('.btn-meal').click(function (){
            const action = $(this).data('action')
            const id = $(this).data('id')

            if(action == 'change_status'){
                $('#id').val(id)
                formGetId.attr('action','{{route('change_status')}}').submit();
            }else if(action == 'meal_add'){
                $('#hidden_input').val({{$category->id}});
                $('#hidden_input').attr('name','category_id')
                formAddUpdate.attr('action','{{route('meal_add')}}')
            } else if(action == 'meal_edit'){
                formAddUpdate.attr('action','{{route('meal_edit')}}')
                $('#hidden_input').val(id);
                $('#hidden_input').attr('name','id')
                $('#edit_head').html('');
                $.ajax({
                    type: 'get',
                    url: '{!! route('meal_edit') !!}',
                    data: {
                        id: id
                    },
                    dataType: "json",
                    success: function (meal) {

                        $('#edit_head').html(meal.name)
                        formAddUpdate.find("[name='name']").val(meal.name)
                        formAddUpdate.find("[name='country_id'] option").filter((index, element) => $(element).val() == meal.country_id).prop('selected', true);
                        formAddUpdate.find("[name='description']").val(meal.description);
                        formAddUpdate.find("[name='price']").val(meal.price);
                        formAddUpdate.find("[name='status']").prop('checked',!meal.status)
                    },
                    error: function (data) {
                        Swal.fire({
                            icon: "error",
                            title: 'Hata',
                            html: "<div id=\"validation-errors\"></div>",
                            showConfirmButton: true,
                            confirmButtonText: "Tamam"
                        });
                        $.each(data.responseJSON.errors, function (key, value) {
                            $('#validation-errors').append('<div class="alert alert-danger">' + value + '</div>');
                        });
                    }
                });
            }else if (action == 'meal_detail') {
                $('#id').val(id)
                $('#detail_head').html('');
                $('#detail_container').html('');
                $.ajax({
                    type: 'get',
                    url: '{!! route('meal_detail') !!}',
                    data: {
                        id: id
                    },
                    dataType: "json",
                    success: function (meal) {

                        $('#detail_head').html(meal.name + ' Detay')

                        $('#detail_container').html(`
                            <div class="mb-4 d-flex"><span class="font-weight-bold text-white" style='width: 18%'>Kategori :</span>  <span style="word-wrap: break-word;flex: 1;text-wrap: wrap;">${meal.get_category.name}</span>  </div>
                            <div class="mb-4 d-flex"><span class="font-weight-bold text-white" style='width: 18%'>Adı :</span>  <span style="word-wrap: break-word;flex: 1;text-wrap: wrap;">${meal.name}</span>  </div>
                            <div class="mb-4 d-flex"><span class="font-weight-bold text-white" style='width: 18%'>Fiyat :</span>  <span style="word-wrap: break-word;flex: 1;text-wrap: wrap;">₺ ${meal.price}</span>  </div>
                            <div class="mb-4 d-flex"><span class="font-weight-bold text-white" style='width: 18%'>Durum :</span>  <span>${meal.status ? 'Aktif' : 'Pasif'}</span>  </div>
                            <div class="mb-4 d-flex"><span class="font-weight-bold text-white" style='width: 18%'>Açıklama :</span>  <span  style="word-wrap: break-word;flex: 1;text-wrap: wrap;line-height: 1.1rem">${meal.description}</span>  </div>
                        `)
                    },
                    error: function (data) {
                        Swal.fire({
                            icon: "error",
                            title: 'Hata',
                            html: "<div id=\"validation-errors\"></div>",
                            showConfirmButton: true,
                            confirmButtonText: "Tamam"
                        });
                        $.each(data.responseJSON.errors, function (key, value) {
                            $('#validation-errors').append('<div class="alert alert-danger">' + value + '</div>');
                        });
                    }
                });
            } else {
                $('#id').val(id)
                formGetId.attr('action','{{route('meal_delete')}}').submit();
            }
        })

    </script>
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
