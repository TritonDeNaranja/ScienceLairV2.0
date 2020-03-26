@php
    use Illuminate\Support\Facades\DB;
    $invs = DB::table('investigators')->get();
    $proyects = DB::table('projects')->get();
    
    $btn = [];
    $names = [];
    $i=0;
@endphp

@extends((Auth::user()->user_type == 'ADMINISTRADOR')? 'layouts.admin': 'layouts.inv') 
@extends('layouts.footer')
<head>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script>
    function editarProyecto(project) {
        $("#editProyect").val(project.name_project);
        $("#editCode").val(project.code);
        $("#editState").val(project.state);
        $("#editIni").val(project.date_start);
        $("#editFin").val(project.date_end);
        $("#editId").attr('value',project.id);
        console.log(project)
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

<head>
    
    <!-- Favicon -->
    <link rel="icon" href="imgTemp/icon.ico">

    <!--  jQuery -->
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>

    <!-- Isolated Version of Bootstrap, not needed if your site already uses Bootstrap -->
    <link rel="stylesheet" href="https://formden.com/static/cdn/bootstrap-iso.css" />

    <!-- Bootstrap Date-Picker Plugin -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.es.min.js"></script>

    <script>
        jQuery(document).ready(function($){
          var date_inputstart=$('input[name="datestart"]');
          var date_inputend=$('input[name="dateend"]');
          var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
          var options={
            weekStart: 1,
            todayBtn: "linked",
            format: "dd/mm/yyyy",
            container: container,
            language: 'es',
            todayHighlight: true,
            autoclose: true,
          };
          date_inputstart.datepicker(options);
          date_inputend.datepicker(options);
        })
    </script>
</head>

<!-- ***** Breadcumb Area Start ***** -->
<div class="mosh-breadcumb-area" style="background-image: url(img/core-img/breadcumb.png);">
    <div class="container h-100">
        <div class="row h-100 align-items-center">
            <div class="col-12">
                <div class="bradcumbContent">
                    <h2>Registra un nuevo proyecto</h2>
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
                    <div class="card-header"><i class="fa fa-flask"></i>  {{ __('Registrar nuevo proyecto') }}</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('registerproject') }}">
                        @csrf

                            <div class="form-group row">
                                <label for="name" class="col-md-5 col-form-label text-md-right"><i class="fa fa-user-circle-o"></i>  {{ __('Nombre') }}</label>

                                <div class="col-md-4">
                                    <input id="name_project" type="text" class="form-control @error('name_project') is-invalid @enderror" name="name_project" value="{{ old('name_project') }}" required autocomplete="name" autofocus>


                                    @error('name_project')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="name" class="col-md-5 col-form-label text-md-right"><i class="fa fa-address-card"></i>  {{ __('Código de proyecto') }}</label>

                                <div class="col-md-4">
                                    <input id="code" type="text" class="form-control @error('code') is-invalid @enderror" name="code" value="{{ old('code') }}" autocomplete="code" autofocus>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-5 col-form-label text-md-right"><i class="fa fa-flag"></i>  {{ __('Estado del proyecto') }}</label>

                                <div class="col-md-4">
                                    <select name="state" class="form-control" >
                                        <option value="EN EJECUCION" 
                                        {{ old('state') == 'EN EJECUCION' ? 'selected' : '' }}>EN EJECUCION</option>
                                        <option value="EN EJECUCION" 
                                        {{ old('state') == 'POSTULADO' ? 'selected' : '' }}>POSTULADO</option>

                                        <option value="FINALIZADO"
                                        {{ old('state') == 'FINALIZADO' ? 'selected' : '' }}>FINALIZADO</option>
                                        
                                        <option value="CANCELADO"
                                        {{ old('state') == 'CANCELADO' ? 'selected' : '' }}>CANCELADO</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                            <label for="password" class="col-md-5 col-form-label text-md-right"><i class="fa fa-calendar"></i>  {{ __('Fecha de inicio') }}</label>

                             <div class="col-md-3">
                                    <input class="form-control @error('datestart') is-invalid @enderror" id="datestart" name="datestart" value="{{ old('datestart') }}" placeholder="DD/MM/YYYY" type="text" autocomplete="off" required />

                                @error('datestart')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                              </div>
                            </div>
                            <div class="form-group row">                                
                            <label for="password" class="col-md-5 col-form-label text-md-right"><i class="fa fa-calendar"></i>  {{ __('Fecha de término') }}</label>

                              <div class="col-md-3" >
                                     <input class="form-control @error('name') is-invalid @enderror" id="dateend" name="dateend" value="{{ old('dateend')}}" placeholder="DD/MM/YYYY" type="text" autocomplete="off" required/>
                              
                                    @if (\Session::has('faileddate'))
                                        <span class="invalid-feedback d-block" role="alert" align="center">
                                            <strong>{!! \Session::get('faileddate') !!}
                                            </strong>
                                        </span>
                                    @endif

                              </div>


                            </div>

                            <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-md-10">
                                    <p class="h5" style="margin-bottom:20px;"><strong>Investigadores disponibles</strong></p>

                                    @if (\Session::has('failedinv'))
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{!! \Session::get('failedinv') !!}</strong>
                                    </span>                                    
                                    @endif

                                        <table class="table table-striped">
                                        <thead class="alert alert-info">
                                            <tr>
                                                <th>
                                                <th>
                                                <th>Nombre investigador
                                                <th>
                                                <th>Unidad asociada</th>
                                            </tr>
                                        </thead>
                                        @foreach($invs as $inv)
                                            @if($inv->state == 'ACTIVO')
                                                @php
                                                    $nom = "check" . $i;
                                                @endphp
                                                <tr>
                                                    <td>
                                                    <td> <input class="form-check-input" type="checkbox" id="{{$nom}}" name="{{$nom}}" value="checked"></td>
                                                    <td>{{$inv->name}}
                                                    <td>
                                                    <td>{{$inv->associatedunit}}</td>
                                                </tr>
                                                @php
                                                    $names[] = $inv->name;
                                                    $i++;                     
                                                @endphp
                                            @endif
                                        @endforeach
                                        @php
                                            Session::put('names', $names);
                                        @endphp
                                        </table>
                                   </div>
                                   
                                </div>
                            </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button class="btn mosh-btn mt-50" type="submit">{{ __('Registrar proyecto') }}</button>
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
    </div>
    <div class="container" style="margin-top:30px;">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <table class="table table-striped">
                        <thead class="alert alert-info">
                                <th style="text-">Proyecto</th>
                                <th style="text-">Codigo Proyecto</th>
                                <th style="text-">Estado del Proyecto</th>
                                <th style="text-">Fecha inicio</th>
                                <th style="text-">Fecha termino</th>
                                
                                <!-- <th style="text-align:center">Estado</th> -->
                                <th style="text-align:center"> </th>
                        </thead>
                        <tbody>
                            @foreach($proyects as $proy)
                            <tr>
                                <td style="text-">{{$proy->name_project}}</td>
                                
                                <td>{{$proy->code}}</td>
                                <td>{{$proy->state}}</td>
                                <td>{{$proy->date_start}}</td>
                                <td>{{$proy->date_end}}</td>
                                
                                <td style="text-"><button onclick="editarProyecto({{ json_encode($proy)}} )" id=<?php echo("editBtn".$loop->index)?> type="button" class="btn-success btn-xs" data-toggle="modal" 
                                data-target="#editproy"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>Editar</button></td>
                                
                            </tr>
                            @endforeach
                        </tbody> 
                        </table>
                    </div>
                </div>
            </div>
