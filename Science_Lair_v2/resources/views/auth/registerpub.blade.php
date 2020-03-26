@php
    use Illuminate\Support\Facades\DB;
    $proys = DB::table('projects')->get();
    $invs = DB::table('investigators')->get();
    $publications = DB::table('publications')->get();
    $authors = DB::table('publication_invs')->get();
    $names = [];
    $i=0;
    $couunis = DB::table('country_units')->get();
    $cu = [];
@endphp

@extends(isset(Auth::user()->user_type) ? (Auth::user()->user_type == 'ADMINISTRADOR')? 'layouts.admin': 'layouts.inv' : 'layouts.people')
@extends('layouts.footer')

<head>
<script type="text/javascript">
    var titleOr = '';
</script>

<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script>
    function editarPublicacion(publication) {
        $("#titleOr").val(publication.title);


        $("#editTitle").val(publication.title);
        $("#editTitle2").val(publication.title2);
        $("#editRevact").val(publication.revact);
        $("#editDate").val(publication.date);
        $("#editPubtype").val(publication.pubtype);
        $("#editSubPubtype").val(publication.subpubtype);
        $("#editProy").attr('value',publication.proy);
        
        
    }
    console.log('publication')

    </script>
    <script type="text/javascript">
        $(document).on('click','.addEdit', function() {
            $.ajaxSetup({
              headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
            });

            $.ajax({
                type: 'POST',
                url: 'editpub',
                data: {
                    '_token': $('input[name=_token]').val(),
                    

                    'title': $('input[name=editTitle]').val(),
                    'title2': $('input[name=editTitle2]').val().toUpperCase(),
                    'pubtype': $('input[name=editPubtype]').val().toUpperCase(),
                    'subpubtype': $('input[name=editSubPubtype]').val(),
                    'revact': $('input[name=editRevact]').val(),
                    'date': $('input[name=editDate]').val(),

                    'proy': $('input[name=editProy]').val(),
                },
                success: function(data){
                    
                                        

                }
            });
        });
    </script>

    <script type="text/javascript">
        
        const INDX = [
        {
            value: "INDEXADA",
            options : ["WOS", "SCOPUS", "SCIELO","OTRO INDICE"]
        },{
            value : "NO INDEXADA",
            options : ["CONGRESO", "REVISTA"]
        }
    ]

    $(document).ready(function() {
        $("#editPubtype").on('change',function() {
    // <!--Se obtiene la opcion seleccionada.-->
        const valor = $(this).val();
        //<!--// Obtener opciones para el select hijo-->
        for(let i=0; i<INDX.length; i++) {
            if (INDX[i].value == valor) {
                const selectSubtipo = $("#editSubPubtype");

                selectSubtipo.empty();

                for (let j=0; j<INDX[i].options.length; j++) {
                    const optionValue = INDX[i].options[j];
                    const option = $('<option></option>').attr("value", optionValue).text(optionValue);
                    selectSubtipo.append(option);
                }
            }
        }
    }
    );
    })
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
    
    <!-- Favicon -->
    <link rel="icon" href="imgTemp/icon.ico">

    <meta name="csrf-token" content="{{ csrf_token() }}">
     
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
          var date=$('input[name="date"]');
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
          date.datepicker(options);
        })
    </script>

    <script type="text/javascript">
        jQuery(document).ready(function(){
            function loadCareer() {
                var pubg = $('.pubg').val();

                $('.subpubg').empty();
                var old = $('.subpubg').data('old') != '' ? $('.subpubg').data('old') : '';

                if(pubg == 'NO INDEXADA'){
                    $('.subpubg').append("<option value='CONGRESO'" + 
                                        (old == 'CONGRESO' ? 'selected' : '') + 
                                        ">CONGRESO</option>");

                    $('.subpubg').append("<option value='REVISTA'" + 
                                        (old == 'REVISTA' ? 'selected' : '') + 
                                        ">REVISTA</option>");
                }else{
                    $('.subpubg').append("<option value='WOS'" + 
                                        (old == 'WOS' ? 'selected' : '') + 
                                        ">WOS</option>");

                    $('.subpubg').append("<option value='SCOPUS'" + 
                                        (old == 'SCOPUS' ? 'selected' : '') + 
                                        ">SCOPUS</option>");

                    $('.subpubg').append("<option value='SCIELO'" + 
                                        (old == 'SCIELO' ? 'selected' : '') + 
                                        ">SCIELO</option>");

                    $('.subpubg').append("<option value='OTRO INDICE'" + 
                                        (old == 'OTRO INDICE' ? 'selected' : '') + 
                                        ">OTRO INDICE</option>");

                }

            }
            loadCareer();
            $('.pubg').on('change', loadCareer);
        });
    </script>

    <script type="text/javascript">
            var extinv = [];
            var assinv = [];
    </script>

    <script type="text/javascript">
         $(document).on('click','.add', function() {
            $.ajaxSetup({
              headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
            });

            $.ajax({
              type: 'POST',
              url: 'registerpubinv',
              data: {
                '_token': $('input[name=_token]').val(),
                'name': $('input[name=name]').val().toUpperCase(),
                'passportnumber': $('input[name=passportnumber]').val()
              },
              success: function(data){
                if ((data.errors)) {
                    if(data.errors.name){
                        $('.errorname').text(data.errors.name);
                    }
                    if(data.errors.passportnumber){
                        $('.errorpass').text(data.errors.passportnumber);
                    }
                } else {
                    if(!extinv.includes(data.name)){
                        extinv.push(data.name);
                        assinv.push($('.assu').val());
                        //console.log(extinv);
                        $('#table').append("<tr style='background-color:#D6F3E4;'>"+
                          "<td>"+
                          "<td>" + 
                          "<td>" + data.name.toUpperCase() + "</td>"+
                          "<td>" +
                          "<td>" + $('.assu').val() + "</td>"+
                          "</tr>");
                        $('.errorname').text('');
                        $('.errorpass').text('');
     
                        $.post("extinv", {
                            "extinv": extinv,
                            "assinv": assinv
                        });
                        $('.successall').text('Publication externo agregado');
                        $('.successall').fadeIn().delay(3000).fadeOut();
                        console.log(extinv);
                    }
                    else{
                        $('.errorname').text('Publication externo ya agregado');
                        }
                    }

                },
                });

                $.ajax({
                  type: 'POST',
                  url: 'extinv',
                  data: {
                    'extinv': extinv,
                    'assinv': assinv
                    },
                });
           });
    </script> 
