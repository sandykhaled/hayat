<!-- form -->
<div class="row">
    <div class="divider">
        <div class="divider-text">{{trans('common.serviceSettings')}}</div>
    </div>
    <div class="col-3">
        <label class="form-label" for="serviceText">{{trans('common.serviceText')}}</label>
        {{Form::text('serviceText',getSettingValue('serviceText'),['id'=>'serviceText','class'=>'form-control'])}}
    </div>
    <div class="col-3">
        <label class="form-label" for="serviceDescription">{{trans('common.serviceDescription')}}</label>
        {{Form::textarea('serviceDescription',getSettingValue('serviceDescription'),['id'=>'serviceDescription','class'=>'form-control','rows'=>'5'])}}
    </div>
    <div class="col-3">
        <label class="form-label" for="aboutUsPhoto">{{trans('common.servicePhoto')}}</label>

        {{ Form::file('servicePhoto', ['id' => 'servicePhoto', 'class' => 'form-control']) }}
        @if (getSettingValue('servicePhoto'))
            <div class="mb-2 d-flex justify-content-center mt-2">
                <img src="{{ asset('uploads/settings/' . getSettingValue('servicePhoto')) }}" alt="{{ trans('common.servicePhoto') }}" class="img-thumbnail" style="width:150px; height: 150px;">
            </div>
        @endif
    </div>
</div>
