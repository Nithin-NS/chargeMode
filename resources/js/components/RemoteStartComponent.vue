<template>
    <div class="container">
        <button
            class="btn btn-primary btn-sm"
            id="start"
            @click.prevent="remoteStart()"
        >
            Boot
        </button>
    </div>
</template>

@section('scripts')
<script>
export default {
    mounted() {
        console.log("RemoteStart mounted.");
    }
};
</script>
@endsection
