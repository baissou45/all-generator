@props([
    "id" => "",
    'name' => '',
    "col" => "col-sm-12 col-lg-6",
    "value" => "",
    "required" => false,
    "type" => "text",
    "placeholder" => "",
])

<div class="form-group {{ $col }}">
    @if (isset($libelle) && $type != 'hidden')
        <label class="form-label" for="{{ $name }}">
            {{ $libelle }}
            @if ($required)
            <strong class="text-danger"> * </strong>
            @endif
        </label>
    @endif

    <div class="input-group">
        {{-- Ajouter un prépend si le composant reçoit cet attribut --}}
        @isset($preppend)
            <div class="input-group-prepend">
                {!! $prepend !!}
            </div>
        @endisset

        <input class="form-control {{ $errors->first($name) ? 'border-danger' : '' }}" id="{{ $id ?? $name }}" type="{{ $type }}" name="{{ $name }}" value="{{ old($name, $value) }}" placeholder="{{ isset($placeholder) ? __($placeholder) : '' }}" {{ $attributes }}>

        {{-- Ajouter un append si le composant reçoit cet attribut --}}
        @isset($append)
            <div class="input-group-append">
                {!! $append !!}
            </div>
        @endisset
    </div>

    @error($name)
        <small class="text-danger"> {{ $errors->first($name) }} </small>
    @enderror
    {{ $small ?? '' }}
</div>

