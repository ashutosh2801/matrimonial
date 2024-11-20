<div class="card">
    <div class="card-header">
        <h5 class="mb-0 h6">{{translate('Basic Information')}}</h5>
    </div>
    <div class="card-body">

        <form action="{{ route('member.basic_info_update', $member->id) }}" method="POST">
            @csrf
            <div class="form-group row">
                <div class="col-md-4">
                    <label for="first_name" >{{translate('First Name')}}
                        <span class="text-danger">*</span>
                    </label>
                    <input type="text" name="first_name" value="{{ $member->first_name }}" class="form-control" placeholder="{{translate('First Name')}}" required>
                    @error('first_name')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label for="middle_name" >{{translate('Middle Name')}}</label>
                    <input type="text" name="middle_name" value="{{ $member->middle_name }}" class="form-control" placeholder="{{translate('Middle Name')}}" required>
                    @error('middle_name')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label for="last_name" >{{translate('Last Name')}}
                        <span class="text-danger">*</span>
                    </label>
                    <input type="text" name="last_name" value="{{ $member->last_name }}" class="form-control" placeholder="{{translate('Last Name')}}" required>
                    @error('last_name')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-4">
                    <label for="first_name" >{{translate('Gender')}}
                        <span class="text-danger">*</span>
                    </label>
                    <select class="form-control aiz-selectpicker" name="gender" required>
                        <option value="1" @if($member->member->gender ==  1) selected @endif >{{translate('Male')}}</option>
                        <option value="2" @if($member->member->gender ==  2) selected @endif >{{translate('Female')}}</option>
                        @error('gender')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="first_name" >{{translate('Date Of Birth')}}
                        <span class="text-danger">*</span>
                    </label>
                    <input type="text" class="aiz-date-range form-control" name="date_of_birth"  value="@if(!empty($member->member->birthday)) {{date('Y-m-d', strtotime($member->member->birthday))}} @endif" placeholder="Select Date" data-single="true" data-show-dropdown="true" data-max-date="{{ get_max_date() }}" autocomplete="off" required>
                    @error('date_of_birth')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            {{-- </div>

            <div class="form-group row"> --}}
                <div class="col-md-4">
                    <label for="first_name" >{{translate('Phone Number')}}
                        <span class="text-danger">*</span>
                    </label>
                    <input type="text" name="phone" value="{{ $member->phone }}" class="form-control" placeholder="{{translate('Phone')}}" required>
                    @error('phone')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
                {{-- <div class="col-md-6">
                    <label for="first_name" >{{translate('On Behalf')}}
                        <span class="text-danger">*</span>
                    </label>
                    <select class="form-control aiz-selectpicker" name="on_behalf" data-live-search="true" required>
                        @foreach ($on_behalves as $on_behalf)
                            <option value="{{$on_behalf->id}}" @if($member->member->on_behalves_id == $on_behalf->id) selected @endif>{{$on_behalf->name}}</option>
                        @endforeach
                    </select>
                    @error('on_behalf')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>--}}
            </div> 
            <div class="form-group row">
                <div class="col-md-4">
                    <label for="marital_status" >{{translate('Marital  Status')}}
                        <span class="text-danger">*</span>
                    </label>
                    <select class="form-control aiz-selectpicker" name="marital_status" data-live-search="true" required>
                        @foreach ($marital_statuses as $marital_status)
                            <option value="{{$marital_status->id}}" @if($member->member->marital_status_id == $marital_status->id) selected @endif>{{$marital_status->name}}</option>
                        @endforeach
                    </select>
                    @error('marital_status')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label for="children" >{{translate('Number Of Children')}}
                    </label>
                    <input type="text" name="children" value="{{ $member->member->children }}" class="form-control" placeholder="{{translate('Number Of Children')}}" >
                </div>
                <div class="col-md-4">
                    <label for="complexion">{{translate('Complexion')}}</label>
                    <input type="text" name="complexion" value="{{ !empty($member->physical_attributes->complexion) ? $member->physical_attributes->complexion : "" }}" class="form-control" placeholder="{{translate('Complexion')}}" required>
                    @error('complexion')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-4">
                    <label for="height">{{translate('Height')}} ({{ translate('In Feet') }})</label>
                    {{-- <input type="number" name="height" value="{{ !empty($member->physical_attributes->height) ? $member->physical_attributes->height : "" }}" step="any" class="form-control" placeholder="{{translate('Height')}}" required> --}}

                    <div class="">
                        @php
                            $height = !empty($member->physical_attributes->height) ? $member->physical_attributes->height : " . ";
                            $height = explode(".", $height);
                        @endphp
                        <select class="col-md-6 form-control aiz-selectpicker" name="height_in_feet" >
                            <option value="">{{translate('Select One')}}</option>
                            @for ($i=1; $i<8; $i++)
                                <option @if(trim($height[0]) == $i) selected @endif value="{{$i}}">{{$i}} ft</option>
                            @endfor
                        </select>
                        <select class="col-md-5 form-control aiz-selectpicker" name="height_in_inch" >
                            <option value="">{{translate('Select One')}}</option>
                            @for ($i=1; $i<12; $i++)
                                <option @if(trim($height[1]) == $i) selected @endif value="{{$i}}">{{$i}} inch</option>
                            @endfor
                        </select>
                    </div>

                    @error('height')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
                {{-- <div class="col-md-4">
                    <label for="weight">{{translate('Weight')}} ({{ translate('In Kg')}})</label>
                    <input type="number" name="weight" value="{{ !empty($member->physical_attributes->weight) ? $member->physical_attributes->weight : "" }}" step="any" placeholder="{{ translate('Weight') }}" class="form-control" required>
                    @error('weight')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
                
            </div>

            <div class="form-group row"> --}}
                <div class="col-md-8">
                    <label for="photo" >{{translate('Photo')}} <small>(800x800)</small>
                        @if(auth()->user()->photo != null && auth()->user()->photo_approved == 0)
                        <small class="text-danger">({{ translate('Pending for Admin Approval.') }})</small>
                        @elseif(auth()->user()->photo != null && auth()->user()->photo_approved == 1)
                            <small class="text-danger">({{ translate('Approved.') }})</small>
                        @endif</label>
                    <div class="input-group" data-toggle="aizuploader" data-type="image">
                        <div class="input-group-prepend">
                            <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
                        </div>
                        <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                        <input type="hidden" name="photo" class="selected-files" value="{{ $member->photo }}">
                    </div>
                    <div class="file-preview box sm">
                    </div>
                </div>
            </div>
            <div class="text-right">
                <button type="submit" class="btn btn-primary btn-sm">{{translate('Update')}}</button>
            </div>
        </form>
    </div>
</div>
