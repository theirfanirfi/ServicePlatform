@extends('layouts.frontlayout')

@push('after_css')
    <style type="text/css">
        input[type="file"] {
            display: none;
        }
        .custom-file-upload {
            border: 1px solid #ccc;
            display: inline-block;
            padding: 6px 12px;
            cursor: pointer;
        }
        #temp_title_files{
            display: none;
        }
        #clear-temp-files{
            display: none;
            margin-top: 7px;
        }
    </style>
@endpush

@section('frontcontent')

    <!-- Page Content -->
    <div class="container">
        @if ($message = session()->get('success'))
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <p>{{ $message }}</p>
            </div>
        @endif
        @if ($message = session()->get('error'))
            <div class="alert alert-error">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <p>{{ $message }}</p></div>
        @endif

        <div class="row">
            <div class="col-sm-12">
                <h2 class="mt-4">Project {{ $project->name }}</h2>
                {!! Form::model($project, ['route' => ['form.store.project'], 'files' => true]) !!}
                <div class="row">
                @if(!$project->exists || $project->canDelete())
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('ship_id', 'Ship') !!}
                            {!! Form::select('ship_id', auth()->user()->getShips()->pluck('name', 'id'), null, ['class' => 'form-control', 'id' => 'ship_id']) !!}
                            @if ($errors->has('ship_id'))
                                <span class="help-block">
                                  <strong>{{ $errors->first('ship_id') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('name') !!}
                            {!! Form::text('name', null, ['class' => 'form-control']) !!}
                            @if ($errors->has('name'))
                                <span class="help-block">
                                  <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('description') !!}
                            {!! Form::text('description', null, ['class' => 'form-control']) !!}
                            @if ($errors->has('description'))
                                <span class="help-block">
                                  <strong>{{ $errors->first('description') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('port') !!}
                            {!! Form::text('port', null, ['class' => 'form-control', 'id' => 'port']) !!}
                            @if ($errors->has('port'))
                                <span class="help-block">
                                  <strong>{{ $errors->first('port') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('date') !!}
                            {!! Form::text('date', null, ['class' => 'form-control dp']) !!}
                            @if ($errors->has('date'))
                                <span class="help-block">
                                  <strong>{{ $errors->first('date') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('eta') !!}
                            {!! Form::text('eta', null, ['class' => 'form-control dtp']) !!}
                            @if ($errors->has('eta'))
                                <span class="help-block">
                                  <strong>{{ $errors->first('eta') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('etb') !!}
                            {!! Form::text('etb', null, ['class' => 'form-control dtp']) !!}
                            @if ($errors->has('etb'))
                                <span class="help-block">
                                  <strong>{{ $errors->first('etb') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('etd') !!}
                            {!! Form::text('etd', null, ['class' => 'form-control dtp']) !!}
                            @if ($errors->has('etd'))
                                <span class="help-block">
                                  <strong>{{ $errors->first('etd') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-12">
                        @if(isset($sellers))

                            {{--<h4>Invite Seller</h4>
                            <div class="form-group clearfix">
                                @foreach($sellers as $seller)
                                    <div class="d-inline col-2 float-left">
                                        <label class="form-check-label d-block">
                                            {!! Form::radio('invitation', $seller->id, in_array($seller->id, $users_invited_id)) !!} {{ $seller->email }}
                                        </label>
                                    </div>
                                @endforeach

                                @if ($errors->has('invite_seller'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('invite_seller') }}</strong>
                                      </span>
                                @endif
                            </div>--}}
                        @endif

                        @if(isset($buyers))
                            <h4>Invite Buyer</h4>
                            <div class="form-group clearfix">
                                @foreach($buyers as $buyer)
                                    <div class="d-inline col-3 float-left">
                                        <label class="form-check-label d-block">
                                            {!! Form::radio('invitation', $buyer->id, in_array($buyer->id, $users_invited_id)) !!} {{ $buyer->email }}
                                        </label>
                                    </div>
                                @endforeach

                                @if ($errors->has('invite_seller'))
                                    <span class="help-block">
                                      <strong>{{ $errors->first('invite_seller') }}</strong>
                                    </span>
                                @endif
                            </div>

                        @endif

                    </div>
                @endif
                    <div class="col-12 mt-4">
                        <label for="file-upload" class="btn btn-warning">
                            <i class="fas fa-paperclip"></i> Attach files
                        </label>
                        <input id="file-upload" type="file" name="files[]" multiple/>
                        <div class="row mt-2">
                            <div class="col">
                                <div id="temp_title_files"><h3>Temporary files</h3></div>
                                <div class="col-12" id="temp_files"></div>
                                <div class="col-12"><a href="#" id="clear-temp-files">clear</a> </div>
                            </div>
                            <div class="col">
                                @if($project->files->count())
                                    <h3>Files</h3>
                                @endif
                                @foreach($project->files as $file)
                                    <div>
                                        <i class="fas fa-file"></i> {{ $file->filename }} <small><a href="#" class="file_delete"><i class="far fa-trash-alt"></i></a></small>
                                        <input type="hidden" name="files[]" value="{{ $file->getOriginal('filename') }}"> </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="mt-4 col-md-12 text-center">
                        <a class="btn btn-default" href="{{ route('projects') }}">back</a>
                        {!! Form::submit('Send', ['class' => 'btn btn-primary col-md-2']) !!}
                    </div>
                </div>
                <br><br>
                {!! Form::hidden('project_id', $project->id) !!}
                {!! Form::close() !!}
            </div>

        </div>
        <!-- /.row -->

    </div>
@endsection
@push('after_scripts')
    <script src="{{ asset('js/underscore.min.js') }}"></script>
    <script type="text/template" id="file_template">
        <div><i class="fas fa-file"></i> <%- name %></div>
    </script>
    <script>
        $(document).ready(function () {
            $('#ship_id').select2();
            $('.dtp').datetimepicker({
                format: 'd/m/Y H:i'
            });
            $('.dp').datetimepicker({
                timepicker:false,
                format: 'd/m/Y'
            });

            $(document).on('change', '#file-upload', function(e, i){
                console.log($(this).get(0).files);
                $('#temp_files').html('');
                $('#clear-temp-files').css('display', 'none');
                $('#temp_title_files').hide();
                $.each($(this).get(0).files, function(i, e){
                    file_template = _.template($('#file_template').html());
                    $('#temp_files').append(file_template(e));
                });
                if($(this).get(0).files.length) {
                    $('#temp_title_files').show();
                    $('#clear-temp-files').css('display', 'block');
                }
            });

            $('#clear-temp-files').click(function(e){
                e.preventDefault();
                $('#file-upload').val('').trigger('change');
            });

            $(document).on('click', '.file_delete', function(e){
                e.preventDefault();
                $(this).closest('div').css('text-decoration', 'line-through');
                $(this).closest('div').find('input').remove();
                $(this).hide();
            })
        });
    </script>
@endpush