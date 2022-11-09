<template lang="">
    <Navbar :user="user">
        <template v-slot:content></template>
    </Navbar>
</template>
<script>
export default {
    props: {
        user: Object,
    },
};
</script>
<style lang=""></style>
