<template lang="">
    <teleport to="body">
        <input type="checkbox" :id="id" class="modal-toggle" />
        <div class="modal cursor-pointer">
            <div class="modal-box">
                <h3 class="font-bold text-lg">
                    <slot name="title"></slot>
                </h3>
                <div class="py-4 flex flex-col w-full">
                    <slot name="content"></slot>
                </div>
                <div class="modal-action">
                    <slot name="action"></slot>
                    <label v-if="!close_hidden" :for="id" class="btn">Close</label>
                </div>
            </div>
        </div>
    </teleport>
</template>
<script>
export default {
    props : {
        id:String,
        close_hidden:Boolean
    }
};
</script>
<style lang=""></style>
