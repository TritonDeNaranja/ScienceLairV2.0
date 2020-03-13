@extends('layouts.admin') 
@extends('layouts.footer')

<head>
    
    <!-- Favicon -->
    <link rel="icon" href="imgTemp/icon.ico">

    <!--  jQuery -->
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>

    
</head>

<!-- ***** Breadcumb Area Start ***** -->
<div class="mosh-breadcumb-area" style="background-image: url(img/core-img/breadcumb.png);">
    <div class="container h-100">
        <div class="row h-100 align-items-center">
            <div class="col-12">
                <div class="bradcumbContent">
                    <h2>Registra un nuevo grupo y personalizalo</h2>
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
                <div class="card-header"><i class="fa fa-users"></i>  {{ __('Añadir nuevo grupo') }}</div>
                <div class="card-body">
                    <form method="POST" action="#" enctype="multipart/form-data">
                    {{ csrf_field() }}

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right"><i class="fa fa-user-circle-o"></i>  {{ __('Nombre') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row ">
                            <label for="email" class="col-md-4 col-form-label text-md-right"><i class="fa fa-file-image-o"></i>  {{ __('Logo') }}</label>

                             <div class="col-md-6 ">
                                
                                 <input type="file" name="select_file"/>
                                 <span class="text-muted">jpg, png</span>                                 

                            
                                @error('select_file')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{$message}}</strong>
                                    </span>

                                @enderror 
                            
                                
                            </div> 
                        </div>

                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-md-8">
                                    <table class="table table-striped">
                                    <thead class="alert alert-info">
                                            <th style="text-align:center">Unidad asociada</th>
                                            <th style="text-align:center">País</th>
                                            <th style="text-align:center"><a href="#" class="btn btn-info addRow">+</a></th>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><input id="unidad" type="text" class="form-control @error('name') is-invalid @enderror" name="unidades[]" value="{{ old('unidades.0')}}" required autocomplete="name" autofocus></td>

                                            <td><input id="pais" type="text" class="form-control @error('name') is-invalid @enderror" name="paises[]" value="{{ old('paises.0') }}" required autocomplete="name" autofocus></td>
                                            <td style="text-align:center"> </td>
                                        </tr>
                                    </tbody> 
                                    </table>
                                </div>
                            </div>
                        </div>
                        <script type = "text/javascript">
                            $('.addRow').on('click', function(){
                                addRow();
                                return false;
                            });

                            function addRow(){
                                var tr = '<tr>' +
                                            '<td><input id="unidad" type="text" class="form-control @error('name') is-invalid @enderror" name="unidades[]" required autocomplete="name" autofocus></td>' +
                                            '<td><input id="pais" type="text" class="form-control @error('name') is-invalid @enderror" name="paises[]" required autocomplete="name" autofocus></td>' +
                                            '<td style="text-align:center"><a href="#" class="btn btn-danger remove">-</a></td>'+
                                        '</tr>';
                                    $('tbody').append(tr);
                            };

                            $('tbody').on('click', '.remove', function(){
                                $(this).parent().parent().remove();
                                return false;
                            });


                        </script>

                        @if(count($errors) > 0)
                            <php>
                            @for ($x = 1; $x < count(Session::get('uni')); $x++)
                                <script type="text/javascript">
                                        var tr = '<tr>' +
                                                    '<td><input id="unidad" type="text" class="form-control @error('name') is-invalid @enderror" name="unidades[]" required autocomplete="name" value="{{session()->get('uni')[$x]}}"autofocus ></td>' +
                                                    
                                                    '<td><input id="pais" type="text" class="form-control @error('name') is-invalid @enderror" name="paises[]" required autocomplete="name" value="{{session()->get('pai')[$x]}}"autofocus></td>' +

                                                    '<td style="text-align:center"><a href="#" class="btn btn-danger remove">-</a></td>'+
                                                '</tr>';
                                            $('tbody').append(tr);                                            
                                </script>
                                
                            @endfor
                            </php >
                        @endif

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button class="btn mosh-btn mt-50" type="submit">{{ __('Añadir nuevo grupo') }}</button>
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
</section>
<!-- ***** Contact Area End ***** -->


