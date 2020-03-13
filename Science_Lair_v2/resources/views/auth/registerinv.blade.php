@php
    use Illuminate\Support\Facades\DB;
    $couunis = DB::table('country_units')->get();
    $invs = DB::table('investigators')->get();
    $cu = [];
@endphp

@extends((Auth::user()->user_type == 'ADMINISTRADOR')? 'layouts.admin': 'layouts.inv') 
@extends('layouts.footer')

<head>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script>
    function editarInvestigador(investigador) {
        $("#editName").val(investigador.name);
        $("#editPassportnumber").val(investigador.passportnumber);
        $("#editAssociatedunit").val(investigador.associatedunit);
        $("#editState").val(investigador.state);
        $("#editId").attr('value',investigador.id);
        console.log(investigador)
    }

    </script>
    <!-- Favicon -->
    <link rel="icon" href="imgTemp/icon.ico">
    
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" rel="stylesheet"/>

    <style>
        .btn-group-xs > .btn, .btn-xs {
          padding: .25rem .4rem;
          font-size: .875rem;
          line-height: .5;
          border-radius: .2rem;
        }
    </style>

</head>

<!-- ***** Breadcumb Area Start ***** -->
<div class="mosh-breadcumb-area" style="background-image: url(img/core-img/breadcumb.png);">
    <div class="container h-100">
        <div class="row h-100 align-items-center">
            <div class="col-12">
                <div class="bradcumbContent">
                    <h2>Registra un nuevo investigador</h2>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ***** Breadcumb Area End ***** -->