</head>

<!-- ***** Breadcumb Area Start ***** -->
<div class="mosh-breadcumb-area" style="background-image: url(img/core-img/breadcumb.png);">
    <div class="container h-100">
        <div class="row h-100 align-items-center">
            <div class="col-12">
                <div class="bradcumbContent">
                    <h2>Registra una nueva publicación</h2>
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
                    <div class="card-header"><i class="fa fa-newspaper-o"></i>  {{ __('Registrar nueva publicación') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('registerpub') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right"><i class="fa fa-etsy"></i>  {{ __('Título de publicación') }}</label>

                                <div class="col-md-6">
                                    <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" required autocomplete="name" autofocus>

                                    @error('title')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right"><i class="fa fa-quora"></i>  {{ __('Título segundo idioma') }}</label>

                                <div class="col-md-6">
                                    <input id="title2" class="form-control @error('title2') is-invalid @enderror" name="title2" value="{{ old('title2') }}" autocomplete="name">

                                    @error('title2')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right"><i class="fa fa-files-o"></i>  {{ __('Revista o acta') }}</label>

                                <div class="col-md-6">
                                    <input id="revact" type="text" class="form-control @error('revact') is-invalid @enderror" name="revact" value="{{ old('revact') }}" required autocomplete="name" autofocus>

                                    @error('revact')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right"><i class="fa fa-calendar"></i>  {{ __('Fecha de publicación') }}</label>

                                  <div class="col-md-3" >
                                         <input class="form-control @error('date') is-invalid @enderror" id="date" name="date" value="{{ old('date')}}" placeholder="DD/MM/YYYY" type="text" autocomplete="off" required/>
                                  </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right"><i class="fa fa-list-alt"></i>  {{ __('Tipo de publicación') }}</label>

                                <div class="col-md-3">
                                    <select name="pubtype" class="form-control pubg" required value="{{old('pubtype')}}">
                                        <option value="INDEXADA" 
                                        {{ old('pubtype') == 'INDEXADA' ? 'selected' : '' }}>
                                        INDEXADA</option>

                                        <option value="NO INDEXADA" 
                                        {{ old('pubtype') == 'NO INDEXADA' ? 'selected' : '' }}>
                                        NO INDEXADA</option>
                                    </select>
                                </div>

                                <label for="password" class="col-md-2 col-form-label text-md-right"><i class="fa fa-list-alt"></i>  {{ __('Subtipo') }}</label>

                                <div class="col-md-3">
                                    <select name="subpubtype" class="form-control subpubg" data-old="{{ old('subpubtype') }}" required>
                                    </select>
                                </div>

                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right"><i class="fa fa-users"></i>  {{ __('Proyecto Asociado') }}</label>

                                  <div class="col-md-6" >
                                        <select name="proy" class="form-control" required>
                                        @foreach($proys as $proy)
                                            @if($proy->state == 'EN EJECUCION')
                                                <option value="{{ $proy->name_project }}" 
                                                    @if(old('proy') == $proy->name_project) 
                                                        selected 
                                                    @endif>{{$proy->name_project}}
                                                </option>
                                            @endif
                                        @endforeach
                                        <option value="NULL" 
                                        @if(old('proy') == 'NULL') 
                                            selected 
                                        @endif>NO ASOCIAR NINGUN PROYECTO</option>
                                        </select>
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

                                        <table class="table table-striped" id="table">
                                            <thead class="alert alert-info">
                                                <tr>
                                                    <th>
                                                    <th>
                                                    <th>Nombre publication
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
                                                Session::put('names_inv', $names);
                                            @endphp
                                        </table>
                                        @if (\Session::has('failedinv') || count($errors) > 0)
                                            @if(\Session::has('extinv'))
                                                @for ($x = 0; $x < count(Session::get('extinv')); $x++)
                                                    <script type="text/javascript">

                                                        var filaa = "<tr style='background-color:#D6F3E4;'>"+
                                                                "<td>"+
                                                                "<td>" + 
                                                                "<td>{{session()->get('extinv')[$x]}}</td>"+
                                                                "<td>" +
                                                                "<td>{{session()->get('assinv')[$x]}}</td>"+
                                                                "</tr>";
                                                        $('.table').append(filaa);
                                                        extinv.push("{{session()->get('extinv')[$x]}}");
                                                        assinv.push("{{session()->get('assinv')[$x]}}")
                                                    </script>
                                                @endfor
                                            @endif
                                        @endif
                                        <a href="#" class="pull-left create-modal" data-toggle="modal" 
                                            <a href="#" class="pull-left create-modal" data-toggle="modal" 
                                        <a href="#" class="pull-left create-modal" data-toggle="modal" 
                                        data-target="#newinv" >Registrar investigador externo</a>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button class="btn mosh-btn mt-50" type="submit"
                                    style="margin-top:20px;">
                                        {{ __('Registrar publicación') }}
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
    </div>
    <div class="container" style="margin-top:30px;">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <table class="table table-striped">
                    <thead class="alert alert-info">
                        <th style="text-">Titulo</th>
                        <th style="text-">Titulo en otro dioma</th>
                        <th style="text-">Tipo</th>
                        <th style="text-">Subtipo</th>
                        <th style="text-">Revista/Acta</th>
                        <th style="text-">Fecha</th>
                        <th style="text-">Proyecto</th>
                        <th style="text-">Autores</th>
                        
                        
                        <th style="text-align:center"> </th>
                    </thead>
                    <tbody>
                        @foreach($publications as $pub)
                            <tr>
                                <td style="text-">{{$pub->title}}</td>
                                
                                
                                <td>{{$pub->title2}}</td>
                                <td>{{$pub->pubtype}}</td>
                                <td>{{$pub->subpubtype}}</td>
                                <td>{{$pub->revact}}</td>
                                <td>{{$pub->date}}</td>
                                <td>{{$pub->proy}}</td>
                                                                
                                <!--Lista de autores se despliega hacia abajo con boton-->
                                <!--<td>{{$pub->created_at}}</td> -->
                                <td><select name="autor" class="form-control" required>
                                
                                    @foreach($authors as $autor)
                                        
                                        @if(($autor->title_inv)==($pub->title))
                                            <option>{{$autor->nameinv}}</option>
                                        @endif
                                        
                                    @endforeach
                                    
                                </td>

                                <td style="text-"><button onclick="editarPublicacion({{ json_encode($pub)}} )" id=<?php echo("editBtn".$loop->index)?> type="button" class="btn-success btn-xs" data-toggle="modal" 
                                data-target="#editpub"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>Editar</button></td>
                                
                            </tr>
                        @endforeach
                    </tbody> 
                </table>
            </div>
        </div>
    </div>
</section>
<!-- ***** Contact Area End ***** -->

<div id="newinv" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Registra un investigador externo</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
            <form class="form-horizontal" role="form">
                <div class="form-group row">
                    <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Nombre completo') }}</label>

                    <div class="col-md-7">
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                        <span class="invalid-feedback d-block" role="alert">
                            <strong class="errorname"></strong>
                        </span>
                    </div>

                </div>

                <div class="form-group row">
                    <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('N° de pasaporte') }}</label>

                    <div class="col-md-7">
                        <input id="passportnumber" type="text" class="form-control @error('name') is-invalid @enderror" name="passportnumber" value="{{ old('passportnumber') }}" required autocomplete="name" autofocus>
                        <span class="invalid-feedback d-block" role="alert">
                            <strong class="errorpass"></strong>
                        </span>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="password" class="col-md-6 col-form-label text-md-right">{{ __('Unidad correspondiente') }}</label>
                    <div class="col-md-4">
                        <select name="associatedunit" class="form-control assu">
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
            </form>
            <span class="success-feedback d-block" align="center" role="alert">
                <strong class="successall" style="color:#3BBF6C;"></strong>
            </span>
            </div>
                <div class="modal-footer">
                <button type="submit" class="btn btn-success add" id="add">
                    {{ __('Registrar investigador externo') }}
                </button>
            </div>
        </div>
    </div>
