@extends('back.layouts.app')
@section('styles')
@endsection
@section('scripts')
@endsection

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        @include('back.partials.ajax_form_messages')
        <form class="form-horizontal" action="{{ route('admin.sample.post') }}" method="post" id="form-update">
          {{ csrf_field() }}
          <div class="card-body">
            <h4 class="card-title">Personal Info</h4>
            <div class="form-group row">
              <label class="col-md-3 control-label col-form-label">Name</label>
              <div class="col-md-9 mc-form-input">
                <input type="text" class="form-control" name="name" id="name" placeholder="Name">
              </div>
            </div>
            <div class="form-group row">
              <label for="lname" class="col-md-3 control-label col-form-label">Last Name</label>
              <div class="col-md-9 mc-form-input">
                <input type="text" class="form-control" name="last_name" id="last_name" placeholder="Last Name Here">
              </div>
            </div>
            <div class="form-group row">
              <label for="lname" class="col-md-3 control-label col-form-label">Password</label>
              <div class="col-md-9 mc-form-input">
                <input type="password" class="form-control" placeholder="Password Here">
              </div>
            </div>
            <div class="form-group row">
              <label for="email1" class="col-md-3 control-label col-form-label">Company</label>
              <div class="col-md-9 mc-form-input">
                <input type="text" class="form-control" id="email1" placeholder="Company Name Here">
              </div>
            </div>
            <div class="form-group row">
              <label for="cono1" class="col-md-3 control-label col-form-label">Contact No</label>
              <div class="col-md-9 mc-form-input">
                <input type="text" class="form-control" id="cono1" placeholder="Contact No Here">
              </div>
            </div>
            <div class="form-group row">
              <label for="cono1" class="col-md-3 control-label col-form-label">Message</label>
              <div class="col-md-9 mc-form-input">
                <textarea class="form-control"></textarea>
              </div>
            </div>
            <div class="form-group row">
            <label class="col-md-3 control-label col-form-label">Single Select</label>
            <div class="col-md-9 mc-form-input">
              <select class="select2 form-control custom-select" style="width: 100%; height:36px;">
                <option>Select</option>
                <optgroup label="Alaskan/Hawaiian Time Zone">
                  <option value="AK">Alaska</option>
                  <option value="HI">Hawaii</option>
                </optgroup>
                <optgroup label="Pacific Time Zone">
                  <option value="CA">California</option>
                  <option value="NV">Nevada</option>
                  <option value="OR">Oregon</option>
                  <option value="WA">Washington</option>
                </optgroup>
                <optgroup label="Mountain Time Zone">
                  <option value="AZ">Arizona</option>
                  <option value="CO">Colorado</option>
                  <option value="ID">Idaho</option>
                  <option value="MT">Montana</option>
                  <option value="NE">Nebraska</option>
                  <option value="NM">New Mexico</option>
                  <option value="ND">North Dakota</option>
                  <option value="UT">Utah</option>
                  <option value="WY">Wyoming</option>
                </optgroup>
                <optgroup label="Central Time Zone">
                  <option value="AL">Alabama</option>
                  <option value="AR">Arkansas</option>
                  <option value="IL">Illinois</option>
                  <option value="IA">Iowa</option>
                  <option value="KS">Kansas</option>
                  <option value="KY">Kentucky</option>
                  <option value="LA">Louisiana</option>
                  <option value="MN">Minnesota</option>
                  <option value="MS">Mississippi</option>
                  <option value="MO">Missouri</option>
                  <option value="OK">Oklahoma</option>
                  <option value="SD">South Dakota</option>
                  <option value="TX">Texas</option>
                  <option value="TN">Tennessee</option>
                  <option value="WI">Wisconsin</option>
                </optgroup>
                <optgroup label="Eastern Time Zone">
                  <option value="CT">Connecticut</option>
                  <option value="DE">Delaware</option>
                  <option value="FL">Florida</option>
                  <option value="GA">Georgia</option>
                  <option value="IN">Indiana</option>
                  <option value="ME">Maine</option>
                  <option value="MD">Maryland</option>
                  <option value="MA">Massachusetts</option>
                  <option value="MI">Michigan</option>
                  <option value="NH">New Hampshire</option>
                  <option value="NJ">New Jersey</option>
                  <option value="NY">New York</option>
                  <option value="NC">North Carolina</option>
                  <option value="OH">Ohio</option>
                  <option value="PA">Pennsylvania</option>
                  <option value="RI">Rhode Island</option>
                  <option value="SC">South Carolina</option>
                  <option value="VT">Vermont</option>
                  <option value="VA">Virginia</option>
                  <option value="WV">West Virginia</option>
                </optgroup>
              </select>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-md-3 control-label col-form-label">Multiple Select</label>
            <div class="col-md-9 mc-form-input">
              <select class="select2 form-control" multiple="multiple">
                <optgroup label="Alaskan/Hawaiian Time Zone">
                  <option value="AK">Alaska</option>
                  <option value="HI">Hawaii</option>
                </optgroup>
                <optgroup label="Pacific Time Zone">
                  <option value="CA">California</option>
                  <option value="NV">Nevada</option>
                  <option value="OR">Oregon</option>
                  <option value="WA">Washington</option>
                </optgroup>
                <optgroup label="Mountain Time Zone">
                  <option value="AZ">Arizona</option>
                  <option value="CO">Colorado</option>
                  <option value="ID">Idaho</option>
                  <option value="MT">Montana</option>
                  <option value="NE">Nebraska</option>
                  <option value="NM" selected>New Mexico</option>
                  <option value="ND">North Dakota</option>
                  <option value="UT">Utah</option>
                  <option value="WY">Wyoming</option>
                </optgroup>
                <optgroup label="Central Time Zone">
                  <option value="AL">Alabama</option>
                  <option value="AR">Arkansas</option>
                  <option value="IL">Illinois</option>
                  <option value="IA">Iowa</option>
                  <option value="KS">Kansas</option>
                  <option value="KY">Kentucky</option>
                  <option value="LA">Louisiana</option>
                  <option value="MN">Minnesota</option>
                  <option value="MS">Mississippi</option>
                  <option value="MO">Missouri</option>
                  <option value="OK">Oklahoma</option>
                  <option value="SD" selected>South Dakota</option>
                  <option value="TX">Texas</option>
                  <option value="TN">Tennessee</option>
                  <option value="WI">Wisconsin</option>
                </optgroup>
                <optgroup label="Eastern Time Zone">
                  <option value="CT">Connecticut</option>
                  <option value="DE">Delaware</option>
                  <option value="FL">Florida</option>
                  <option value="GA">Georgia</option>
                  <option value="IN">Indiana</option>
                  <option value="ME">Maine</option>
                  <option value="MD">Maryland</option>
                  <option value="MA">Massachusetts</option>
                  <option value="MI">Michigan</option>
                  <option value="NH">New Hampshire</option>
                  <option value="NJ">New Jersey</option>
                  <option value="NY">New York</option>
                  <option value="NC">North Carolina</option>
                  <option value="OH">Ohio</option>
                  <option value="PA">Pennsylvania</option>
                  <option value="RI">Rhode Island</option>
                  <option value="SC">South Carolina</option>
                  <option value="VT">Vermont</option>
                  <option value="VA">Virginia</option>
                  <option value="WV">West Virginia</option>
                </optgroup>
              </select>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-md-3 control-label col-form-label">Radio Buttons</label>
            <div class="col-md-9 mc-form-input">
              <div class="custom-control custom-radio">
                <input type="radio" class="custom-control-input" id="customControlValidation1" name="radio-stacked">
                <label class="custom-control-label" for="customControlValidation1">First One</label>
              </div>
              <div class="custom-control custom-radio">
                <input type="radio" class="custom-control-input" id="customControlValidation2" name="radio-stacked">
                <label class="custom-control-label" for="customControlValidation2">Second One</label>
              </div>
              <div class="custom-control custom-radio">
                <input type="radio" class="custom-control-input" id="customControlValidation3" name="radio-stacked">
                <label class="custom-control-label" for="customControlValidation3">Third One</label>
              </div>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-md-3 control-label col-form-label">Checkboxes</label>
            <div class="col-md-9 mc-form-input">
              <div class="custom-control custom-checkbox mr-sm-2">
                <input type="checkbox" class="custom-control-input" id="customControlAutosizing1">
                <label class="custom-control-label" for="customControlAutosizing1">First One</label>
              </div>
              <div class="custom-control custom-checkbox mr-sm-2">
                <input type="checkbox" class="custom-control-input" id="customControlAutosizing2">
                <label class="custom-control-label" for="customControlAutosizing2">Second One</label>
              </div>
              <div class="custom-control custom-checkbox mr-sm-2">
                <input type="checkbox" class="custom-control-input" id="customControlAutosizing3">
                <label class="custom-control-label" for="customControlAutosizing3">Third One</label>
              </div>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-md-3 control-label col-form-label">File Upload</label>
            <div class="col-md-9 mc-form-input">
              <div class="custom-file">
                <input type="file" class="custom-file-input" id="validatedCustomFile">
                <label class="custom-file-label" for="validatedCustomFile">Choose file...</label>
                <div class="invalid-feedback">Example invalid custom file feedback</div>
              </div>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-md-3 control-label col-form-label">Disabled input</label>
            <div class="col-md-9 mc-form-input">
              <input type="text" id="disabledTextInput" class="form-control" placeholder="Disabled input" disabled>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-md-3 control-label col-form-label">Autoclose Datepicker</label>
          <div class="input-group col-md-9 mc-form-input">
            <input type="text" class="form-control" id="datepicker-autoclose" placeholder="mm/dd/yyyy">
            <div class="input-group-append">
              <span class="input-group-text"><i class="fa fa-calendar"></i></span>
            </div>
          </div>
        </div>
          <div class="form-group row">
            <div class="col-md-3 control-label col-form-label">
              <span>Tooltip Input</span>
            </div>
            <div class="col-md-9 mc-form-input">
              <input type="text" data-toggle="tooltip" title="A Tooltip for the input !" class="form-control" id="validationDefault05" placeholder="Hover For tooltip">
            </div>
          </div>
          <div class="form-group row">
            <div class="col-md-3 control-label col-form-label">
              <span>Appended Input</span>
            </div>
            <div class="col-md-9 mc-form-input">
              <div class="input-group">
                <input type="text" class="form-control" placeholder="5.000" aria-label="Recipient 's username" aria-describedby="basic-addon2">
                <div class="input-group-append">
                  <span class="input-group-text" id="basic-addon2">$</span>
                </div>
              </div>
            </div>
          </div>
          </div>
          <div class="border-top">
            <div class="card-body">
              <button type="submit" class="btn btn-primary">Submit</button>
              <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Back</a>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection