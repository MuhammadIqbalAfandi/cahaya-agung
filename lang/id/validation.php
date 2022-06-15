<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
     */

    'accepted' => 'Nilai harus be accepted.',
    'accepted_if' => 'Nilai harus be accepted when :other is :value.',
    'active_url' => 'Nilai is not a valid URL.',
    'after' => 'Tanggal harus setelah tanggal :date.',
    'after_or_equal' => 'Tanggal harus setelah atau sama dengan :date.',
    'alpha' => 'Nilai harus only contain letters.',
    'alpha_dash' => 'Nilai harus only contain letters, numbers, dashes and underscores.',
    'alpha_num' => 'Nilai harus only contain letters and numbers.',
    'array' => 'Nilai harus be an array.',
    'before' => 'Tanggal harus sebelum tanggal :date.',
    'before_or_equal' => 'Tanggal harus sebelum atau sama dengan :date.',
    'between' => [
        'numeric' => 'Nilai harus antara :min and :max.',
        'file' => 'Nilai harus be between :min and :max kilobytes.',
        'string' => 'Nilai harus antara :min dan :max karakter.',
        'array' => 'Nilai harus have between :min and :max items.',
    ],
    'boolean' => 'Nilai harus true atau false.',
    'confirmed' => 'Konfirmasi password tidak cocok.',
    'current_password' => 'The password is incorrect.',
    'date' => 'Format tanggal salah.',
    'date_equals' => 'Tanggal harus sama dengan tanggal :date.',
    'date_format' => 'Format tanggal salah :format.',
    'different' => 'Nilai and :other harus be different.',
    'digits' => 'Nilai harus :digits digit.',
    'digits_between' => 'Nilai harus antara :min dan :max digit.',
    'dimensions' => 'Nilai has invalid image dimensions.',
    'distinct' => 'Nilai has a duplicate value.',
    'email' => 'Format e-mail salah.',
    'ends_with' => 'Nilai harus end with one of the following: :values.',
    'exists' => 'The selected Nilai is invalid.',
    'file' => 'Nilai harus be a file.',
    'filled' => 'Nilai harus have a value.',
    'gt' => [
        'numeric' => 'Nilai harus be greater than :value.',
        'file' => 'Nilai harus be greater than :value kilobytes.',
        'string' => 'Nilai harus be greater than :value characters.',
        'array' => 'Nilai harus have more than :value items.',
    ],
    'gte' => [
        'numeric' => 'Nilai harus be greater than or equal :value.',
        'file' => 'Nilai harus be greater than or equal :value kilobytes.',
        'string' => 'Nilai harus be greater than or equal :value characters.',
        'array' => 'Nilai harus have :value items or more.',
    ],
    'image' => 'Harus gambar.',
    'in' => 'Nilai tidak cocok.',
    'in_array' => 'Nilai does not exist in :other.',
    'integer' => 'Nilai harus integer.',
    'ip' => 'Nilai harus be a valid IP address.',
    'ipv4' => 'Nilai harus be a valid IPv4 address.',
    'ipv6' => 'Nilai harus be a valid IPv6 address.',
    'json' => 'Nilai harus be a valid JSON string.',
    'lt' => [
        'numeric' => 'Nilai harus be less than :value.',
        'file' => 'Nilai harus be less than :value kilobytes.',
        'string' => 'Nilai harus be less than :value characters.',
        'array' => 'Nilai harus have less than :value items.',
    ],
    'lte' => [
        'numeric' => 'Nilai harus be less than or equal :value.',
        'file' => 'Nilai harus be less than or equal :value kilobytes.',
        'string' => 'Nilai harus be less than or equal :value characters.',
        'array' => 'Nilai harus not have more than :value items.',
    ],
    'max' => [
        'numeric' => 'Nilai harus :max angka.',
        'file' => 'Nilai harus not be greater than :max kilobytes.',
        'string' => 'Nilai harus :max karakter.',
        'array' => 'Nilai harus not have more than :max items.',
    ],
    'mimes' => 'Harus berupa file dengan format: :values.',
    'mimetypes' => 'Nilai harus be a file of type: :values.',
    'min' => [
        'numeric' => 'Nilai harus :min angka.',
        'file' => 'Nilai harus be at least :min kilobytes.',
        'string' => 'Nilai harus :min karakter.',
        'array' => 'Nilai harus have at least :min items.',
    ],
    'multiple_of' => 'Nilai harus be a multiple of :value.',
    'not_in' => 'Nilai yang dipilih tidak sah.',
    'not_regex' => 'Format tidak sah.',
    'numeric' => 'Nilai harus angka.',
    'password' => 'The password is incorrect.',
    'present' => 'Nilai harus be present.',
    'regex' => 'Format tidak sah.',
    'required' => 'Nilai tidak boleh kosong.',
    'required_if' => 'Nilai is required when :other is :value.',
    'required_unless' => 'Nilai is required unless :other is in :values.',
    'required_with' => 'Nilai is required when :values is present.',
    'required_with_all' => 'Nilai is required when :values are present.',
    'required_without' => 'Nilai is required when :values is not present.',
    'required_without_all' => 'Nilai is required when none of :values are present.',
    'prohibited' => 'Nilai is prohibited.',
    'prohibited_if' => 'Nilai is prohibited when :other is :value.',
    'prohibited_unless' => 'Nilai is prohibited unless :other is in :values.',
    'prohibits' => 'Nilai prohibits :other from being present.',
    'same' => 'Nilai and :other harus match.',
    'size' => [
        'numeric' => 'Nilai harus be :size.',
        'file' => 'Nilai harus be :size kilobytes.',
        'string' => 'Nilai harus be :size characters.',
        'array' => 'Nilai harus contain :size items.',
    ],
    'starts_with' => 'Nilai harus start with one of the following: :values.',
    'string' => 'Nilai harus string.',
    'timezone' => 'Nilai harus be a valid timezone.',
    'unique' => 'Nilai telah digunakan.',
    'uploaded' => 'Gagal untuk mengupload.',
    'url' => 'Nilai harus be a valid URL.',
    'uuid' => 'Nilai harus be a valid UUID.',
    'table' => 'Table tidak boleh kosong',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
     */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
     */

    'attributes' => [],

];