</div>

<!--editar informacion-->
<div id="editpub" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title titula">Editar una publicacion existente</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
        
            <div class="modal-body">
                <form method="POST" action="{{ route('registerpub') }}" class="form-horizontal" >

                @csrf
                <input name="_method" type="hidden" value="PUT">
                <input hidden name="titleOr" id="titleOr" value="titleOr"/>

                <div class="form-group ">
                    <label for="name" class="">{{ __('Titulo') }}</label>

                    <div class="">
                        <input id="editTitle" type="text" class="form-control" name="title" value="{{ old('editTitle') }}" required autocomplete="editTitle" autofocus>
                        <span class="invalid-feedback d-block" role="alert">
                            <strong class="errorname"></strong>                            <strong class="errorname"></strong>
                        </span>
                    </div>
                
                </div>

                <div class="form-group ">
                    <label for="name" class="">{{ __('Titulo en otro idioma') }}</label>

                    <div class="">
                        <input id="editTitle2" type="text" class="form-control" name="title2" value="{{ old('editTitle2') }}" required autocomplete="editTitle2" autofocus>
                        <span class="invalid-feedback d-block" role="alert">
                            <strong class="errorpass"></strong>
                        </span>
                    </div>
                </div>
                <div class= "form-group">
                    <label for="editPubtype">Tipo</label>
                        <select class="form-control state" name="pubtype" id= "editPubtype">
                            <option value="INDEXADA">INDEXADA</option>
                            <option value="NO INDEXADA">NO INDEXADA</option>
                        </select>
                </div>
                <div class= "form-group">
                    <label for="editSubPubtype">Sub tipo</label>
                        
                        <select class="form-control state" name="subpubtype" id= "editSubPubtype">
                                
                                
                        
                        </select>
                </div>
                <div class="form-group ">
                    <label for="name" class="">{{ __('Revista / Acta') }}</label>

                    <div class="">
                        <input id="editRevact" type="text" class="form-control" name="revact" value="{{ old('editRevact') }}" required autocomplete="editRevact" autofocus>
                        <span class="invalid-feedback d-block" role="alert">
                            <strong class="errorpass"></strong>
                        </span>
                    </div>
                </div>
                
                <div class="form-group ">
                    <label for="name" class="">{{ __('Proyecto') }}</label>

                    <div class="">
                        <input id="editProy" type="text" class="form-control" name="proy" value="{{ old('editProy') }}" required autocomplete="editProy" autofocus>
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
                <button type="submit" class="btn btn-success addEdit" id="addEdit">
                    {{ __('Editar publicacion') }}
                </button>
            </div> 
            </form>
        </div>
    </div>
</div>

