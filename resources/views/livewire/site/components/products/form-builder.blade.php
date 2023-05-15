@foreach($form as $key => $item)
    @if($item['type'] == 'text')
        @if(FormBuilder::isVisible($form, $item))
            <div class="col-span-2 lg:col-span-{{$item['width']}} py-3">
                <label for="{{$key}}" class="account-email"> {!! $item['label'] !!}</label>
                <input id="{{$key}}" type="text" name="{{$item['name']}}" class="text-field" placeholder="{{$item['placeholder']}}"
                       wire:model.defer="form.{{$key}}.value">
                @error('form.'.$key.'.error')
                <small class="text-danger">{{$message}}</small>
                @enderror
            </div>
            <hr>
        @endif
    @endif
    @if($item['type'] == 'textArea')
        @if(FormBuilder::isVisible($form, $item))
            <div class="col-span-2 lg:col-span-{{$item['width']}} py-3">
                <label for="{{$key}}" class="account-email">{!! $item['label'] !!}</label>
                <textarea id="{{$key}}" name="{{$item['name']}}" class="text-field h-auto resize-y"
                          placeholder="{{$item['placeholder']}}" rows="4" wire:model.defer="form.{{$key}}.value"></textarea>
                @error('form.'.$key.'.error')
                <small class="text-danger">{{$message}}</small>
                @enderror
            </div>
        @endif
    @endif
    @if($item['type'] == 'select')
        @if(FormBuilder::isVisible($form, $item))
            <div class="col-span-2 lg:col-span-{{$item['width']}} py-3">
                <label for="{{$key}}" class="account-email">{!! $item['label'] !!}</label>
                <select id="{{$key}}" name="{{$item['name']}}" class="text-field h-auto resize-y" wire:model="form.{{$key}}.value">
                    <option value="">انتخاب کنید...</option>
                    @foreach($item['options'] as $option)
                        <option value="{{$option['value']}}">{{$option['value']}}</option>
                    @endforeach
                </select>
                <br>
                @error('form.'.$key.'.error')
                <small class="text-danger">{{$message}}</small>
                @enderror
            </div>
            <hr>
        @endif
    @endif
    @if($item['type'] == 'radio')
        @if(FormBuilder::isVisible($form, $item))
            <div class="col-span-2 lg:col-span-{{$item['width']}} ">
                <div class="flex items-center gap-4 flex-wrap">
                    <p>{!! $item['label'] !!}</p>
                    <div class="flex items-center gap-4">
                        @foreach($item['options'] as $keyRadio => $radio)
                            <label class="flex items-center gap-1 cursor-pointer mb-0">
                                <input type="radio" name="{{$item['name']}}" value="{{$radio['value']}}"
                                       wire:model="form.{{$key}}.value"> {{$radio['value']}}
                            </label>
                        @endforeach
                    </div>
                </div>
                @error('form.'.$key.'.error')
                <small class="text-danger">{{$message}}</small>
                @enderror
            </div>
            <hr>
        @endif
    @endif
    @if($item['type'] == 'customRadio')
        @if(FormBuilder::isVisible($form, $item))
            <div class="col-span-2 lg:col-span-{{$item['width']}} py-3">
                <div class="flex items-center flex-wrap">
                    <p>{!! $item['label'] !!}</p>
                    <div class="flex items-center">
                        @foreach($item['options'] as $keyRadio => $radio)
                            <label class="flex items-center gap-1 cursor-pointer mb-0">
                                <input type="radio" name="{{$item['name']}}" value="{{$radio['value']}}"
                                       wire:model="form.{{$key}}.value"> {{$radio['value']}}
                            </label>
                        @endforeach
                    </div>
                </div>
                @error('form.'.$key.'.error')
                <small class="text-danger">{{$message}}</small>
                @enderror
            </div>
            <hr>
        @endif
    @endif
    @if($item['type'] == 'paragraph')
        @if(FormBuilder::isVisible($form, $item))
            <div class="col-span-2 lg:col-span-{{$item['width']}}">
                <div class="flex items-center gap-4 flex-wrap">
                    {!! $item['label'] !!}
                </div>
            </div>
        @endif
    @endif
@endforeach
