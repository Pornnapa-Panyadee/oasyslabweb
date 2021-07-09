<template>
    <section
        id="banner"
        class="wrapper"
    >
        <div class="displayWrapper">
            <div
                class="display"
                v-for="(banner, index) in banners"
                :key="index"
            >
                <transition name="fade">
                    <a
                        v-show="currentIndex === index"
                        :href="banner.external_path || '#'"
                        :target="banner.external_path ? '_blank' : '_self'"
                    >
                        <img
                            :src="banner.image ? banner.image.path : banner.image_path"
                            :alt="index"
                        >
                        <div class="overlay filter" />
                    </a>
                </transition>
            </div>
        </div>
        <div class="thumbnailWrapper">
            <div class="thumbnailDisplay">
                <carousel
                    v-if="banners.length > 0"
                    :autoWidth="true"
                    :loop="true"
                    :items="5"
                    :center="true"
                    :nav="false"
                    :dots="false"
                    :onChangePosition="onChangePosition"
                    :onClickItem="onClickItem"
                >
                    <div
                        class="imgWrapper"
                        v-for="(banner, index) in banners"
                        :key="index"
                    >
                        <img
                            class="thumbnail"
                            :src="banner.image ? banner.image.path : banner.image_path"
                            :data-index="index"
                        >
                        <div class="overlay filter" />
                    </div>
                </carousel>
                <div
                    class="leftButton"
                    @click="prev"
                >
                    <img src="/images/icons/arrow-left.png" alt="Previous">
                </div>
                <div
                    class="rightButton"
                    @click="next"
                >
                    <img src="/images/icons/arrow-right.png" alt="Next">
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import carousel from '../../components/v-owl-carosuel'
export default {
    components: {
        carousel
    },
    data() {
        return {
            currentIndex: 0,
            banners: []
        }
    },
    computed: {
        bannerThumbnailMap() {
            return this.banners.reduce((obj, each, index) => {
                obj[index] = [...Array(this.banners.length)].map((each, insideIndex) => {
                    let result = insideIndex - parseInt(this.banners.length / 2) + index
                    result = result >= 0 ? result : result + this.banners.length
                    result = result < this.banners.length ? result : result - this.banners.length
                    return result
                })
                return obj
            }, ({}))
        }
    },
    mounted() {
        axios.get('/api/banners')
            .then(response => response.data)
            .then(responseBody => {
                const imagesData = responseBody.data
                    .filter(imageData => imageData.image || imageData.image_path)
                    .sort((imageA, imageB) => imageA.order_no - imageB.order_no)
                this.banners = imagesData
            })
            .then(() => this.createAutoSlider())
    },
    unmouned() {
        clearInterval(this.interval)
    },
    methods: {
        createAutoSlider() {
            this.interval = setInterval(() => {
                if (this.skipInterval) {
                    this.skipInterval = false
                }
                else {
                    this.fromAutoSilder = true
                    this.next()
                }
            }, 10000)
        },
        prev() {
            this.$children[0].prev()
        },
        next() {
            this.$children[0].next()
        },
        onChangePosition(position) {
            const index = position % this.banners.length
            if (index !== this.currentIndex) {
                this.currentIndex = index
                if (!this.fromAutoSilder) {
                    this.skipInterval = true
                }
                this.fromAutoSilder = false
            }
        },
        onClickItem(item) {
            const index = $(item).find('img').data('index')
            if (index !== this.tempIndex) {
                const oldIndex = this.currentIndex
                this.tempIndex = index

                const isRight = this.bannerThumbnailMap[oldIndex].indexOf(index) - this.bannerThumbnailMap[oldIndex].indexOf(oldIndex) >= 0
                while (this.currentIndex !== index) {
                    if (isRight) { 
                        this.next()
                    }
                    else {
                        this.prev()
                    }
                }
            }
        }
    }
}
</script>


<style lang="scss" scoped>
@import '../../../sass/mixins.scss';
@import '../../../sass/responsive.scss';
$bannerHeight: 520px;

.wrapper {
    & div.owl-item {
        & > div {
            margin: 50px 25px;
            border-radius: 4px;
            box-shadow: 0 0 24px #AAA;
            width: 100px;
            height: 100px;
            transition: 0.3s;
            cursor: pointer;
        }
        & img.thumbnail {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        &.center {
            & > div {
                box-sizing: content-box;
                margin: 0 10px;
                margin-top: 35px;
                width: 130px;
                height: 130px;
            }
        }
    }
    position: relative;
    margin-bottom: 96px; // Temp
    & > .displayWrapper {
        position: relative;
        height: $bannerHeight;
        & {
            @include respond-to($mobile) {
                max-height: 400px!important;
            }
        }
        & > .display {
            width: 100%;
            position: absolute;
            & > a {
                & > img {
                    width: 100%;
                    height: $bannerHeight;
                    object-fit: cover;
                    & {
                        @include respond-to($mobile) {
                            max-height: 400px!important;
                        }
                    }
                }
            }
        }
    }
    & > .thumbnailWrapper {
        overflow-x: hidden;
        position: absolute;
        left: 0;
        right: 0;
        bottom: -72px;
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: center;
        z-index: 100;
        & > .thumbnailDisplay {
            position: relative;
            max-width: 750px;
            %navigateButton {
                & {
                    @include respond-to((max-width: 950px)) {
                        display: none;
                    }
                }
                position: absolute;
                bottom: 0;
                opacity: 0.8;
                cursor: pointer;
                transition: 0.3s;
                z-index: 500;
                &:hover {
                    opacity: 1;
                }
                & > img {
                    width: 36px;
                    height: 36px;
                }
            }
            & > .leftButton {
                @extend %navigateButton;
                left: -10%;
            }
            & > .rightButton {
                @extend %navigateButton;
                right: -10%;
            }
        }
    }
}

.imgWrapper {
    position: relative;
}

.overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: 50;
}
</style>

<style>
.fade-enter-active, .fade-leave-active {
  transition: opacity .5s;
}
.fade-enter, .fade-leave-to {
  opacity: 0;
}
</style>
