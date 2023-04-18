@extends('layouts.landing.master')
@push('scripts')
<script>
    $(document).ready(function() {
        getData()
        function getData(){
            $.ajax({
                type: 'GET',
                url: '{{ route('getData') }}',
                dataType: 'JSON',
                success: function (response) {
                    console.log(response.data)
                },
                error: function(error) {
                    console.log(error);
                }
            })
        }
    });
</script>
@endpush