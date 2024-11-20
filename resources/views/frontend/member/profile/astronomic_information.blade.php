<div class="card">
    <div class="card-header">
        <h5 class="mb-0 h6">{{translate('Astronomic Information')}}</h5>
    </div>
    <div class="card-body">
      <form action="{{ route('astrologies.update', $member->id) }}" method="POST">
          <input name="_method" type="hidden" value="PATCH">
          @csrf
          <div class="form-group row">
              <div class="col-md-6">
                  <label for="nakshatra">{{translate('Nakshatra')}}</label>
                  <input type="text" name="nakshatra" value="{{ !empty($member->astrologies->nakshatra) ? $member->astrologies->nakshatra : "" }}" class="form-control" placeholder="{{translate('Nakshatra')}}" required>
                  @error('nakshatra')
                      <small class="form-text text-danger">{{ $message }}</small>
                  @enderror
              </div>
              <div class="col-md-6">
                  <label for="rashi">{{translate('Rashi')}}</label>
                  <input type="text" name="rashi" value="{{ !empty($member->astrologies->rashi) ? $member->astrologies->rashi : "" }}" placeholder="{{ translate('Rashi') }}" class="form-control" required>
                  @error('rashi')
                      <small class="form-text text-danger">{{ $message }}</small>
                  @enderror
              </div>
          </div>
          <div class="form-group row">
              <div class="col-md-6">
                  <label for="time_of_birth">{{translate('Time Of Birth')}}</label>
                  <input type="text" name="time_of_birth" value="{{ !empty($member->astrologies->time_of_birth) ? $member->astrologies->time_of_birth : "" }}" class="form-control" placeholder="{{translate('Time Of Birth')}}" required>
                  @error('time_of_birth')
                      <small class="form-text text-danger">{{ $message }}</small>
                  @enderror
              </div>
              <div class="col-md-6">
                  <label for="city_of_birth">{{translate('City Of Birth')}}</label>
                  <input type="text" name="city_of_birth" value="{{ !empty($member->astrologies->city_of_birth) ? $member->astrologies->city_of_birth : "" }}" placeholder="{{ translate('City Of Birth') }}" class="form-control" required>
                  @error('rashi')
                      <small class="form-text text-danger">{{ $message }}</small>
                  @enderror
              </div>
          </div>

          <div class="text-right">
              <button type="submit" class="btn btn-primary btn-sm">{{translate('Update')}}</button>
          </div>
      </form>
    </div>
</div>