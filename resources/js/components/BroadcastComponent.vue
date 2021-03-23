<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Broadcast Component</div>

                    <div class="card-body">
                      Message from Broadcast Component
                      {{ comment }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    // const app = new Vue({
    //     el: '#app',
    //     mounted() {
    //         console.log('Broadcast Component mounted.')
    //     }
    //  });
    export default {
        data: function(){
            return {
                comment : 'Nithin'
            }
        },
        mounted() {
            console.log('Broadcast Component  mounted.')
        }
    }
</script>
