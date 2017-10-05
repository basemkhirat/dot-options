@extends("admin::layouts.master")

@section("content")

    <form action="" method="post">

        @include("options::partials.nav")

        <div class="wrapper wrapper-content fadeInRight">

            @include("admin::partials.messages")

            <input type="hidden" name="_token" value="{{ csrf_token() }}"/>

            <div class="row">

                <div class="col-md-12">
                    <div class="panel ">

                        <div class="panel-body">
                            <div class="tab-content">
                                <div id="options_main" class="tab-pane active">
                                    <div class="row">
                                        <div class="col-md-6">


                                            <div class="form-group">
                                                <label
                                                    for="site_name">{{ trans("options::options.attributes.site_name") }}</label>
                                                <input name="site_name" type="text"
                                                       value="{{ @Request::old("site_name", Config::get("site_name")) }}"
                                                       class="form-control" id="site_name"
                                                       placeholder="{{ trans("options::options.attributes.site_name") }}">
                                            </div>

                                            <div class="form-group">
                                                <label
                                                    for="site_slogan">{{ trans("options::options.attributes.site_slogan") }}</label>
                                                <input name="site_slogan" type="text"
                                                       value="{{ @Request::old("site_slogan", Config::get("site_slogan")) }}"
                                                       class="form-control" id="site_slogan"
                                                       placeholder="{{ trans("options::options.attributes.site_slogan") }}">
                                            </div>

                                            <div class="form-group">
                                                <label
                                                    for="site_email">{{ trans("options::options.attributes.site_email") }}</label>
                                                <input name="site_email" type="text"
                                                       value="{{ @Request::old("site_email", Config::get("site_email")) }}"
                                                       class="form-control" id="site_email"
                                                       placeholder="{{ trans("options::options.attributes.site_email") }}">
                                            </div>

                                            <div class="form-group">
                                                <label
                                                    for="site_copyrights">{{ trans("options::options.attributes.site_copyrights") }}</label>
                                                <input name="site_copyrights" type="text"
                                                       value="{{ @Request::old("site_copyrights", Config::get("site_copyrights")) }}"
                                                       class="form-control" id="site_copyrights"
                                                       placeholder="{{ trans("options::options.attributes.site_copyrights") }}">
                                            </div>

                                            <div class="form-group">
                                                <label
                                                    for="timezone">{{ trans("options::options.attributes.timezone") }}</label>
                                                <select id="timezone" class="form-control chosen-select chosen-rtl"
                                                        name="app_timezone">
                                                    
                                                    @for ($i = -12; $i <= 12; $i++) 
                                                    <?php
                                                    if ($i == 0) {
                                                        $zone = "";
                                                    } elseif ($i > 0) {
                                                        $zone = "+$i";
                                                    } else {
                                                        $zone = $i;
                                                    }
                                                    ?>
                                                    <option
                                                        value="Etc/GMT{{ $zone }}"
                                                        @if (Config::get("app.timezone") == "Etc/GMT" . $zone) selected="selected" @endif>
                                                        GMT{{ $zone }}</option>
                                                    @endfor
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label
                                                    for="date_format">{{ trans("options::options.attributes.date_format") }}</label>
                                                <select id="date_format" class="form-control chosen-select chosen-rtl"
                                                        name="date_format">
                                                    @foreach (array("Y-m-d H:i A", "Y-m-d", "d/m/Y", "H:i A") as $format)
                                                    <option
                                                        value="{{ $format }}"
                                                        @if (Config::get("date_format") == $format) selected="selected" @endif>{{ date($format, time() - 2 * 60 * 60) }}</option>
                                                    @endforeach
                                                    <option
                                                        value="relative"
                                                        @if (Config::get("date_format") == "relative") selected="selected" @endif>{{ time_ago(time() - 2 * 60 * 60) }}</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label
                                                    for="app_locale">{{ trans("options::options.attributes.locale") }}</label>
                                                <select id="app_locale" class="form-control chosen-select chosen-rtl"
                                                        name="app_locale">
                                                    @foreach (Config::get("admin.locales") as $code => $lang)
                                                    <option
                                                        value="{{ $code }}"
                                                        @if (Config::get("app.locale") == $code) { selected="selected" @endif>{{ $lang["title"] }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <fieldset>
                                                <legend>{{ trans("options::options.attributes.site_status") }}</legend>

                                                <div class="form-group switch-row">
                                                    <label class="col-sm-10 control-label"
                                                           for="site_status">{{ trans("options::options.attributes.site_status") }}</label>
                                                    <div class="col-sm-2">
                                                        <input
                                                            @if (Config::get("site_status")) checked="checked"
                                                            @endif
                                                            type="checkbox" id="site_status" name="site_status"
                                                            value="1"
                                                            class="switcher switcher-sm">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label
                                                        for="offline_message">{{ trans("options::options.attributes.offline_message") }}</label>
                                                    <br/>
                                                    <textarea class="form-control" id="offline_message"
                                                              name="offline_message"
                                                              placeholder="{{ trans("options::options.attributes.offline_message") }}">{{ @Request::old("offline_message", Config::get("offline_message")) }}</textarea>
                                                </div>

                                            </fieldset>

                                        </div>
                                        <div class="col-md-6">


                                            <div class="widget style1 navy-bg">
                                                <div class="row">

                                                    <div class="col-xs-8 text-left">
                                                        <span> {{ trans("options::options.dot_version") }}
                                                            : </span>
                                                        <h2 class="font-bold"
                                                            style="font-family: sans-serif,Verdana, Arial">{{ DOT_VERSION }}</h2>
                                                    </div>

                                                    <div class="col-xs-4 text-center">
                                                        <i class="fa fa-cloud fa-5x"></i>
                                                    </div>

                                                </div>
                                            </div>

                                            <div class="row text-center">
                                                <a href="javascript:void(0)"
                                                   data-loading-text="{{ trans("options::options.checking") }}"
                                                   class="btn btn-primary btn-labeled btn-main check-update"> <span
                                                        class="btn-label icon fa fa-life-ring"></span> &nbsp;
                                                    {{ trans("options::options.check_for_update") }}
                                                </a>
                                            </div>

                                            <br/> <br/>

                                            <div class="update-status">

                                                @if(version_compare(Config::get("latest_version"), DOT_VERSION, ">"))
                                                @include("options::update", ["version" => Config::get("latest_version")])
                                                @endif

                                            </div>

                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>

                    </div>
                </div>
            </div>

            <div style="clear:both"></div>
            <div>
                <div class="container-fluid">
                    <div class="form-group">
                        <input type="submit" class="pull-left btn btn-flat btn-primary"
                               value="{{ trans("options::options.save_options") }}"/>
                    </div>
                </div>
            </div>

        </div>

    </form>

@stop


@push("header")
    <link href="{{ assets("admin::tagit") }}/jquery.tagit.css" rel="stylesheet" type="text/css">
    <link href="{{ assets("admin::tagit") }}/tagit.ui-zendesk.css" rel="stylesheet" type="text/css">
@endpush

@push("footer")
    <script src="{{ assets("admin::tagit") }}/tag-it.js"></script>
    <script>
        $(document).ready(function () {
            var elems = Array.prototype.slice.call(document.querySelectorAll('.switcher'));
            elems.forEach(function (html) {
                var switchery = new Switchery(html);
            });
        });
    </script>
    <script>
        $(document).ready(function () {

            $(".check-update").click(function () {

                var base = $(this);

                base.button("loading");

                $.post("{{ route("admin.options.check_update") }}", function (result) {


                    $(".update-status").html(result);

                    base.button("reset");


                }).fail(function () {
                    base.button("reset");
                });

            });


            $("#mytags").tagit({
                singleField: true,
                singleFieldNode: $('#tags_names'),
                allowSpaces: true,
                minLength: 2,
                placeholderText: "",
                removeConfirmation: true,
                tagSource: function (request, response) {
                    $.ajax({
                        url: "{{ route("admin.google.search") }}",
                        data: {term: request.term},
                        dataType: "json",
                        success: function (data) {
                            console.log(data);
                            response($.map(data, function (item) {
                                return {
                                    label: item.name,
                                    value: item.name
                                }
                            }));
                        }
                    });
                }
            });


        });
    </script>
@endpush
