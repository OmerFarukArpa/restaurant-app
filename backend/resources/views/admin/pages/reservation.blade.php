@extends('admin.layouts.app')

@section('title')
    Rezervasyonlar
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
                            <form id="form_get_id" class="d-none" action="" method="POST">
                                @csrf
                                <input value="" id="reservation_id" name="reservation_id" type="text">
                            </form>
                            <h4 class="card-title">Rezarvasyonlar</h4>
                            <div class="table-responsive">
                                <table class="table mb-4">
                                    <thead>
                                    <tr>
                                        <th>
                                            No
                                        </th>
                                        <th> Kullanıcı adı </th>
                                        <th> Email </th>
                                        <th> Rezarvasyon tarihi </th>
                                        <th> İşlemler </th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($reservations as $reservation)
                                        <tr>
                                            <td>{{$loop->index + $reservations->firstItem()}}</td>
                                            <td>
                                                <span class="pl-2">{{$reservation->user->name}}</span>
                                            </td>
                                            <td>{{ $reservation->user->email}} </td>
                                            <td> {{$reservation->created_at}} </td>
                                            <td class="d-flex gap-2">
                                                <a data-id="{{$reservation->id}}" id="detail" class="btn btn-outline-primary btn-fw mr-1 btn-detail btn-modal">Detay</a>
                                               <div class="mr-1 {{($reservation->reservationStatus->status != 'pending') ? 'd-none' : ''}}">
                                                   <a data-action="reservation_approval" data-id="{{$reservation->id}}" class="btn btn-outline-success btn-fw btn-get-id mr-1">Onay</a>
                                                   <a data-action="reservation_cancel" data-id="{{$reservation->id}}" class="btn btn-outline-danger btn-get-id btn-fw">İptal</a>
                                               </div>
                                                <a id="invoice_entry" data-id="{{$reservation->id}}" class="btn btn-outline-warning btn-fw btn-invoice-entry btn-modal {{(($reservation->reservationStatus->status == 'approval') && !$reservation->pay_status ? '' : 'd-none') }}">Fatura gir</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                {{$reservations->links()}}
                                <div data-id="invoice_entry" id="myModal" class="modal">

                                    <!-- Modal content -->
                                    <div class="modal-content">
                                        <div class="d-flex justify-content-between mb-4">
                                            <h4 class="mb-4">Fatura Giriş</h4>
                                            <span class="modal-close">&times;</span>
                                        </div>

                                        <form class="forms-sample" enctype="multipart/form-data" action="{{route('invoice_entry')}}" method="POST" >
                                            @csrf
                                            <input class="d-none" type="text" value="" id="res_id" name="reservation_id">
                                            <div class="form-group">
                                                <label for="amount">Hesap Tutarı</label>
                                                <input type="number" step="0.01" class="form-control" id="amount" name="amount">
                                                @if($errors->has('amount'))
                                                    <div class="alert alert-danger">{{$errors->first('amount')}}</div>
                                                @endif
                                            </div>
                                            <div class="d-flex justify-content-end mt-4 mb-2">
                                                <button type="submit" class="btn btn-success  btm-md">Kaydet</button>
                                            </div>
                                        </form>
                                    </div>

                                </div>
                                <div data-id="detail" id="myModal" class="modal">
                                    <!-- Modal content -->
                                    <div class="modal-content">
                                        <div class="d-flex justify-content-between mb-4">
                                            <h4 id="detail_head" class="mb-4 text-white d-inline-block"></h4>
                                            <span id="message_detail_close" class="modal-close">&times;</span>
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
        $('.btn-detail').click(function (){
            $('#detail_head').html('');
            $('#detail_container').html('');
            const reservationId = $(this).data('id');
            $.ajax({
                type: 'get',
                url: '{!! route('reservation_detail') !!}',
                data: {
                    id: reservationId
                },
                dataType: "json",
                success: function (reservation) {
                    $('#detail_head').html('Rezervasyon Detay')

                    $('#detail_container').html(`
                        <div class="mb-4 d-flex"><span class="font-weight-bold text-white" style='width: 23%'>Kullanıcı adı :</span>  <span  style='flex:1;text-wrap: wrap;word-break: break-word'>${reservation.user.user_name}</span>  </div>
                        <div class="mb-4 d-flex"><span class="font-weight-bold text-white" style='width: 23%'>Ad Soyad :</span>  <span  style='flex:1;text-wrap: wrap;word-break: break-word'>${reservation.user.name}</span>  </div>
                        <div class="mb-4 d-flex"><span class="font-weight-bold text-white" style='width: 23%'>Email :</span>  <span  style='flex:1;text-wrap: wrap;word-break: break-word'>${reservation.user.email}</span>  </div>
                        <div class="mb-4 d-flex"><span class="font-weight-bold text-white" style='width: 23%'>Tarih :</span>  <span  style='flex:1;text-wrap: wrap;word-break: break-word'>${reservation.date}</span>  </div>
                        <div class="mb-4 d-flex"><span class="font-weight-bold text-white" style='width: 23%'>Kişi sayısı :</span>  <span  style='flex:1;text-wrap: wrap;word-break: break-word'>${reservation.number_of_people}</span>  </div>
                        ${(reservation.reservation_status.status != 'pending') ? `
                             <div class="mb-4 d-flex"><span class="font-weight-bold text-white" style='width: 23%'>Onay durumu :</span>  <span  style='flex:1;text-wrap: wrap;word-break: break-word'>${((reservation.reservation_status.status == 'approval') && 'Onaylandı') || ((reservation.reservation_status.status == 'cancel') && 'İptal edildi')}</span>  </div>
                        ` : ''}
                        ${(reservation.reservation_status.status == 'approval') && reservation.pay_status ? `
                            <div class="mb-4 d-flex"><span class="font-weight-bold text-white" style='width: 23%'>Hesap :</span>  <span  style='flex:1;text-wrap: wrap;word-break: break-word'>₺ ${reservation.amount}</span>  </div>
                        ` : ''}
                    `);

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

        })


        $('.btn-invoice-entry').click(function (){
            const reservationId = $(this).attr('data-id');
            $('#res_id').val(reservationId);
        })


        const form = $('#form_get_id')
        $('.btn-get-id').click(function () {
            const action = $(this).data('action')
            const id = $(this).data('id')
            $('#reservation_id').val(id)

            if(action == 'reservation_approval'){
                form.attr('action','{{route('reservation_approval')}}').submit();
            }else {
                form.attr('action', '{{route('reservation_cancel')}}').submit();

            }
        });
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
