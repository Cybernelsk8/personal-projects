<script setup>
    const props = defineProps({
        color : {
            type : String,
            default : '',
        }
    })
</script>

<template>
    <div class="flex flex-col">
        <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block max-w-7xl min-w-full py-5 align-middle md:px-6 lg:px-8">
                <div class="overflow-hidden md:rounded-lg">
                    <table class="min-w-full divide-y divide-slate-600 table-auto">
                        <thead :class="props.color">
                            <slot name="thead"></slot>
                        </thead>
                        <tbody class="divide-y divide-slate-600">
                            <slot name="tbody"></slot>
                        </tbody>
                        <tfoot :class="props.color">
                            <slot name="tfoot"></slot>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>

    td{
        @apply py-3;
    }

    th{
        @apply font-bold uppercase py-2;
    }

</style>