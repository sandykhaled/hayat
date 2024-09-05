<div class="divider">
    <div class="divider-text">{{trans('common.aboutUsSetting')}}</div>
</div>

<div class="row d-flex justify-content-start">
    <div class="col-3">
        <label class="form-label" for="aboutUsText">{{trans('common.aboutUsText')}}</label>
        {{Form::text('aboutUsText',getSettingValue('aboutUsText'),['id'=>'aboutUsText','class'=>'form-control'])}}
    </div>
    <div class="col-3">
        <label class="form-label" for="aboutUsDescription">{{trans('common.aboutUsDescription')}}</label>
        {{Form::textarea('aboutUsDescription',getSettingValue('aboutUsDescription'),['id'=>'aboutUsDescription','class'=>'form-control','rows'=>'5'])}}
    </div>

    <div class="col-3">
        <label class="form-label" for="aboutUsPhoto">{{trans('common.aboutUsPhoto')}}</label>

        {{ Form::file('aboutUsPhoto', ['id' => 'aboutUsPhoto', 'class' => 'form-control']) }}
        @if (getSettingValue('aboutUsPhoto'))
            <div class="mb-2 d-flex justify-content-center mt-2">
                <img src="{{ asset('uploads/settings/' . getSettingValue('aboutUsPhoto')) }}" alt="{{ trans('common.aboutUsPhoto') }}" class="img-thumbnail" style="width:150px; height: 150px;">
            </div>
        @endif
    </div>
</div>