<!-- ***** Contact Area Start ***** -->
<section class="contact-area section_padding_100">
    <div class="container">
        <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><i class="fa fa-search"></i>  {{ __('Registrar nuevo investigador') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('registerinv') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right"><i class="fa fa-user-circle-o"></i>  {{ __('Nombre completo') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>


                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right"><i class="fa fa-address-card"></i>  {{ __('Número de pasaporte') }}</label>

                            <div class="col-md-6">
                                <input id="passportnumber" type="text" class="form-control @error('name') is-invalid @enderror" name="passportnumber" value="{{ old('passportnumber') }}" required autocomplete="name" autofocus>

                                @error('passportnumber')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>


                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right"><i class="fa fa-users"></i>  {{ __('Unidad correspondiente') }}</label>

                            <div class="col-md-6">
                                <select name="associatedunit" class="form-control">
                                @foreach($couunis as $couuni)
                                    @if(!in_array($couuni->unit, $cu))
                                        @php
                                            $cu[] = $couuni->unit;
                                        @endphp
                                    @endif
                                @endforeach
                                @foreach($cu as $c)
                                    <option value="{{$c}}" 
                                                @if(old('associatedunit') == $c) 
                                                    selected 
                                                @endif>{{$c}}</option>>
                                @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right"><i class="fa fa-flag"></i>  {{ __('Estado') }}</label>

                            <div class="col-md-3">
                                <select name="state" class="form-control">
                                    <option value="ACTIVO" 
                                    {{ old('state') == 'ACTIVO' ? 'selected' : '' }}>ACTIVO</option>

                                    <option value="INACTIVO" 
                                    {{ old('state') == 'INACTIVO' ? 'selected' : '' }}>INACTIVO</option>
                                </select>

                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-4.7 offset-md-4">
                                <button class="btn mosh-btn mt-50" type="submit">{{ __('Registrar investigador') }}</button>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
            <!-- Contact Information -->
            <div class="col-12 col-md-4">
                <div class="contact-information">
                    <h2>Contacto</h2>
                    <div class="single-contact-info d-flex">
                        <div class="contact-icon mr-15">
                            <img src="img/core-img/map.png" alt="">
                        </div>
                        <p>0610/ Av. Angamos,<br> Antofagasta, Chile</p>
                    </div>
                    <div class="single-contact-info d-flex">
                        <div class="contact-icon mr-15">
                            <img src="img/core-img/call.png" alt="">
                        </div>
                        <p>Celular: +123456789</p>
                    </div>
                    <div class="single-contact-info d-flex">
                        <div class="contact-icon mr-15">
                            <img src="img/core-img/message.png" alt="">
                        </div>
                        <p>sciencelair@sciencelair.com</p>
                    </div>
                </div>
            </div>

            <div class="container" style="margin-top:30px;">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <table class="table table-striped">
                        <thead class="alert alert-info">
                                <th style="text-align:center">Nombre completo
                                <th>
                                <th style="text-align:center">Número pasaporte</th>
                                <th style="text-align:center">Unidad correspondiente</th>
                                <th style="text-align:center">Estado</th>
                                <th style="text-align:center"> </th>
                        </thead>
                        <tbody>
                            @foreach($invs as $inv)
                            <tr>
                                <td style="text-align:center">{{$inv->name}}</td>
                                <td></td>
                                <td>{{$inv->passportnumber}}</td>
                                <td>{{$inv->associatedunit}}</td>
                                <td>{{$inv->state}}</td>
                                <td style="text-align:center"><button onclick="editarInvestigador({{ json_encode($inv)}} )" id=<?php echo("editBtn".$loop->index)?> type="button" class="btn-success btn-xs" data-toggle="modal" 
                                data-target="#editinv"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>Editar</button></td>
                                
                            </tr>
                            @endforeach
                        </tbody> 
                        </table>
                    </div>
                </div>
            </div>



        </div>
    </div>
</section>
<!-- ***** Contact Area End ***** -->

<div id="editinv" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title titula">Editar un investigador existente</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <form method="post" action="{{ route('registerinv') }}" class="form-horizontal" >
        @csrf
        <input name="_method" type="hidden" value="PUT">
            <input hidden name="id" id="editId" value="j"/>
            <div class="form-group ">
                <label for="name" class="">{{ __('Nombre completo') }}</label>

                <div class="">
                    <input id="editName" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                    <span class="invalid-feedback d-block" role="alert">
                        <strong class="errorname"></strong>
                    </span>
                </div>

            </div>

            <div class="form-group ">
                <label for="name" class="">{{ __('N° de pasaporte') }}</label>

                <div class="">
                    <input id="editPassportnumber" type="text" class="form-control @error('name') is-invalid @enderror" name="passportnumber" value="{{ old('passportnumber') }}" required autocomplete="name" autofocus>
                    <span class="invalid-feedback d-block" role="alert">
                        <strong class="errorpass"></strong>
                    </span>
                </div>
            </div>

            <div class="form-group">
                <label for="password" class="">{{ __('Unidad correspondiente') }}</label>
                <div class="">
                    <select id="editAssociatedunit" name="associatedunit" class="form-control assu">
                    @foreach($couunis as $couuni)
                        @if(!in_array($couuni->unit, $cu))
                            @php
                                $cu[] = $couuni->unit;
                            @endphp
                        @endif
                    @endforeach
                    @foreach($cu as $c)
                        <option value="{{$c}}" 
                             @if(old('associatedunit') == $c) 
                                selected 
                            @endif>{{$c}}</option>>
                    @endforeach
                    </select>
                </div>
            </div>

            <div class= "form-group">
            <label for="editState">Estado</label>
                <select class="form-control assu" name="state" id= "editState">
                    <option value="ACTIVO">ACTIVO</option>
                    <option value="INACTIVO">INACTIVO</option>
                </select>
            </div>
            
            <button type="submit" class="btn btn-success add" id="add">
                Editar Investigador
            </button>
        </form>
        <span class="success-feedback d-block" align="center" role="alert">
            <strong class="successall" style="color:#3BBF6C;"></strong>
        </span>
      </div>
          <div class="modal-footer">
            
          </div>
    </div>
  </div>
</div>
