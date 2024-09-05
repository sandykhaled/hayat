<div class="divider">
    <div class="divider-text">{{trans('common.main')}}</div>
</div>

<div class="row d-flex justify-content-start">
    <div class="col-3">
        <label class="form-label" for="mainText">{{trans('common.mainText')}}</label>
        {{Form::text('mainText',getSettingValue('mainText'),['id'=>'mainText','class'=>'form-control'])}}
    </div>
    <div class="col-3">
        <label class="form-label" for="mainDescription">{{trans('common.mainDescription')}}</label>
        {{Form::textarea('mainDescription',getSettingValue('mainDescription'),['id'=>'mainDescription','class'=>'form-control','rows'=>'5'])}}
    </div>

    <div class="col-3">
        <label class="form-label" for="mainPhoto">{{trans('common.mainPhoto')}}</label>

        {{ Form::file('mainPhoto', ['id' => 'mainPhoto', 'class' => 'form-control']) }}
        @if (getSettingValue('mainPhoto'))
                    <div class="mb-2 d-flex justify-content-center mt-2">
                        <img src="{{ asset('uploads/settings/' . getSettingValue('mainPhoto')) }}" alt="{{ trans('common.mainPhoto') }}" class="img-thumbnail" style="width:150px; height: 150px;">
                    </div>
                @endif
    </div>
    <div class="col-3">
        <label class="form-label" for="clientsCount">{{trans('common.clientsCount')}}</label>
        {{Form::text('clientsCount',getSettingValue('clientsCount'),['id'=>'clientsCount','class'=>'form-control'])}}
    </div>
</div>
<div class="row">
    <div class="divider">
        <div class="divider-text">{{trans('common.aboutUs')}}</div>
    </div>
    <div class="col-3">
        <label class="form-label" for="homeAboutUsText">{{trans('common.homeAboutUsText')}}</label>
        {{Form::text('homeAboutUsText',getSettingValue('homeAboutUsText'),['id'=>'homeAboutUsText','class'=>'form-control'])}}
    </div>
    <div class="col-6">
        <label class="form-label" for="homeAboutUsDescription">{{trans('common.homeAboutUsDescription')}}</label>
        {{Form::textarea('homeAboutUsDescription',getSettingValue('homeAboutUsDescription'),['id'=>'homeAboutUsDescription','class'=>'form-control','rows'=>'5'])}}
    </div>
</div>
<!--/ form -->
