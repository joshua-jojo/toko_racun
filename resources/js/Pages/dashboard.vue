<template lang="">
    <Navbar :toko="toko" :user="user">
        <template v-slot:content></template>
    </Navbar>
</template>
<script>
export default {
    props: {
        user: Object,
        toko: Object,
    },
};
</script>
<style lang=""></style>