</section>
<!-- ***** Contact Area End ***** -->

<!-- editarinformacion-->
<div id="editproy" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title titula">Editar este proyecto</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <form method="post" action="{{ route('registerproject') }}" class="form-horizontal" >
                @csrf
                <input name="_method" type="hidden" value="PUT">
                <input hidden name="id" id="editId" value="j"/>
                <div class="form-group ">
                    <label for="name" class="">{{ __('Proyecto') }}</label>

                    <div class="">
                        <input id="editProyect" type="text" class="form-control @error('name') is-invalid @enderror" name="name_project" value="{{ old('name') }}" required autocomplete="name" autofocus>
                        <span class="invalid-feedback d-block" role="alert">
                        <strong class="errorname"></strong>
                        </span>
                    </div>

                </div>

                <div class="form-group ">
                    <label for="name" class="">{{ __('Codigo') }}</label>

                    <div class="">
                        <input id="editCode" type="text" class="form-control @error('name') is-invalid @enderror" name="code" value="{{ old('code') }}" required autocomplete="name" autofocus>
                        <span class="invalid-feedback d-block" role="alert">
                            <strong class="errorpass"></strong>
                        </span>
                    </div>
                </div>


                <div class= "form-group">
                <label for="editState">Estado</label>
                    <select class="form-control assu" name="state" id= "editState">
                        <option value="EN EJECUCION">EN EJECUCION</option>
                        <option value="CANCELADO">CANCELADO</option>
                        <option value="FINALIZADO">FINALIZADO</option>
                    </select>
                </div>
                <div class="form-group ">
                    <label for="name" class="">{{ __('Fecha Inicio') }}</label>

                    <div class="">
                        <input id="editIni" type="text" class="form-control @error('name') is-invalid @enderror" name="date_start" value="{{ old('date_start') }}" required autocomplete="name" autofocus>
                        <span class="invalid-feedback d-block" role="alert">
                            <strong class="errorpass"></strong>
                        </span>
                    </div>
                </div>
                <div class="form-group ">
                    <label for="name" class="">{{ __('Fecha Termino') }}</label>

                    <div class="">
                        <input id="editFin" type="text" class="form-control @error('name') is-invalid @enderror" name="date_end" value="{{ old('date_end') }}" required autocomplete="name" autofocus>
                        <span class="invalid-feedback d-block" role="alert">
                            <strong class="errorpass"></strong>
                        </span>
                    </div>
                </div>
                <span class="success-feedback d-block" align="center" role="alert">
                <strong class="successall" style="color:#3BBF6C;"></strong>
                </span>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success add" id="add">
                 Editar Proyecto
                 </button>
            </div>
            </form>
        </div>
    </div>
</div>

