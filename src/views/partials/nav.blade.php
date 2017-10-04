<div class="row wrapper border-bottom white-bg page-heading">

    <div class="col-lg-3 col-md-3 col-sm-4 hidden-xs">
        <h2>
            <i class="fa fa-cogs"></i>
            {{ trans("options::options.options") }}
        </h2>
        <ol class="breadcrumb ">
            <li>
                <a href="{{ URL::to(ADMIN . "/options") }}">{{ trans("options::options.options") }}</a>
            </li>
            <li class="active">
                <strong>{{ trans("options::options." . $option_page) }}</strong>
            </li>
        </ol>
    </div>

    <div class="col-lg-9 col-md-9 col-sm-8 col-xs-12">
        <ul class="nav nav-tabs option-tabs">

            @if(Gate::allows("options.general"))
            <li @if ($option_page == "main") class="active" @endif><a href="{{ route("admin.options.show") }}"><i class="fa fa-sliders"></i> <span class="hidden-sm hidden-xs hidden-md">{{ trans("options::options.main") }}</span></a></li>
            @endif

            @if(Gate::allows("options.seo"))
            <li @if ($option_page == "seo") class="active" @endif><a href="{{ route("admin.options.seo") }}"><i class="fa fa-line-chart"></i> <span class="hidden-sm hidden-xs hidden-md">{{ trans("options::options.seo") }}</span></a></li>
            @endif

            @if(Gate::allows("options.media"))
            <li @if ($option_page == "media") class="active" @endif><a href="{{ route("admin.options.media") }}"><i class="fa fa-camera"></i> <span class="hidden-sm hidden-xs hidden-md">{{ trans("options::options.media") }}</span></a></li>
            @endif

            @if(Gate::allows("options.social"))
            <li @if ($option_page == "social") class="active" @endif><a href="{{ route("admin.options.social") }}"><i class="fa fa-globe"></i>  <span class="hidden-sm hidden-xs hidden-md">{{ trans("options::options.social") }}</span></a></li>
            @endif

        </ul>
    </div>
</div>
