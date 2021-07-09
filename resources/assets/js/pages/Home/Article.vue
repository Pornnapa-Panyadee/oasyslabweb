<template>
    <section
        id="articles"
        class="wrapper"
    >
        <div class="lineBlue bg-main1"></div>
        <div class="left">
            <header class="bg-main4 color-main4">{{ $t('articles.header') }}</header>
            <ul>
                <li
                    v-for="(type, index) in articlesType"
                    :key="index"
                    :class="{'active': index === activeTypeIndex}"
                    @click="changeType(index)"
                >
                    {{ type.type }}
                </li>
            </ul>
        </div>
        <div class="right">
            <div
                class="list"
                v-for="(type, index) in displayArticlesType"
                :key="index"
            >
                <carousel
                    :nav="false"
                    :responsive="silderResponsive"
                    v-if="index === activeTypeIndex && type.articles.length > 0"
                >
                    <div
                        v-for="(article, index) in type.articles"
                        :key="index"
                        class="project"
                        @click="goToArticlePage(article)"
                    >
                        <div class="imgWrapper">
                            <img
                                :src="article.image"
                                v-if="article.image"
                            >
                            <div class="overlay filter" />
                        </div>
                        <div
                            class="noImage"
                            v-if="!article.image"
                        />
                        <div class="projectContent">
                            <strong>{{ article.title }}</strong>
                        </div>
                    </div>

                    <template slot="prev">
                        <div class="leftButton">
                            <img src="/images/icons/arrow-left.png" alt="Previous">
                        </div>
                    </template>
                    <template slot="next">
                        <div class="rightButton">
                            <img src="/images/icons/arrow-right.png" alt="Next">
                        </div>
                    </template>
                </carousel>
                <div
                    v-else-if="index === activeTypeIndex && type.articles.length === 0"
                    class="noList"
                >
                    {{ $t('articles.noArticle') }}
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import carousel from '../../components/v-owl-carosuel'
import axios from 'axios'
export default {
    computed: {
        silderResponsive() {
            let newStep = 0
            return [...Array(24)].reduce((sum, each, index) => {
                const value = index * 250 + 700
                sum[value] = { items: index + 1 }
                return sum
            }, {
                0: {items: 1},
                500: {items: 2},
            })
        },
        displayArticlesType() {
            return this.articlesType.map(type => {
                return {
                    ...type,
                    articles: type.articles
                        .map(article => ({
                            ...article,
                            image: article.images ? article.images.path : article.cover_path,
                            title: this._i18n.locale === 'th' ? article.title_th : article.title_en,
                        }))
                }
            })
        }
    },
    components: {
        carousel
    },
    data() {
        return {
            articlesType: [],
            activeTypeIndex: 0
        }
    },
    mounted() {
        axios.get('/api/articles')
            .then(response => response.data)
            .then(responseData => {
                this.articlesType = responseData.data.map(type => {
                    return {
                        ...type,
                        articles: type.articles.sort((articleA, articleB) => articleA.order_no - articleB.order_no)
                    }
                })
            })
    },
    methods: {
        changeType(index) {
            this.activeTypeIndex = index
        },
        goToArticlePage(article) {
            location.href = `/article/${article.slug}`
        }
    }
}
</script>

<style lang="scss">
.owl-dots.disabled {
    display: initial !important;
}
.owl-dot:active, .owl-dot:focus {
    outline: none;
}
.owl-dot.active, .owl-dot:hover {
    & > span {
        background-color: #F1C200!important;
    }
}
</style>

<style lang="scss" scoped>
@import '../../../sass/responsive.scss';

.wrapper {
    position: relative;
    display: flex;
    flex-direction: row;
    & {
        @include respond-to($mobile) {
            flex-direction: column;
        }
    }
    & > .lineBlue {
        position: absolute;
        top: 36px;
        left: 0;
        right: 0;
        height: 80px;
        z-index: -100;
    }
    & > .left {
        display: flex;
        flex-direction: column;
        & > header {
            padding: 12px 48px;
            font-weight: 900;
            font-size: 3em;
            border-bottom-right-radius: 4px;
        }
        & > ul {
            flex: 1;
            background-color: #F1C200;
            margin-right: 16px;
            padding: 36px 36px 36px 48px;
            padding-right: 0;
            list-style: none;
            display: flex;
            flex-direction: column;
            & {
                @include respond-to($mobile) {
                    margin-right: 0px;
                }
            }
            & > li {
                font-size: 1.2em;
                padding: 4px 0;
                padding-right: 36px;
                text-transform: capitalize;
                cursor: pointer;
                &.active {
                    margin-left: -24px;
                    font-weight: 900;
                    background-color: #FFF;
                    border-top-left-radius: 4px;
                    border-bottom-left-radius: 4px;
                    padding: 12px 24px;
                    & {
                        @include respond-to($mobile) {
                            margin-left: 0px;
                        }
                    }
                }
            }
        }
    }
    & > .right {
        flex: 1;
        overflow-x: hidden;
        & > .list {
            margin: 48px;
            position: relative;
            & .project {
                background-color: #FFF;
                border-radius: 8px;
                margin: 12px;
                margin-bottom: 36px;
                box-shadow: 0 0 10px #AAA;
                height: 300px;
                cursor: pointer;
                & > .imgWrapper > img {
                    width: 100%;
                    height: 200px;
                    border-top-left-radius: 8px;
                    border-top-right-radius: 8px;
                    object-fit: cover;
                }
                & > .noImage {
                    background-color: #AAA;
                    width: 100%;
                    height: 200px;
                    border-top-left-radius: 8px;
                    border-top-right-radius: 8px;
                }
                & > .projectContent {
                    margin: 24px;
                    display: block;
                    text-overflow: ellipsis;
                    word-wrap: break-word;
                    overflow: hidden;
                    max-height: 3.6em;
                    line-height: 1.8em;
                    overflow: hidden;
                }
            }
            %navigateButton {
                position: absolute;
                bottom: 0;
                opacity: 0.8;
                cursor: pointer;
                transition: 0.3s;
                z-index: 100;
                &:hover {
                    opacity: 1;
                }
                & > img {
                    width: 36px;
                    height: 36px;
                }
            }
            & .leftButton {
                @extend %navigateButton;
                left: 0;
            }
            & .rightButton {
                @extend %navigateButton;
                right: 0;
            }
            & > .noList {
                flex: 1;
                height: 200px;
                display: flex;
                justify-content: center;
                align-items: center;
                font-size: 2em;
                margin-top: 90px;
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
