@extends('design.index')
@section('titlePage')
    Request
@endsection
@section('tf_design_main_content')
    <div class="panel panel-default ">
        <!-- title -->
        <div class="panel-heading tf-bg-none tf-border-none text-center">
            <h4>Welcome designer</h4>
        </div>
        <!-- end title -->
        <!-- form request -->
        <div class="panel-body">
            <div class="col-md-10 col-md-offset-1 col-lg-10 col-lg-offset-1">
                <form class="form-horizontal" role="form">
                    <div class="form-group">
                        <div class="col-sm-10 col-sm-offset-2">
                            <a class="tf-link-red">Rule request design ?</a>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">Select width</label>
                        <div class="col-sm-10">
                            <select class="form-control">
                                <option>128</option>
                                <option>160</option>
                                <option>192</option>
                                <option>224</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputPassword3" class="col-sm-2 control-label">Size design</label>
                        <div class="col-sm-10" >
                            <div class="tf-overflow-auto tf-height-300" style="">
                                <label class="radio tf-margin-lef-32">
                                    <input type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1">
                                    <img src="{!! asset('public/imgsample/area.gif') !!}" />&nbsp;&nbsp;&nbsp;
                                    size(128x96) | Point: 100
                                </label>
                                <label class="radio tf-margin-lef-32">
                                    <input type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1">
                                    <img src="{!! asset('public/imgsample/area.gif') !!}" />&nbsp;&nbsp;&nbsp;
                                    size(96x96) | Point: 100
                                </label>
                                <label class="radio tf-margin-lef-32">
                                    <input type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1">
                                    <img src="{!! asset('public/imgsample/area.gif') !!}" />&nbsp;&nbsp;&nbsp;
                                    size( 128x 128 ) | Point: 150
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputPassword3" class="col-sm-2 control-label">Object design</label>
                        <div class="col-sm-10" >
                            <label class="radio-inline">
                                <input type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1">Building
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2"> Avatar
                            </label>
                            <label class="radio-inline">
                                <span class="tf-link-red" onclick="tf_show('#explainObject');" href="">(what is it?)</span>
                            </label>
                            <div id="explainObject" class="panel panel-default tf-display-none">
                                <div class="panel-body">
                                    description object description object description object description object <br/>
                                    description object description object description object description object <br/>
                                    description object description object description object description object <br/>
                                    <span class="tf-link-red" onclick="tf_hide('#explainObject');" href="">Hide</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">Field applied</label>
                        <div class="col-sm-10">
                            <select class="form-control">
                                <option>private</option>
                                <option>public</option>
                            </select>
                            <span class="tf-link-red" onclick="tf_show('#explainFild');" href="">(what is it?)</span>
                            <div id="explainFild" class="panel panel-default tf-display-none">
                                <div class="panel-body">
                                    description field description field description field description field <br/>
                                    description field description field description field description field <br/>
                                    description field description field description field description field<br/>
                                    <span class="tf-link-red" onclick="tf_hide('#explainFild');" href="">Hide</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">Pattern design	</label>
                        <div class="col-sm-10">

                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">Pattern design	</label>
                        <div class="col-sm-10">
                            <label for="exampleInputFile">File input</label>
                            <input type="file" id="exampleInputFile">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">Description design	</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" rows="5" placeholder="Description request..."></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <div class="checkbox">
                                <label>
                                    <input name="readrule" type="checkbox"> I have read the rule
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10 text-center">
                            <input type="hidden" name="_token" value="{!! csrf_token() !!}" />
                            <button type="submit" class="btn btn-primary btn-sm">Send</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- form request -->
    </div>
@endsection