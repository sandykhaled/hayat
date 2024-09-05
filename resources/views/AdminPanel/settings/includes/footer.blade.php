<!-- form -->
<div class="row">
    <div class="divider">
        <div class="divider-text">{{trans('common.contacts')}}</div>
    </div>
    <div class="col-12 col-md-4">
        <label class="form-label" for="phone">{{trans('common.phone')}}</label>
        {{Form::text('phone',getSettingValue('phone'),['id'=>'phone','class'=>'form-control'])}}
    </div>
    <div class="col-12 col-md-4">
        <label class="form-label" for="address">{{trans('common.address')}}</label>
        {{Form::text('address',getSettingValue('address'),['id'=>'address','class'=>'form-control'])}}
    </div>
    <div class="col-3">
        <label class="form-label" for="email">{{trans('common.email')}}</label>
        {{Form::text('email',getSettingValue('email'),['id'=>'email','class'=>'form-control'])}}
    </div>
    <div class="col-12 col-md-4">
        <label class="form-label" for="linkedIn">{{trans('common.linkedIn')}}</label>
        {{Form::url('linkedIn',getSettingValue('linkedIn'),['id'=>'linkedIn','class'=>'form-control'])}}
    </div>
    <div class="col-12 col-md-4">
        <label class="form-label" for="Twitter">{{trans('common.Twitter')}}</label>
        {{Form::url('Twitter',getSettingValue('Twitter'),['id'=>'Twitter','class'=>'form-control'])}}
    </div>
    <div class="col-12 col-md-4">
        <label class="form-label" for="map">{{trans('common.Facebook')}}</label>
        {{Form::url('Facebook',getSettingValue('Facebook'),['id'=>'Facebook','class'=>'form-control'])}}
    </div>
    <div class="col-12 col-md-4">
        <label class="form-label" for="whatsapp">{{trans('common.whatsapp')}}</label>
        {{Form::url('whatsapp',getSettingValue('whatsapp'),['id'=>'whatsapp','class'=>'form-control'])}}
    </div>
    <div class="col-12 col-md-4">
        <label class="form-label" for="instagram">{{trans('common.instagram')}}</label>
        {{Form::url('instagram',getSettingValue('instagram'),['id'=>'instagram','class'=>'form-control'])}}
    </div>
    <div class="divider">
        <div class="divider-text">{{trans('common.footerSection')}}</div>
    </div>
    <div class="col-12 col-md-4">
        <label class="form-label" for="footerText">{{trans('common.footerText')}}</label>
        {{Form::text('footerText',getSettingValue('footerText'),['id'=>'footerText','class'=>'form-control'])}}
    </div>
    <div class="col-12 col-md-4">
        <label class="form-label" for="footerDescription">{{trans('common.footerDescription')}}</label>
        {{Form::textarea('footerDescription',getSettingValue('footerDescription'),['id'=>'footerDescription','class'=>'form-control','rows'=>'5'])}}
    </div>
    <div class="col-3">
        <label class="form-label" for="aboutUsPhoto">{{trans('common.footerLogo')}}</label>

        {{ Form::file('footerLogo', ['id' => 'footerLogo', 'class' => 'form-control']) }}
        @if (getSettingValue('footerLogo'))
            <div class="mb-2 d-flex justify-content-center mt-2">
                <img src="{{ asset('uploads/settings/' . getSettingValue('footerLogo')) }}" alt="{{ trans('common.footerLogo') }}" class="img-thumbnail" style="width:150px; height: 150px;">
            </div>
        @endif
    </div>
</div>
<!--/ form -->
