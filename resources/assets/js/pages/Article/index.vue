<template>
    <Layout>
        <section
            class="wrapper"
            v-if="article"
        >
            <div
                class="coverImage imgWrapper"
                :style="{
                    backgroundImage: `url('/${displayArticle.image}')`
                }"
            >
                <div class="overlay filter" />
            </div>
            <div class="content">
                <div class="title">
                    {{ displayArticle.title }}
                </div>
                <div class="date">
                    {{ $t('date.createdAt') }}: <strong>{{ getDateFormat(displayArticle.created_at) }}</strong> /
                    {{ $t('date.updatedAt') }}: <strong>{{ getDateFormat(displayArticle.updated_at) }}</strong>
                </div>
                <p v-html="displayArticle.detail" />
            </div>
        </section>
    </Layout>
</template>

<script>
import Layout from '../Layout'
import axios from 'axios'
import moment from 'moment'

export default {
    components: {
        Layout
    },
    data() {
        return {
            article: null
        }
    },
    computed: {
        displayArticle() {
            const article = this.article
            if (article) {
                return {
                    ...article,
                    image: article.images ? article.images.path : article.cover_path,
                    title: this._i18n.locale === 'th' ? article.title_th : article.title_en,
                    detail: this._i18n.locale === 'th' ? article.detail_th : article.detail_en,
                }
            }
            return null
        }
    },
    mounted() {
        const urls = window.location.href.replace('#', '').split('/')
        const slug = urls[urls.length - 1]
        axios.get('/api/article/' + slug)
            .then(response => response.data)
            .then(({ data }) => {
                this.article = data
            })
    },
    methods: {
        getDateFormat(date) {
            const dateObj = moment(date).toDate()
            if (this._i18n.locale === 'th') {
                return `
                    วัน${this.$t('date.days')[dateObj.getDay()]}ที่
                    ${dateObj.getDate()}
                    ${this.$t('date.months')[dateObj.getMonth()]}
                    ${dateObj.getFullYear() + 543}
                    เวลา ${dateObj.getHours()}:${dateObj.getSeconds()}น.
                `
            }
            else {
                return `
                    ${this.$t('date.days')[dateObj.getDay()]}
                    ${dateObj.getDate()}
                    ${this.$t('date.months')[dateObj.getMonth()]}
                    ${dateObj.getFullYear()},
                    ${dateObj.getHours()}:${dateObj.getSeconds()}
                `
            }
        }
    }
}
</script>

<style lang="scss" scoped>
@import '../../../sass/mixins.scss';
@import '../../../sass/responsive.scss';
.wrapper {
    padding-bottom: 64px;
    & > .coverImage {
        background-size: cover;
        background-position: center center;
        background-color: #AAA;
        height: 400px;
    }
    & > .content {
        @include container();
        margin-top: -100px;
        z-index: 1000;
        background-color: #FFF;
        border-radius: 12px;
        padding: 0 32px;
        & > .title {
            text-align: center;
            font-size: 2em;
            font-weight: bold;
            padding-top: 32px;
            padding-bottom: 12px;
        }
        & > .date {
            text-align: center;
            color: #777;
            padding-bottom: 20px;
        }
    }
}

.imgWrapper {
    position: relative;
    z-index: -1;
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
