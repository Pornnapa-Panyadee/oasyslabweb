<template>
    <Slideout
        menu="#mobile-menu"
        panel="#panel"
        :toggleSelectors="['#hamburger']"
        :touch="false"
    >
        <Navbar />
        <main id="panel" @click="closeMobileMenu">
            <slot></slot>
        </main>
    </Slideout>
</template>

<script>
import Slideout from 'vue-slideout'
import Navbar from '../components/Navbar'

export default {
    components: {
        Slideout,
        Navbar,
    },
    methods: {
        closeMobileMenu() {
            this.$children[0].slideout.close()
        }
    }
}
</script>

<style>
p {
    font-family: Prompt!important;
}
</style>

<style>
body {
    width: 100%;
    height: 100%;
    margin: 0;
}

.slideout-menu {
    position: fixed;
    top: 0;
    bottom: 0;
    width: 256px;
    height: 100vh;
    -webkit-overflow-scrolling: touch;
    z-index: 0;
    display: none;
    background-color: #1d1f20;
    color: white;
}

.slideout-menu-left {
    left: 0;
}

.slideout-menu-right {
    right: 0;
}

.slideout-panel {
    background-color: #FFF;
    color: white;
    position: relative;
    z-index: 1;
    will-change: transform;
    min-height: 100vh;
}

.slideout-open,
.slideout-open body,
.slideout-open .slideout-panel {
    overflow: hidden;
}

.slideout-open .slideout-menu {
    display: block;
}
</style>

<style lang="scss" scoped>
*, *::after, *::before {
    color: #333;
    box-sizing: border-box;
    font-family: Prompt!important;
}
</style>
