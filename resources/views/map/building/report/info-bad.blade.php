@extends('components.container.contain-action-6')
@section('content_action')
<!-- notify bad info -->
    <div class="panel panel-default tf-border-none tf-padding-none">
        <div class="panel-heading tf-bg tf-color-white tf-border-none">
            Notify bad information
        </div>
        <div class="panel-body">
            <form class="col-sm-10 col-sm-offset-1 form-horizontal" enctype="multipart/form-data" method="post" action="">
                <div class="form-group">
                    <div class="radio">
                        <label>
                            <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked>
                            Spam
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked>
                            Sex
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked>
                            Politic
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-12 text-center">
                        <input type="hidden" name="_token" value="{!! csrf_token() !!}" />
                        <button type="submit" class="btn btn-default">Save</button>
                        <a class="btn btn-default" href="">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
<!-- end notify bad info -->
@endsection